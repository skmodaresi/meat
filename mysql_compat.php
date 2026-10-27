<?php
/**
 * mysql_* compatibility layer for PHP 8.
 * ---------------------------------------------------------------------------
 * The ext/mysql API (mysql_connect, mysql_query, mysql_fetch_assoc, ...) was
 * deprecated in PHP 5.5, removed in PHP 7.0 and does not exist on PHP 8.
 *
 * This codebase calls that API 17,000+ times across 647 files, and almost all
 * of those call sites rely on PHP 5's *implicit last connection*:
 *
 *     mysql_connect($host, $user, $pass);   // sets the "current" link
 *     $r = mysql_query("SELECT ...");       // no link argument
 *
 * mysqli has no such concept - every call needs an explicit link - so rewriting
 * the call sites mechanically would be both enormous and error-prone. This
 * layer reproduces the PHP 5 semantics (implicit link, false-on-error, no
 * exceptions) on top of mysqli, so the application code is left intact.
 *
 * Behavioural notes / deliberate differences:
 *  - mysqli_report(MYSQLI_REPORT_OFF) is required: since PHP 8.1 mysqli throws
 *    exceptions by default, while mysql_* returned false and set an error that
 *    callers retrieve with mysql_error().
 *  - mysql_connect() caches connections by parameter set and reuses them, which
 *    is what PHP 5 did when $new_link was false.
 *  - Resource handles are now mysqli/mysqli_result objects. Nothing in this
 *    codebase calls is_resource() on a connection.
 *
 * Loaded by require_once at the top of every file that calls mysql_*.
 * Verified against the 16 mysql_* functions actually used in this repository.
 * ---------------------------------------------------------------------------
 */

if (!function_exists('mysql_connect')) {

    if (!extension_loaded('mysqli')) {
        trigger_error(
            'The mysql_* compatibility layer requires the mysqli PHP extension.',
            E_USER_ERROR
        );
    }

    // Preserve PHP 5 semantics: return false on error, never throw.
    mysqli_report(MYSQLI_REPORT_OFF);

    if (!defined('MYSQL_ASSOC')) {
        define('MYSQL_ASSOC', 1);
    }
    if (!defined('MYSQL_NUM')) {
        define('MYSQL_NUM', 2);
    }
    if (!defined('MYSQL_BOTH')) {
        define('MYSQL_BOTH', 3);
    }

    /**
     * Resolve the implicit "current" connection, mirroring PHP 5's last-link
     * bookkeeping. Accepts null (use current link) or an explicit mysqli link.
     *
     * @param  mixed $link
     * @return mysqli|null
     */
    function __mysql_compat_link($link = null)
    {
        if ($link instanceof mysqli) {
            return $link;
        }
        if ($link === null) {
            $current = isset($GLOBALS['__mysql_compat_link']) ? $GLOBALS['__mysql_compat_link'] : null;
            return $current instanceof mysqli ? $current : null;
        }
        // A stale/foreign handle: treat as "no connection".
        return null;
    }

    /** Record a connection-level error so mysql_error() can report it. */
    function __mysql_compat_fail($message)
    {
        $GLOBALS['__mysql_compat_error'] = (string) $message;
        return false;
    }

    /**
     * @param string|null      $server
     * @param string|null      $username
     * @param string|null      $password
     * @param bool             $new_link
     * @param int              $client_flags
     * @return mysqli|false
     */
    function mysql_connect(
        $server = null,
        $username = null,
        $password = null,
        $new_link = false,
        $client_flags = 0
    ) {
        if ($server === null) {
            $server = (string) ini_get('mysql.default_host');
        }
        if ($username === null) {
            $username = (string) ini_get('mysql.default_user');
        }
        if ($password === null) {
            $password = (string) ini_get('mysql.default_password');
        }

        $host = (string) $server;
        $port = null;
        if (preg_match('/^([^:]+):(\d+)$/', $host, $m)) {
            $host = $m[1];
            $port = (int) $m[2];
        }

        $key = $host . '|' . (string) $port . '|' . $username . '|' . $password;

        // PHP 5 returned the existing connection for identical credentials
        // unless $new_link was requested.
        if (!$new_link && isset($GLOBALS['__mysql_compat_links'][$key])) {
            $existing = $GLOBALS['__mysql_compat_links'][$key];
            if ($existing instanceof mysqli) {
                $GLOBALS['__mysql_compat_link'] = $existing;
                $GLOBALS['__mysql_compat_error'] = '';
                return $existing;
            }
        }

        $link = mysqli_init();
        if (!$link instanceof mysqli) {
            return __mysql_compat_fail('Unable to initialise mysqli.');
        }

        if ($port === null) {
            $port = (int) ini_get('mysqli.default_port');
            if ($port === 0) {
                $port = 3306;
            }
        }

        $ok = @$link->real_connect(
            $host,
            (string) $username,
            (string) $password,
            '',
            $port,
            (string) ini_get('mysqli.default_socket'),
            (int) $client_flags
        );

        if (!$ok) {
            return __mysql_compat_fail(mysqli_connect_error());
        }

        $GLOBALS['__mysql_compat_links'][$key] = $link;
        $GLOBALS['__mysql_compat_link'] = $link;
        $GLOBALS['__mysql_compat_error'] = '';

        return $link;
    }

    /**
     * @param string $database_name
     * @param mixed  $link
     * @return bool
     */
    function mysql_select_db($database_name, $link = null)
    {
        $l = __mysql_compat_link($link);
        if (!$l) {
            return false;
        }
        return mysqli_select_db($l, $database_name);
    }

    /**
     * @param string $query
     * @param mixed  $link
     * @return mysqli_result|bool
     */
    function mysql_query($query, $link = null)
    {
        $l = __mysql_compat_link($link);
        if (!$l) {
            return false;
        }
        return mysqli_query($l, $query);
    }

    /**
     * @param mysqli_result|mixed $result
     * @return array|false
     */
    function mysql_fetch_assoc($result)
    {
        if (!$result instanceof mysqli_result) {
            return false;
        }
        $row = mysqli_fetch_assoc($result);
        return $row === null ? false : $row;
    }

    /**
     * @param mysqli_result|mixed $result
     * @param int                  $result_type MYSQL_ASSOC | MYSQL_NUM | MYSQL_BOTH
     * @return array|false
     */
    function mysql_fetch_array($result, $result_type = MYSQL_BOTH)
    {
        if (!$result instanceof mysqli_result) {
            return false;
        }
        $map = array(
            MYSQL_ASSOC => MYSQLI_ASSOC,
            MYSQL_NUM   => MYSQLI_NUM,
            MYSQL_BOTH  => MYSQLI_BOTH,
        );
        $flags = isset($map[$result_type]) ? $map[$result_type] : (int) $result_type;
        $row = mysqli_fetch_array($result, $flags);
        return $row === null ? false : $row;
    }

    /**
     * @param mysqli_result|mixed $result
     * @return array|false
     */
    function mysql_fetch_row($result)
    {
        if (!$result instanceof mysqli_result) {
            return false;
        }
        $row = mysqli_fetch_row($result);
        return $row === null ? false : $row;
    }

    /**
     * Read a single cell, like the removed mysql_result().
     *
     * @param mysqli_result|mixed $result
     * @param int|string          $row
     * @param int|string|null     $field
     * @return mixed|false
     */
    function mysql_result($result, $row, $field = null)
    {
        if (!$result instanceof mysqli_result) {
            return false;
        }
        if (!mysqli_data_seek($result, (int) $row)) {
            return false;
        }
        $data = mysqli_fetch_array($result, $field === null ? MYSQLI_NUM : MYSQLI_BOTH);
        if ($data === null || $data === false) {
            return false;
        }
        if ($field === null) {
            return isset($data[0]) ? $data[0] : false;
        }
        if (array_key_exists($field, $data)) {
            return $data[$field];
        }
        if (is_numeric($field) && array_key_exists((int) $field, $data)) {
            return $data[(int) $field];
        }
        return false;
    }

    /**
     * @param mysqli_result|mixed $result
     * @return int|false
     */
    function mysql_num_rows($result)
    {
        if (!$result instanceof mysqli_result) {
            return false;
        }
        return mysqli_num_rows($result);
    }

    /**
     * @param mysqli_result|mixed $result
     * @return int|false
     */
    function mysql_num_fields($result)
    {
        if (!$result instanceof mysqli_result) {
            return false;
        }
        return mysqli_num_fields($result);
    }

    /**
     * @param mixed $link
     * @return int|false
     */
    function mysql_affected_rows($link = null)
    {
        $l = __mysql_compat_link($link);
        if (!$l) {
            return false;
        }
        return mysqli_affected_rows($l);
    }

    /**
     * @param mixed $link
     * @return int|false
     */
    function mysql_insert_id($link = null)
    {
        $l = __mysql_compat_link($link);
        if (!$l) {
            return false;
        }
        return mysqli_insert_id($l);
    }

    /**
     * @param mixed $link
     * @return string
     */
    function mysql_error($link = null)
    {
        if ($link instanceof mysqli) {
            return (string) mysqli_error($link);
        }
        $l = __mysql_compat_link(null);
        if ($l) {
            return (string) mysqli_error($l);
        }
        return isset($GLOBALS['__mysql_compat_error'])
            ? (string) $GLOBALS['__mysql_compat_error']
            : '';
    }

    /**
     * @param mixed  $link
     * @param string $string
     * @return string|false
     */
    function mysql_real_escape_string($string, $link = null)
    {
        $l = __mysql_compat_link($link);
        if (!$l) {
            return false;
        }
        return mysqli_real_escape_string($l, $string);
    }

    /**
     * @param int      $row
     * @param mixed    $link
     * @return bool
     */
    function mysql_data_seek($result, $row, $link = null)
    {
        if (!$result instanceof mysqli_result) {
            return false;
        }
        return mysqli_data_seek($result, (int) $row);
    }

    /**
     * @param mysqli_result|mixed $result
     * @param int                  $field
     * @return string|false
     */
    function mysql_field_name($result, $field)
    {
        if (!$result instanceof mysqli_result) {
            return false;
        }
        $info = mysqli_fetch_field_direct($result, (int) $field);
        if (!$info || !isset($info->name)) {
            return false;
        }
        return (string) $info->name;
    }

    /**
     * @param mixed $link
     * @return bool
     */
    function mysql_close($link = null)
    {
        $l = __mysql_compat_link($link);
        if (!$l) {
            return false;
        }

        if (isset($GLOBALS['__mysql_compat_links']) && is_array($GLOBALS['__mysql_compat_links'])) {
            foreach ($GLOBALS['__mysql_compat_links'] as $key => $stored) {
                if ($stored === $l) {
                    unset($GLOBALS['__mysql_compat_links'][$key]);
                }
            }
        }

        $closed = @mysqli_close($l);

        $GLOBALS['__mysql_compat_error'] = '';
        if (isset($GLOBALS['__mysql_compat_link']) && $GLOBALS['__mysql_compat_link'] === $l) {
            $GLOBALS['__mysql_compat_link'] = null;
        }

        return $closed;
    }
}
