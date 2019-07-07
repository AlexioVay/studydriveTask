<?php

class Init {

    public function startup() {
        $db = MysqliDb::getInstance();
        // Pre-Init:
        $access = null;
        $signup = ROOT . 'signup/1';
        if ($_SESSION['step'] > 1) $signup = ROOT . 'signup/'.$_SESSION['step'];
        $button = __('BTN_PARTICIPATE');
        # At least Step 2 not completed:
        if (!isset($_SESSION['uid'])) {
            $reasons[] = __('REASON_COMPLETE');
        } else if (isset($_SESSION['uid'])) {
            // Calculate Profile Completion:
            if ($_SESSION['progression'] < 100) {
                $account = init::load('Account');
                $match['progression'] = $account->progression();
            }
            // Define Admin Access:
            if (!$_SESSION['admin']) {
                $db->where('uid', $_SESSION['uid']);
                $access = $db->getOne('users_access', 'id, users, orders, position');
                if ($db->count > 0) {
                    $_SESSION['admin'] = 1;
                }
            } else if ($_SESSION['admin']) {
                $access['users'] = 1;
                $access['orders'] = 1;
                $access['position'] = 1;
            }
            // Define Account Unlock Status:

            if (!$_SESSION['address']) {
                $db->where('uid', $_SESSION['uid']);
                $address_check = $db->getOne('users_address', 'street, housenumber, city, zip');
                if (empty($address_check)) {
                    $_SESSION['address'] = false;
                    $signup = 'settings';
                    $button = __('BTN_ENTER_ADDRESS');
                    $reasons[] = __('REASON_ADDRESS');
                } else {
                    $_SESSION['address'] = true;
                    $_SESSION['street'] = $address_check['street'];
                    $_SESSION['housenumber'] = $address_check['housenumber'];
                    $_SESSION['city'] = $address_check['city'];
                    $_SESSION['zip'] = $address_check['zip'];
                }
            }
            // Not completed:
            if ($_SESSION['completed']) {
                $reasons = null;
                $signup = ROOT;
            } else {
                $button = __('BTN_CONFIRM');
                $db->where('uid', $_SESSION['uid']);
                $db->where('status', 'Completed');
                $check = $db->getValue('orders', '1');

                $active_check = false;
                // Check all requirements:
                # Email not confirmed:
                if (!$_SESSION['inactive']) {
                    $db->where('uid', $_SESSION['uid']);
                    $active_check = $db->getValue('users_activate', '1');

                    if (!empty($active_check)) {
                        $active_check = false;
                        $_SESSION['inactive'] = 1;
                        $reasons[] = __('REASON_ACTIVATE');
                    } else {
                        $active_check = true;
                        unset($_SESSION['inactive']);
                    }
                }
                # Re-check and summarize:
                if (empty($check) || !$_SESSION['address'] || !$active_check) {
                    # Address not confirmed:
                    if (!$_SESSION['address']) {
                        $reasons[] = __('REASON_PAYMENT');
                        if ($_SESSION['payment'] == 'bt')
                            $signup = ROOT . 'signup/3#modal-payment';
                        else
                            $signup = ROOT . 'signup/3';
                    }
                    $_SESSION['pending'] = 1;
                } else {
                    $_SESSION['completed'] = true;
                    $_SESSION['step'] = 4;
                    unset($_SESSION['pending']);
                    $signup = ROOT;
                }
            }
            if (empty($signup)) $signup = ROOT . 'signup/' . $_SESSION['step'];
        } else if ($_COOKIE['uid'] && $_COOKIE['email'] && !defined('XFILE')) { // Do NOT Process when Xfile (External File) is set
            // Check for COOKIE when not logged in, automatically login user:
            $email = trim(str_replace('%40', '@', $_COOKIE['email']));
            $db->where('id', $_COOKIE['uid']);
            $db->where('email', $email);
            $db->getOne('users', 'COUNT(1)');
            // Validate success:
            if ($db->count > 0) {
                login($email);
            }
        }

        $output['signup'] = $signup;
        $output['reasons'] = $reasons;
        $output['access'] = $access;
        $output['button'] = $button;

        return $output;
    }

    public function account($signup) {
        $signup_button = null;
        $login = '<span class="dropdown">';

        // Profile Image:
        $mobile = false;
        $pimg = '<i class="material-icons account">account_circle</i>';
        if (IS_MOBILE)
            $mobile = true;

        if (!isset($_SESSION['uid'])) {
            // User NOT LOGGED in:
            $signup_button = '<a title="' . __('PARTICIPATE_TITLE') . '" href="' . $signup . '" class="btn xl btn-info">' . __('BTN_PARTICIPATE') . '</a>';

            $login .= '
            <a href="#modal-login" class="mi">
                '.$pimg.__('LOGIN').'
            </a>';
        } else {
            // User LOGGED in:
            $db = MysqliDb::getInstance();
            $db->where('rid', $_SESSION['uid']);
            $friends = $db->getValue('users_ref', 'COUNT(1)');

            if (empty($friends)) $friends = '-';
            $signup_button = '<a title="' . __('PARTICIPATE_TITLE') . '" class="btn xl btn-info" href="' . $signup . '">' . __('BTN_CONFIRM') . '</a>';
            $unlocked = false;
            $class = 'mi';
            $pimg = null;
            $pimg_path_part = 'upload/users/thumbnail/' . $_SESSION['uid'] . '.jpg';
            if (!$_SESSION['pimg']) {
                $pimg_path = ROOT_ABS . $pimg_path_part;
                if (file_exists($pimg_path)) {
                    $_SESSION['pimg'] = true;
                } else {
                    $pimg = '<i class="material-icons account">account_circle</i>';
                }
            } else {
                $pimg = '<img class="pimg" src="' . ROOT . $pimg_path_part . $_SESSION['pimg_cache']. '" alt="' . __('PIMG') . '" />';
                $class = 'pi';
            }

            if ($_SESSION['completed']) $unlocked = '<span title="' . __('ACCOUNT_UNLOCKED') . '"><i class="material-icons green">check_circle</i></span>';

            $dropdown_direction = ' dropdown-menu-right';
            $logout = null;
            if ($mobile) {
                $dropdown_direction = null;
                $logout = '<i class="material-icons logout">exit_to_app</i>';
            }
            $login .= '
                <span title="' . __('SETTINGS') . '" data-toggle="dropdown" class="'.$class.'">
                    '.$pimg.'
                    '.$_SESSION['prename'].'
                    '.$logout.' 
                </span>' . $unlocked;
            if (!IS_MOBILE) {
                $login .= '<ul class="dropdown-menu'.$dropdown_direction.'">';
                if ($_SESSION['admin']) {
                    $nav = $this->load('Navigation');
                    $login .= $nav->admin();
                }
            }

            if (!IS_MOBILE)
            $login .= '<li><a href="'.ROOT.'settings">' . __('SETTINGS') . '</a></li>
                <li><a class="logout">' . __('LOGOUT') . '</a></li>
                </ul>
            ';
        }
        $login .= '</span>';

        $output['login'] = $login;
        $output['signup_button'] = $signup_button;

        return $output;
    }

    public function jsTimeout($html, $ms = 1000) {
        $output = '
setTimeout(function(){'.($html).'}, '.$ms.');';

        return $output;
    }

    public function escape($data) {
        $output = preg_replace("/\r?\n/", "\\n", addslashes($data));
        return $output;
    }


    public function XHRReturn($data) {
        $case = htmlspecialchars($data);

        switch($case):
            case 'login':

            break;
            case 'logout':
                clearCookies();
                session_unset();
                session_destroy();
            break;
        endswitch;

        $uri = explode('?', $_SERVER['REQUEST_URI']);
        header('Location: ' . $uri[0]);
        exit();
    }

    public static function load($class) {
        require_once ROOT_CMS_ABS . '/classes/'.$class.'.php';
        $output = null;

        switch ($class):
            case 'Navigation': $output = new Navigation(); break;
            case 'Guarantee': $output = new Guarantee(); break;
            case 'Home': $output = new Home(); break;
            case 'Account': $output = new Account(); break;
            case 'Admin': $output = new Admin(); break;
            case 'News': $output = new News(); break;
            case 'Template': $output = new Template(); break;
            case 'Init': $output = new Init(); break;
            case 'Docs': $output = new Docs(); break;
            case 'Modal': $output = new Modal(); break;
        endswitch;

        return $output;
    }

    public function aside($data) {
        if ($data['target'] == 'settings') {
            $address = $data['address'];
            $account = $this->load('Account');
            $profile = $account->profile(false, $address);
        }

        $output = '
        <div class="sticky-top">
            '.$profile.'
            <div id="contact">
                <div class="mb40">
                    <div class="visible-xs pt10 pb20">
                        <hr />
                    </div>
                <h2>'.__('247_TITLE').'</h2>
                    <p>'.__('247').'</p>
            
                    <a href="http://facebook.com/'.FACEBOOK_USERNAME.'" target="_blank">
                        <div class="fb-bg gc">
                            <span id="button-fb"></span><br />
                            '.FACEBOOK_USERNAME.'
                        </div>
                    </a>
                    <div class="mt10">
                        <strong class="grey-light uc gc">'.__('MAIL_ADRESS').'</strong>
                    </div>
                </div>
            </div>
        </div>';

        return $output;
    }

    public function status($match) {
        $signup_button = $match['signup_button'];
        $status = '<div>';
        if (!$_SESSION['uid']) { // User not signed up or registered:
            $status .= advantages() . $signup_button;
        } else {
            if (is_array($match['reasons'])) { // User didnt pay or didnt verified all account info:

                $count = count($match['reasons']);
                $status .= '
                <h2 class="red">
                    <i class="material-icons red md-20 mr10">warning</i>
                    ' . __('INACTIVE_TITLE') . '
                </h2>
                <p>' . __('INACTIVE_TEXT', [$count]) . '</p>
                <ul class="mb10">';

                foreach ($match['reasons'] as $error) {
                    $status .= '<li class="square">' . $error . '</li>';
                }
                $status .= '
                </ul>
                ' . $match['signup_button'] . '
                ';

            } else if ($_SESSION['completed']) { // User paid and verified all account info:
                /** @var Account() $Account */
                $account = $this->load('Account');
                $signup_button = null;
                $db = MysqliDb::getInstance();
                // Check if test review was written or not:
                $db->where('uid', $_SESSION['uid']);
                $user_text = $db->getValue('users_info', 'text');

                // Check if profile is internally validated to get job offers:
                $db->where('uid', $_SESSION['uid']);
                $db->orderBy('date');
                $rating = $db->getOne('profile_rating',
                    'rating, text, DATE_FORMAT(`date`, "%d.%m.%Y, %H:%i") AS date');
                $rating_value = $rating['rating'];

                if (empty($user_text))
                    $box_text = __('USER_REVIEW_EMPTY');
                else if (!empty($rating))
                    $box_text = '<span class="grey f09">' . $rating['date'] . '</span><br />' . nl2br($rating['text']);

                $review_pt = null;
                $offers_html = null;
                $active_pb = null;
                if ($rating_value == 3) {
                    $db->where('r.uid', $_SESSION['uid']);
                    $db->join('jobs_response r', 'j.id = r.jid');
                    $db->join('topics g', 'j.game_id = g.id', 'LEFT');
                    $db->join('companies c', 'j.cid = c.id', 'LEFT');
                    $db->orderBy('r.response', 'DESC');
                    $jobs = $db->get('jobs j', null,
                        'c.name AS company, j.title, g.title AS game, 
                j.type, j.extras, j.salary, j.date,
                r.id AS rid, r.response');
                    $offers = null;
                    if ($db->count > 0 ) {
                        foreach ($jobs as $x) {
                            $id = $x['rid'];
                            $company = $x['company'];
                            $title = $x['title'];
                            $type = $x['type'];
                            $extras = $x['extras'];
                            $salary = $x['salary'];
                            $game = $x['game'];
                            $state = $x['response'];
                            $offers .= $account->offer($company, $salary, $game, $type, $state, $extras, $id);
                        }
                    }
                    if (!empty($offers)) {
                        $review_pt = 'pt30';
                        $active_pb = ' pb20';
                        $offers_html = "
                    <div class='offers-bg'>
                        <div class='gb'></div>     
                        <div class='container pt15'>
                            <h2>" . __('OPEN_OFFERS') . ":</h2>
                        </div>
                        
                        " . scroll_x_arrows() . "         
                        <div class='mt15 scroll-x dragscroll' data-snap-ignore='true'>
                            <div class='container'>
                            " . $offers . "                     
                            </div>
                        </div>
                        " . legend() . "       
                    </div>         
                    ";
                    }
                    $review = '
                <div class="container ' . $review_pt . ' pb15">
                    <div class="row">
                        <div class="col-sm-7">
                            <h2>' . __('USER_REVIEW_TITLE') . ':</h2>
                            <div class="box-green">' . $box_text . '</div>
                            <p class="note">' . __('USER_REVIEW_NOTE') . '</p>
                        </div>
                        <div class="col-sm-5">
                        </div>
                    </div>
                </div>
                ';
                }
                $progression = $account->progression(true);
                $status .= "
            <div class='row'>
                <div class='col-sm-7'>
                    <h2 class='green f13'><i class='material-icons green lh13 mr10 md-20'>check_circle</i>" . __('ACTIVE_TITLE') . "</h2>
                    <p class='ml2" . $active_pb . "'>" . __('ACTIVE_TEXT') . "</p>
                </div>
                <div class='col-sm-5'>
                    " . $progression['html'] . "
                </div>    
            </div>" . $offers_html;
                $status .= $review . ref_monthly();
            }
        }
        $status .= '</div>';

        return $status;
    }
}