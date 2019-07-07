<?php /** @noinspection PhpIncludeInspection */

function user_name($uid, $prename = 0) {
    $db = MysqliDb::getInstance();

    $output = null;
    if ($prename) {
        $db->where('id', $uid);
        $output = $db->getValue('users', 'prename');
    } else {
        $db->where('id', $uid);
        $user = $db->getOne('users', 'prename, surname');
        $output = "<strong>".$user['prename']." ".$user['surname']."</strong>";
    }

    return $output;
}

function user_email($uid) {
    $db = MysqliDb::getInstance();
    $db->where('id', $uid);
    $output = $db->getValue('users', 'email');

    return $output;
}

function beauty($number) {
    $fraction = null;
    $number = number_format((float) $number, 2, '.', '');
    sscanf($number, '%d.%d', $whole, $fraction); // split apart
    $fraction = str_pad($fraction, 2, '0', STR_PAD_LEFT); // fill $fraction with zeros

    $output = '<div class="db green">
            <span class="price-decimal-point">'.CURRENCY.' ' . $whole . '
                <span class="price-decimal-place">' . $fraction . '</span>
            </span>

            </div>
            <div class="cb"></div>
            ';
    return $output;
}

function pay() {
    $ec = __('PAYMENT_BANK').' *';
    $pp = '<span class="pp">'.__('PAYMENT_PAYPAL').'</span>
    <img src="'.ROOT_CMS.'img/service/paypal.svg" alt="PayPal Logo" class="pp_icon" />';

    $iap = null;
    $package = false;
    if (!empty(PACKAGE)) {
        $package = true;

        // Link to Google Play Store when not using the APP:
        $as = $ae = null;
        if (!APP) {
            $as = '<a href="https://play.google.com/store/apps/details?id='.PACKAGE.'" target="_blank">';
            $ae = '</a>';
        }
        $iap = '<span class="iap">'.__('PAYMENT_IAP').'</span>
        '.$as.'<img src="'.ROOT_CMS.'img/service/googleplay.svg" alt="Google Play Logo" class="iap_icon" />'.$ae;
    }
    /*$dd = '<span class="dd">'.__('PAYMENT_DD').'</span>
    <img src="'.ROOT_CMS.'img/service/gocardless.svg" alt="GoCardless Logo" class="gc_icon" />';
    $steam = '<span class="steam">'.__('PAYMENT_STEAM').'</span> 
    <img src="'.ROOT_CMS.'img/service/steam.svg" alt="Steam Logo" class="steam_icon" />';*/

	$output = '<div class="visible-xs pt10 pb20"><hr /></div>
	<legend class="cl mb15">'.__('PAYMENT_SELECT').'</legend>
		'.check('pay', 'radio', 'bt', null, $ec);
		#'.check('pay-dd', 'pay', 'radio', $dd, null, null, 'br', 'dd').'
    $output .= check('pay', 'radio', 'pp', null, $pp);

    if ($package && $iap)
    $output .= check('pay', 'radio', 'iap', null, $iap);

    $output .= '<p class="note">'.__('PAY_BT_NOTE').'</p>';
	
	return $output;	
}

function curl($url, $post = null, $decode = true) {
    $ch = curl_init();
    if (isset($_GET)) {
        foreach ($_GET as $k => $y) {
            $post[$k] = $y;
        }
        if (defined('LGC')) {
            $post['lgc'] = LGC;
        }
    }

    curl_setopt($ch, CURLOPT_AUTOREFERER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    if (!empty($post)) {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }
    $data = curl_exec($ch);
    curl_close($ch);

    $response = null;
    if ($decode)
        $response = json_decode($data, true);
    else
        $response = $data;

    $output = $response;

    return $output;
}

function getIP() {
    $ip = $_SERVER['REMOTE_ADDR'];
    if ($_SESSION['ip_address']) {
        $ip = $_SESSION['ip_address'];
    } elseif (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }

    return $ip;
}

function getCurrency($currency = null) {
    $is_eu = IS_EU;
    if ($currency) {
        $currencyCode = $currency;
        if ($currency != 'en') $currencyCode = 'EUR';
    } else if (LOCALHOST || LGC != 'en' || $is_eu || BLANG == 'de') {
        $currencyCode = 'EUR';
    } else if (!empty($_COOKIE['currency'])) {
        $currencyCode = $_COOKIE['currency'];
    } else if (!empty($_SESSION['currency'])) {
        $currencyCode = $_SESSION['currency'];
    } else {
        $ip_info = unserialize(@file_get_contents('http://www.geoplugin.net/php.gp?ip=' . IP));
        $currencyCode = $ip_info['geoplugin_currencyCode'];
        $_SESSION['ip_address'] = IP;
        $_SESSION['currency'] = $currencyCode;
    }

    $output = null;
    if ($currencyCode == 'GBP') {
        $output['presign'] = 'GBP ';
        $output['sign'] = '£';
    } else if ($currencyCode == 'EUR') {
        $output['aftsign'] = ' EUR';
        $output['sign'] = '€';
    } else {
        $output['code'] = 'USD';
        $output['presign'] = 'USD ';
        $output['sign'] = '$';
    }
    if (!$output['code']) $output['code'] = $currencyCode;

    return $output;
}

function DBConnect($dir = DIR) {
    $db = unserialize(PROJECTS)[$dir];
    
    if (!empty($db)) {
        $db += unserialize(DB_DEFAULT);
    } else {
        $projects = unserialize(PROJECTS);
        $first_dir = null;
        foreach($projects as $k => $x) {
            $first_dir = $k;
            break;
        }
        $db = unserialize(PROJECTS)[$first_dir];
        $db += unserialize(DB_DEFAULT);
    }

    return new MysqliDb($db);
}

function _n($value, $cut = false, $currency = null) {
    $presign = null;
    $aftsign = null;
    if (defined('CURRENCY')) $sign = CURRENCY;
    if (defined('PRESIGN')) $presign = PRESIGN;
    if (defined('AFTSIGN')) $aftsign = PRESIGN;

    if ($currency || empty($sign) || empty($presign) || empty($aftsign)) {
        $currency = getCurrency($currency);
        $presign = $currency['presign'];
        $aftsign = $currency['aftsign'];
        $sign = $currency['sign'];
    }

    if (!empty($presign)) {
        if ($cut) $presign = $sign;
        $aftsign = null;
    }
    if (!empty($aftsign)) {
        $presign = null;
        if ($cut) $aftsign = $sign;
    }

    $decimals = 2;
    if ($cut) $decimals = 0;

    $x = $presign;
    if (LGC == 'de') {
        $x .= number_format($value, $decimals, ',', '.');
    } else {
        $x .= number_format($value, $decimals, '.', ',');
    }
    $x .= $aftsign;

    return $x;
}

function scroll_x_arrows() {
    require_once 'detect.php';
    $output = null;
    if (!IS_MOBILE)
    $output = "
    <div class='scroll-arrow-container'>
        <span class='scroll-arrow left dn'><i class='material-icons lh12'>keyboard_arrow_left</i></span>      
        <span class='scroll-arrow right'><i class='material-icons lh12'>keyboard_arrow_right</i></span>      
    </div>";

    return $output;
}

function advantages() {
    $output = '<ul id="advantages">';

    $reasons = __('REASONS');
    foreach ($reasons as $data) {
        $output .= '<li><i class="material-icons lh07 md-20 green">check</i> '.$data.'</li>';
    }
    $output .= '</ul>';

    return $output;
}

function paypal($title, $pp_merchant, $start_price) {
// notice: form id of following pp_input has to be id='form'
$output = "<input id='custom' type='hidden' name='custom' value='".$_SESSION['uid']."-".LGC."' />
		<input type='hidden' name='item_name' value='".$title."' />
		<input type='hidden' name='item_number' value='1' />
		<input type='hidden' name='cmd' value='_xclick' />
		<input type='hidden' name='charset' value='utf-8' /> 
		<input type='hidden' name='no_note' value='1' />
		<input type='hidden' name='quantity' value='1' />
		<input type='hidden' name='business' value='".$pp_merchant."' />
		<input type='hidden' name='receiver_email' value='".$pp_merchant."' />
		<input type='hidden' name='currency_code' value='EUR' />
		<input type='hidden' name='return' value='".ROOT."#modal-success-order-placed' />
		<input type='hidden' name='notify_url' value='".ROOT."ipn.php' />
		<input type='hidden' name='cancel_return' value='".ROOT."signup/3#modal-error-paypal' />
		<input id='pp_price' type='hidden' name='amount' value='".$start_price."' />";
return $output;		
}


// send mail
function sDigit ($value){ 
	# todo dont geht this: $id = (array_key_exists(''.$key.'', $value) && is_string($value) && ctype_digit($value)) ? $value : FALSE;
	$id = (ctype_digit($value) && !empty($value)) ? $value : FALSE;
	return $id;
}

function timediff($datetime,$font_size = 0) {
	$num_padded = sprintf("%02s", $font_size);
	if (!empty($font_size)) $fs = " f" . $num_padded;
	#$date = date("H:i", strtotime($datetime));	
	$datetime = new DateTime( $datetime );
    $interval = date_create('now')->diff( $datetime );
	$str = "<span class='grey".$fs."'>vor <strong>";
	$suffix = "</strong>";
    if ( $v = $interval->y >= 1 ) { $str .= $interval->y; $suffix .= "y"; }
    elseif ( $v = $interval->m >= 1 ) { $str .= $interval->m; $suffix .= "mon"; }
    elseif ( $v = $interval->d >= 1 ) { $str .= $interval->d; $suffix .= "d"; }
    elseif ( $v = $interval->h >= 1 ) { $str .= $interval->h; $suffix .= "h"; }
    elseif ( $v = $interval->i >= 1 ) { $str .= $interval->i; $suffix .= "min"; }
	elseif ( $v = $interval->s <= 10 ) { $str = "<span class='grey'>"; $suffix .= "gerade eben"; }
    else { $str .= $interval->s; $suffix .= "s"; }
	return $str . $suffix . "</span>";
}

function banking($value, $email = 0) {
    $vertical = "
    <div class='visible-xs table-responsive mt20' data-snap-ignore='true'>
    <table class='table striped'>
        <tr><td width='24%'><strong>Name:</strong></td></tr>
        <tr><td>".__('ACCOUNT_NAME')."</td></tr>
        <tr><td width='24%'><strong>IBAN:</strong></td></tr>
        <tr><td>DE98120300001052241856</td></tr>
        <tr><td width='24%'><strong>BIC:</strong></td></tr>
        <tr><td>BYLADEM1001</td></tr>
        <tr><td width='24%'><strong>".__('REFERENCE_LINE').".:</td></tr>
        <tr style='border-bottom:1px #ddd solid'><td>".INITIALS.$value."</td></tr>
    </table>
    </div>
    ";
    $horizontal = "
    <div class='hidden-xs table-responsive mt20' data-snap-ignore='true'>
    <table class='table striped' style='width: 100%'>
        <tr><td width='24%'><strong>Name:</strong></td><td width='76%'>".__('ACCOUNT_NAME')."</td></tr>
        <tr><td width='24%'><strong>IBAN:</strong></td><td width='76%'>DE98120300001052241856</td></tr>
        <tr><td width='24%'><strong>BIC:</strong></td><td width='76%'>BYLADEM1001</td></tr>
        <tr style='border-bottom:1px #ddd solid'><td width='24%'><strong>".__('REFERENCE_LINE').":</td><td width='76%'>".INITIALS.$value."</td></tr>
    </table>
    </div>
    ";

    if (!$email)
    $output = $horizontal . $vertical;
    else
    $output = $horizontal;

    return $output;
}

function order_calc($price) {
    $percent_value = $price * 0.19;
    $calc = $price - $percent_value;

    $output = "
    <div style='border-top: 1px solid #cccccc;'>&nbsp;</div>
    <div class='table-responsive' data-snap-ignore='true'>
        <table style='width: 100%'>
        <tr><td width='24%'><strong>".__('NET_PRICE').":</strong></td><td width='76%'>"._n($calc)."</td></tr>
        <tr><td width='24%'><strong>".__('VAT').":</strong></td><td width='76%'>"._n($percent_value)."</td></tr>
        <tr><td width='24%'><strong>".__('PRICE_TOTAL').":</strong></td><td width='76%'><strong>"._n($price)."</strong></td></tr>
        </table>
    </div>
    <div style='border-top: 1px solid #cccccc; margin-top: 20px'>&nbsp;</div>    
    ";
    return $output;
}

function legend() {
    $output = "
    <div class='legende'>
        <div class='container'>
            <span><i class='material-icons md-15 lh13 mr7'>local_bar</i> " . __('ICON_EVENTS') . "</span>
            <span><i class='material-icons md-15 mr7'>home</i> " . __('ICON_HOME') . "</span>
            <span><i class='material-icons md-15 mr7'>directions_car</i> " . __('ICON_TRAVEL') . "</span>
            <span><i class='material-icons md-15 mr7'>access_time</i> " . __('ICON_TIME') . "</span>
        </div>
        <div class='gt'></div>
    </div>";
    return $output;
}


function root() {
    global $match;
    // Init:
    header('Cache-Control: max-age=84600');
    header('Content-Type: text/html; charset=utf-8');
    $template = init::load('Template');
    // Load Specified Class:
    require_once 'classes/'.$match['class'].'.php';

    $mobile = null;
    $bodyA = null;
    if (IS_MOBILE) $mobile = '<script src="' . ROOT_CMS . 'js/mobile.min.js" type="text/javascript"></script>';
    if (isset($_SESSION['fb']) && $_SESSION['step'] < 3) $bodyA = 'data-upload="1"';

    $output = '
    <!DOCTYPE html lang="' . LGC . '">
    <head>
    ' . $template->head($match) . '
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-967181573"></script>
    <script>window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag(\'js\', new Date()); gtag(\'config\', \'AW-967181573\');
    </script>
    </head>
    <body'.$bodyA.'>
        <script>
        (function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,\'script\',\'//www.google-analytics.com/analytics.js\',\'ga\');
        ga(\'create\', \'' . UA_CODE . '\', \'auto\');
        ga(\'send\', \'pageview\');
        </script>
        <div id="fb-root"></div>
        '.$template->main($match).'
        <script src="' . ROOT_CMS . 'js/default.min.js" type="text/javascript"></script>
        '.$mobile.'
        <script src="' . ROOT_CMS . 'js/js.php?m='.IS_MOBILE.'&x='.$match['js'].'&y='.session_id().'&z=/'.$match['uri'].'" type="text/javascript"></script>    
    </body>
    </html>';

    return $output;
}

function timeUTC($time) {
    $output = null;
    if (LGC == 'en') {
        $output = gmdate("m/d/Y, H:i", time() - $time);
    } else {
        $output = gmdate("d.m.Y, H:i", time() - $time);
    }

    return $output;
}



function CRUD($table, $where, Array $insert, Array $update) {
    $db = MysqliDb::getInstance();
    $db->where($where);
    $check = $db->getValue($table, 'COUNT(1)');
    if ($check < 1) {
        $db->insert($table, $insert);
    } else {
        $db->where($where);
        $db->update($table, $update);
    }
}


function getCountry() {
    $country = null;
    $code = null;
    $is_eu = null;
    $lgc = null;
    $phone = null;
    $region = null;
    $city = null;
    if (LOCALHOST || $_COOKIE['country'] || $_COOKIE['country_is_eu'] || $_COOKIE['country_lgc']
        || $_COOKIE['country_country_phone'] || $_COOKIE['country_region'] || $_COOKIE['country_city']) {

        if ($_COOKIE['country']) $code = $_COOKIE['country'];
        if ($_COOKIE['country_is_eu']) $is_eu = $_COOKIE['country_is_eu'];
        if ($_COOKIE['country_lgc']) $lgc = $_COOKIE['country_lgc'];
        if ($_COOKIE['country_country_phone']) $phone = $_COOKIE['country_country_phone'];
        if ($_COOKIE['country_region']) $region = $_COOKIE['country_region'];
        if ($_COOKIE['country_city']) $city = $_COOKIE['country_city'];
    } else {
        #$key = 'd731630f3118861231a40da283d93280';
        $key = '1756185e27faea80cb774b6f594167c1';
        $location = curl('http://api.ipstack.com/'.IP.'?access_key='.$key.'&format=1');
        if ($location) {
            $code = strtolower($location['country_code']);
            $is_eu = $location['location']['is_eu']; // Using EUR?
            $lgc = $location['location']['languages'][0]['code']; // Language Code
            $phone = $location['location']['calling_code'];
            $region = $location['region_name'];
            $city = $location['city'];

            if (!empty($code)) setcookie("country", $code, COOKIE_TIME, "/");
            if (!empty($is_eu)) setcookie("country_is_eu", $is_eu, COOKIE_TIME, "/");
            if (!empty($lgc)) setcookie("country_lgc", $lgc, COOKIE_TIME, "/");
            if (!empty($phone)) setcookie("country_phone", $phone, COOKIE_TIME, "/");
            if (!empty($region)) setcookie("country_region", $region, COOKIE_TIME, "/");
            if (!empty($city)) setcookie("country_city", $city, COOKIE_TIME, "/");
        }
    }
    $country['code'] = $code;
    $country['is_eu'] = $is_eu;
    $country['lgc'] = $lgc;
    $country['phone'] = $phone;
    $country['region'] = $region;
    $country['city'] = $city;

    return $country;
}

// Send payment notice / dunning email
function dunning() {
    $projects = unserialize(DB);
    if (is_array($projects)) {
        foreach ($projects as $key => $p) {
            $dir = $key;
            $db = DBConnect($dir);

            $output = null;
            for ($i = 1; $i <= 4; $i++) {
                $start = null;
                $end = null;
                switch ($i):
                    case 1: // 8 days ago, first payment remember notice:
                        $end = date('Y-m-d', strtotime('-7 days'));
                        $start = date('Y-m-d', strtotime('-8 days'));
                        break;
                    case 2: // 15 days ago, first dunning:
                        $end = date('Y-m-d', strtotime('-14 days'));
                        $start = date('Y-m-d', strtotime('-15 days'));
                        break;
                    case 3: // 29 days ago, second dunning:
                        $end = date('Y-m-d', strtotime('-28 days'));
                        $start = date('Y-m-d', strtotime('-29 days'));
                        break;
                    case 4: // 43 days ago, third dunning:
                        $end = date('Y-m-d', strtotime('-42 days'));
                        $start = date('Y-m-d', strtotime('-43 days'));
                        break;
                endswitch;

                $db->where('(o.date BETWEEN "' . $start . '" AND "' . $end . '")');
                $db->where('(o.status != "Completed")');
                $db->join('users u', 'o.uid = u.id');
                $db->join('dunning d', 'd.uid = u.id', 'LEFT');
                $db->orderBy('date', 'DESC');
                $db->groupBy('u.id');
                $orders = $db->get('orders o', null,
                    'u.id AS uid, o.id AS oid, o.status, u.prename, u.surname, u.email, u.gender, u.lang,
        d.stage, 
        DATE_FORMAT(o.date, "%Y-%m-%d") AS date_raw, DATE_FORMAT(o.date, "%d.%m.%Y") AS date, DATE_FORMAT(o.date, "%H:%i") AS time');

                if (is_array($orders) && !empty($orders)) {
                    # PP UNPAID Status Case: Reversed, Canceled_Reversal, Denied, Refunded
                    # GC UNPAID Status Case: Failed
                    $unpaid = ['Reversed', 'Canceled_Reversal', 'Denied', 'Refunded', 'Failed'];
                    // Remember user to pay on the 8th day:
                    $collect = null;
                    foreach ($orders as $x) {
                        $lgc = null;
                        // This prevents that the new dunning system bothers old customers:
                        $order_id = $x['oid'];
                        $stage = $x['stage'];
                        $status = $x['status'];
                        // Calculate time between dates:
                        switch ($i):
                            case 1:
                                $date_end = date('d.m.Y', strtotime($x['date_raw'] . " +14 days"));
                                break;
                            case 2:
                            case 3:
                            case 4:
                                $date_end = date('d.m.Y', strtotime($x['date_raw'] . " +28 days"));
                                break;
                        endswitch;

                        $timeFirst = strtotime($date_end . ' 00:00:00');
                        $timeSecond = strtotime(date('Y-m-d') . ' 00:00:00');
                        $timeDiff = ($timeFirst - $timeSecond) / 86400; // 86400 = days

                        if (in_array($status, $unpaid)) {
                            $stage = 0;
                        } else if (($i > 1 && empty($stage)) || (is_array($collect) && in_array($order_id, $collect)) || $timeDiff < 1) {
                            // $timeDiff checks means: Dunning date shouldn't be over 2 weeks in the past
                            continue; // Skip loop to next order (next user)
                        }
                        // Init.
                        $uid = $x['uid'];
                        $ref = $uid . ' / ' . $order_id;
                        $prename = ucfirst(trim(strtolower(utf8_decode($x['prename']))));
                        $surname = ucfirst(trim(strtolower(utf8_decode($x['surname']))));
                        $email = $x['email'];
                        $gender = $x['gender'];
                        $date = $x['date'];
                        $time = $x['time'];
                        #$lgc = $x['lang'];
                        #if (empty($lgc)) $lgc = LGC_DEFAULT;

                        // Already collected:
                        $collect[] = $order_id;
                        // Check dunning phase:
                        if (!$stage) $stage = 1;
                        else $stage += 1;
                        // Prepare
                        $params = [$stage, $prename, $surname, $gender, $date, $time, $ref];
                        // Execute
                        $output .= 'Stufe ' . $stage . ': ' . $prename . ' ' . $surname . ' ' . $date . ' (' . $ref . ')<br /><br />';
                        #$output .= __('MAIL_DUNNING', $params);

                        // Send Mail
                        send_mail($email, 'dunning', $params); # Todo: Add ",$lgc" later when "language switch issue" is fixed
                        // Increase stage number:
                        if ($stage > 1) {
                            $db->where('uid', $uid);
                            $db->update('dunning', ['stage' => $stage]);
                        } else { // Or insert new entry:
                            $db->insert('dunning', ['uid' => $uid, 'stage' => 1, 'date' => $db->now()]);
                        }
                    }
                } else {
                    $output .= '<strong>No data for ' . $start . '.</strong><br /><br />';
                }
            }
        }
    }

    return $output;
}

// Language System
function __($name, $values = null) {
    global $lang;
    if ($values) return $lang[$name]($values);
    else return $lang[$name];
}

function upload_img($data, $id = false, $folder = false) {
    $return = null;
    $dir = '';
    if ($id) $image_id = $id;
    elseif (isset($_SESSION['uid'])) $image_id = $_SESSION['uid'];

    if ($folder) $dir .= $folder.'/'; else $dir = 'users/';
    $img = $data;
    $img = str_replace('data:image/jpeg;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    $file = 1;
    $filePath = $file . '.jpeg';
    file_put_contents($filePath, $data);
    $quality = 100;
    // convert to jpg
    $src_img = imagecreatefromjpeg($filePath);
    $picsize = getimagesize($filePath);
    $src_width = $picsize[0];
    $src_height = $picsize[1];
    $max_width = 700;
    // calc
    $convert = $max_width / $src_width;
    $dest_width = $max_width;
    $dest_height = ceil($src_height * $convert);
    $dst_img = imagecreatetruecolor($dest_width, $dest_height);
    imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $dest_width, $dest_height, $src_width, $src_height);
    imagepng($dst_img, $filePath, 9);
    $bg = imagecreatetruecolor(imagesx($src_img), imagesy($src_img));
    imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
    imagealphablending($bg, TRUE);
    imagecopy($bg, $src_img, 0, 0, 0, 0, imagesx($src_img), imagesy($src_img));
    imagedestroy($src_img);
    $path = ROOT_ABS . "upload/".$dir.$image_id.".jpg";
    $path_thumbnail = ROOT_ABS . 'upload/'.$dir.'thumbnail/'.$image_id.'.jpg';
    imagejpeg($bg, $path, $quality);
    #unlink($filePath);
    // Save Image
    /** @var SimpleImage() $image */
    // Create Original
    require_once 'libs/SimpleImage.php';

    try {
        $SimpleImage = new SimpleImage($path);
        $image = $SimpleImage;
        $image->fitToWidth(700)->toFile($path, 'image/jpeg', 90);

        if (strpos($dir, 'users') !== false) {
            $_SESSION['pimg'] = true;
            // Database UPDATE -> moderate profile image
            $db = MysqliDb::getInstance();
            $db->where('uid', $image_id);
            $db->where('profile', 1);
            $update_id = $db->getValue('users_img', 'id');

            $insert = ['uid' => $image_id, 'profile' => 1, 'date' => $db->now(), 'date_approved' => $db->now(), 'date_declined' => null];
            if ($db->count > 0) {
                $db->where('id', $update_id);
                $db->update('users_img', $insert);
                $_SESSION['pimg_cache'] = '?'.date('d_m_Y_H_i');
                $return = 1;
            } else {
                $db->insert('users_img', $insert);
            }

            // Create Blur Thumbnail
            #$image = $SimpleImage; // Source (Original Image)
            #$image->thumbnail(200, 200, 'top')->pixelate(23)->blur('gaussian', 5)->toFile(ROOT_ABS.'upload/'.$dir.'thumbnail/blur/'.$image_id.'.jpg', 100);
            // Profile Background
            $image = $SimpleImage; // Source (Original Image)
            $filename_bg =  ROOT_ABS . 'upload/'.$dir.$image_id.'_bg.jpg';
            $image
                ->blur('gaussian', 10)
                ->toFile($filename_bg, 'image/jpeg', 90);
        }
        // Create Thumbnail
        $image = $SimpleImage;
        $image
            ->thumbnail(200, 200, 'top')
            ->toFile($path_thumbnail, 'image/jpeg', 90);
    } catch (Exception $e) {
        $return = $e->getMessage();
    }

    return $return;
}

// send mail
function send_mail($adress, $mail_code, $data = 0, $lgc = LGC) {
    global $lang;
    // Force Specific Language:
    if ($lgc != LGC)
        $lang = include 'lang/' . $lgc . '.php';
    // Load Mail Language File:
    $lang += include ROOT_CMS_ABS . 'lang/'.LGC.'_mail.php';

    $text =
    "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN' 'http://www.w3.org/TR/html4/loose.dtd'>
    <html lang='".$lgc."'>
    <head>
    <style type='text/css'>
    body { font-size: 15px }
    a { color: #8AB02A }
    p { padding: 0; line-height: 20px; margin: 0; text-align: left; float: none }
    </style>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    </head>
    <body>
    <a href='".ROOT."'>
    <img src='".ROOT."img/logo.png' alt='Logo' style='max-width: 300px; border:0; margin-bottom:15px' /></a>
    <br /><br /><p>";
    $case = strtoupper($mail_code);

    $title = __('MAIL_'.$case.'_TITLE', $data);
    $text .= __('MAIL_' . $case, $data);

$imprint = '
<div><span style="font-family:\'Roboto\',Arial,sans-serif;font-size:x-small; color: #ddd">______________________________</span></div>
<div><div align="left" style="font-family:\'Roboto\',Arial,sans-serif;font-size:1.3em">&nbsp;</div>
<div align="left" style="font-family:monospace;font-size:1.0em; text-align: left; color: #777">
'.__('MAIL_FOOTER_TEXT').'
</div>
<br style="font-family:Arial;font-size:x-small"><div align="left" style="font-family:Arial;font-size:x-small">
</div>
<div align="left" style="font-family:Arial;font-size:x-small">
<font size="1" face="Arial"><br></font></div>
<div align="left" style="font-family:Arial;font-size:x-small">
<font size="1" face="Arial">
<a href="https://www.facebook.com/'.FACEBOOK_USERNAME.'"
style="color:rgb(17,85,204)" target="_blank">
<span style="text-decoration: none; font-size: 1.2em; margin-left: 10px; margin-top: 2px; display: inline-block">facebook.com/'.FACEBOOK_USERNAME.'</span></a>
&nbsp;
</font>
';

    if ($mail_code == 'dunning' || $mail_code == 'remember') $mail_bye = __('MAIL_BYE_FORMAL');
    else $mail_bye = __('MAIL_BYE');

    if ($mail_code != 'ask' && $mail_code != 'notify' && $mail_code != 'error' && $mail_code != 'application')
    $text .= "<br /><br />
    ".$mail_bye."
    <br /><br />
    </p>
    ".$imprint."
    </body>
    </html>";
    if ($mail_code == 'application')
    $text .= $imprint;

    require_once 'mailer/PHPMailerAutoload.php';
    date_default_timezone_set('Etc/UTC');
    $mail = new PHPMailer();
    $mail->isSMTP();
    //Enable SMTP debugging
    // 0 = off (for production use), 1 = client messages, 2 = client and server messages
    $mail->SMTPDebug = 0;
    $mail->CharSet = "UTF-8";
    $mail->SetLanguage ("de", "mailer/");
    $mail->Debugoutput = 'html';
    $mail->Host = MAIL_HOST;
    //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    //Username to use for SMTP authentication - use full email address for gmail
    $mail->Username = MAIL_USER;
    $mail->Password = MAIL_PASS;

    $mail->ClearReplyTos();
    $mail->addAddress($adress, $data[0]);
    $mail->addReplyTo($adress, $data[0]);
    $mail->addBCC('alexiovay@gmail.com');
    $mail->Subject = $title;
    #$mail->msgHTML(file_get_contents('mailer/examples/contents.html'), dirname(__FILE__));
    $mail->msgHTML($text);
    $mail->AltBody = 'This is a plain-text message body';
    #$mail->addAttachment('img/logo.png');
    #send the message, check for errors
        try {
            $mail->setFrom(CONTACT_EMAIL, PROJECT);
            $mail->send();
        } catch (phpmailerException $e) {
            $msg = '
    Mail Code: '.$mail_code.'<br />
    SESSION[uid]: '.$_SESSION['uid'].'<br />
    Error: '.$e->getMessage().'';
            if (isset($data) && is_array($data)) {
                    foreach ($data as $k => $x) {
                        $msg .= '
        '.$k.': '.$x.'<br />';
                }
        }
        mail('alexiovay@gmail.com', 'Error Occured: '.PROJECT.'', $msg);
    }
}


function randnumb($lenght) {
    $abc = "A,B,C,D,E,F,G,H,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,0,1,2,3,4,5,6,7,8,9";
    $abcarray = explode(",", $abc);
    mt_srand((double)microtime()*1000000);

    $thepass = null;
    for ($i=1; $i <= $lenght; $i++) {
        $random = mt_rand(0,35);
        $thepass .= $abcarray[$random];
    }

    return $thepass;
}

function register($form) {
    $fb = $_SESSION['fb_uid'];
    $pass = $_SESSION['pass'];
    if (empty($pass)) $pass = $_COOKIE['pass'];

    $prename = $_SESSION['prename'];
    $surname = $_SESSION['surname'];
    $zip = $_SESSION['zip'];
    $email = $_SESSION['email'];
    $gender = $_SESSION['gender'];
    $birthdate = $_SESSION['birthdate'];
    if (empty($prename)) $prename = $_COOKIE['prename'];
    if (empty($surname)) $surname = $_COOKIE['surname'];
    if (empty($zip)) $zip = $_COOKIE['zip'];
    if (empty($email)) $email = $_COOKIE['email'];
    if (empty($gender)) $gender = $_COOKIE['gender'];
    if (empty($birthdate)) $birthdate = $_COOKIE['birthdate'];
    $email = trim($email);
    if (stripos($birthdate, '.') !== false) {
        $ex = explode('.', $birthdate);
        $birthdate = $ex[2].'-'.$ex[1].'-'.$ex[0];
    }
    $lg = LGC;

    $detect = new Mobile_Detect();
    $device = 1;
    if ($detect->isMobile()) $device = 2;
	$db = MysqliDb::getInstance();
	$db->insert('users',
    [
        'fb_uid' => $fb,
        'email' => strtolower($email),
        'pass' => $pass,
        'prename' => $prename,
        'surname' => $surname,
        'zip' => $zip,
        'gender' => $gender,
        'birthday' => $birthdate,
        'signup' => $db->now(),
        'lang' => $lg,
        'device' => $device
    ]);
	$insert_id = $db->getInsertId();

    // Error Reporting
    if (!empty($db->getLastError())) {
        $error_array = [$db->getLastQuery(), $db->getLastError(), $_SESSION['uid']];
        send_mail('alexiovay@gmail.com', 'error', $error_array);
    }
	$uid = $insert_id;
	if (!empty($uid)) $_SESSION['uid'] = $uid;


    // Referral
    if ($_SESSION['rid']) {
        // Write to database:
        $db->insert('users_ref', ['uid' => $uid, 'rid' => $_SESSION['rid'], 'date' => $db->now()]);
        // Notify via email:
        $name = 'Name: '.$prename.' '.$surname;
        $db->where('id', $_SESSION['rid']);
        $ref_user = $db->getOne('users', 'prename, surname');
        $ref_name = ''.$ref_user['prename'].' '.$ref_user['surname'].'';
        $refuid = 'Referral UID: '.$_SESSION['rid'];
        $notify_array = [$name, $birthdate, $ref_name, $refuid];
        send_mail('alexiovay@gmail.com', 'notify', $notify_array);
    }

	$code = randnumb(10); # Aktivierungs-Code generieren
    $db->insert('users_activate',
    ['uid' => $uid, 'code' => $code, 'rid' => $_SESSION['rid'], 'ip' => $_SERVER['REMOTE_ADDR'], 'date' => $db->now()]);

    // Prepare Insert
    $insertVal['uid'] = $uid;
    $count = count(__('Q'));
    for ($i = 1; $i <= $count; $i++) {
        $insertVal['Q' . $i] = $form['Q_' . $i];
    }
    if (defined('USER_INFO')) {
        $extra = explode(',', USER_INFO);
        if (is_array($extra)) {
            foreach($extra as $extraVal) {
                $val = trim($extraVal);
                if (!empty($val)) $insertVal[$val] = $form[$val];
            }
        }
    }
    $insertVal['text'] = $form['text'];
    $insertVal['date'] = DATE_NOW;
    if (INITIALS == 'ST' && $form['publisher']) {
        $insertVal['publisher'] = $form['publisher'];
        send_mail('info@jobspace24.com', 'notify', [$prename, $surname, $birthdate, $form['publisher']]);
    }
    // Execute Insert
    $db->insert('users_info', $insertVal);

    // Send Mail
    $register_array = [$prename, $uid, $code];
    send_mail($email, 'register', $register_array);

	return $uid;
}

function isUtf8($string) {
    return preg_match('%(?:'
      . '[\xC2-\xDF][\x80-\xBF]'                // non-overlong 2-byte
      . '|\xE0[\xA0-\xBF][\x80-\xBF]'           // excluding overlongs
      . '|[\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}'    // straight 3-byte
      . '|\xED[\x80-\x9F][\x80-\xBF]'           // excluding surrogates
      . '|\xF0[\x90-\xBF][\x80-\xBF]{2}'        // planes 1-3
      . '|[\xF1-\xF3][\x80-\xBF]{3}'            // planes 4-15
      . '|\xF4[\x80-\x8F][\x80-\xBF]{2}'        // plane 16
      . ')+%xs', $string);
}

function fixUtf8($string) {
    $output = $string;
    if (!isUtf8($string)) $output = utf8_decode($string);

    return $output;
}

function ref_monthly() {
    if (!$_SESSION['uid']) return null;

    $db = MysqliDb::getInstance();
    $db->where('YEAR(date)', date('Y'));
    $db->where('r.rid', $_SESSION['uid']);
    $db->join('users u', 'u.id = r.uid');
    $db->groupBy('month');
    $monthly = $db->get('users_ref r', null,
'COUNT(1) AS cnt, MONTH(r.date) AS month, rid, uid, prename, surname');
    $m = null;
    $c = null;
    $s = null; // Status array
    $total = 0;
    $unlocked = 0;
    $cash = 0;
    $month_now = date('m');
    $incompleted = null;
    $completed = null;
    foreach($monthly as $x) {
        $count = $x['cnt'];
        $month = $x['month'];
        $m[$month] = $count;
        $total += $count;

        $db->where('MONTH(r.date) = ' . $month);
        $db->where('r.rid', $_SESSION['uid']);
        $db->groupBy('u.id');
        $db->join('orders o', 'r.uid = o.uid', 'LEFT');
        $db->join('users u', 'r.uid = u.id');
        $user = $db->get('users_ref r', null,'prename, surname, status');

        if (is_array($user) && !empty($user)) {
            foreach($user as $y) {
                $prename = fixUtf8($y['prename']);
                $surname = fixUtf8($y['surname']);
                $status = $y['status'];

                if ($status == 'Completed') {
                    $completed[] = '<strong class="green">' . $prename . ' ' . $surname . '</strong>';
                    $cash += 5;
                    $c[$month] += 5;
                    $s[$month] += 1;
                    $unlocked++;
                } else {
                    $incompleted[] = '<strong class="grey">' . $prename . ' ' . $surname . '</strong>';
                }
            }
        }
    }
    $names = null;
    if (is_array($completed) && !empty($completed))
        $names .= ' <i class="material-icons green mr7 md-20">check_circle</i>' . implode(', ', $completed);
    if (is_array($incompleted) && !empty($incompleted))
        $names .= ' <i class="material-icons grey ml7 mr7 md-20">cancel_presentation</i> '.implode(', ', $incompleted);
    if (empty($completed) && empty($incompleted)) $names = '<span class="f09">'.__('REF_EMPTY').'</span>';

    $referral = '
    <div>
        <span class="dib mt20 mb10 f11 box-green">'.$names.'</span>
    </div>';


    $wa = "javascript:jsShare('".__('SHARE_TEXT')."');";
    if (APP) $wa = "https://wa.me/?text=".urlencode(__('SHARE_TEXT'))."";

    $output = "
    <hr class='mt40' />

    <div class='pt30 pb30'>
        <h2><i class='material-icons md-20 mr10'>person_add</i> " . __('REF_TITLE') . "</h2>
        <p class='f11 mb20 green'>" . __('REF_INTRO_TEXT') . "</p>
        <div class='mb15 green gc f11'>" . __('PERSONAL_CODE') . ":<br />
            <span class='badge mt10'>".ROOT_WWW."/" . $_SESSION['uid'] . "</span>
        </div>        
        
        <p>" . __('REF_TEXT') . "</p>
        ".$referral."        
        <div class='pt15 pb5 f11 gs'>
            ".__('SHARE').":
        </div> 
        <div>
            <a href='".$wa."' class='dib mt10 mr15'>
                <img src='".ROOT_CMS."img/social/whatsapp.svg' width='25' alt='WhatsApp' />
            </a>
            <a href='https://www.facebook.com/sharer/sharer.php?u=".ROOT."' class='dib mt10 mr15'>
                <img src='".ROOT_CMS."img/social/facebook.svg' width='25' alt='Facebook' />
            </a>          
            <a href='https://twitter.com/intent/tweet?url=".ROOT."' class='dib mt10'>
                <img src='".ROOT_CMS."img/social/twitter.svg' width='27' alt='Twitter' />
            </a>             
        </div>";

    $output .= '
    <div class="mt10 table-monthly">
        <table class="table table-responsive" data-snap-ignore=\'true\'>
    <thead>
        <tr>
            <td width="100"></td>';
    for ($i = 1; $i <= 12; $i++) {
        $class = ' grey-dark';
        if ($i == $month_now) $class = ' active text-shadow';
        $output .= "<td class='".$class."'>" . substr(__('TIME_MONTHS')[$i], 0, 3) . "</td>";
    }

    $output .= '<td class="green">'.date('Y').'</td>
    </tr></thead>
    <tbody>
    <tr>
        <td class="tal">'.__('REFERRED').'</td>';
    for ($i = 1; $i <= 12; $i++) {
        $class = null;
        $month_ref = '-';
        if ($i == $month_now) {
            $class = ' class="green-bg"';
        }
        if ($m[$i] > 0) {
            $month_ref = $m[$i];
        }
        $output .= '<td'.$class.'>'.$month_ref.'</td>';
    }
    $output .= '
        <td>'.$total.'</td>
    </tr>
    <tr>
        <td class="borderless tal">'.__('UNLOCKED').'</td>';
    for ($i = 1; $i <= 12; $i++) {
        $count = '-';
        $class = null;
        if ($s[$i] > 0) {
            $count = $s[$i];
            $class = 'green';
        } else {
            $class = 'grey';
        }

        if ($i == $month_now) {
            $class .= ' green-bg';
            $a = 0;
            if ($s[$i] > 0) $a = $s[$i];
            $count = $a;
        }
        $output .= '<td class="borderless '.$class.'">'.$count.'</td>';
    }
    if ($unlocked > 0) $class = ' green';
    $output .= '<td class="borderless'.$class.'">'.$unlocked.'</td></tr>
    <tr><td class="tal">'.__('EARNINGS').'</td>';
    for ($i = 1; $i <= 12; $i++) {
        $class = null;
        $bonus = null;
        if ($m[$i] == 0) $class = ' grey-light';
        if ($i == $month_now) {
            $class .= ' green-bg';
        }
        $output .= '<td class="green'.$class.'">' . _n($c[$i], true)  . '</td>';
    }
    $output .= '
    
    <td class="green">'._n(5*$unlocked, true).'</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    ';

    return $output;
}


function job_type($type) {
    switch ($type):
        case 1: $type = __('MINIJOB'); break;
        case 2: $type = __('FULL_TIME'); break;
        case 3: $type = __('PART_TIME'); break;
        case 4: $type = __('SINGLE_TASK'); break;
        case 5: $type = __('EDUCATION'); break;
    endswitch;

    return $type;
}

function job_extras($type) {
    $output = null;

    switch ($type):
        case 1: $var = 'home'; $icon = 'home'; $title = 'ICON_HOME'; break;
        case 2: $var = 'travel'; $icon = 'directions_car'; $title = 'ICON_TRAVEL'; break;
        case 3: $var = 'events'; $icon = 'local_bar'; $title = 'ICON_EVENTS'; break;
        case 4: $var = 'food'; $icon = 'restaurant'; $title = 'ICON_FOOD'; break;
        #case 5: $var = 'sport'; $icon = 'fitness_center'; $title = 'ICON_SPORT'; break;
        case 6: $var = 'time'; $icon = 'access_time'; $title = 'ICON_TIME'; break;
    endswitch;
    $output['var'] = $var;
    $output['icon'] = $icon;
    $output['title'] = $title;

    return $output;
}

function clearCookies() {
    $past = time() - 3600;
    foreach ($_COOKIE as $key => $value) {
        setcookie($key, $value, $past, '/');
    }
}

function input($name, $type = 'text', $value = null, $iteration = null, $empty = false) {
    global $match;

    // Initialize:
    $class = null;
    $label = null;
    $id = $name . $value;
    // Override with Facebook Data if NOT empty:
    if ($_SESSION['fb']) {
        if (empty($value) && $name == 'prename') $value = $_SESSION['fb_prename'];
        if (empty($value) && $name == 'surname') $value = $_SESSION['fb_surname'];
        if (!empty($_SESSION['fb_bday']) && $name == 'birthdate') $value = str_replace("/", "-", $_SESSION['fb_bday']);
        if (!empty($_SESSION['fb_email']) && $name == 'email') $value = $_SESSION['fb_email'];
    }
    // Cases:
    $container_class = null;
    $option = null;
    switch ($name):
        case 'email':
        case 'email_repeat':
            $type = 'email';
            break;
        case 'pass':
        case 'pass_repeat':
        case 'old_pass':
        case 'new_pass':
        case 'new_pass_repeat':
            $type = 'password';
            $empty = true;
            break;
        case 'zip':
            #todo find out all countries with only numeric zip codes:
            if (LGC == 'de')
                $type = 'tel';
            break;
        case 'phone_number_country_code':
        case 'phone_number_full':
            if ($name == 'phone_number_country_code') {
                $preset = '+' . COUNTRY_PHONE;
                $container_class .= 'phone_lgc';
                $option = ' maxlength="3" min="1" max="999"';
            } else {
                $option = ' maxlength="15" min="1" max="999999999999999"';
            }
            $container_class .= ' inline';
            $type = 'tel';
            break;
        case 'birthdate':
            if (stripos($value, '-') !== false) {
                $ex = explode('-', $value);
                $value = $ex[2] . '.' . $ex[1] . '.' . $ex[0];
            }
            $readonly = true;
            $option = ' data-datepicker-dmyd="1"';
            break;
        case 'occupation_since':
        case 'occupation_to':
            $type = 'text';
            $option = ' data-datepicker-my="1"';
            $readonly = true;
            break;
    endswitch;
    // Manipulate:
    if ($readonly) $readonly = ' readonly';
    if (!empty($container_class)) $container_class = ' class="' . $container_class . '"';
    // Define Naming and Labels:
    if (!$label) {
        $a = __(strtoupper($name));
        $b = __(strtoupper('INPUT_' . $name));

        if (isset($a)) $label = $a;
        else if (isset($b)) $label = $b;
    }
    // Iteration:
    if ($iteration) {
        $id .= '_' . $iteration;
        $name .= '_' . $iteration;
    }
    if (!empty($id)) $id = ' id="' . str_replace('/', '_', $id) . '"';
    // Define Value:
    if ($empty) {
        $value = null;
    } else if (isset($_SESSION[$name])) {
        $value = $_SESSION[$name];
    } else if (isset($_COOKIE[$name])) {
        $noCookieSave = $match['noCookieSave'];
        if (!in_array($match['target'], $noCookieSave)) $value = $_COOKIE[$name];
    }

    if (!empty($value)) {
        $class = ' class="filled"';
        if ($preset) $preset = '<span class="visible">'.$preset.'</span>';
    } else if ($preset) {
        $preset = '<span class="hidden">'.$preset.'</span>';
    }

	$output = '
    <em'.$container_class.'>'.$preset.'
        <input'.$id.' type="'.$type.'" name="'.$name.'" value="'.$value.'"'.$option.$readonly.' />
        <label'.$class.'>'.$label.'</label>
    </em>';

    return $output;
}

function q($question, Array $answers, $type, $extra = null, $collapseMessage = null) {
    $output = ['type' => $type, 'question' => $question, 'answers' => $answers, 'extra' => $extra, 'collapseMessage' => $collapseMessage];
    return $output;
}

function check($name, $type = null, $value = 1, $value_saved = null, $text = null, $iteration = null, $attr = null) {
    $array = null;
    $output = null;
    $sessVal = null;
    $cookVal = null;
    $textClass = null;
    $containerClass = null;

    $label = __(strtoupper($name));
    // Conditions:
    switch ($name):
        case 'occupation_types':
            $array = $label;
            $type = 'radio';
        break;
        case 'gender':
            if ($value == 1) $text = __('FEMALE');
            else $text = __('MALE');
        break;
        case 'question_sure':
            $label = __('INPUT_QUESTION_SURE');
            $textClass = 'f09';
            $containerClass = 'accept';
        break;
        case 'privacy': case 'termsofservice': case 'deletion': case 'deletion_lifetime':
            $containerClass = 'accept';

            $label = __('ACCEPT_'.strtoupper($name));
            $type = 'checkbox';
        break;
    endswitch;
    $id = $name;
    if ($iteration) {
        $id .= '_' . $iteration;
        $name .= '_' . $iteration;
    }
    if ($value) {
        $id .= '_' . $value;
    }
    // Manipulate:
    if ($textClass) $textClass = " class='".$textClass."'";
    if ($containerClass) $containerClass = " class='".$containerClass."'";
    if (!$text && $label) $text = $label;
    $app = null;
    if (APP) $app = ' class="app"';

    if (is_array($array)) {
        $i = 1;
        foreach ($array as $label) {
            $loop_id = $id.'_'.$i;
            $loop_name = $id;
            $output .= check_template($loop_id, $loop_name, $type, $label, $i, $value_saved, $textClass, $containerClass, $app, $attr);
            $i++;
        }
    } else {
        $output = check_template($id, $name, $type, $text, $value, $value_saved, $textClass, $containerClass, $app, $attr);
    }

    return $output;
}

function check_template($id, $name, $type, $text, $value, $value_saved, $textClass, $containerClass, $app, $attr) {
    $empty = false;
    if ($value_saved == 'empty') $empty = true;
    $check = false;
    $checked = check_validation($name, $value, $value_saved, $empty);
    if ($checked) $check = " checked";

    $id = str_replace('/', '_', $id);

    if ($attr) $attr = ' '.$attr;
    return
    "<ins".$containerClass.">
        <input id='".$id."' name='".$name."' type='".$type."' value='".$value."'".$attr.$check." />
        <label for='".$id."' id='label_".$id."'>
            <span".$app."></span><i".$textClass.">".$text."</i>
        </label>
    </ins>";
}

function check_validation($name, $value, $value_saved = null, $empty = false) {
    global $match;
    $output = false;

    if ($empty) {
        $output = false;
    } else if (isset($value_saved) && $value_saved == $value) {
        $output = true;
    } else if (isset($_SESSION[$name])) {
        $sessVal = str_replace('%2C', ',', $_SESSION[$name]);
        if ($sessVal == $value || stripos($sessVal, '' . $value . '') !== false) $output = true;
    } else if (isset($_COOKIE[$name])) {
        $skip = false;
        $noCookieSave = $match['noCookieSave'];
        if (in_array($match['target'], $noCookieSave)) $skip = true;

        if (!$skip) {
            $cookVal = str_replace('%2C', ',', $_COOKIE[$name]);
            if ($cookVal == $value || stripos($cookVal, '' . $value . '') !== false) $output = true;
        }
    }
    return $output;
}



function login($email, $pass = null, $firstLogin = false, $uid = null, $data = null) {
    $db = MysqliDb::getInstance();
	// clear previously saved data
    $qs = null;
    $count = count(__('Q'));
    for ($i = 1; $i <= $count; $i++) $qs .= 'i.q'.$i.',';

    $email = trim($email);
    if ($uid)
        $db->where('u.id', $uid);
    else
        $db->where('u.email', $email);

    $db->join('users_info i', 'u.id = i.uid');
    $db->join('users_work w', 'u.id = w.uid', 'LEFT');
    $user = $db->getOne('users u',
    'u.id, u.prename, u.surname, u.zip, u.gender, u.birthday,'.$qs.'
    i.text,i.phone_number, i.phone_country_code, 
    w.id AS work');

	$prename = $user['prename'];
	$uid = $user['id'];
	$cookie = null;
	if (!empty($user['birthday'])) {
        $birthday = explode("-", $user['birthday']);
        $bday = $birthday[2] . '.' . $birthday[1] . '.' . $birthday[0];
        $_SESSION['birthdate'] = $bday;
        $cookie['birthdate'] = $bday;
    }
    $cookie['prename'] = $prename;
    $cookie['email'] = $email;
    $cookie['uid'] = $uid;
	for ($i = 1; $i <= $count; $i++) {
        if (!empty($user['q' . $i])) {
            $_SESSION['Q_' . $i] = $user['q' . $i];
        }
    }

	$_SESSION['prename'] = $prename;
	$_SESSION['surname'] = $user['surname'];
	$_SESSION['email'] = $email;
	$_SESSION['uid'] = $uid;
	if ($pass) $_SESSION['pass'] = $pass;
	// general
	$_SESSION['zip'] = $user['zip'];	
	$_SESSION['gender'] = $user['gender'];
	// extra
    $_SESSION['text'] = $user['text'];
    // Phone Number:
    $_SESSION['phone_number'] = $user['phone_number'];
    $_SESSION['phone_country_code'] = $user['phone_country_code'];
    if (isset($user['work'])) $_SESSION['work'] = true;

	// check if already paid
    // Assign customer service employee if user was already at least at step 3:
    if (!$firstLogin) $_SESSION['customer_service'] = 1;

    $db->where('uid', $_SESSION['uid']);
    $order = $db->getOne('orders', 'status, method');
    $status = $order['status'];

    if (empty($status)) {
        // User didn't pay yet
        $_SESSION['step'] = 3;
        $_SESSION['pending'] = 1;
    } else {
        // check if pay-status = pending
        if ($status == 'Completed') {
            $_SESSION['completed'] = true;
        } else {
            $_SESSION['step'] = 4;
            $_SESSION['pending'] = 1;
            // check and set pay-method
            $_SESSION['payment'] = $order['method'];
        }
    }

    // Topics:
    $db->where('f.uid', $_SESSION['uid']);
    $db->where('f.state', 1);
    $db->join('topics t', 't.id = f.tid');
    $topics = $db->get('topics_follow f', null, 'f.tid, t.title');
    if ($db->count > 0) {
        foreach ($topics as $x) {
            $title = $x['title'];
            $tid = $x['tid'];
            $_SESSION['topics'][$tid] = $title;
        }
    }

	// check if first time login
    $db->where('uid', $uid);
    $db->getValue('users_time', '1');

	if (empty($check)) { // INSERT: First time logged in
        $db->insert('users_time',
        ['uid' => $uid, 'login' => $db->now(), 'logout' => $db->now(), 'ip' => $_SERVER['REMOTE_ADDR']]);
	} else { // UPDATE: NOT first time logged in
	    $db->where('uid', $uid);
        $db->update('users_time',
        ['login' => $db->now(), 'logout' => $db->now(), 'ip' => $_SERVER['REMOTE_ADDR']]);
	}

	if (!empty($cookie)) {
	    define('COOKIESAVE', serialize($cookie));
    }
    // Login via filesys.php:
    if (!strpos($_SERVER['SCRIPT_FILENAME'], 'xhr.php')) {
        header('Location: ' . ROOT);
        exit();
    }
    $output['success'] = __('MODAL_LOGIN');

    return $output;
}

function format_text($string) {
	return nl2br($string);
} 

function shortStr($var,$len) {
	if (strlen($var) > $len){ $var = "".substr($var, 0, $len)."..."; }
	return $var;
}

function validation($done) {
    $output = null;
global $validate, $sum;
// if error
if (!empty($sum)) {
$output = "<ul>";
$i=0;
foreach ($validate as $error) { 
	$output .= "<li class='square";
	if ($i != 0) $output .= " pt10";  
	$output .= "'>".$error."</li>"; 
	$i++;
}
$output .= "</ul>";
} else if (!empty($_GET['error'])) {
// if success
$output .= '<ul>
      <li class="media">
        <span class="pull-left pt5" href="#">
            <i class="material-icons red">warning</i>
        </span>
        <div class="media-body">
          <p class="ml5 f11">'.__('S'.$_GET['error'].'').'</p>
        </div>
      </li>
    </ul>';
} else {
// if success
$output = '<ul>
      <li class="media">
        <span class="pull-left pt5" href="#">
            <i class="material-icons green">check</i> 
        </span>
        <div class="media-body">
          <p class="ml5 f11">'.__('S'.$done.'').'</p>
        </div>
      </li>
    </ul>';
}
return $output;
}

#todo: kann ersetzt werden wenn es kalenderauswahl f&uuml;r datum gibt:
function isValidDateTime($dateTime) {
    if (preg_match("/^(\d{4})-(\d{2})-(\d{2}) ([01][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/", $dateTime, $matches)) {
        if (checkdate($matches[2], $matches[3], $matches[1])) {
            return true;
        }
    }

    return false;
}

function add_order($uid, $price, $status, $payment, $txn_id = 0, $log = 0) {
    $order_id = null;
    $db = MysqliDb::getInstance();
    $db->where('uid', $uid);
    $get = $db->getOne('orders', 'id');
    $order_id = $get['id'];
    // Depending on existent db entry, update or insert new:
    if (empty($price)) $price = PRICE_DEFAULT;
    if ($db->count > 0) {
        # Set to 'Pending' when Reversed, Canceled_Reversal, Denied, Refunded
        $db->where('id', $order_id);
        $db->update('orders',
        ['method' => $payment, 'txn_id' => $txn_id, 'log' => $log, 'date_updated' => $db->now(), 'status' => $status]);
        $insert_id = $order_id;
    } else {
        $db->insert('orders',
        ['uid' => $uid, 'price' => $price, 'method' => $payment,
        'ip' => $_SERVER['REMOTE_ADDR'], 'txn_id' => $txn_id, 'log' => $log, 'date' => $db->now(),
        'status' => $status]);
        $insert_id = $db->getInsertId();
    }
    // Error Reporting
    if (!empty($db->getLastError())) {
        $data = [$db->getLastQuery(), $db->getLastError(), $_SESSION['uid']];
        send_mail('alexiovay@gmail.com', 'error', $data);
    }

	return $insert_id;
}


# sandbox 8mcYQzZEWRzyYqpu5ERezauuwNrB6juxYyZ79IIzQVIYFDgPuBvLEgjlXzC
# no sandbox 'PLuuP38m11H7w5xsGfaRKKFY9SmXsvSqgltMmz2K3Xcl1xCXLG8EclLFwRm';
function process_pdt($tx)
{
		$token = 'FEHtW03uOdInvN-eJOBOZHnX0PZ0Dt6Arukt2G5qIHWRA6p8sSWPjKA601G';
        // Init cURL
        $request = curl_init();

        // Set request options
        curl_setopt_array($request, array
        (
                CURLOPT_URL => 'https://www.paypal.com/cgi-bin/webscr',
                CURLOPT_POST => TRUE,
                CURLOPT_POSTFIELDS => http_build_query(array
                (
                        'cmd' => '_notify-synch',
                        'tx' => $tx,
                        'at' => $token,
                )),
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_HEADER => FALSE,
                CURLOPT_SSL_VERIFYPEER => FALSE, // todo auf TRUE setzen?
                CURLOPT_CAINFO => 'cacert.pem',
        ));

        // Execute request and get response and status code
        $response = curl_exec($request);
        $status   = curl_getinfo($request, CURLINFO_HTTP_CODE);

        // Close connection
        curl_close($request);

        // Validate response
        if($status == 200 AND strpos($response, 'SUCCESS') === 0)
        {
                // Remove SUCCESS part (7 characters long)
                $response = substr($response, 7);

                // Urldecode it
                $response = urldecode($response);

                // Turn it into associative array
                preg_match_all('/^([^=\r\n]++)=(.*+)/m', $response, $m, PREG_PATTERN_ORDER);
                $response = array_combine($m[1], $m[2]);

                // Fix character encoding if needed
                if(isset($response['charset']) AND strtoupper($response['charset']) !== 'UTF-8')
                {
                        foreach($response as $key => $value)
                        {
                                $value = mb_convert_encoding($value, 'UTF-8', $response['charset']);
                        }

                        $response['charset_original'] = $response['charset'];
                        $response['charset'] = 'UTF-8';
                }

                // Sort on keys
                ksort($response);

                // Done!
                return $response;
        }
		
        return FALSE;
	
}

// Class that abstracts both the $_COOKIE and setcookie()
class Cookie {
    // The array that stores the cookie
    protected $data = array();
    // Expiration time from now
    protected $expire;
    // Domain for the website
    protected $domain;

    // Default expiration is 28 days (28 * 3600 * 24 = 2419200).
    // Parameters:
    //   $cookie: $_COOKIE variable
    //   $expire: expiration time for the cookie in seconds
    //   $domain: domain for the application `example.com`, `test.com`
    public function __construct($cookie, $domain = false, $expire = 31536000)
    {
        // Set up the data of this cookie
        $this->data = $cookie;
        $this->expire = $expire;
        $domain = '.' . ROOT;

        if ($domain) {
            $this->domain = $domain;
        } else {
            $this->domain =
                isset($_SERVER['HTTP_X_FORWARDED_HOST']) ?
                    $_SERVER['HTTP_X_FORWARDED_HOST'] : isset($_SERVER['HTTP_HOST']) ?
                    $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];
        }
    }

    public function __get($name) {
        return (isset($this->data[$name])) ? $this->data[$name] : "";
    }

    public function __set($name, $value = null)
    {
        // Check whether the headers are already sent or not
        try {
            if (headers_sent())
                throw new Exception("Can't change cookie " . $name . " after sending headers.");
        } catch (Exception $e) {
            return false;
        }

        // Delete the cookie
        if (!$value)
        {
            setcookie($name, null, time() - 3600, '/', $this->domain);
            unset($this->data[$name]);
            unset($_COOKIE[$name]);
        }

        else
        {
            // Set the actual cookie
            setcookie($name, $value, time() + $this->expire, '/', $this->domain);
            $this->data[$name] = $value;
            $_COOKIE[$name] = $value;
        }
    }
}


?>