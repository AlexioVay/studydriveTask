<?php
$file = 'DE98120300001052241856';
$csv = array_map('str_getcsv', file(__DIR__.'/data/'.$file.'.csv'));

$kto = str_replace(['";',';"'], ' ', $csv[0][0]);

$total = str_replace(';"', ' ', $csv[4][0]);
$totalEx = explode(': ', $total);
$totalTitle = $totalEx[0];
$totalValue = $totalEx[1];

unset($csv[0], $csv[1], $csv[2], $csv[3], $csv[4], $csv[5], $csv[6]);

$return['title'][0] = '
<h3>'.$kto.'</h3>
'.$totalTitle.':
<div><strong class="green f14">'.$totalValue.' EUR</strong></div>';

function f($str) {
    $str = preg_replace('/\s+/', '', $str);
    $str = str_replace('AWV-MELDEPFLICHTBEACHTENHOTLINEBUNDESBANK:(0800)1234-111', '', $str);
    $ex = explode('/', $str);
    $name = $ex[0];

    preg_match('~[a-z]~i', $ex[1], $match, PREG_OFFSET_CAPTURE);
    $pos = null;
    if (!empty($match)) {
        $pos = $match[0][1];
        $order_nr = substr($ex[1], 0, $pos);
    } else {
        $order_nr = $ex[1];
    }

    $name = strtoupper(substr($name, 0, 2));
    $output['name'] = $name;
    $output['order_nr'] = $order_nr;

    return $output;
}

$collect = null;
foreach($csv as $x) {
    $merge = null;
    foreach($x as $y) {
        $val = $x[0];
        $merge .= strtolower($val);
    }
    $merge = str_replace('"', '', $merge);
    // Only Collect Gutschrift:
    $strpos = strpos($merge, 'gutschr', 1);
    if ($strpos !== false) {
        $lineEx = explode(';', $merge);
        $date = $lineEx[0];
        $name = '<strong>'.ucwords($lineEx[3]).'</strong>';
        $value = f($lineEx[4]);

        if ($value['order_nr'])
            $collect[$value['name']][] = ['date' => $date, 'name' => $name, 'order_nr' => $value['order_nr']];
    }
}

// Check Projects for Order Numbers
$conn = unserialize(PROJECTS);
$i = 1;
$return = null;
foreach($conn as $dir => $x) {
    $dbx = DBConnect($dir);
    $initials = $x['initials'];

    foreach($collect as $k => $y) {
        if ($k == $initials) {
            foreach($y as $z) {
                $date = $z['date'];
                $name = $z['name'];
                $order_nr = $z['order_nr'];
                $dbx->where('id', $order_nr);
                $dbx->where('method', 'bt');
                $status = $dbx->getValue('orders', 'status');

                $icon = '<i class="material-icons md-18 ml10">access_time</i>';
                if ($status == 'Completed') $icon = '<i class="material-icons green md-18 ml10">check_circle</i>';

                $return['html'][$date][] = '
                <div class="pt5">' . $date . ': &nbsp; ' . $name . ' &nbsp; &middot; &nbsp; ' . $initials.' '.$order_nr . $icon . '</div>';
                $i++;
            }
            unset($collect[$k]);
            break;
        }
    }
}