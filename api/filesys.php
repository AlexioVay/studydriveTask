<?php
/** @noinspection PhpUnhandledExceptionInspection */
// File coordinator: This file coordinates all files, relevant to CMS.
require_once ROOT_ABS . 'custom.php'; // local functions
require_once 'functions.php';
require_once 'libs/CrawlerDetect/CrawlerDetect.php';
$CrawlerDetect = new CrawlerDetect();

// Default constants:
define('DATE_NOW', date('Y-m-d H:i:s'));
define('COOKIE_TIME', time() + 86400 * 60 * 60);
define('LGC_DEFAULT', 'de'); // Depends on domain name: If domain name is a German word, this should be 'de'
define('APP', ($_SERVER['HTTP_X_REQUESTED_WITH'] == PACKAGE && PACKAGE != null) ? true : false);
// Receive country data of user:
define('IP', getIP());
$getCountry = getCountry();
define('COUNTRY', $getCountry['code']);
define('COUNTRY_LGC', $getCountry['lgc']);
define('COUNTRY_PHONE', $getCountry['phone']);
define('COUNTRY_REGION', $getCountry['region']);
define('COUNTRY_CITY', $getCountry['city']);
define('IS_EU', $getCountry['is_eu']);
define('BLANG', substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
define('HUMAN', $CrawlerDetect->isCrawler() ? false : true);
@define('URI', LOCALHOST ? substr(str_replace(DIR.'/', '', $_SERVER['REQUEST_URI']), 1) : substr($_SERVER['REQUEST_URI'], 1));
// Set Language:
$load_lang = LGC_DEFAULT;
if (!defined('LGC')) {
    if ($_GET['lang']) { // First Priority: Manually Language Set
        $_SESSION['lang'] = $_GET['lang'];
        setcookie("lang", $_GET['lang'], time() + 86400 * 60 * 60, "/");
        $load_lang = $_GET['lang'];
    } else if (isset($_SESSION['lang']) || isset($_COOKIE['lang'])) { // Second Priority: Session or Cookie Set
        if ($_SESSION['lang']) $load_lang = $_SESSION['lang'];
        else $load_lang = $_COOKIE['lang'];
    } else {
        # German language countries:
        if (HUMAN) {
            /* - - - Human Visitor - - - */
            if (COUNTRY_LGC == LGC_DEFAULT || COUNTRY == LGC_DEFAULT || BLANG == LGC_DEFAULT || LOCALHOST)
                $load_lang = 'de';
            else if (INITIALS == 'VM' && BLANG == 'en')
                $load_lang = 'en';
            else
                $load_lang = 'de'; #en
        } else {
            /* - - - Search Engine Crawls - - - */
            if (EN_HOST) // Crawl the English domain name with English contents:
                $load_lang = 'de'; #en
            else
                $load_lang = LGC_DEFAULT;
        }
    }
    define('LGC', $load_lang);
}

$dir = 'lang/' . $load_lang . '.php';
$lang = include ROOT_ABS . $dir;
$lang += include ROOT_CMS_ABS . 'lang/' . $load_lang . '_main.php';

// Convert EUR to USD in the US:
$currency = getCurrency();
$price = PRICE_DEFAULT;
if (IS_EU) {
    $from = 'EUR';
    $to = 'USD';
    $curl = curl('http://api.fixer.io/latest?symbols=' . $from . ',' . $to . '');
    if (!empty($curl) && is_array($curl)) $rate = $curl['rates'][$to];
    if ($rate > 0) {
        $price = round(PRICE_DEFAULT * $rate);
    }
}
define('PRICE', $price);
define('PRESIGN', $currency['presign']);
define('AFTSIGN', $currency['aftsign']);
define('CURRENCY', $currency['sign']);
// Language Relevant Constants:
define('PROJECT', __('PROJECT'));
define('COPYRIGHT_URL', __('COPYRIGHT_URL'));
define('SERVICE_NAMES', serialize(__('SERVICE_NAMES')));
define('TWITTER_BOTS', serialize(['sarah_gamerin', 'vaydesign']));
// Mobile Detect:
require_once 'detect.php';
$detect = new Mobile_Detect();
$isMobileOrTablet = false;
if ($_COOKIE['viewport'] <= 991) $isMobileOrTablet = true;
@define('IS_MOBILE', $detect->isMobile() || $detect->isTablet() || $isMobileOrTablet);
// Database Login:
$db = DBConnect();
// Assign built Vars:
define('ACCESS', serialize($access));
// Load Routing:
require_once 'routes.php';