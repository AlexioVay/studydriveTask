<?php
// Init
# Default Values:
$remote_cms = 'https://jobspace24.com/api/';
$dir_cms = 'jobspace24/api';
$dir_default = 'spieletester';
if (defined('DIR_CMS')) {
    $dir_cms = DIR_CMS;
    switch ($dir_cms):
        case 'jobspace24/api':
            $remote_cms = 'https://jobspace24.com/api/';
            break;
    endswitch;
} else {
    // This file was called directly, therefore use default values:
    define ('DIR_CMS', $dir_cms);
    define ('DIR', $dir_default);
    define ('DIR_ABS', 'C:/xampp/htdocs/'.$dir_default.'/');
}

// Init:
define ('LOCALHOST', ((strpos($_SERVER['HTTP_REFERER'], 'localhost') !== false) || $_SERVER['HTTP_HOST'] == 'localhost') ? true : false);
define ('DEFAULT_HOST', (defined('WWW') && WWW == 'https://'.$_SERVER['HTTP_HOST'].'/') ? true : false);
define ('EN_HOST', (defined('WWW_EN') && WWW_EN == 'https://'.$_SERVER['HTTP_HOST'].'/') ? true : false);
// Paths:
# Supress to avoid further process when only CONSTANTS are required:
define ('ROOT_USERNAME', 'w011c73c');
@define ('ROOT', LOCALHOST ? 'http://localhost/'.DIR.'/' : ((EN_HOST && defined('WWW_EN')) ? WWW_EN : WWW));
define ('ROOT_CMS', LOCALHOST ? 'http://localhost/'.$dir_cms.'/' : $remote_cms);
define ('ROOT_CMS_ABS', LOCALHOST ? 'C:/xampp/htdocs/'.$dir_cms.'/' : '/www/htdocs/'.ROOT_USERNAME.'/'.$dir_cms.'/');
define ('ROOT_CMS_DIR', $dir_cms); // Set the default CMS directory (when CMS is in root and not in subfolder of root)
define ('ROOT_WWW', str_replace(['https://','/'], '', 'www.' .ROOT));
define ('ROOT_SHORT', str_replace('www.','', ROOT_WWW));
define ('ROOT_ABS', DIR_ABS . '/');
// Project Settings:
define ('PROJECTS', serialize([
    'spieletester' => [
        'host' => 'www.gametestergo.com',
        'username' => 'd01a0a97',
        'password' => 'mlpplm00',
        'db' => 'd01a0a97',
        'initials' => 'ST'
    ],
    'sjobs' => [
        'host' => 'www.schauspiel-jobs.de',
        'username' => 'd02bd396',
        'password' => 'mlpplm00',
        'db' => 'd02bd396',
        'initials' => 'SJ'
    ],
    'vaymodels' => [
        'host' => 'www.vaymodels.com',
        'username' => 'd02c4584',
        'password' => 'mlpplm00',
        'db' => 'd02c4584',
        'initials' => 'VM'
    ],
    'winfluencer' => [
        'host' => 'www.winfluencer.org',
        'username' => 'd02c4588',
        'password' => 'mlpplm00',
        'db' => 'd02c4588',
        'initials' => 'WF'
    ]
]));
require_once 'db/MysqliDb.php';
define('DB_DEFAULT', serialize(['port' => 3306, 'prefix' => '', 'charset' => 'utf8mb4']));
