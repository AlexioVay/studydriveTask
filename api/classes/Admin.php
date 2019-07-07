<?php

class Admin {

    public function api() {
        return
        "<div class='mt5 mb15' data-snap-ignore='true'>
            ".curl(ROOT_CMS.'api.php', ['path' => ROOT_ABS], false)."
        </div>";
    }

    public function output($data) {
        $db = MysqliDb::getInstance();

        $output = null;
        $overview = '
        <div class="container">
        <a href="'.ROOT.'admin"><legend><i class="material-icons mr7 md-18">android</i>Administration</legend></a>
        <div class="pt20"></div>';
        if (defined('ACCESS')) $access = unserialize(ACCESS);

        if ($access['users'] == 1) {
            // count new game reviews:
            $db->join('orders o', 'i.uid = o.uid');
            $db->where('i.date != "" AND i.text != "" AND i.checked IS NULL AND i.invalid != 1');
            $count = $db->getValue('users_info i', 'COUNT(DISTINCT i.uid)');
            $cnt = '<span class="ml10 badge-new-circle">'.$count.'</span>';

            $add = null;
            if (INITIALS == 'SJ') {
                $add .= '&nbsp;&middot;&nbsp; <a href="'.ROOT.'admin/?case=users&filter=adult"><span>Erotik</span></a> 
                &nbsp;&middot;&nbsp; <a href="'.ROOT.'admin/?case=users&filter=underage"><span>Minderjährig</span></a>';
            }
            $overview .= "<a href='".ROOT."admin/?case=users&filter=unlocked'>
            <h2>Benutzer</h2>".$cnt."</a>
            ".$add."
            <hr class='mb35' />";
        }
        if ($access['orders'] == 1) {
            $overview .= "<a href='".ROOT."admin/?case=orders&amp;month=".date('n')."&amp;year=".date('Y')."'>
            <h2>Bestellungen</h2></a>
            <hr class='mb35' />";

            $overview .= "<a href='".ROOT."admin/?case=jobs'>
            <h2>Stellenanzeigen</h2></a>
            <hr class='mb35' />";

            $overview .= "<a href='".ROOT."admin/?case=api'>
            <h2>Business</h2></a>
            <hr />";
        }

        // List last referrals by date
        $db->groupBy('date');
        $db->orderBy('id', 'DESC');
        $ref = $db->get('users_ref', 10,
        'DATE_FORMAT(date, "%d.%m.%Y") AS date, COUNT(DISTINCT id) AS cnt');

        $overview .= '</div>';

        $refF = '
            <div class="container">
                <h2 class="mt10 mb10 db">Last Referrals</h2>';
        foreach($ref as $x) {
            $refF .= '
                <span class="f09 grey">'.$x['date'].':</span>
                <span class="fwB dib ml5 mr15">'.$x['cnt'].'</span>
            ';
        }
        $refF .= '
        </div>';
        // List all registered users by date
        $db->groupBy('date');
        $db->orderBy('id', 'DESC');
        $ref = $db->get('users_register_log', 15,
        'date AS date_raw, DATE_FORMAT(date, "%d.%m.%Y, %a") AS date, WEEKDAY(date) AS weekday, COUNT(DISTINCT email) AS cnt');

        $main = "    
        ".$refF."
        
        <div class='container'>
        ";

        $main .= "<h2 class='mt20'>Register Log</h2>";
        $paid_weekly = 0;
        $i = 1;
        $main .= '<table class="table register fwB f09">
        <tr>
            <td>Datum</td>
            <td>Step 1</td>
            <td>Step 2</td>
            <td>Bezahlt</td>
            <td>Erhalten</td>
        </tr>';
        $weekday_today = -1;
        $weekday_count = 0;
        foreach($ref as $x) {
            $weekday = $x['weekday'];
            $date_raw =  $x['date_raw'];
            $color = 'grey';

            // Retrieve all users:
            $db->where('DATE(signup)', $date_raw);
            $db->orderBy('signup', 'DESC');
            $uids = $db->get('users', null, 'id, prename, surname, gender');
            $list = null;
            if (is_array($uids)) {
                foreach($uids as $y) {
                    $uid = $y['id'];
                    $prename = $y['prename'];
                    $surname = $y['surname'];

                    $img = null;
                    if (file_exists(ROOT_ABS.'upload/users/thumbnail/'.$uid.'.jpg'))
                        $img = '
                        <a href="'.ROOT.'upload/users/'.$uid.'.jpg">
                            <img src="'.ROOT.'upload/users/thumbnail/'.$uid.'.jpg" alt="" class="pimg mr10" style="margin-left: 0" />
                        </a>';
                    $list[] = '<span>'.$img.' <a href="'.ROOT.'user/'.$uid.'">'.$prename.' '.$surname.'</a></span>';
                }
            }
            if (isset($list) && !empty($list) && is_array($list)) {
                $list = implode(', ', $list);
                $list = '<br />' . $list;
            }

            if ($i == 1) {
                $weekday_today = $weekday;
                $weekday_count = 1;
            }
            if ($weekday == $weekday_today) $weekday_count++;

            $db->where('date(date)', $date_raw);
            $db->where('status', 'Completed');
            $o = $db->getOne('orders', 'COUNT(id) AS cnt, SUM(price) AS sum, method, status');
            $paid = $o['cnt'];
            $method = $o['method'];
            $price = $o['sum'];
            // Calculate PayPal fee:
            if ($o['method'] == 'pp' && $o['status'] == 'Completed') $price = $price - ($price * 0.054);

            $db->where('date(u.signup)', $date_raw);
            $act = $db->get('users u', null, 'u.id');
            $activated = $db->count;

            $paid_amount = '&ndash;';
            if ($price > 0) $paid_amount = $price.' &euro;';
            if ($i % 7 == 1) $color = 'green';
            $paid_weekly += $price;
            $weekly = null;
            if ($i > 1 && $paid_weekly > 0 && $color != 'grey') {
                $weekly = '
                <tr class="fwB mb20">
                    <td class="grey">Insgesamt</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="f13 green">' . $paid_weekly . '&euro;</td>
                </tr>';
            }
            $main .= $weekly;
            if ($weekday_count > 3) break;

            $main .= '
            <tr class="f12 '.$color.'-bg">
                <td>'.$x['date'].$list.'</td>
                <td>'.$x['cnt'].'</td>
                <td>'.$activated.'</td>
                <td>'.$paid.'</td>
                <td class="green f11">'.$paid_amount.'</td>
            </tr>';
            #if ($weekday_count > 3) break;
            if ($weekly) $paid_weekly = 0;
            $i++;
        }
        $main .= '</table>';

        $main .= "<a class='db mt5' href='".ROOT."x.php'>Übersicht</a><br />";

        $output .= "<div id='content' class='container mt20'>";
        if ($_GET['case'] == 'jobs') {
            $output .= $this->jobs();
        } elseif ($_GET['case'] == 'orders') {
            $output .= $this->orders();
        } else if ($_GET['case'] == 'users') {
            $output .= $this->users();
        } else if ($_GET['case'] == 'api') {
            $output = $overview . $this->api();
        } else {
            $output .= $overview . $main;
        }
        $output .= "</div>";

        return $output;

    }

    public function jobs() {
        $db = MysqliDb::getInstance();
        $db->join('companies c', 'j.cid = c.id', 'LEFT');
        $db->join('topics g', 'j.game_id = g.id', 'LEFT');
        $jobs = $db->get('jobs j', null,
        'name, address, website, phone, 
        j.title, type, extras, salary, DATE_FORMAT(`date`, "%d.%m.%Y, %H:%i") AS date,
        g.title AS game');

        $output = null;
        foreach ($jobs as $x) {
            // job
            $title = $x['title'];
            $type = job_type($x['type']);
            $salary = $x['salary'];
            $date = $x['date'];
            // company
            $name = $x['name'];
            $address = $x['address'];
            $website = $x['website'];
            $phone = $x['phone'];
            $company = '<div class="pt10">
            Unternehmen: &nbsp;'.$name.' &nbsp;&middot;&nbsp; 
            '.$address.' &nbsp;&middot;&nbsp; 
            '.$website.' &nbsp;&middot;&nbsp; 
            '.$phone.'
            </div>';
            // game
            if (!empty($x['game'])) $game = '<div class="pt10">Spiel: &nbsp;'.$x['game'].'</div>';

            $extras = $x['extras'];
            $ex = explode(',', $extras);
            $ico = null;
            foreach($ex as $y) {
                $extra = job_extras($y);
                $ico .= '
                <span class="dib mr10 f09"> '.$extra['icon'].' '.__($extra['title']).'</span>';
            }

            $output .= '
            <hr />
            <div>
                <span class="pull-right">'.$date.'</span>
                <strong class="f12">'.$title.'</strong> &nbsp;&middot;&nbsp; 
                '.$type.' &nbsp;&middot;&nbsp;
                <span class="green fwB">'._n($salary).'</span>
                '.$company.'
                '.$game.'            
                <div class="mt10">'.$ico.'</div>
            </div>
            ';
        }

        $output = "
        <a href='".ROOT."admin'><legend><i class='material-icons mr7'>android</i>Administration</legend></a>
        <div class='pt10'>
            <h1>Stellenanzeigen</h1>
            <div class='pt10 pb30'>
            ".$output."
            </div>
        </div>";

        return $output;
    }

    public function access() {
        $output = '
        <li>
            <a tabindex="-1" href="' . ROOT . 'admin">' . __('ADMIN') . '</a> 
            <div class="dropdown-menu-icons">
                <a href="'.ROOT.'admin/?case=api"><i class="material-icons md-18">business</i></a>
                <a href="'.ROOT.'admin/?case=users"><i class="material-icons md-18">face</i></a>
                <a href="'.ROOT.'admin/?case=orders"><i class="material-icons md-18">shopping_cart</i></a>
                <a href="'.ROOT.'admin/?case=jobs"><i class="material-icons md-18">work</i></a>
            </div>
        </li>';

        return $output;
    }

    public function users() {
        $db = MysqliDb::getInstance();
        $output = null;
        // determine page number from $_GET
        $page = 1;
        if (!empty($_GET['page'])) {
            $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
            if (false === $page) $page = 1;
        }
        // set the number of items to display per page
        $items_per_page = 5;
        // build query
        $offset = ($page - 1) * $items_per_page;
        $next = $page + 1;
        $prev = $page - 1;

        $qs = null;
        $count = count(__('Q'));
        for ($i = 1; $i <= $count; $i++) $qs .= 'i.q'.$i.',';

        $text_class = 'mb10 mr10';

        $filters_on = false;
        $filter = null;

        $unlocked = $adult = $underage = false;
        if ($_GET['filter']) {
            $filters_on = true;
            $ex = explode(',', $_GET['filter']);
            if (is_array($ex) && !empty($ex)) {
                $i = 1;
                foreach($ex as $x) {
                    if (in_array($x, $ex)) ${$x} = true;

                    if ($i == 1)
                        $filter .= '&filter=' . $x;
                    else
                        $filter .= ',' . $x;

                    $i++;
                }
            }
        }
        $filters[1] = check('unlocked', 'unlocked', 'checkbox', 'Freigeschaltet', $unlocked, $text_class);

        switch (INITIALS):
            case 'SJ': // www.schauspiel-jobs.de
            $filters['sj1'] = check('adult', 'adult', 'checkbox', 'Erotik', $adult, $text_class);
            $filters['sj2'] = check('underage', 'underage', 'checkbox', 'Minderjährig', $underage, $text_class);

            if ($filters_on) {
                if (in_array('adult', $ex)) {
                    $db->where('(i.q1 LIKE "%7" OR i.q1 = "7") AND (u.gender = 2)');
                }
                if (in_array('underage', $ex)) {
                    $db->where('(YEAR(CURDATE())-YEAR(birthday)) < 18');
                }
            }
            break;
        endswitch;
        if ($filters_on) {
            if (in_array('unlocked', $ex))
            $db->join('orders o', 'o.uid = u.id');
        }

        if (is_array($filters) && !empty($filters)) {
            $build = null;
            foreach($filters as $x) {
                $build .= $x;
            }
            $filters = '<div id="sort" class="pt20">'.$build.'</div>';
        }

        $db->pageLimit = $items_per_page;
        $db->where("(i.text != '' AND i.date != '' AND i.checked IS NULL AND i.invalid != 1)");
        $db->join('users_info i', 'i.uid = u.id');
        $db->groupBy('u.id');
        $db->orderBy('i.date', 'DESC');
        $result = $db->withTotalCount()->get('users u', [$offset, $items_per_page], "
        u.id, u.prename, u.surname, u.email, (YEAR(CURDATE())-YEAR(birthday)) AS age, u.birthday,
        ".$qs."
        i.text, DATE_FORMAT(i.`date`, '%d.%m.%Y, %H:%i') AS date");

        $output .= "<a href='".ROOT."admin'><legend><i class='material-icons mr7'>android</i>Administration</legend></a>" . '
            <div class="pt10 pb15">
            <span>Sortiert nach letzter Profil-Aktualisierung</span>
            '.$filters.'
            </div>
        </div>
        <div class="gt"></div>
        <div class="pt25">';

        $i = 0;
        $prev = 0;
        if ($_GET['page'] > 1) $prev = $_GET['page'] - 1;
        foreach ($result as $user) {
        $db->where('uid', $user['id']);
        $count = $db->getValue('profile_rating', 'COUNT(1)');

        $db->orderBy('date', 'DESC');
        $db->where('uid', $user['id']);
        $rating_date = $db->getValue('profile_rating', 'DATE_FORMAT(`date`, "%d.%m.%Y, %H:%i:%s")');

        $last_check = null;
        if (!empty($rating_date)) {
            $last_check = " (Zuletzt ".$rating_date.")";
        }

        $age = $user['age'];
        $age_output = null;
        if ($age < 150) {
            $age_output = $age . ' Jahre ('.$user['birthday'].') &nbsp; &middot; &nbsp; ';
        }
        $times = $count . ' Mal';
        if ($count == 0) $times = 'bisher nicht';

        $account = init::load('Account');
        $skills_data = ['dir' => DIR, 'q4' => $user['q4'], 'q5' => $user['q5'], 'q6' => $user['q6'], 'q7' => $user['q7']];
        $skills = $account->skills($skills_data);

        $img = null;
        if (file_exists(ROOT_ABS . 'upload/users/'.$user['id'].'.jpg'))
        $img = '<a href="'.ROOT.'upload/users/'.$user['id'].'.jpg" target="_blank">
        <img src="'.ROOT.'upload/users/'.$user['id'].'.jpg" alt="Profilbild" class="pimg-big" /></a>';

        $output .=
        "<div id='review-".$i."'>
            <div class='container mb20'>
                ".$img."<code>" . $user['id'] . "</code> &nbsp; 
                <a href='".ROOT."user/".$user['id']."'><h2>".$user['prename']." ".$user['surname']."</h2></a> &nbsp; &middot; &nbsp; 
                ".$age_output."
                <a href='mailto:".$user['email']."'>".$user['email']."</a>
                ".$skills."
                <div class='pt10 f09 grey'>Testbericht wurde ".$times." geprüft".$last_check."</div>
            </div>
            <div class='dummy pt20 pb20 mb15'>
                <p class='container'><span class='f09 grey'>".$user['date']."</span><br />".nl2br(trim($user['text']))."</p>
            </div>
            <div class='container'>
                <div data-toggle='collapse' data-target='#check-".$i."'>
                    <a>Prüfung</a>
                </div>
                <div id='check-".$i."' class='collapse'>
                    <div class='mt20 mb5 fwB'>Bewertung:</div>
                    <div>
                        <form id='ratingForm-".$i."' class='mt10'>
                            <input type='hidden' name='i' value='".$i."' />
                            <input type='hidden' name='uid' value='".$user['id']."' />
                            ".check("rating-".$i."-1", "rating", 'radio', 'Schlecht', null, 'mb10 mr10', null, 1)."
                            ".check("rating-".$i."-2", "rating", 'radio', 'Mittel', null, 'mb10 mr10', null, 2)."
                            ".check("rating-".$i."-3", "rating", 'radio', 'Super', null, 'mb10 mr10', null, 3)."
                            <div class='fwB mt5 mb10'>Beispielsätze:</div>
                            <ul class='f09'>
                                <li class='square'>Bitte optimiere deine Rechtschreibung und deine Kommasetzung, da darauf besonders viel Wert gelegt wird.</li>
                                <li class='square'>Bitte schreibe einen ausführlicheren Testbericht. Es sollten zu jeder Kategorie mindestens 3-4 Sätze geschrieben werden.</li>
                                <li class='square'>Bitte überarbeite deinen Testbericht inhaltlich.</li>
                                <li class='square'>Sehr gut geschriebener Testbericht. Bitte gehe ihn trotzdem nochmal in Ruhe durch, um Rechtschreibfehler zu korrigieren und die Kommasetzung zu optimieren, da darauf unter anderem stark geachtet wird.</li>
                                <li class='square'>Sehr gut geschriebener Testbericht. Du hast sehr gute Chancen vermittelt zu werden.</li>
                            </ul>
                            <textarea class='mt15' name='text'></textarea>
                            ".check("rating-".$i."-4", "invalid", 'checkbox', 'Ungültig', null, null, 'db mt15 f09 grey')."
                            <button data-form='#ratingForm-".$i."' data-task='profile_rating' class='mt20 async btn btn-info'>".__('SAVE')."</button>
                        </form>
                    </div>
                </div>
            </div>
            <hr class='default-4' />
        </div>";

        $i++;
    }
        $output .= '<div class="container pb25">';
        if ($prev) $output .= "<a class='uc f11' href='".ROOT."admin/?case=users&page=".$prev.$filter."'>prev</a> &middot; ";
        $output .= "<a class='uc f11' href='".ROOT."admin/?case=users&page=".$next.$filter."'>next</a>";
        $output .= '</div>';

        $output .= '</div>
        </div>';

        return $output;
    }

    public function orders() {
        $output = null;
        $db = MysqliDb::getInstance();
        $month = date('m');
        $year = date('Y');
        if ($_GET['month']) $month = $_GET['month'];
        if ($_GET['year']) $year = $_GET['year'];

        $initials = unserialize(PROJECTS);
        $options = null;
        foreach($initials as $k => $x) {
            $val = $x['initials'];
            $options .= '<option value="'.$k.'">'.$val.'</option>';
        }
        // DKB Crawl:
        $return = null;
        require_once ROOT_CMS_ABS.'libs/DKB/api.php';
        $dkb = null;
        $i = 1;
        if (is_array($return['html'])) {
            foreach ($return['html'] as $x) {
                sort($x, SORT_STRING);
                foreach($x as $y) {
                    if ($i == 15) break;
                    $dkb .= $y;
                    $i++;
                }
            }
        }

        $output .= '
        <a href="'.ROOT.'admin"><legend><i class="material-icons mr7">android</i>Administration</legend></a>
        <h1>Bestellungen</h1>
        
        <div class="mb20">
            <h3>DKB-Auszug:</h3>
            <div>'.$dkb.'</div>
        </div>
        
        <div>
            <form id="vwzForm">
               <select class="dib" name="initials" style="float: left; height: 42px; border-top-left-radius: 5px; border-bottom-left-radius: 5px; padding: 10px 7px 8px 7px">
                    '.$options.'
                </select>
                <input class="dib pull-left" type="number" name="vwz" data-form="#vwzForm" data-task="vwz" style="font-size: 1.5em; font-family: \'Google Sans\'; width: 110px; border: 1px solid #bdd889; border-left: 0; height: 42px" />
            </form>
    
        <select class="pull-right" style="width: 77px; height: 42px;" onchange="if (this.value) window.location.href=this.value" name="year">';
        $year_now = date('Y');
        $year_unix = strtotime($year_now . ' -10 year');
        $year_calc = date("Y-m-d", $year_unix);

        for ($i = $year_now; $i >= $year_calc; --$i) {
            $j = str_pad($i, 2, "0", STR_PAD_LEFT);
            $output .= "<option value='" . ROOT . "admin/?case=orders&month=" . $month . "&year=" . $j . "'";
            if ($i == $year) {
                $output .= " selected";
            }
            $output .= ">" . $i . "</option>";
        }
        $output .= "
        </select>
        <select class='pull-right' style='width: 60px; height: 42px; border-right: 0'  onchange='if (this.value) window.location.href=this.value' name='month'>";
            for ($i = 1; $i <= 12; $i++) {
                $output .= "<option value='" . ROOT . "admin/?case=orders&month=" . $i . "&year=" . $year . "'";
                if ($i == $month) {
                    $output .= " selected";
                }
                $output .= ">" . $i . "</option>";
            }
            $output .= "</select>
        <div id='vwzResponse' class='cb pt15 pb15'></div>
        </div>
            
        <div class='table-responsive mt20' data-snap-ignore='true' data-snap-ignore='true'>
        <table class='table striped'>
            <thead>
                <tr>
                <th class='tac' width='50'>#</th>			
                <th>Käufer</th>
                <th>User ID</th>
                <th>Preis</th>
                <th>Status</th>
                <th>Zahlungsart</th>
                <th>Zeitpunkt</th>			
                </tr>
            </thead>
        <tbody>";

            $year = date("Y");
            $where = null;
            if (isset($month)) {
                if (isset($year)) $year = sDigit($year);
                $where = "MONTH(`date`)='" . sDigit($month) . "' AND YEAR(`date`)='" . $year . "'";
            }

            if (!empty($where)) $db->where($where);
            $db->join('users u', 'u.id = o.uid');
            $db->orderBy('date_updated', 'DESC');
            $db->orderBy('o.id', 'DESC');
            $result = $db->get('orders o', null,
                'o.id, o.uid, o.price, o.status, o.method, o.ip, o.log, o.date, o.date_updated, 
                u.email, u.lang');

            $i = 0;
            foreach ($result as $data) {
                $price = $data['price'];
                // Calculate PayPal fee:
                if ($data['method'] == 'pp' && $data['status'] == 'Completed')
                    $price = $price - ($price * 0.054);

                if ($data['status'] == "Completed") {
                    $class = " class='success'";
                    $status = "ok";
                    $url = "<a href='?s=backend&amp;case=orders&amp;month=" . $month . "&amp;year=" . $year . "&amp;uid=" . $data['uid'] . "&amp;amount=" . $data['price'] . "&amp;article=" . $data['article'] . "&amp;site_id=" . $data['site_id'] . "&amp;id=" . $data['id'] . "' title='Zahlung offen'>";
                } else {
                    unset($class);
                    $status = "remove";
                    $url = "<a href='?s=backend&amp;case=orders&amp;month=" . $month . "&amp;year=" . $year . "&amp;uid=" . $data['uid'] . "&amp;amount=" . $data['price'] . "&amp;article=" . $data['article'] . "&amp;site_id=" . $data['site_id'] . "&amp;id=" . $data['id'] . "&confirm=1' title='Zahlung bestätigen'>";
                }
                if ($data['method'] == "bt") $payment = "Überweisung";
                else if ($data['method'] == "pp") $payment = "PayPal";
                else if ($data['method'] == "dd") $payment = "Lastschrift";
                else if ($data['method'] == "iap") $payment = "App";
                else $payment = "Steam
        <span class='db f09 fwB pt5'>" . $data['log'] . "</span>";

                $db->where('uid', $data['uid']);
                $check = $db->getValue('users_activate', '1');
                if (empty($check)) {
                    $status_activate = "ok";
                    $url_activate = "<a href='#'>";
                } else {
                    $status_activate = "remove grey";
                    $url_activate = "<a href='?s=backend&amp;case=orders&amp;month=" . $month . "&amp;year=" . $year . "&amp;uid=" . $data['uid'] . "&amp;amount=" . $data['price'] . "&amp;uid=" . $data['uid'] . "&amp;site_id=" . $data['site_id'] . "&amp;id=" . $data['id'] . "&amp;activate=1' title='Account bestätigen'>";
                }

                $updated = null;
                if (!empty($data['date_updated'])) $updated = '<br />(updated ' . timediff($data['date_updated']) . ')';
                $output .= "<tr" . $class . ">
                    <td class='tac'>" . $data['id'] . "</td>
                    <td>" . user_name($data['uid']) . "<br/>" . $data['email'] . "</td>
                    <td>" . $data['uid'] . " " . $url_activate . "<span class='f08 ml5 glyphicon glyphicon-" . $status_activate . "'></span></td>	
                    <td><strong>" . _n($price, false, $data['lang']) . "</strong></td>
                    <td>
                    " . $url . "<span class='f09 glyphicon glyphicon-" . $status . "'></span></a>
                    </td>	
                    <td>" . $payment . "</td>	
                    <td title='" . $data['date'] . "'>" . timediff($data['date']) . $updated . "</td>			
                  </tr>";
                $i++;
            }

            $db->where("YEAR(`date`)='" . $year . "' AND (`status` = 'Completed' or `status` = 'Reversed' OR status = 'Canceled_Reversal')");
            $db->groupBy('MONTH(date)');
            $db->orderBy('id', 'ASC');
            $result_months = $db->get('orders', null,
                'SUM((`price`)) as price, MONTH(`date`) as date, method, status');

            $sum_year = 0;
            foreach ($result_months as $data) {
                $price = $data['price'];
                if ($data['method'] == 'pp' && $data['status'] == 'Completed') $price = $price - ($price * 0.054);

                $sum_month[$data['date']] = $price;
                if ($data['price'] > 0) $sum_year += $price;
            }
            $month_num = date('m');
            $month_wz = $month_num;
            $month_wz += 0;

            $db = MysqliDb::getInstance();
            $db->where("(status = 'Completed' OR status = 'Reversed' OR status = 'Canceled_Reversal')");
            $db->where("MONTH(date)", 12);
            $db->where("YEAR(date)", ($year - 1));
            $last_dec = $db->getValue('orders', 'SUM(price)');

            $output .= "</tbody></table>
        </div>
        <div class='grey mt10 mb20'>" . $i . " Bestellungen</div>";

        return $output;
    }

}