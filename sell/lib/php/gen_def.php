<?php
$GLOBALS['costumerTypes'] = array(
	1 => 'معمولی', 
	2 => 'متفرقه',
);

$GLOBALS['reportTypes'] = array(
	2 => 'تاريخ حواله', 
	1 => 'شماره حواله',
);
$GLOBALS['reportTypesnew'] = array(
	1 => ' با در نظر گرفتن تاريخ حواله هاي ابطالي', 
	2 => 'بدون در نظر گرفتن تاريخ حواله هاي ابطالي',
);
$GLOBALS['reportMTypes'] = array(
	2 => 'تاريخ معرفي نامه', 
	1 => 'شماره معرفي نامه',
);
$GLOBALS['HorMTypes'] = array(
	1 => 'براساس حواله', 
	2 => 'براساس معرفي نامه',
);
$GLOBALS['hcreateType'] = array(
	1 => 'براساس شماره پيش حواله', 
	2 => 'براساس شماره پيش فاكتور',
);

$GLOBALS['pfcreateType'] = array(
	1 => 'براساس شماره پيش حواله', 
	2 => 'براساس شماره پيش فاكتور',
);
$GLOBALS['EbtalHType'] = array(
	1 => 'براساس شماره پيش حواله', 
	2 => 'براساس شماره پيش فاكتور',
	3 => 'بر اساس شماره حواله',
);
$GLOBALS['SellType'] = array(
	1 => 'آزاد یا متفرقه', 
	2 => 'با آنالیز',
);

$GLOBALS['access_allow'] = array(1);
$GLOBALS['access_positions'] = array(
	1 => 'Root',
	5 => 'Manager',
	10 => 'Master user',
	15 => 'Saleors',
	20 => 'co-o fficer',
	50 => 'visitor',
);

global $positionTypes;
$positionTypes = array(
	
    5 => array('title' => 'مدیر ', 'cmnt' => 'فله اي ميباشد', ''=>''),
	10 => array('title' => 'کاربر ارشد', 'cmnt' => 'كيسه اي ميباشد', ''=>''),
	15 => array('title' => ' کاربر معمولی', 'cmnt' => 'كارتني ميباشد', ''=>''),
	20 => array('title' => ' کاربر خارجی', 'cmnt' => 'كارتني ميباشد', ''=>''),
	 
);

global $pkTypes;
$pkTypes = array(
	
     0 => array('title' => 'فله ای', 'cmnt' => 'فله اي ميباشد', ''=>''),
	-1 => array('title' => 'کیسه ای', 'cmnt' => 'كيسه اي ميباشد', ''=>''),
	 1 => array('title' => 'کارتنی', 'cmnt' => 'كارتني ميباشد', ''=>''),
	 2 => array('title' => 'لاشه ای', 'cmnt' => 'لاشه اي ميباشد', ''=>''),	
);


//global $p_Unit;
//$p_Unit = array(
//
//	0 => array('title' => 'كيلوگرم', 'cmnt' => 'واحد گرم است', ''=>''),
//	1 => array('title' => 'تن', 'cmnt' => 'واحد كيلوگرم است', ''=>''),
//	
//);

global $p_Category;
$p_Category = array(
	1 => array('title' => 'جلد', 'cmnt' => 'دسته اول', ''=>''),
	2 => array('title' => 'دسته', 'cmnt' => 'دسته دوم', ''=>''),
	3 => array('title' => 'کیسه', 'cmnt' => 'دسته سوم', ''=>''),
	
);

global $p_Redundancy;
$p_Redundancy = array(
	0 => array('title' => 'ندارد', 'cmnt' => 'افزودني دارد', ''=>''),
	1 => array('title' => 'دارد', 'cmnt' => 'افزودني ندارد', ''=>''),

);
global $ch_emerge_factor;
$ch_emerge_factor = array(
	0 => array('title' => 'ندارد', 'cmnt' => 'افزودني دارد', ''=>''),
	1 => array('title' => 'دارد', 'cmnt' => 'افزودني ندارد', ''=>''),

);
global $p_Subsidies;
$p_Subsidies = array(
	2 => array('title' => 'بلي', 'cmnt' => 'يارانه دارد', ''=>''),
	1 => array('title' => 'خير', 'cmnt' => 'يارانه ندارد', ''=>''),
	3 => array('title' => 'هردو', 'cmnt' => 'مهم نیست', ''=>''),

);

global $p_unit;
$p_unit = array(
	0 => array('title' => 'اصلی', 'cmnt' => 'واحد اصلی است', ''=>''),
	1 => array('title' => 'فرعی', 'cmnt' => 'واحد فرعی است', ''=>''),

);

global $p_types;
$p_types = array(
	1 => array('title' => 'علوفه ای', 'cmnt' => 'فقط مخصوص بال', ''=>''),
	2 => array('title' => 'گوشتی', 'cmnt' => 'فقط مخصوص بال', ''=>''),
		
);


//print $pkTypes[1]['title'];


global $d_documentTypes;
$d_documentTypes = array(
	0 => array('title' => 'اعلامیه قطعی واریز وجه نقذ', 'cmnt' => 'اين سند حسابداري است', ''=>''),
	1 => array('title' => 'اعلامیه قطعی واریز حواله بانکی', 'cmnt' => 'اين سند مالي است', ''=>''),
	2 => array('title' => 'اعلامیه مو قت واگذاری چک بانکی', 'cmnt' => 'اين يك سند اصلي است', ''=>''),
	3 => array('title' => 'اعلامیه مو قت واگذاری چک عادی به بانک', 'cmnt' => 'اين يك سند اصلي است', ''=>''),
	4 => array('title' => 'به بدهکار حساب جاری مشتری', 'cmnt' => 'اين يك سند اصلي است', ''=>''),
	5 => array('title' => 'اسناد دریافتنی نزد صندوق-چک', 'cmnt' => 'اين يك سند اصلي است', ''=>''),
	6 => array('title' => 'اعلامیه قطعی واریز چک بانکی', 'cmnt' => 'اين يك سند اصلي است', ''=>''),
	-1 => array('title' => 'به بدهکار حساب جاری فروشندگان', 'cmnt' => 'اين يك سند اصلي است', ''=>''),
);
global $d_bankTypes;
$d_bankTypes = array(
    0 => array('title' => 'بانک تجارت', 'cmnt' => 'اين سند حسابداري است', ''=>''),
	1 => array('title' => 'بانک ملی', 'cmnt' => 'اين سند حسابداري است', ''=>''),
	2 => array('title' => 'بانک رفاه کارگران', 'cmnt' => 'اين سند مالي است', ''=>''),
	3 => array('title' => 'بانک سپه', 'cmnt' => 'اين يك سند اصلي است', ''=>''),
	4 => array('title' => 'بانک صادرات', 'cmnt' => 'اين يك سند اصلي است', ''=>''),
	5 => array('title' => 'بانک کشاورزی', 'cmnt' => 'اين يك سند اصلي است', ''=>''),
	6 => array('title' => 'بانک مسکن', 'cmnt' => 'اين يك سند اصلي است', ''=>''),
	7 => array('title' => 'بانک ملت', 'cmnt' => 'اين يك سند اصلي است', ''=>''),

);
//براي محل هاي تحويل كالا

global $l_Types;
$l_Types = array(
 	0 => array('title' => 'مبادي', 'cmnt' => '1', ''=>''),
	1 => array('title' => 'غيرمبادي', 'cmnt' => '1', ''=>''),
		
);


global $l_delivery;
$l_delivery = array(

    
	0 => array('title' => 'حواله', 'cmnt' => '1', ''=>''),
	1=> array('title' => 'معرفي نامه', 'cmnt' => '2', ''=>''),
	
);
//براي افزودني و كاستني ها

global $ch_type;
$ch_type = array(

    0 => array('title' => 'علوفه اي', 'cmnt' => '1', ''=>''),
	1 => array('title' => 'گوشتي', 'cmnt' => '1', ''=>''),
);

global $p_charge;
$p_charge = array(

    1 => array('title' => 'ندارد', 'cmnt' => '1', ''=>''),
	2 => array('title' => 'دارد', 'cmnt' => '2', ''=>''),
);

global $ch_dependancy;
$ch_dependancy = array(

    1 => array('title' => 'وابسته', 'cmnt' => '1', ''=>''),
	2 => array('title' => 'مستقل', 'cmnt' => '2', ''=>''),
);
global $d_pardakht_t;
$d_pardakht_t = array(

    1 => array('title' => 'پرداختی', 'cmnt' => '1', ''=>''),
	2 => array('title' => 'اضافه پرداختی', 'cmnt' => '2', ''=>''),
	3 => array('title' => 'درجریان وصول', 'cmnt' => '2', ''=>''),
	4 => array('title' => ' اسناد دريافتي و غیره  ', 'cmnt' => '3', ''=>''),
	5 => array('title' => 'في مابين  ', 'cmnt' => '3', ''=>''),
	
);
global $dpf_type;
$dpf_type = array(

    1 => array('title' => 'چك', 'cmnt' => 'چك', ''=>''),
	2 => array('title' => 'سفته', 'cmnt' => 'سفته', ''=>''),
	3 => array('title' => 'فيش', 'cmnt' => 'فيش', ''=>''),
	4 => array('title' => 'اعلاميه  ', 'cmnt' => 'اعلاميه', ''=>''),
	5 => array('title' => 'ضمانتنامه  ', 'cmnt' => 'ضمانتنامه', ''=>''),
	6 => array('title' => '-----', 'cmnt' => '', ''=>''),
	7 => array('title' => 'به حساب بدهكاري مشتري', 'cmnt' => 'حساب بدهكار مشتري', ''=>''),
	8 => array('title' => 'به حساب بستانكاري مشتري', 'cmnt' => 'حساب بستانكاري مشتري', ''=>''),
	9 => array('title' => 'في مابين', 'cmnt' => 'في ما بين', ''=>''),
	10 => array('title' => 'از حساب بستانکاري مشتري', 'cmnt' => 'از حساب بستانکاري مشتري', ''=>''),
	11 => array('title' => 'معرفي نامه', 'cmnt' => 'معرفي نامه', ''=>''),
	
);

global $month;
$month = array(

    1 => array('title' => 'فروردین', 'cmnt' => 'فروردین', ''=>''),
	2 => array('title' => 'اردیبهشت', 'cmnt' => 'اردیبهشت', ''=>''),
	3 => array('title' => 'خرداد', 'cmnt' => 'خرداد', ''=>''),
	4 => array('title' => 'تیر  ', 'cmnt' => 'تیر', ''=>''),
	5 => array('title' => 'مرداد  ', 'cmnt' => 'مرداد', ''=>''),
	6 => array('title' => 'شهریور', 'cmnt' => 'شهریور', ''=>''),
	7 => array('title' => 'مهر', 'cmnt' => 'مهر', ''=>''),
	8 => array('title' => 'آبان', 'cmnt' => 'آبان', ''=>''),
	9 => array('title' => 'آذر', 'cmnt' => 'آذر', ''=>''),
	10 => array('title' => 'دی', 'cmnt' => 'دی', ''=>''),
	11 => array('title' => 'بهمن', 'cmnt' => 'بهمن', ''=>''),
	12 => array('title' => 'اسفند', 'cmnt' => 'بهمن', ''=>''),
	
);
global $dahe;
$dahe = array(

    1 => array('title' => 'دهه اول', 'cmnt' => 'دهه اول', ''=>''),
	2 => array('title' => 'دهه دوم', 'cmnt' => 'دهه دوم', ''=>''),
	3 => array('title' => 'دهه سوم', 'cmnt' => 'دهه سوم', ''=>''),
	
	
);



global $pay_type;
$pay_type = array(

    1 => array('title' => 'پرداخت شده', 'cmnt' => 'پرداخت شده', ''=>''),
	2 => array('title' => 'پرداخت نشده', 'cmnt' => 'پرداخت نشده', ''=>''),
	
	
);
global $ch_dependancy_to;
$ch_dependancy_to = array(

    0 => array('title' => ' وابسته به مقدار و محل تحويل كالا', 'cmnt' => '1', ''=>''),
	1 => array('title' => 'فاصله محل تحويل كالا', 'cmnt' => '1', ''=>''),
	2 => array('title' => 'مبلغ كالا', 'cmnt' => '1', ''=>''),
);


global $ch_type_redundancy;
$ch_type_redundancy = array(

    1 => array('title' => ' افزودنی', 'cmnt' => '1', ''=>''),
	2 => array('title' => 'كاستنی', 'cmnt' => '1', ''=>''),
	
);
//براي اطلاعات مشتريان

global $personality_customer;
$personality_customer = array(

    1 => array('title' => ' حقيقي', 'cmnt' => '1', ''=>''),
    2 => array('title' => ' غير دولتی) حقوقی)', 'cmnt' => '1', ''=>''),
	3 => array('title' => 'دولتی ) حقوقی) ', 'cmnt' => '1', ''=>''),
	
);


global $condition_activity_customer;
$condition_activity_customer = array(
1 => array('title' => 'غيرفعال', 'cmnt' => '1', ''=>''),
    0 => array('title' => 'فعال', 'cmnt' => '1', ''=>''),
	
	
);



global $type_customer;
$type_customer = array(

    0 => array('title' => ' خارجي', 'cmnt' => '1', ''=>''),
	1 => array('title' => 'داخلي', 'cmnt' => '1', ''=>''),
	
);

global $condition_pay_customer;
$condition_pay_customer = array(

    0 => array('title' => 'نقدي', 'cmnt' => '1', ''=>''),
	1 => array('title' => 'نسيه و نقد', 'cmnt' => '1', ''=>''),
	
);


global $ActTypesCus;
$ActTypesCus = array(

    0 => array('title' => 'متفرقه', 'cmnt' => '1', ''=>''),
	1 => array('title' => 'مرغداري', 'cmnt' => '1', ''=>''),
    2 => array('title' => 'دامداري', 'cmnt' => '1', ''=>''),
	3 => array('title' => 'كنسانتره سازي', 'cmnt' => '1', ''=>''),	
    4 => array('title' => 'خريدار گوشت', 'cmnt' => '1', ''=>''),
	
);

global $condition_share_customer;
$condition_share_customer = array(

    0 => array('title' => 'تعيين سهميه', 'cmnt' => '1', ''=>''),
	23 => array('title' => 'عدم تعيين سهميه', 'cmnt' => '1', ''=>''),
	
);

global $province_name;
$province_name = array(
	
     0 => array('title' => 'آذربايجان غربي', 'cmnt' => 'فله اي ميباشد', ''=>''),
	 1 => array('title' => 'آذربايجان غربي', 'cmnt' => 'كيسه اي ميباشد', ''=>''),
     2 => array('title' => 'اردبيل', 'cmnt' => 'كارتني ميباشد', ''=>''),
	 3 => array('title' => 'اصفهان', 'cmnt' => 'لاشه اي ميباشد', ''=>''),
	 4 => array('title' => 'ايلام', 'cmnt' => 'فله اي ميباشد', ''=>''),
	 5 => array('title' => 'بوشهر', 'cmnt' => 'كيسه اي ميباشد', ''=>''),
	 6 => array('title' => 'تهران', 'cmnt' => 'كارتني ميباشد', ''=>''),
	 7 => array('title' => 'چهار محال بختياري', 'cmnt' => 'لاشه اي ميباشد', ''=>''),
	 8 => array('title' => 'خراسان', 'cmnt' => 'فله اي ميباشد', ''=>''),
	 9 => array('title' => 'شیراز', 'cmnt' => 'كيسه اي ميباشد', ''=>''),	
);

?>
