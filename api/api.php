<?php
header('Content-type: text/html; charset=utf-8');

$show_all = false;
$path = null;
if (!empty($_POST)) {
    // Mandatory:
    $path =  $_POST['path'];

    if (!empty($_POST['lgc'])) define('LGC', $_POST['lgc']);
    if (!empty($_POST['admin'])) {
        $full = $_POST['full'];
        $year = $_POST['year'];

        if (!empty($full)) $show_all = true;
    }
    if (!empty($_POST['email'])) {
        /* - - -  Send Project-Related Email  - - - */
        $dir = $_POST['dir'];
        $test = require_once __DIR__ . '/' . $dir . '/init.php';
        // Mail ORDER Array Data:
        $email = $_POST['email'];
        $prename = $_POST['prename'];
        $method = $_POST['method'];
        $status = $_POST['status'];
        $uid = $_POST['uid'];
        $price = PRICE;
        $order_id = $_POST['order_id'];
        // Act like other project from specific dir:
        if (!empty($dir)) {
            $mail_data = [$prename, $method, $status, $uid, $price, $order_id];
            send_mail($email, 'order', $mail_data);
        }

        exit();
    }
}
require_once $path . 'init.php';


$conn = unserialize(PROJECTS);
$output = null;
$mp = null; // mp = monthly price
$errlog = null;


if (empty($year)) $year = date('Y');
if (!empty($conn) && is_array($conn)) {
    $next_year = null;
    if ($year != date('Y'))
    $next_year = ' &nbsp;&middot;&nbsp; <span class="f12"><a href="'.ROOT.'admin/?admin=1&year='.($year + 1).'">'.($year + 1).'</a></span>';

    $output .= '
    <div>
        '.scroll_x_arrows().'             
        <div class="container">
            <span class="f12"><a href="'.ROOT.'admin?case=api&admin=1&year='.($year - 1).'">'.($year - 1).'</a></span> &nbsp;&middot;&nbsp; 
            <span class="f12"><a href="'.ROOT.'admin?case=api&admin=1&year='.($year).'"><u>'.($year).'</u></a></span>
            '.$next_year.'
            
            <span class="pull-right"><a href="'.ROOT.'admin?case=api&admin=1&year='.$year.'&full=1">Alle Monate anzeigen</a></span>
        </div>         
        <div class="mt15 scroll-x dragscroll">       
            <div class="container pb25">
            ';

    $fm = null; // Full Month data
    $a = 1;
    $proj = null;
    $projSum = null;
    $projRec = null;
    $projDaySum = null;
    $mTotal = null;
    $maleTotal = null;
    $femaleTotal = null;
    $mobileTotal = null;
    $desktopTotal = null;
    $this_month_static_m = date('m');
    $this_month_static_n = date('m');
    $this_month_total_days = cal_days_in_month(CAL_GREGORIAN, $this_month_static_n, $year);
    $this_year = $year;
    foreach($conn as $key => $x) {
        $initials = $x['initials'];
        if ($initials == 'WF') continue;

        $db = DBConnect($key);
        $proj[$a] = $initials;
        $to = $year."-".$this_month_static_m."-".$this_month_total_days." 23:59:59";

        $between = "(o.date BETWEEN '".$this_year."-01-01 00:00:00' AND '".$to."')";
        if (!$show_all && date('n') <= 2) {
            if ($this_month_static_n == 1)
                $from_month = 11;
            else if ($this_month_static_n == 2)
                $from_month = 12;

            $between = "(o.date BETWEEN '" . ($this_year - 1) . "-".$from_month."-01 00:00:00' AND '" . $to . "')";
        }

        // Payments SQL
        $db->where($between);
        $db->where("(o.status = 'Completed' OR o.status = 'Reversed' OR o.status = 'Canceled_Reversal')");
        $db->join('users u', 'u.id = o.uid');
        $db->groupBy('DAY(o.date), MONTH(o.date)');
        $db->orderBy('YEAR(o.date)', 'ASC');
        $db->orderBy('DAY(o.date)', 'ASC');
        $day_results = $db->get('orders o', null,
        'SUM(o.price) AS price, DATE_FORMAT(o.date, "%e") AS day, MONTH(o.date) AS month,
        u.gender, u.device');
        $payment_count = $db->count;

        /* - - - Error Log - - - */
        $db->orderBy('date', 'DESC');
        $errors = $db->get('errors', null,
        'id, uid, log, dir, uri, DATE_FORMAT(date, "%d.%m.%Y, %H:%i:%s") AS date, date AS date_raw');
        if ($db->count > 0) {
            $errlog .= '
            <div class="pt20">
                <div class="container pt20">
                    <strong class="gc f11">'.$x['host'].'</strong>
                    <table class="table table-responsive f09 mt20" data-snap-ignore=\'true\' width="100%">
                            <tr>
                                <td class="gc f11">Log</td>
                                <td class="gc f11 pl15">Dir</td>
                                <td class="gc f11 pl15">URI</td>
                                <td class="gc f11 pl15">User</td>
                                <td class="gc f11 pl15">Date</td>
                            </tr>';

                    $fi = 1;
                    foreach ($errors as $e) {
                        $id = $e['id'];
                        $dir = $e['dir'];
                        $uid = '-';
                        if ($e['uid']) $uid = $e['uid'];

                        $delete = '<br /><br /><a class="async db mt10 pink" data-task="admin_delete_error" data-hide="1" data-params="'.$dir.','.$id.'" href="#error-'.$id.'"><i class="mr10 material-icons md-15">remove_circle</i> Delete</a>';
                        $log = stripslashes(nl2br($e['log']));
                        $log = str_replace(['rn '], '', $log);
                        $log = "
                        <tr id='error-".$id."''>
                            <td class='pt10 f11 brall' colspan='5'>
                                <div id='check-".$initials.$fi."' class='collapse'>".$log."".$delete."</div>
                            </td>
                        </tr>";

                        $uri = '-';
                        if ($e['uri']) $uri = $e['uri'];
                        $date = $e['date'];
                        $errlog .= '
                        <tr data-toggle="collapse" data-target="#check-'.$initials.$fi.'" class="cp">
                            <td><strong class="green f13">+</strong></td>
                            <td class="pt10 vtop pl15">' . $dir . '</td>
                            <td class="pt10 vtop pl15">' . $uri . '</td>
                            <td class="pt10 vtop pl15">' . $uid . '</td>
                            <td class="pt10 vtop pl15">'.timediff($e['date_raw']).' (' . $date . ')</td>
                        </tr>'
                        .$log;
                        $fi++;
                    }
                    $errlog .= '</table>
                </div>
            </div>';
        }

        // Payments HTML
        $mx = null;
        if ($payment_count > 0) {
            for ($i = 1; $i <= 12; $i++) {
                // Validation:
                $this_month = $i;
                if ($this_month_static_n <= 3 && $i > 3) {
                    break; // Skip future months
                }
                // Collect Daily Results:
                $total = 0;
                $female = $male = 0;
                $mobile = $desktop = 0;
                foreach ($day_results as $z) {
                    /* - - - Demographics - - - */
                    $gender = $z['gender'];
                    $device = $z['device'];
                    if ($gender == 1) $male++;
                    else if ($gender == 2) $female++;
                    if ($device == 1) $desktop++;
                    else if ($device == 2) $mobile++;


                    $month = $z['month'];
                    if ($month == $this_month) {
                        $price = $z['price'];
                        $total = $price / PRICE;
                        $day = $z['day'];
                        if ($day <= 7) $loop = 1;
                        else if ($day <= 14) $loop = 2;
                        else if ($day <= 21) $loop = 3;
                        else if ($day <= 28) $loop = 4;
                        else if ($day <= 31) $loop = 5;

                        $total += $total;
                        // Collect as Array:
                        $fm[$this_month][$day][$initials] += $price;
                        $projRec[$initials][$this_month][$loop][$day] += $price; // For records (max)
                        $projDaySum[$this_month][$loop][$day] += $price; // For records (max)
                        $projSum[$this_month][$loop][$initials] += $total;
                        $mTotal[$this_month] += $total;
                        $maleTotal[$this_month] += $male;
                        $femaleTotal[$this_month] += $female;
                        $mobileTotal[$this_month] += $mobile;
                        $desktopTotal[$this_month] += $desktop;
                    }
                }
                // Define Price:
                $this_month_price = $mTotal[$i];
                $price = '-';
                if ($this_month_price > 0) {
                    $price = _n($this_month_price);
                    $mp[($i - 1)] += $this_month_price;
                }
            }

        }
        $a++;
    }
    // Total
    $totalDayMax = null;
    $totalWeekMax = null;
    $from = 1;
    $to = 12;

    if (!empty($mp)) {
        $dbd = null;
        $dcount = null;
        if (!$show_all) {
            $now = date('n');
            $from = $now - 2;
            $to = $now;
        }
        for ($i = $from; $i <= $to; $i++) {
            $bbb = 1;
            $this_month = $i;
            $last_month = $i - 1;

            // Skip:
            if ($this_month_static_n > 3 && $i > $this_month_static_n) break;
            // Define Month:
            if ($i == -1) {
                $this_month = 11;
                $last_month = 10;
            } else if ($i == 0) {
                $this_month = 12;
                $last_month = 11;
            } else if ($i == 1) {
                $this_month = 1;
                $last_month = 12;
            }
            // Define Year:
            if ($to <= 3 && $this_month >= 11) $year = $year - 1;

            $this_month_total_days = cal_days_in_month(CAL_GREGORIAN, $this_month, $year);
            $day_month = $this_month_total_days;
            $class = null;
            $current = false;
            if ($this_month == (int) date('n')) {
                $day_month = (int) date('j');
                $class = ' now';
                $current = true;
            }
            // Calculate day by day data:
                $dbd .= '<table class="table-cal'.$class.'">
                <thead class="month"><tr><td colspan="10">'.__('TIME_MONTHS')[$this_month].'</td></tr></thead>';

                $loops = ceil($this_month_total_days / 7);
                $jj = $jjj = 1;
                $weekly_sum = 0;
                $iteration = null;
                $total_sum = 0;
                for ($j = 1; $j <= $loops; $j++) {
                    if ($j == 1) $weekMax = 7;
                    else if ($j == 2) $weekMax = 14;
                    else if ($j == 3) $weekMax = 21;
                    else if ($j == 4) $weekMax = 28;
                    else if ($j == 5) $weekMax = 31;
                    $class = null;

                    // THEAD
                    $dbd .= '<thead><tr><td></td>';
                    $daily_sum = 0;
                    for ($n = 1; $n <= 7; $n++) {
                        if ($jj <= $this_month_total_days)
                            $dbd .= '<td>'.$jj.'</td>';
                        else
                            $dbd .= '<td></td>';

                        $jj++;
                    }
                    $dbd .= '<td>'.__('DAILY').'</td><td>'.__('SUM').'</td></tr></thead>';
                    // TBODY
                    $dbd .= '<tbody>';
                    foreach ($proj as $px) {
                        if (empty($projSum[$this_month][$j][$px])) break;
                        $dbd .= '<tr><td>' . $px . '</td>';

                        for ($nn = 1; $nn <= 7; $nn++) {
                            $sum = $fm[$this_month][($nn+$iteration)][$px];
                            $pmax[$px] = $sum;
                            $max = max($projRec[$px][$this_month][$j]);
                            $classRec = null;

                            $dbdSumF = '-';
                            if ($sum > 0)
                                $dbdSumF = _n($sum, true);

                            if ($sum == $max) $classRec = ' class="green"';

                            $dbd .= '<td'.$classRec.'>'.$dbdSumF.'</td>';
                            $daily_sum += $sum;
                        }
                        // Weekly Sum (last column per week):
                        $weeklyF = null;
                        $dailyAvgF = null;
                        if ($daily_sum > 0) {
                            if ($current) $weekMax = $day_month;
                            $dailyAvgF = _n($daily_sum / $weekMax, true);
                            $weeklyF = _n($daily_sum, true);
                        }
                        $dbd .= '<td>'.$dailyAvgF.'</td><td class="green">'.$weeklyF.'</td>
                        </tr>';
                        $total_sum += $daily_sum;
                        $daily_sum = 0;
                    }
                    $daySum = null;
                    if (is_array($projDaySum[$this_month][$j])) {
                        $max = max($projDaySum[$this_month][$j]);
                        $totalDaySum = 0;

                        for ($bb = 1; $bb <= 7; $bb++) {
                            $val = $projDaySum[$this_month][$j][$bbb];
                            $classRec = null;
                            $daySumF = '-';
                            if ($val > 0)
                                $daySumF = _n($val, true);
                            if ($val == $max) {
                                $classRec = ' class="green"';
                                $totalDayMax[$bbb.'. '.__('TIME_MONTHS')[$this_month]] = $val;
                                $daySumF = _n($val, true);
                            }
                            $daySum .= '<td' . $classRec . '>' . $daySumF . '</td>';
                            $totalDaySum += $val;

                            $bbb++;
                        }
                        $totalWeekMax[__('TIME_MONTHS')[$this_month].' '.$j.'. '.__('CAL_WEEK').''] = $totalDaySum;

                        $last_month_cw = null;
                        if ($projDaySum[($last_month)][$j]) {
                            $last_month_cw_sum = array_sum($projDaySum[($last_month)][$j]);
                            $last_month_cw_sum = $totalDaySum - $last_month_cw_sum;
                            $sign = null;
                            $diffClass = ' red';
                            if ($last_month_cw_sum >= 0) {
                                $sign = '+';
                                $diffClass = null;
                            }

                            $last_month_cw = ' <span class="f09'.$diffClass.'">('.$sign._n($last_month_cw_sum, true).')</span>';
                        }
                        $dbd .= '
                        <tbody>
                            <tr>
                                <td>&nbsp;=</td>
                                ' . $daySum . '
                                <td>'._n(($totalDaySum / $weekMax), true).'</td>
                                <td>'._n($totalDaySum, true).$last_month_cw.'</td>
                            </tr>
                        </tbody>';
                    }
                    $iteration += 7;

                    $dbd .= '</tbody>';
                }

                $prediction = null;
                if ($this_month == (int) date('n')) {
                    $prediction = '<span class="db">~'._n(($total_sum / $day_month) * $this_month_total_days, true).'</span>';
                }
                $rec[$this_month] = $total_sum;

                $last_month_sum = null;
                if ($mTotal[($last_month)]) {
                    $last_month_sum = $mTotal[($last_month)];
                } else if ($rec[($last_month)]) {
                    $last_month_sum = $rec[($last_month)];
                }
                if ($last_month_sum > 0) {
                    $diffTotal = $total_sum - $rec[($last_month)];
                    $diffTotalClass = null;
                    $sign = '+';
                    if ($diffTotal < 0) {
                        $diffTotalClass = ' red';
                        $sign = null;
                    }
                    $diffTotalF = '<span class="db f09' . $diffTotalClass . '">(' . $sign . _n($diffTotal, true) . ')</span>';
                }

                $dbd .= '
                    <tbody>
                        <tr>
                            <td colspan="8"></td>
                            <td class="f11 green">
                                '._n($total_sum / $day_month, true).$prediction.'
                            </td>
                            <td class="total">
                                '._n($total_sum, true).$diffTotalF.'
                            </td>
                        </tr>
                        <tr><td class="f09" colspan="10">'.$maleTotal[$this_month].' m, '.$femaleTotal[$this_month].' f</td></tr>
                    </tbody>
                </table>';
        }
        $maxMonth = null;
        $maxMonthNr = null;
        if (is_array($rec)) {
            $maxMonth = max($rec);
            $totalF = null;
            foreach($rec as $key => $val) {
                $totalF += $val;
                if ($val == $maxMonth) $maxMonthNr = $key;
            }
            $totalF = _n($totalF, true);
        }
        $dbd .= '
        <table class="table-cal summary">
            <thead class="month"><tr><td colspan="2">'.__('BALANCE_SHEET').'</td></tr></thead>
            <thead class="title">
                <tr>
                    <td colspan="2">'.__('RECORDS').' ('.__('TIME_MONTHS')[$from].' - '.__('MONTHS_SHORT')[$to].')</td>
                </tr>
            </thead>
            <tbody>';

        $max_earning_day_value = null;
        $max_earning_week_value = null;
        if (is_array($totalDayMax)) {
            $max_earning_day_value = max($totalDayMax);
            foreach ($totalDayMax as $key => $val) {
                if ($val == $max_earning_day_value) $max_earning_day = $key;
            }
        }
        if (is_array($totalWeekMax)) {
            $max_earning_week_value = max($totalWeekMax);
            foreach ($totalWeekMax as $key => $val) {
                if ($val == $max_earning_week_value) $max_earning_week = $key;
            }
        }
        $dbd .=
        '<tr>
            <td>
                <span>'.$max_earning_day.'</span>
                '.__('MAX_DAILY_EARNING').'
            </td>
            <td>
                <strong>'._n($max_earning_day_value, true).'</strong>
            </td>    
        </tr>
        <tr>
            <td>
                <span>'.$max_earning_week.'</span>
                '.__('MAX_WEEKLY_EARNING').'
            </td>
            <td>
                <strong>'._n($max_earning_week_value, true).'</strong>
            </td>    
        </tr>        
        <tr>        
            <td>
                <span>'.__('TIME_MONTHS')[$maxMonthNr].'</span>            
                '.__('MAX_MONTHLY_EARNING').'
            </td>
            <td>
                <strong>'._n($maxMonth, true).'</strong>
            </td>    
        </tr>
        </tbody>
            <thead class="title"><tr><td colspan="2">'.__('RECORDS_LIFETIME').'</td></tr></thead>
        <tbody>        
        <tr>        
            <td>'.__('BEST_MONTH_LIFETIME').'</td><td>TBD</td>            
        </tr>';

        foreach ($proj as $val) {
            $dbd .= '<tr><td>'.$val.':</td><td>TBD</td></tr>';
        }
        $dbd .= '
            <tr><td>'.__('TOTAL').':</td><td class="total fwB f12">'.$totalF.'</td></tr>
            </tbody>
        </table>';
    }
    $output .= $dbd;
}
$output .= '</div></div>';

$output .= $errlog;


echo $output;