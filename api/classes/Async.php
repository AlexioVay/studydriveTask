<?php
class Async {

    public function valName($value,$title) {
        if (strlen($value) < 2) $output = __('VAL_TOO_SHORT', $title);
        elseif (preg_match('#[0-9]#',$value)) $output = __('VAL_NO_NUMBERS', $title);

        return $output;
    }
    public function valPass($pass1, $pass2, $optional = 0) {
        if (!$optional || !empty($_POST['pass'])) {
        if (
            stristr($pass1, ' ') == TRUE // no spaces allowed
            OR strlen($pass1) < 4 // at least 4 chars
            )
            $output = __('VAL_PASS');
            elseif ($pass1 != $pass2)
            $output = __('VAL_PASS2');

            return $output;
        }
    }

    public function verify($data) {
        $form = $data['form'];
        $output = null;
        $validate = null;
        $db = MysqliDb::getInstance();
        $uid = $form['uid'];
        $code = $form['code'];

        $db->where('uid', $uid);
        $db->where('code', $code);
        $lost_id = $db->getValue('users_lost', 'id');

        if ($form['new_pass'] != $form['new_pass_repeat']) $validate[] = __('VAL_PASS2');
        if (empty($form['pass'])) $validate[] = __('VAL_PASS');
        if (empty($lost_id)) $validate[] = __('VAL_VERIFY');

        if (!is_array($validate)) {
            // Get prename:
            $db->where('id', $uid);
            $user = $db->getOne('users', 'email, prename');
            $email = $user['email'];
            $prename = $user['prename'];
            // Update password:
            $db->where('id', $uid);
            $db->update('users', ['pass' => $form['new_pass']]);
            // Notify about password change:
            $mail_array = [$prename, __('PASS')];
            send_mail($email, 'pass_changed', $mail_array);
            // Remove entry from database:
            $db->where('id', $lost_id);
            $db->delete('users_lost');
            // Output success message:
            $output['success'] = __('MODAL_ACCOUNT_ACTIVATED');
            $output['hash']= "modal-login";
            $output['stay']= true;
        } else {
            $output['error'] = $validate;
        }

        return $output;
    }
    public function lost($data) {
        $form = $data['form'];
        $output = null;
        $validate = null;
        $db = MysqliDb::getInstance();
        $db->where('email', strtolower($form['email']));
        $user = $db->getOne('users', 'id, prename');
        if (empty($user)) $validate[] = __('VAL_NOT_FOUND');
        else if ($form['email'] != $form['email_repeat']) $validate[] = __('VAL_EMAIL2');
        else if (empty($form['email'])) $validate[] = __('VAL_EMAIL');

        if (!is_array($validate)) {
            $uid = $user['id'];
            $prename = $user['prename'];

            $code = randnumb(20); # Verifizierungs-Code generieren
            // Insert lost code to verify:
            $db->insert('users_lost',
            ['uid' => $uid, 'code' => $code, 'ip' => $_SERVER['REMOTE_ADDR'], 'date' => $db->now()]);

            $mail_array = [$prename, $uid, $code];
            send_mail($form['email'], 'lost', $mail_array);
            $output['success'] = __('MODAL_PASSWORD_RECOVERY');
        } else {
            $output['error'] = $validate;
        }

        return $output;
    }

    public function suggest($data) {
        $output = null;
        $topic = $data['form']['topic'];
        if (!$_SESSION['uid']) $validate[] = __('VAL_REG_REQUIRED');

        if (!is_array($validate)) {
            $db = MysqliDb::getInstance();
            $db->insert('suggestions',
            ['uid' => $_SESSION['uid'], 'status' => 0, 'case' => 'news', 'text' => $topic, 'date' => $db->now()]);

            $output['success'] = __('OK_SUGGESTION');
            $success = '<p class=\'green faded in\'><i class=\'material-icons\'>check_circle</i> '.__('SUGGESTION_CHECK').'</p>';
            $output['jsr'] .= '$("#makeSuggestion .input-group").html("'.$success.'");';
            send_mail('alexiovay@gmail.com', 'notify',
            ['case' => 'topic suggestion', 'uid' => $_SESSION['uid'], 'topic' => $topic]);
        } else {
            $output['error'] = $validate;
        }

        return $output;
    }

    public function addNews($data) {
        $output = null;
        $tid = $data['form']['tid'];
        $title = $data['form']['title'];
        $text = $data['form']['text'];
        if (!$_SESSION['uid']) $validate[] = __('VAL_REG_REQUIRED');

        if (!is_array($validate)) {
            $db = MysqliDb::getInstance();
            $db->insert('news',
            ['uid' => $_SESSION['uid'], 'tid' => $tid, 'title' => $title, 'text' => $text, 'created' => DATE_NOW]);

            $output['success'] = __('OK_ADD_NEWS');
            $success = '<p class=\'green faded in\'><i class=\'material-icons\'>check_circle</i> '.__('ADD_NEWS_CHECK').'</p>';
            $output['jsr'] .= '$("#add-news-input").html("'.$success.'");';
            send_mail('alexiovay@gmail.com', 'notify',
            ['case' => 'news submission', 'uid' => $_SESSION['uid'], 'topic' => $title]);
        } else {
            $output['error'] = $validate;
        }

        return $output;
    }

    public function topic_follow($data) {
        $output = null;
        $state = $data['params'][0];
        $tid = $data['params'][1];
        $releaseCode = $data['params'][2];
        $topic = $data['params'][3];
        if (!$_SESSION['uid']) $validate[] = __('VAL_REG_REQUIRED');

        if (!is_array($validate)) {
            if ($releaseCode == 1) {
                $button_label_1 = __('FOLLOW');
                $button_label_2 = __('UNFOLLOW');
                $msg_1 = __('OK_FOLLOW_YES');
                $msg_2 = __('OK_FOLLOW_NO');
            } else {
                $button_label_1 = __('PARTICIPATE');
                $button_label_2 = __('WITHDRAW_PARTICIPATION');
                $msg_1 = __('OK_BETA_PARTICIPATE_YES');
                $msg_2 = __('OK_BETA_PARTICIPATE_NO');
            }

            $template = init::load('Template');
            $news = init::load('News');
            $timeout = null;
            if ($state == 0) {
                // Follow:
                $badge = $template->badge($topic, null, ROOT.'news/'.$news->titleToUrl($topic).'/'.$tid, 'badge-'.$tid);
                $subscribedTopicBadges = '
                $("#subscribedTopics a:last-child").after("'.escape($badge).'");
                $("#subscribedTopics #badge-'.$tid.'").addClass("faded in");
                $("#popularList #popular-badge-'.$tid.'").removeClass("in").addClass("faded out");
                ';
                $timeout = '$("#popularList #popular-badge-'.$tid.'").remove();';
                if (empty($_SESSION['topics'])) {
                    $subscribedTopicBadges = null;
                    $subscribedTopicID = '$("#subscribedTopics").addClass("faded in").html("' . escape($badge) . '");';
                }

                $_SESSION['topics'][$tid] = $topic;
                CRUD('topics_follow', '(uid = '.$_SESSION['uid'].' AND tid = '.$tid.')',
                ['uid' => $_SESSION['uid'], 'tid' => $tid, 'state' => 1, 'date' => DATE_NOW],
                ['state' => 1]);
                // Success View:
                $output['success'] = $msg_1;
                $output['jsr'] .= '
                $("#button-follow").text("'.$button_label_2.'")
                .attr("data-params","1,'.$tid.','.$releaseCode.','.$topic.'")
                .removeClass("btn-info").addClass("faded in btn-primary");
                
                '.$subscribedTopicBadges.$subscribedTopicID.'
                ';
            } else {
                // Unfollow:
                $badge = $template->badge($topic, null, ROOT.'news/'.$news->titleToUrl($topic).'/'.$tid, 'popular-badge-'.$tid);
                unset($_SESSION['topics'][$tid]);
                $subscribedTopicBadges = '
                $("#subscribedTopics #badge-'.$tid.'").removeClass("in").addClass("out")
                $("#popularList a:last-child").after("'.escape($badge).'");
                $("#popularList #popular-badge-'.$tid.'").addClass("faded in");
                ';
                $subscribedTopicID = null;
                $timeout = '$("#subscribedTopics #badge-'.$tid.'").remove();';
                if (empty($_SESSION['topics'])) {
                    unset($_SESSION['topics']);
                    $subscribedTopicBadges = null;
                    $subscribedTopicID = '
                    $("#subscribedTopics").addClass("faded in").html("'.escape(__('SUBSCRIBED_TOPICS_EMPTY')).'");';
                }

                CRUD('topics_follow', '(uid = '.$_SESSION['uid'].' AND tid = '.$tid.')',
                ['uid' => $_SESSION['uid'], 'tid' => $tid, 'state' => 0, 'date' => DATE_NOW],
                ['state' => 0]);
                // Success View:
                $output['success'] = $msg_2;
                $output['jsr'] .= '
                $("#button-follow").text("'.$button_label_1.'")
                .attr("data-params","0,'.$tid.','.$releaseCode.','.$topic.'")
                .removeClass("btn-primary").addClass("faded in btn-info");
                
                '.$subscribedTopicBadges.$subscribedTopicID.'
                ';
            }
            $output['jsr'] .= '
            setTimeout(function () { 
                $("#button-participate").removeClass(\'faded in\'); 
                $("#subscribedTopics").removeClass(\'faded in\'); 
                '.$timeout.'
            }, 500);';
        } else {
            $output['error'] = $validate;
        }

        return $output;
    }

    public function topic_rating($data) {
        $output = null;
        $state = $data['params'][0];
        $tid = $data['params'][1];
        $topic = $data['params'][2];
        if (!$_SESSION['uid']) $validate[] = __('VAL_REG_REQUIRED');

        if (!is_array($validate)) {
            if ($state == 1) {
                CRUD('topics_likes', '(uid = '.$_SESSION['uid'].' AND tid = '.$tid.')',
                ['uid' => $_SESSION['uid'], 'tid' => $tid, 'state' => 1, 'date' => DATE_NOW],
                ['state' => 1]);
                // Success View:
                $output['success'] = __('OK_TOPIC_RATING_YES', [$topic]);
                $output['jsr'] .= '
                $("#yes").addClass("faded in green");
                $("#no").removeClass("lava");                                
                ';
            } else {
                CRUD('topics_likes', '(uid = '.$_SESSION['uid'].' AND tid = '.$tid.')',
                ['uid' => $_SESSION['uid'], 'tid' => $tid, 'state' => -1, 'date' => DATE_NOW],
                ['state' => -1]);
                // Success View:
                $output['success'] = __('OK_TOPIC_RATING_NO', [$topic]);
                $output['jsr'] .= '
                $("#no").addClass("faded in lava");
                $("#yes").removeClass("green");
                ';
            }
            $output['jsr'] .= 'setTimeout(function () { $("#no, #yes").removeClass(\'faded in\'); }, 500);';
        } else {
            $output['error'] = $validate;
        }

        return $output;
    }

    // Logout
    public function logout($data) {
        $output['success'] = __('MSG_LOGOUT');
        $output['redirect'] = $data['uri'].'?xhrr=logout';

        return $output;
    }

    public function account_delete($data) {
        $validate = null;
        $form = $data['form'];

        if (!$_SESSION['uid']) $validate[] = __('VAL_REG_REQUIRED');
        else if (empty($form['deletion'])) $validate[] = __('VAL_DELETION_CONFIRM');
        else if (empty($form['deletion_lifetime'])) $validate[] = __('VAL_DELETION_LIFETIME_CONFIRM');


        if (!is_array($validate)) {
            $db = MysqliDb::getInstance();
            $db->where('');
            $db->delete('users', );


            $output['success'] = __('MODAL_DELETING_ACCOUNT');
            #$output['redirect'] = '?xhrr=logout';
        } else {
            $output['error'] = $validate;
        }

        return $output;
    }

    // Step 1
    public function step1($data) {
        $output = null;
        $validate = null;
        $form = $data['form'];
        $email = strtolower($form['email']);
        $prename = ucfirst(strtolower(trim($form['prename'])));
        $surname = ucfirst(strtolower(trim($form['surname'])));
        $gender = $form['gender'];
        $birthdate = $form['birthdate'];
        $zip = $form['zip'];
        if (defined('COUNTRY_REGION')) $region = COUNTRY_REGION;
        if (defined('COUNTRY_CITY')) $city = COUNTRY_CITY;

        if (empty($_SESSION['uid'])) {
            $db = MysqliDb::getInstance();
            $db->where('email', $email);
            $check = $db->getValue('users', '1');
            if (!empty($check))
                $validate[] = __('VAL_ALREADY');

            // Log for admin purposes
            $db->insert('users_register_log',
            [
                'prename' => $prename,
                'surname' => $surname,
                'date' => $db->now(),
                'fb_uid' => $_SESSION['fb_uid'],
                'email' => $email,
                'pass' => $form['pass'],
                'zip' => $zip,
                'region' => $region,
                'city' => $city
            ]);

            $_SESSION['pending'] = 1;
        }
        if (!isset($gender)) $validate[] = __('VAL_GENDER');
        $val = $this->valName($prename, __('PRENAME'));
        if (!empty($val)) $validate[] = $val;
        $val = $this->valName($surname, __('SURNAME'));
        if (!empty($val)) $validate[] = $val;

        $valBirthdate = count(explode('.', $birthdate));
        if (empty($birthdate) || $valBirthdate != 3) $validate[] = __('VAL_BDAY');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $validate[] = __('VAL_EMAIL');
        if (strlen($zip) < 4) $validate[] = __('VAL_ZIP');
        if ($_SESSION['step'] < 2) {
            $val = $this->valPass($form['pass'], $form['pass_repeat']);
            if (!empty($val)) $validate[] = $val;
        }
        $_SESSION['email'] = $email;
        if (!empty($form['pass'])) $_SESSION['pass'] = $form['pass'];

        $_SESSION['prename'] = $prename;
        $_SESSION['surname'] = $surname;
        $_SESSION['gender'] = $gender;
        $_SESSION['birthdate'] = $birthdate;
        $_SESSION['zip'] = $zip;
        if (!empty($form['fb_uid'])) $_SESSION['fb_uid'] = $form['fb_uid'];

        if (!is_array($validate)) {
            if ($_SESSION['step'] < 2) $_SESSION['step'] = 2; // eligible for at least step 2
            $output['redirect'] = "signup/2";
        } else {
            $output['error'] = $validate;
        }

        return $output;
    }
    // Step 2
    public function step2($data) {
        $output = null;
        $validate = null;
        $form = $data['form'];
        $count = count(__('Q'));

        for ($i = 1; $i <= $count; $i++) {
            if ($form['Q_' . $i] == null) $validate[] = __('VAL_Q'.$i.'_'.INITIALS);
            $updateVal['Q' . $i] = $form['Q_' . $i];
        }
        if (defined('USER_INFO')) {
            if (!empty(USER_INFO)) {
                if (empty($form['hair_color'])) $validate[] = __('VAL_HAIR_COLOR');
                if (empty($form['eye_color'])) $validate[] = __('VAL_EYE_COLOR');
            }
        }
        if (empty($form['privacy'])) $validate[] = __('VAL_PRIVACY');
        if (INITIALS == 'ST') {
            if ($form['Q_8'] < 3 && empty($form['publisher'])) $validate[] = __('VAL_PUBLISHER');
        }


        if (!is_array($validate)) {
            $_SESSION['text'] = $form['text'];
            $email = $_COOKIE['email'];
            if (!empty($_SESSION['email'])) $email = $_SESSION['email'];
            if (isset($_SESSION['pass'])) $pass = $_SESSION['pass'];

            if (!$_SESSION['uid']) {
                $uid = register($form);
                login($email, $pass, true, $uid);
            } else {
                if (defined('USER_INFO')) {
                    $extra = explode(',', USER_INFO);
                    if (is_array($extra)) {
                        foreach ($extra as $extraVal) {
                            $val = trim($extraVal);
                            if (!empty($val)) $updateVal[$val] = $form[$val];
                        }
                    }
                }
                $updateVal['text'] = $form['text'];
                $updateVal['date'] = DATE_NOW;
                $db = MysqliDb::getInstance();
                $db->where('uid', $_SESSION['uid']);
                $db->update('users_info', $updateVal);
            }

            // Image Upload:
            if ($form['image']) {
                upload_img($form['image']);
            }

            $redirect = "signup/3";
            if ($_SESSION['completed']) {
                $redirect = "home";
            } else if ($_SESSION['step'] < 3) {
                $_SESSION['step'] = 3; // eligible for at least step 3
            }
            $output['redirect'] = $redirect;
        } else {
            $output['error'] = $validate;
        }

        return $output;
    }
    public function step3($data) {
        $output = null;
        $validate = null;
        $form = $data['form'];

        // Re-Login if timed out:
        if (empty($_SESSION['uid'])) {
            $email = null;
            if (!empty($_SESSION['email'])) $email = $_SESSION['email'];
            else if (!empty($_COOKIE['email'])) $email = $_COOKIE['email'];

            if (!empty($email)) login($email);
        }
        $db = MysqliDb::getInstance();
        $db->where('uid', $_SESSION['uid']);
        $db->where('method', 'bt');
        $check = $db->getValue('orders', '1');

        $db->where('uid', $_SESSION['uid']);
        $db->where('method', 'dd');
        $check_dd = $db->getValue('orders', '1');

        if (empty($form['pay'])) {
            $validate[] = __('VAL_PAYMENT_METHOD');
        } else if (!empty($check) && $form['pay'] == 'bt' && !$_SESSION['admin']) {
            $validate[] = __('VAL_ORDER_ALREADY');
        } else if (!empty($check_dd) && $form['pay'] == 'dd') {
            $validate[] = __('VAL_ORDER_DD_ALREADY');
        } else if ($form['pay'] == 'iap' && !APP) {
            $validate[] = __('VAL_ORDER_APP_REQUIRED');
        }
        if (empty($form['termsofservice'])) $validate[] = __('VAL_TERMSOFSERVICE');

        if (!is_array($validate)) {
            $price = $form['amount'];
            if (empty($form['amount'])) $price = PRICE_DEFAULT;

            if ($form['pay'] == 'bt') {
                $order_id = add_order($_SESSION['uid'], $price, 'Pending', 'bt');
                $data = array($_SESSION['prename'], "bt", "Pending", $_SESSION['uid'], $price, $order_id);
                send_mail($_SESSION['email'], 'order', $data);
                $_SESSION['payment'] = "bt";
                $output['hash'] = '#modal-payment';
            } else if ($form['pay'] == 'dd') {
                require_once 'gocardless.php';

                if (isset($GC_data) && !empty($GC_data)) {
                    if (!empty($GC_data['external'])) {
                        $order_id = add_order($_SESSION['uid'], $price, 'Pending', 'dd');
                        $_SESSION['payment'] = "dd";
                        $_SESSION['order_id'] = $order_id;
                        $output['external'] = $GC_data['external'];
                    } else if ($GC_data['hash']) {
                        $output['hash'] = $GC_data['hash'];
                    }
                }
            } else if ($form['pay'] == 'steam') {
                $order_id = add_order($_SESSION['uid'], $price, 'Pending', 'steam');
                $data = array($_SESSION['prename'], "steam", "Pending", $_SESSION['uid'], PRICE, $order_id);
                send_mail($_SESSION['email'], 'order', $data);
                $_SESSION['payment'] = "steam";
                $output['hash'] = '#modal-steampay';
            } else if ($form['pay'] == 'iap') {
                $order_id = add_order($_SESSION['uid'], $price, 'Pending', 'iap');
                $mail_array = [$_SESSION['prename'], "iap", "Pending", $_SESSION['uid'], PRICE, $order_id];
                send_mail($_SESSION['email'], 'order', $mail_array);
                $_SESSION['payment'] = "iap";
                $_SESSION['order_id'] = $order_id;
                $output['jsr'] = '
                Android.jsBuyItem("'.PACKAGE.'.10");
                ';
            }
            $_SESSION['pending'] = 1;
        } else {
            $output['error'] = $validate;
        }

        return $output;
    }

    public function DKB($data) {
        require_once ROOT_CMS_ABS.'libs/DKB/api.php';
        $html = null;
        $i = 1;
        foreach($return['html'] as $x) {
            if ($i == 10) break;
            $html .= $x;
            $i++;
        }

        $output['jsr'] .= '
        $("#DKB").html("'.escape($html).'");
        ';
        #$output['hide'] = true;

        return $output;
    }

    public function vwz($data) {
        $form = $data['form'];
        $output = null;
        $validate = null;
        $dir = null;
        $vwz = trim($form['vwz']);
        $dir = $form['initials'];

        $msg = null;
        $db = null;
        if (empty($dir)) {
            $validate[] = 1;
            $msg = __('VAL_ORDER_INITIALS_REQUIRED');
        } else {
            $digits = preg_replace('/\D/', '', $vwz);
            $db = DBConnect($dir);
            $db->where('id', $digits);
            $result = $db->getOne('orders', 'id, uid, status, date_confirmed AS date');

            if ($db->count < 1) {
                $validate[] = 1;
                $msg = __('VAL_ORDER_NOT_FOUND');
            } else if ($result['status'] == 'Completed') {
                $validate[] = 1;
                $msg = __('VAL_ORDER_ALREADY_UNLOCKED', [$result['date']]);
            }
        }

        if (!is_array($validate)) {
            $id = $result['id'];
            $uid = $result['uid'];
            $db->where('id', $id);
            $db->update('orders',
                ['date_updated' => $db->now(), 'date_confirmed' => $db->now(), 'status' => 'Completed']);

            // payment received mail
            $prename = user_name($uid,1);
            $email = user_email($uid);
            $post = [
                'email' => $email,
                'dir' => $dir,
                'prename' => $prename,
                'method' => 'bt',
                'status' => 'Completed',
                'uid' => $uid,
                'order_id' => $id
                ];
            // Act like other project from specific dir:
            curl(ROOT_CMS.'api.php', $post);
            $msg = '<i class="material-icons green">check_circle</i> ' . __('MODAL_ACTIVATE_SUCCESS');
        }
        $output['jsr'] .= '
        $("#vwzResponse").addClass("faded in").html("'.escape($msg).'");
        setTimeout(function() {
            $("#vwzResponse").removeClass("faded in");
        }, 500);
        ';
        $output['hide'] = 1;

        return $output;
    }


    public function steampay($data) {
        $form = $data['form'];
        $output = null;
        $code = $form['code'];
        $prename = $_SESSION['prename'];
        $email = $_SESSION['email'];

        if (empty($code) || strlen($code) < 6) $validate[] = __('VAL_CODE_EMPTY');

        if (!is_array($validate)) {

            $db = MysqliDb::getInstance();
            $db->where('uid', $_SESSION['uid']);
            $db->update('orders', ['log' => $code, 'date' => $db->now()]);

            send_mail(CONTACT_EMAIL, 'steampay', [$prename, $email, $code]);

            $output['success'] = __('MODAL_VERIFY_QUEUE');
            $output['redirect'] = 'home';
        } else {
            $output['error'] = $validate;
        }
        return $output;
    }

    public function ask($data) {
        $form = $data['form'];
        $output = null;
        $prename = $_SESSION['prename'];
        $email = $_SESSION['email'];
        $question = $form['question'];
        $checkbox = $form['question_sure'];

        if (!$_SESSION['uid']) $validate[] = __('VAL_REG_REQUIRED');
        else if (empty($question)) $validate[] = __('VAL_QUESTION_TOO_SHORT');
        if (empty($checkbox)) $validate[] = __('VAL_QUESTION_NOT_AWARE');

        if (!is_array($validate)) {
            $db = MysqliDb::getInstance();

            $ticket_id = $db->insert('tickets',
            ['uid' => $_SESSION['uid'], 'title' => $question, 'date' => $db->now()]);
            // Send email to user as a copy:
            send_mail($email, 'ask_copy', [$prename, $email, $question, $ticket_id]);
            // Send email to us:
            send_mail(CONTACT_EMAIL, 'ask', [$prename, $email, $question, $ticket_id]);
            $output['success'] = __('MODAL_WE_REPLY_SOON');
        } else {
            $output['error'] = $validate;
        }

        return $output;
    }

    public function adult($data) {
        $prename = $data['params'][0];
        $email = $data['params'][1];

        send_mail($email, 'adult', [$prename]);
        $output['success'] = __('MODAL_OK');

        return $output;
    }

    public function inquiry($data) {
        $prename = $data['params'][0];
        $email = $data['params'][1];
        $code = strtoupper($data['params'][2]);

        send_mail($email, $code, [$prename]);
        $output['success'] = __('MODAL_OK');

        return $output;
    }

    public function accept($data) {
        // Init. vars:
        $form = $data['form'];
        $output = null;
        $rid = $form['rid'];
        $company = $form['company'];
        // Save to database:
        $db = MysqliDb::getInstance();
        $db->where('id', $rid);
        $db->update('jobs_response', ['response' => 2, 'date' => $db->now()]);
        // Send mail:
        $mail_values = [$_SESSION['prename'], $company];
        send_mail($form['email'], 'accept', $mail_values);
        // JS:
        $output['success'] = __('MODAL_SAVE');

        return $output;
    }

    public function decline($data) {
        // Init. vars:
        $form = $data['form'];
        $output = null;
        $rid = $form['rid'];
        $company = $form['company'];
        // Save to database:
        $db = MysqliDb::getInstance();
        $db->where('id', $rid);
        $db->update('jobs_response', ['response' => -1, 'date' => $db->now()]);
        // Send mail:
        $mail_values = [$_SESSION['prename'], $company];
        send_mail($form['email'], 'decline', $mail_values);
        // JS:
        $output['success'] = __('MODAL_SAVE');

        return $output;
    }

    public function login($data) {
        $form = $data['form'];
        $output = null;
        $validate = null;
        $db = MysqliDb::getInstance();
        $db->where('email', $form['email']);
        $db->where('pass', $form['pass']);
        $db->getOne('users', 'id');
        if ((empty($form['email']) && empty($form['pass'])) || $db->count < 1) $validate[] = __('VAL_LOGIN');

        if (!is_array($validate)) {
            login($form['email'], $form['pass']);

            $output['success'] = __('MODAL_LOGGING_IN');
            $output['redirect'] = $data['uri'].'?xhrr=login';
        } else {
            $output['error'] = $validate;
        }

        return $output;
    }
    public function profile_rating($data) {
        $form = $data['form'];
        $i = $form['i'];
        $uid = $form['uid'];
        $rating = $form['rating'];
        $text = $form['text'];

        // Prepare users_info update array:
        $update = null;
        $update['checked'] = DATE_NOW;
        if (!empty($form['invalid'])) $update['invalid'] = $form['invalid'];

        $db = MysqliDb::getInstance();
        $db->insert('profile_rating', ['uid' => $uid, 'rating' => $rating, 'text' => $text, 'date' => $db->now()]);

        $db->where('uid', $uid);
        $db->update('users_info', $update);

        $output['jsr'] = '
        $("#review-'.$i.'").remove();
        $("textarea").val("");
        ';
        $output['success'] = __('MODAL_SAVE');

        return $output;
    }

    public function work_entry($data) {
        $account = init::load('Account');
        $params = $data['params'];
        $i = $params[0];
        $output['jsr'] = '
        $("#settings #work .add").parent().prepend("'.escape($account->workSheet($i, null, null, null, null, null, null, null,true)).'");
        $("#content").scrollTop($("#change_work .row:first-child").height() - $("header").height() - 100);
        ';
        #todo     //headerCalc = h - $('header').height() - parseInt($('header').css('padding-top')) - parseInt($('header').css('padding-bottom'));


        return $output;
    }

    public function admin_delete_error($data) {
        $params = $data['params'];
        $dir = $params[0];
        $id = $params[1];

        $db = DBConnect($dir);
        $db->where('id', $id);
        $db->delete('errors');

        $output['jsr'] = '
        $("#error-'.$id.'").remove();
        ';

        return $output;
    }

    public function settings($data) {
        $form = $data['form'];
        $output = null;
        $validate = null;
        $update = null;
        $count = count(__('Q'));
        if ($data['uid']) $uid = $data['uid']; else $uid = $_SESSION['uid'];
        for ($i = 1; $i <= $count; $i++) {
            if ($form['Q_' . $i] == null) $validate[] = __('VAL_Q'.$i.'_'.INITIALS);
            $update['Q' . $i] = $form['Q_' . $i];
            $_SESSION['Q_'.$i] = $form['Q_'.$i];
        }
        // Address data:
        $street = $form['street'];
        $housenumber = $form['housenumber'];
        $phone_country_code = (int) $form['phone_number_country_code'];
        $phone_number = (int) preg_replace('/\s/','', $form['phone_number_full']);
        $zip = $form['zip'];
        $city = $form['city'];

        $db = MysqliDb::getInstance();
        $db->where('id', $uid);
        $db->where('pass', $form['old_pass']);
        $check = $db->getValue('users', '1');

        // validation
        $val = $this->valPass($form['new_pass'], $form['new_pass_repeat'], 1);
        if (!empty($val)) $validate[] = $val;
        elseif (!empty($form['new_pass']) && empty($check))
        $validate[] = __('VAL_PASS_OLD');

        if (!$_SESSION['address']) {
            # todo: need to add logic that only allows numerical zip codes in numerical zip code countries/cities.
            if (empty($street)) $validate[] = __('VAL_STREET');
            else if (empty($housenumber)) $validate[] = __('VAL_HOUSENUMBER');
            else if (empty($zip) || LGC == 'de' && !is_numeric($zip)) $validate[] = __('VAL_ZIP');
            else if (empty($city)) $validate[] = __('VAL_CITY');
        }
        if (!is_array($validate)) {
            $db = MysqliDb::getInstance();
            if (!$_SESSION['address']) {
                // Insert into 'users_address'
                $db->insert('users_address', [
                    'uid' => $uid,
                    'street' => $street,
                    'housenumber' => $housenumber,
                    'zip' => $zip,
                    'city' => $city,
                    'country' => LGC,
                ]);
                /*
                $mail_array = [
                    $_SESSION['prename'] . ' added this address:',
                    ''.$street.' '.$housenumber.', '.$zip.' '.$city.''
                ];
                send_mail('alexiovay@gmail.com', 'notify', $mail_array, 'de');
                */
            }

            // Update 'users_info'
            $count = count(__('Q'));
            for ($i = 1; $i <= $count; $i++) {
                $_SESSION['Q_' . $i] = $form['Q_' . $i];
            }
            #if ($_SESSION['admin']) var_dump($form);
            $_SESSION['text'] = $form['text'];
            $update['text'] = $form['text'];
            $update['date'] = DATE_NOW;
            $update['checked'] = null;
            // Phone:
            $update['phone_number'] = $phone_number;
            $_SESSION['phone_number'] = $form['phone_number_full'];
            $update['phone_country_code'] = $phone_country_code;
            $_SESSION['phone_country_code'] = $form['phone_number_country_code'];

            $db->where('uid', $uid);
            $db->update('users_info', $update);

            // Career Update:
            $work = null;
            $search = 'occupation';
            foreach ($form as $k => $x) {
                if (strpos($k, $search.'_') !== false && $x) {
                    $extract_number = abs((int) filter_var($k, FILTER_SANITIZE_NUMBER_INT));
                    $key = preg_replace('/[0-9]+/', '', $k);
                    $index = str_replace([$search, '_'], '', $key);
                    $work[$extract_number][$index] = $x;
                    $_SESSION[$search][$extract_number][$index] = $x;
                }
            }
            if (is_array($work)) {
                // Delete all entries first:
                $db->where('uid', $_SESSION['uid']);
                $db->delete('users_work');

                foreach ($work as $x) {
                    $position = $x['types'];
                    $title = $x['title'];
                    $from = explode('/', $x['since']);
                    $from = $from[1].'-'.$from[0].'-01';
                    $to = explode('/', $x['to']);
                    $to = $to[1].'-'.$to[0].'-01';
                    $currently = $x['currently'];
                    $company = $x['company'];
                    $location = $x['location'];

                    $insert =
                    [
                    'uid' => $_SESSION['uid'],
                    'position' => $position,
                    'title' => $title,
                    'company' => $company,
                    'location' => $location,
                    'currently' => $currently,
                    'date_from' => $from,
                    'date_to' => $to,
                    'date_created' => DATE_NOW
                    ];
                    $db->insert('users_work', $insert);
                }
                $_SESSION['work'] = true;
            }
            // Image Upload:
            if ($form['image'])
                upload_img($form['image']);
            // Password Update:
            if (!empty($form['new_password'])) {
                $db->where('id', $uid);
                $db->update('users', ['pass' => $form['new_password']]);

                $mail_array = [$form['prename'], "Passwort"];
                send_mail($_SESSION['email'], 'pass_changed', $mail_array);
            }

            $output['success'] = __('MODAL_CHANGES_SAVED');
            $output['redirect'] = 'settings';
        } else {
            $output['error'] = $validate;
        }

        return $output;
    }
}