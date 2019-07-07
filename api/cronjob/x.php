<?php
session_start();#
if ($_SESSION['uid'] != 1) exit();

require_once 'init.php';

$mysqlhost = "www.spieletester.eu"; // MySQL Hostname
$mysqluser = "d01a0a97"; // MySQL Username
$mysqlpass = "mlpplm00"; // MySQL Password
$mysqldb = "d01a0a97"; // Name der Datenbank
$mysqli = new mysqli($mysqlhost, $mysqluser, $mysqlpass, $mysqldb);



$db = MysqliDb::getInstance();
$db->where('date = DATE_SUB(NOW(), INTERVAL 2 WEEK)');
#$db->where('method', 'bt');
#$db->where('status', 'Pending');
$dunning = $db->get('orders', null, 'id');

var_dump($dunning);

#$data = ['number' => 1, 'surname' => 'Schubert', 'gender' => 2, 'price' => PRICE];
#send_mail('alexiovay@gmail.com', 'dunning', $data);



$sql = '
SELECT u.email,u.pass FROM users u
LEFT JOIN orders o ON o.uid = u.id
WHERE o.method = "pp"
ORDER BY o.date DESC
';
$result = $mysqli->query($sql);

if ($_GET['y']) {
    $_SESSION['x'][] = $_GET['y'];
    header('Location: x.php');
    exit();
}

$i = 1;
echo '
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>body { font-family: Arial; font-weight: bold; }</style>
</head>
<body>
<table>';
while ($x = mysqli_fetch_array($result)) {
    $aa = '<a href="x.php?y=' . $x['email'] . '">';
    $ae = '</a>';
    if (is_array($_SESSION['x'])) {
        if (in_array($x['email'], $_SESSION['x'])) {
            $aa = '<strike>';
            $ae = '</strike>';
        }
    }

    if ($x['email'] && $x['pass'])
    echo '
    <tr>
        <td><strong>'.$i.'</strong></td>
        <td style="padding: 7px 0 7px 10px; font-weight: bold">'.$aa.''.$x['email'].''.$ae.'</td>
        <td style="font-weight: bold">'.$x['pass'].'</td>
    </tr>';
    $i++;
}
echo '</table></body></html>';