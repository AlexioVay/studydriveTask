<?php

class Account {

    public function progression($button = null) {
        $html = null;
        $progression = 100;
        $li = null;
        if ($_SESSION['progression'] < 100) {
            if (!$_SESSION['pimg']) {
                $li .= '<li class="square">' . __('PIMG') . '</li>';
                $progression -= 10;
            }
            if (!$_SESSION['address']) {
                $li .= '<li class="square">' . __('ADDRESS') . '</li>';
                $progression -= 20;
            }
            if (!$_SESSION['phone_number']) {
                $li .= '<li class="square">' . __('PHONE_NUMBER') . '</li>';
                $progression -= 10;
            }
            if (!$_SESSION['work']) {
                $li .= '<li class="square">' . __('WORK') . '</li>';
                $progression -= 20;
            }

            $class = null;
            if ($button)
                $button = '
                <div class="cta">
                    <a href="'.ROOT.'settings" class="btn btn-info">'.__('COMPLETE_PROFILE').'</a>
                </div>
                ';
            else
                $class = ' class="mt"';

            $html = '
            <div id="progression"'.$class.'>
                <i class="material-icons md-20">timelapse</i> <h2>' . __('PROGRESSION_TITLE', [$progression]) . '</h2>
                <p>' . __('PROGRESSION_TEXT') . '</p>
                <ul>
                    ' . $li . '
                </ul>
                '.$button.'
            </div>
            ';
        }
        $_SESSION['progression'] = $progression;

        $output['value'] = $progression;
        $output['html'] = $html;

        return $output;
    }

    public function skills($data) {
        $dir = $data['dir'];
        $q4 = $data['q4'];
        $q5 = $data['q5'];
        $q6 = $data['q6'];
        $q7 = $data['q7'];

        $hidden = false;
        if ($data['hidden']) $hidden = $data['hidden'];
        $output = null;

        if ($dir == 'spieletester') {
            if ($q4 || $q5 || $q6 || $q7) {
                $output .= '<br />';
                // Q4 - English skills:
                if (!empty($q4)) {
                    if (!$hidden || ($hidden && $q4 <= 2))
                    $output .= __('ENGLISH_SKILLS') . ': ' . __('Q4')['answers'][$q4] . ' &nbsp;&middot;&nbsp; ';
                }
                // Q5 - Work type:
                if ($q5) {
                    if (!$hidden) {
                        $output .= __('WORK_TYPE') . ': ';
                        $ex = explode(',', $q5);
                        $type = null;
                        foreach ($ex as $z) {
                            $title = __('Q5')['answers'][$z];
                            if (!empty($z) || ((is_array($type)) && !in_array($title, $type))) $type[] = $title;
                        }
                        if (is_array($type)) $output .= implode(', ', $type) . ' &nbsp;&middot;&nbsp; ';
                    }
                }
                // Q6 - Work experience:
                if ($q6 && $q6 < 4) {
                    if (!$hidden || ($hidden && $q6 <= 3))
                    $output .= __('WORK_EXPERIENCE') . ': ' . __('Q6')['answers'][$q6] . ' &nbsp;&middot;&nbsp; ';
                }
                // Q7 - Job abroad:
                if ($q7) {
                    if (!$hidden || ($hidden && $q7 == 1))
                    $output .= __('TRAVEL_READINESS') . ': ' . __('Q7')['answers'][$q7];
                }
            }
        }

        return $output;
    }

    private function signup($data) {
        /** @var Init $init */
        $init = init::load('Init');

        $left = 7;
        $right = 5;
        // Aside
        if ($data['target'] == 'settings')
            $data['settings'] = $this->settings($data);


        $a = null;
        $b = null;
        $aside = null;
        if (!IS_MOBILE) {
            $aside = $init->aside(['target' => $data['target'], 'address' => $data['settings']['aside']]);
            if ($data['params']['step'] < 3) {
                $a = '
                <div class="row">
                    <div class="col-sm-' . $left . '">';
                $b = '
                    <div class="col-sm-' . $right . ' sticky-top-container">' . $aside . '</div>
                </div>';
            }
        }

        $subtarget = $data['subtarget'];
        $data['aside'] = $aside;
        $main = $this->$subtarget($data);

        $output = '<div class="container pt20 mb25">'.$a.$main.$b.'</div>';

        return $output;
    }

    public function output($data) {
        $target = $data['output'];
        $output = $this->$target($data);

        return $output;
    }

    private function step1($data){
        $output = null;
        // if user goes step back from 2 or 3, fill out input fields with data stored in $_SESSION
        if ($_SESSION['fb']) {
            $fb_login = "
            <span class='pull-left'>
                <img src='https://graph.facebook.com/" . $_SESSION['fb_uid'] . "/picture' class='img-circle' width='50' height='50' alt='Facebook'>
            </span>
            <h2 class='fb-blue'>" . __('FB_CONNECTED_TITLE') . "</h2>
            <p class='mt15'>" . __('FB_CONNECTED_TEXT') . "</p>
            ";
        } else {
            $fb_login = "
            <p>" . __('STEP1_TEXT') . "</p>
            <a class='btn btn-default mt25 mb10' href='" . ROOT . "signin-facebook'>Facebook Login</a>
            ";
        }
        // Hide pass field when already above step 1:
        $pass_form = null;
        if ($_SESSION['step'] < 2) {
            $pass_form = "
            <fieldset>       
                <div class='col-sm-6'>
                    <i class='material-icons pass'>visibility_off</i>
                    ".input('pass')."
                </div>
                <div class='col-sm-6'>
                    <i class='material-icons pass'>visibility_off</i>
                    ".input('pass_repeat')."
                </div>
            </fieldset>";
        }
        $output .= "
            <form id='registerForm' autocomplete='off'>
                <input type='password' class='stopAutofill' />            
                <h1>".__('STEP1_TITLE')."</h1>
                ".$fb_login."
                <hr />
                <div class='row'>        
                    <fieldset>
                        <div class='col-sm-12'>
                            ".check('gender',  'radio', 1)."
                            ".check('gender', 'radio', 2)."
                        </div>
                    </fieldset>
                    <fieldset>
                        <div class='col-sm-6'>".input('prename')."</div>
                        <div class='col-sm-6'>".input('surname')."</div>
                    </fieldset>
                    <fieldset>
                        <div class='col-sm-6'>".input('email')."</div>
                        <div class='col-sm-3'>".input('birthdate')."</div>                
                        <div class='col-sm-3'>".input('zip')."</div>
                    </fieldset>
                    ".$pass_form."                           
                </div>
                <p class='email_note'>".__('EMAIL_NOTE')."</p>
                <div class='button'>
                    <a data-form='#registerForm' data-task='step1' class='async btn xl btn-info'>".__('BTN_CONTINUE')."</a>
                </div>
            </form>
        </div>";

        return $output;
    }

    private function settings($data) {
        $main = null;
        $address = null;
        $address_aside = null;

        if (!$_SESSION['address']) {
            $address = "
            <div class='address'>
                <div class='pb5'>
                    <h3 class='mb5'>" . __('ADDRESS') . "</h3>
                    <p class='green'>" . __('ADDRESS_NOTE') . "</p>
                </div>
                <div class='mt10'>	
                    <div class='row'>
                    <fieldset>
                        <div class='col-sm-9'>" . input('street') . "</div>
                        <div class='col-sm-3'>" . input('housenumber') . "</div>
                    </fieldset>
                    <fieldset>
                        <div class='col-sm-4'>" . input('zip') . "</div>
                        <div class='col-sm-8'>" . input('city') . "</div>
                    </fieldset>                  
                    </div>
                </div>     
            </div>";
        } else {
            $address_aside = "
            <div class='address'>
                <div>" . $_SESSION['street'] . " " . $_SESSION['housenumber'] . "</div>
                <div>" . $_SESSION['zip'] . " " . $_SESSION['city'] . "</div>
            </div>
            ";
        }

        $progression_html = null;
        $collapse_work = null;
        $collapse_phone = null;
        if ($data['progression']['value'] < 100) {
            $progression_html = $data['progression']['html'];
        }
        if (!$_SESSION['work']) $collapse_work = ' show';
        if (!$_SESSION['phone_number']) $collapse_phone = ' show';

        $db = MysqliDb::getInstance();
        $db->where('uid', $_SESSION['uid']);
        $get_work = $db->get('users_work', null,
            'position, title, company, currently, location, 
            DATE_FORMAT(date_from, "%m/%Y") AS date_from, DATE_FORMAT(date_to, "%m/%Y") AS date_to');

        $i = 1;
        $work =
            '<div id="work">
            <a data-toggle="collapse" data-target="#change_work">
                <i class="material-icons">work</i> 
                ' . __('WORK') . '<i class="material-icons">keyboard_arrow_down</i>
            </a>
            
            <div id="change_work" class="collapse' . $collapse_work . '">
        ';
        if ($db->count < 1) {
            $work .= $this->workSheet();
        } else {
            foreach ($get_work as $x) {
                $work .= $this->workSheet($i, $x['position'], $x['title'], $x['date_from'], $x['date_to'], $x['currently'], $x['company'], $x['location']);
                $i++;
            }
        }
        $work .= '
                <div class="add">
                    <span class="async '.COLOR.'" data-task="work_entry" data-params="' . ($i + 1) . '" data-hide="1">' . __('ADD_ENTRY') . ' 
                        <i class="material-icons md-18">add_box</i>
                    </span>
                </div>
            </div>
        </div>';

        $main .=
            $progression_html . '
        <input type="password" class="stopAutofill" />
        <div class="overview">
            ' . $address . '
            ' . $work . '   
        <hr />        
            
            <div id="phone">
                <a data-toggle="collapse" data-target="#change_phone">
                    <i class="material-icons">phone_android</i> 
                    ' . __('PHONE_NUMBER') . '<i class="material-icons">keyboard_arrow_down</i>
                </a>
                <p>' . __('PHONE_NUMBER_DESCRIPTION') . '</p>
                
                <div id="change_phone" class="collapse' . $collapse_phone . '">
                    <div class="row">
                        <fieldset>
                            <div class="col-sm-8">
                            ' . input('phone_number_country_code') . '
                            ' . input('phone_number_full') . '
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
                        
        <hr />                        
        
            <div id="char">
                <a data-toggle="collapse" data-target="#change_char">
                    <i class="ico"></i> 
                    ' . __('CHARACTERISTICS') . '<i class="material-icons">keyboard_arrow_down</i>
                </a>
                <p>' . __('CHARACTERISTICS_DESCRIPTION') . '</p>
                
                <div id="change_char" class="collapse out">
                    '.$this->step2Form($data).'
                </div>
            </div>
            
        <hr />                        
        
            <div id="pass">
                <a data-toggle="collapse" data-target="#change_pass">
                    <i class="material-icons">lock</i> 
                    ' . __('CHANGE_PASS') . '<i class="material-icons">keyboard_arrow_down</i>
                </a>
                <div id="change_pass" class="collapse out">
                    <div class="row">
                        <fieldset>
                            <div class="col-sm-4">' . input('old_pass') . '</div>
                            <div class="col-sm-4">' . input('new_pass') . '</div>
                            <div class="col-sm-4">' . input('new_pass_repeat') . '</div>
                        </fieldset>
                    </div>
                </div>
            </div>
            
        <hr />                        
             
                
        </div>';

        $output['main'] = $main;
        $output['aside'] = $address_aside;

        return $output;
    }

    public function workSheet($iteration = 1, $position = null, $title = null, $from = null, $to = null, $currently = null, $company = null, $location = null, $empty = false) {
        if ($empty) $currently = 'empty';

        $output = '
        <div class="row">
            <fieldset class="faded in">
                <div class="col-sm-12">
                    <p class="title">'.__('OCCUPATION_POSITION').'</p>
                    <div>'.check('occupation_types', null, null, $position, null, $iteration).'</div>
                </div>
            </fieldset>
            <fieldset class="faded in">
                <div class="col-sm-6">
                ' . input('occupation_title', 'text', $title, $iteration, $empty) . '
                </div>
                <div class="col-sm-3">
                ' . input('occupation_since', null, $from, $iteration, $empty) . '
                </div>   
                <div class="col-sm-3">
                ' . input('occupation_to', null, $to, $iteration, $empty) . '
                </div>          
                '.check("occupation_currently", "checkbox", 1, $currently,  __('OCCUPATION_CURRENTLY'), $iteration).'
            </fieldset>
            <fieldset class="faded in">      
                <div class="col-sm-7">
                ' . input('occupation_company', 'text', $company, $iteration, $empty) . '
                </div>
                <div class="col-sm-5">
                ' . input('occupation_location', 'text', $location, $iteration, $empty) . '
                </div>                                                                                                              
            </fieldset>
        </div>';

        return $output;
    }

    private function qa() {
        $output = null;
        $count = count(__('Q'));

        for ($i = 0; $i < $count; $i++) {
            $answers = __('Q')[$i]['answers'];
            $max = count($answers);
            $output .= '<legend>' . __('Q')[$i]['question'] . '</legend>';

            if (isset(__('Q')[$i]['extra']))
                $output .= '<div class="extra"><i class="material-icons md-15">info</i> '.__('Q')[$i]['extra'].'</div>';

            $j = 1;
            if (is_array($answers)) {
                $customField = null;
                $customFieldPrevious = null;
                foreach (__('Q')[$i]['answers'] as $key => $val) {
                    $type = __('Q')[$i]['type'];
                    $checked = null;
                    if (is_array($val)) {
                        $customField = $val[key($val)];
                        $customFieldKey = key($customField);
                        $customFieldValue = $customField[key($customField)];

                        $ex = explode('-', $customFieldValue);
                        $customType = $ex[0];
                        $toggle = $customFieldKey;

                        $attr = 'data-toggle="'.$toggle.'" data-target="#'.$customFieldValue.'"';
                        $field = check('Q', $type, $j, null, key($val), ($i + 1), $attr);
                        if ($customFieldValue != $customFieldPrevious) {
                            $collapseMessage = null;
                            if (isset(__('Q')[$i]['collapseMessage']))
                                $collapseMessage = '<p class="mb20 f09">'.__('Q')[$i]['collapseMessage'].'</p>';

                            $customFieldOutput = '<div id="' . $customFieldValue . '" class="mt20 mb30 dn">'.$collapseMessage;
                            switch ($customType):
                                case 'textarea':
                                    $customFieldOutput .= '<textarea name="' . $ex[1] . '"></textarea>';
                                    break;
                            endswitch;
                            $customFieldOutput .= '</div>';

                            $customFieldArray[$i][] = $customFieldOutput;
                        }
                    } else {
                        $field = check('Q', $type, $j, null, $val, ($i + 1));
                    }

                    $jCount = count(__('Q')[$i]['answers']);
                    $output .= $field;
                    if ($customFieldArray[$i] && $j == $jCount) {
                        foreach ($customFieldArray[$i] as $x) {
                            $output .= $x;
                        }
                        $customFieldArray = null;
                    }

                    $customFieldPrevious = $customFieldValue;
                    if (($key + 1) == $max) $output .= '<hr />';
                    $j++;
                }
            }
        }

        return $output;
    }

    private function step2($data) {
        // Pimg:
        $pimg = '
            <div id="pimg-select">
                <legend>' . __('PIMG_TITLE') . '</legend>
                    <p>' . __('PIMG_TEXT') . '</p>		
                    <div>
                        <div class="btn btn-file btn-file">
                            ' . __('SELECT_PIMG') . '
                            <input id="upload" name="file_data" type="file" accept="image/*" />
                        </div>
                    </div>
                    <div id="upload-preview" data-snap-ignore="true"></div>            
            </div>
            <hr />';
        if ($data['settings']) {
            $main = $data['settings']['main'];
        } else {
            if (INITIALS == 'ST') $pimg = null;
            $main = $this->step2Form($data);
        }

        $output = '
        <div id="settings">
            <form id="registerForm">' . $main . $pimg;
        // Back Button:
        $back_button = null;
        if (!$_SESSION['completed'] && $_SESSION['step'] < 3)
            $back_button = '<a href="' . ROOT . 'signup/1" class="btn xl btn-back">' . __('BTN_BACK') . '</a>';
        // Settings or Signup?
        $task = 'step2';
        if ($data['settings'])
            $task = 'settings';
        else
            $output .= check('privacy') . '
            <div class="cl"></div>';

        $btn_step2 = __('BTN_REGISTER');
        if ($_SESSION['uid']) $btn_step2 = __('SAVE');
        $output .= '
                <div class="button">
                    ' . $back_button . '
                    <a data-form="#registerForm" data-task="' . $task . '" class="async pull-right btn xl btn-info">' . $btn_step2 . '</a>
                </div>
            </form>
            </div>
        </div>';

        return $output;
    }

    private function step2Form($data) {
        $output = $this->qa();
        // Text:
        $text = null;
        if ($_SESSION['text']) $text = $_SESSION['text'];
        else if ($_COOKIE['text']) $text = $_COOKIE['text'];
        // Project Cases:
        switch (INITIALS):
            case 'ST':
                $output .= '
                ' . __('STEP_2_TEST') . '
                <textarea name="text" rows="4" class="mt20 mb20" placeholder="' . __('STEP_2_TEST_PLACEHOLDER') . '">' . $text . '</textarea>';
            break;
            case 'SJ':
            case 'VM':
            case 'WF':
                $height = 170;
                $height_kids = 130;
                $weight = 65;
                $weight_kids = 40;
                if (isset($_SESSION['height'])) $height = $_SESSION['height'];
                if (isset($_SESSION['height_kids'])) $height_kids = $_SESSION['height_kids'];
                if (isset($_SESSION['weight'])) $weight = $_SESSION['weight'];
                if (isset($_SESSION['weight_kids'])) $weight_kids = $_SESSION['weight_kids'];

                $hair_color_string = __('PLEASE_SELECT');
                $eye_color_string = __('PLEASE_SELECT');
                if (isset($_COOKIE['hair_color'])) {
                    $hair_color = $_COOKIE['hair_color'];
                    $string = __(strtoupper($hair_color));
                    if (!empty($string)) $hair_color_string = __(strtoupper($hair_color));
                }
                if (isset($_COOKIE['eye_color'])) {
                    $eye_color = $_COOKIE['eye_color'];
                    $string = __(strtoupper($eye_color));
                    if (!empty($string)) $eye_color_string = __(strtoupper($eye_color));
                }

                $adult_sizes = null;
                $kids_sizes = null;
                if ($_COOKIE['display_sizes'] == 'adult') {
                    $kids_sizes = ' dn';
                    $display_sizes = __('KIDS_SIZES');
                } else {
                    $adult_sizes = ' dn';
                    $display_sizes = __('ADULT_SIZES');
                }

                $output .= '
            <legend>' . __('QHAIR') . '</legend>
            <fieldset id="hair-color">
                <span class="color-circle black"></span>  
                <span class="color-circle brown"></span>  
                <span class="color-circle blonde"></span>  
                <span class="color-circle red"></span>  
                <span class="hair-color-value">' . $hair_color_string . '</span>
                <input id="input-hair-color" name="hair_color" type="hidden" value="' . $hair_color . '" />
            </fieldset>
            
            <hr class="mb25" />
            
            <legend>' . __('QEYE') . '</legend>
            <fieldset id="eye-color">
                <span class="color-circle brown"></span>  
                <span class="color-circle green"></span>  
                <span class="color-circle blue"></span>  
                <span class="color-circle grey"></span>  
                <span class="eye-color-value">' . $eye_color_string . '</span>
                <input id="input-eye-color" name="eye_color" type="hidden" value="' . $eye_color . '" />
            </fieldset>
            
            <hr class="mb25" />        
    
            <div class="row">
                <div class="col-sm-6">
                    <fieldset class="mb15">            
                        <legend>
                            ' . __('BODY_HEIGHT') . '
                            <span class="right">
                                <span>cm</span>
                                <span id="height-value" class="grey-dark' . $adult_sizes . '"></span>
                                <span id="height-kids-value" class="grey-dark' . $kids_sizes . '"></span>
                                <span class="mr5">ft</span>                        
                                <span id="height-value-feet" class="grey-dark"></span>
                            </span>
                        </legend>
                        <div id="height-slider" class="mt10' . $adult_sizes . '"></div>
                        <div id="height-kids-slider" class="mt10' . $kids_sizes . '"></div>
                        <input id="input-height" type="hidden" name="height" value="' . $height . '" />
                        <input id="input-height-kids" type="hidden" name="height_kids" value="' . $height_kids . '" />
    
                    </fieldset>
                </div>
                <div class="col-sm-6">
                    <fieldset class="mb15">            
                        <legend>
                            ' . __('BODY_WEIGHT') . '
                            <span class="right">
                                <span>kg</span>
                                <span id="weight-value" class="grey-dark' . $adult_sizes . '"></span>
                                <span id="weight-kids-value" class=" grey-dark' . $kids_sizes . '"></span>
                                <span class="mr5">lbs</span>                        
                                <span id="weight-value-lbs" class="grey-dark"></span>
                            </span>                        
                        </legend>
                        <div id="weight-slider" class="mt10' . $adult_sizes . '"></div>
                        <div id="weight-kids-slider" class="mt10' . $kids_sizes . '"></div>
                        <input id="input-weight" type="hidden" name="weight" value="' . $weight . '" />
                        <input id="input-weight-kids" type="hidden" name="weight_kids" value="' . $weight_kids . '" />               
                    </fieldset>
                </div>		    	    
            </div>
            <a class="switch-sliders">' . $display_sizes . '</a>			
            
            <hr class="mb30" />
    
            ' . __('TEXTAREA_SELF_DESCRIPTION') . '
            
            <textarea name="text" rows="4" class="mt20 mb40" placeholder="' . __('STEP_2_TEST_PLACEHOLDER') . '">' . $text . '</textarea>
            ';
            break;
        endswitch;

        return $output;
    }

    private function step3($data) {
        $output = null;
        $hidden = null;
        if (empty($_SESSION['customer_service'])) {
            $hidden = ' dn';
            $names = unserialize(SERVICE_NAMES);
            shuffle($names);
            $name = $names[0];
            $_SESSION['customer_service'] = $name;

            $output .= "
            <!-- Event snippet for Signup Step 3 conversion page -->
            <script>
            gtag('event', 'conversion', {'send_to': 'AW-967181573/EageCO7O64cBEIWKmM0D'});
            </script>";

            $output .= "
            <div id='verification' class='mb10'>
                <p class='mb20'>" . __('CONNECTING_WITH') . "...</p>
                <span class='db f12 fwB'>" . $name . " <i class='material-icons green ml5'>adjust</i></span>
                <span class='f11 green'>" . __('CUSTOMER_SERVICE') . "</span>
                <br /><br />
            
                <span class='loader'></span>
                <p class='pl30 faded in'>" . __('VALIDATING_USER') . "...</p>
            </div>";
        }

        $prename = $_SESSION['prename'];
        if (!empty($_COOKIE['prename'])) $prename = $_COOKIE['prename'];

        $legend = null;

        $account = init::load('Account');
        switch (INITIALS):
            case 'ST':
            $offers =
            $account->offer('NaughtyDog', 800, 'The Last Of Us: Part II', 0, 2, '1,4,5,6') .
            $account->offer('Sony Interactive Entertainment', 1400, 'Death Stranding', 2, 1, '2,3,4,6') .
            $account->offer('Rockstar', 1200, 'Red Dead Redemption 2', 2, 1, '2,3,4') .
            $account->offer('Ubisoft', 1100, 'Rainbow Six: Siege', 2, 0, '1,3,4,5,6');
            $legend = legend();
            break;
            case 'SJ':
            $offers =
            $account->offer('AMC', 1300, 'Better Call Saul', 0, 2) .
            $account->offer('Netflix', 1100, 'DARK', null, 1) .
            $account->offer('Amazon Prime', 1000, 'You Are Wanted', 0, 1) .
            $account->offer('AMC', 1600, 'The Walking Dead', 0, 0);
            break;
            case 'VM':
            $offers =
            $account->offer('H&M', 800, 'hm', 0, 2) .
            $account->offer('Elle', 1100, 'elle', 0, 1) .
            $account->offer('Cosmopolitan', 900, 'cosmopolitan', null, 1) .
            $account->offer('Tommy Hilfiger', 800, 'tommy', 0, 0);
            break;
        endswitch;

        $output .= '
        <div class="verification-success tb'.$hidden.'">
            <div class="qualified sm-tac">
                <h2><i class="material-icons md-20 green mr10">check_circle</i> '.__('QUALIFIED_TITLE').'</h2>
                <p class="mb10 f11">'.__('CONGRATS').', '.$prename.'! '.__('QUALIFIED_TEXT').'</p>
            </div>';

            $db = MysqliDb::getInstance();
            $db->where('date BETWEEN (MONTH(CURRENT_DATE - INTERVAL 1 MONTH)) AND CURRENT_DATE()');
            $mediations = $db->getValue('mediations', 'amount');

            $last_month = date('Y-m-d', strtotime("-1 month"));
            $last_month = date('Y-m-d', strtotime("-1 month"));
            if ($mediations < 1) {
                $mediations = mt_rand(292,394);
                $db->insert('mediations', ['amount' => $mediations, 'date' => $last_month]);
            }

            $output .= "
            <hr class='mt30 hidden-sm hidden-xs' />
                    <div id='profile-preview'>
                        <div class='row'>
                            <div class='col-md-5'>
                                ".$this->profile()."
                            </div>
                            <div class='col-md-7'>
                                <h2>
                                    <i class='material-icons mr10 md-20 yellow'>stars</i> ".__('FIRST_CLASS_SERVICE')."
                                </h2>
                                <p class='f11'>".__('PRESENTATION_TEXT')."</p>
                                <p class='mt10'>
                                ".__('LAST_MONTH_TEXT', $mediations)."
                                </p>
                                <div class='cl'></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr class='hr-green' />  
                    
            <div class='dummy ".$hidden."' data-snap-ignore='true'>
                <div class='container pt25 pb10 sm-tac'>
        
                <h2 class='mt5'><u>".__('EXAMPLE')."</u></h2>
                <p class='f11 text-shadow'>".__('EXAMPLE_TEXT')."</p>
                </div>
                <div>
                    ".scroll_x_arrows()."             
                    <div class='mt15 scroll-x dragscroll'>
                        <div class='container'>
                        ".$offers."
                        </div>
                    </div>
                    ".$legend."                
                </div>            
            </div>
        
            <div id='last-step' class='container mt30 mb25 ".$hidden."'>
            <form id='payForm'>
                <div class='row'>
                    <div class='col-sm-8'>
                        <div class='sm-tac pt25 pb20'>
                            <h2 class='db'><i class='material-icons pink md-20 mr10'>favorite</i>
                            ".__('PLAY_FOR_CASH')."</h2>
                            <p class='mt5 mb30'>".__('PLAY_FOR_CASH_TEXT')."</p>
        
                            <div class='box-green'>".__('STEP3_BOX')."</div>
                            <p class='note tal'>".__('STEP3_TEXT_NOTE')."</p>
                        </div>
                    <hr class='visible-xs visible-sm mt0 mb40' />";

                $price = PRICE;
                if (defined('PRICE_APP') && APP) $price = PRICE_APP;

                $output .= "
                    <div class='row'>
                        <div class='col-sm-6'>
                            ".paypal(__('PAY_TITLE'), PAYPAL_ADDRESS, $price)."
                            <legend class='cl mb20'>".__('TOTAL_SUM')."</legend>
                            <span id='total_price' class='fwB green f14'>"._n($price)."</span>
                            <span class='grey-light db mt3'>".__('INCL_TAXES')."</span>
                            <legend class='mt20 f12 green'>".__('ONE_TIME_PAYMENT')."</legend>
                        </div>
                        <div class='col-sm-6 pay-option'>
                            ".pay()."
                        </div>
                    </div>
                    
                    <hr class='mt15 mb25' />
                    ".check('termsofservice')."
                    
                        <div class='button'>		
                            <button id='pay' data-form='#payForm' data-task='step3' 
                            class='async btn btn-info xl'>".__('BTN_PAY')."</button>
                        </div>
                    </div>
                    <div class='col-sm-4'>
                        ".$data['aside']."
                    </div>
            </form>
            <div class='cb'></div>
        </div>";

        return $output;
    }

    public function profile($registerForm = true, $address = false) {
        $email = $_SESSION['email'];
        $prename = ($_SESSION['prename']);
        $surname = ($_SESSION['surname']);
        $bday = $_SESSION['birthdate'];
        $zip = $_SESSION['zip'];
        if (empty($prename)) $prename = $_COOKIE['prename'];
        if (empty($surname)) $surname = $_COOKIE['surname'];
        if (empty($bday)) $bday = $_COOKIE['birthdate'];
        if (empty($zip)) $zip = $_COOKIE['zip'];
        #$gender = $_SESSION['gender'];

        $name_class = null;
        $pimg = "<i class='material-icons md-60'>account_circle</i>";
        if ($_SESSION['pimg']) {
            $pimg = '<img class="pimg" src="'.ROOT.'upload/users/'.$_SESSION['uid'].'.jpg'.$_SESSION['pimg_cache'].'" alt="'.__('PIMG').'" />';
            $name_class = ' mt';
        }

        $note = __('PERSONAL_DATA_CHANGE_NOTE');
        if ($registerForm) $note = __('PROFILE_PREVIEW_NOTE');

        $output = "
        <aside id='profile'>
            <div>
                <div class='pimg'>" . $pimg . "</div>
                <div class='name".$name_class."'>" . $prename . " " . $surname . "</div>
                <div class='details'>
                    <span><i class='material-icons'>email</i> " . $email . "</span>
                    <span><i class='material-icons'>cake</i> " . $bday . "</span>
                    <span><i class='material-icons'>location_on</i> " . $zip . "</span>
                </div>
                ".$address."
                <p class='grey-normal'>" . $note . "</p>
            </div>
        </aside>";

        return $output;
    }

    public function offer($company, $price, $game, $type = 0, $status = 1, $extras = null, $id = 0) {
        // $status = 1 means that this offer is waiting to get approved or declined by the user.
        // $status = 0 means that this offer is a potential job offer we're trying to acquire for the user.
        $url = null;
        $class = ' wider';
        $beauty_name = '<u>' . $company . '</u>';
        $company = strtolower($company);

        $type_string = __('SINGLE_TASK');
        if ($type == 1) $type_string = __('MINIJOB');
        else if ($type == 2) $type_string = __('FULL_TIME');
        else if ($type == 3) $type_string = __('PART_TIME');
        else if ($type == 4) $type_string = __('EDUCATION');

        $img_path = str_replace([' ', ':'], [''], $game);
        $img = ROOT . 'img/product/'.strtolower($img_path).'.jpg';
        $width = 0;
        $height = 0;
        switch ($company):
            default: case '': $url = ROOT . 'img/logo.svg'; break;
            case 'naughtydog': $url = ROOT . 'img/company/naughtydog.svg'; break;
            case 'netflix': $url = ROOT . 'img/company/netflix.svg'; break;
            case 'amc': $url = ROOT . 'img/company/amc.svg'; break;
            case 'amazon prime': $url = ROOT . 'img/company/amazonprime.svg'; break;
            case 'prosieben': $url = ROOT . 'img/company/prosieben.svg'; break;
            case 'ubisoft': $url = ROOT . 'img/company/ubisoft.svg'; break;
            case 'sony interactive entertainment': $url = ROOT . 'img/company/sony.svg'; break;
            case 'rockstar': $url = ROOT . 'img/company/rockstar.svg.png'; break;
            case 'h&m': $url = ROOT . 'img/company/hm.svg'; break;
            case 'elle': $url = ROOT . 'img/company/elle.svg'; break;
            case 'tommy hilfiger': $url = ROOT . 'img/company/tommy.svg'; $width = 190; $height = 17; break;
            case 'cosmopolitan': $url = ROOT . 'img/company/cosmopolitan.svg'; break;
        endswitch;

        $form_start = $form_end = $hidden = $btn_class = $accept = $decline = $home = $food = $sport = $events = $travel = $time = null;
        // Extras:
        $accept = ' data-task="accept" data-form="#order-'.$id.'"';
        $decline = ' data-verify="'.__('MODAL_VERIFY_DECLINE_OFFER').'" data-task="decline" data-form="#order-'.$id.'"';
        $btn_class = 'async ';

        $i = 0;
        $extras = explode(',', $extras);
        foreach($extras as $x) {
            $extra = job_extras($x);
            $var = $extra['var'];
            $ico = $extra['icon'];
            $$var = "<i class='material-icons md-15 mr5 grey'>".$ico."</i>";
            $i++;
        }
        $icons = $home.$travel.$events.$sport.$time;

        $game_html = null;
        $game_img = null;
        $buttons = null;
        if (!empty($game)) {
            $game_img = '<img class="game" src="'.$img.'" alt="'.$game.'" />';
            $game_html = '<u>' . $game . '</u>';
        }
        if ($status == 2) { // Accepted job offer
            $search_text = __('COMPANY_SEARCHING_ACCEPTED', [$beauty_name, $game_html]);
            $class .= ' accepted';
        } else if ($status == 1) { // Successful job offer
            $form_start = '<form id="order-'.$id.'">
            <input type="hidden" name="rid" value="'.$id.'" />
            <input type="hidden" name="company" value="'.$company.'" />        
            ';
            $form_end = '</form>';

            $search_text = __('COMPANY_SEARCHING', [$beauty_name, $game_html]);
            if (empty($id)) { // Dummy case (signup step 3)
                $accept = null;
                $decline = null;
                $btn_class = null;
            }

            $buttons = '
            <button class="'.$btn_class.'accept btn xs btn-info pull-right"'.$accept.'>'.__('ACCEPT').'</button>
            <span class="'.$btn_class.'decline cp pull-right grey f09 mt10 mr15"'.$decline.'>'.__('DECLINE').'</span>        
            ';
        } else if ($status == -1) { // Declined/invalid/expired job offer
            $search_text = __('COMPANY_SEARCHING_CANCELED', [$beauty_name, $game_html]);
            $class .= ' invalid';
        } else { // Pending job offer
            $search_text = __('COMPANY_SEARCHING_PENDING', [$beauty_name, $game_html]);
        }

        $style = null;
        if ($width > 0 && $height > 0) {
            $style = ' style="width: '.$width.'px; height: '.$height.'px"';
        }
        $output =
        "
        <div class='offer".$class." faded in'>
            ".$game_img."
            <img class='company' src='".$url."' alt='".$company."'".$style." />
            <p>".$search_text."</p>
            <table class='table table-responsive mb10' data-snap-ignore='true'>
                <tr>
                    <td class='grey fwB pb5'>".__('SALARY')."</span></td>
                    <td class='grey fwB pb5'>".__('TYPE')."</span></td>
                </tr>
                <tr class='f11'>
                    <td>".beauty($price)."</td>
                    <td>".$type_string."</td>
                </tr>
            </table>
            ".$form_start.$buttons.$form_end."
            <div class='icons'>".$icons."</div>
        </div>
        ";

        return $output;
    }


}