<?php
session_start();
if ($_SESSION['uid'] != 1) exit();
class pay {
    public function payment($formID, $price) {
        $payment = '
        <h1>PayPal Payment</h1>
        <input value="pp" name="payment" type="radio" data-method="pp">
        ' . $this->paypal($price) . '
        <input id="price_original" name="price" type="hidden" value="' . $price . '" />
        ';

        $output = '
        <form id="#'.$formID.'" method="post" action="https://www.paypal.com/cgi-bin/webscr">
        ' . $payment . '
        ' . $price .' EUR
        <input type="submit" name="buy" value="BUY" />
        </form>
        ';

        return $output;
    }

    // PayPal
    public function paypal($price, $order_id = false, $method = 'pp', $type = 'pp') {
        $uri = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."";
        $output = "
        <input type='hidden' name='return' value='" . $uri . "#return' />
        <input type='hidden' name='notify_url' value='" . $uri . "/ipn.php' />
        <input type='hidden' name='cancel_return' value='" . $uri . "#cancel' />
        <input id='custom' type='hidden' name='custom' value='' />
        <input id='item_name' type='hidden' name='item_name' value='PayPal Payment' />
        <input id='item_number' type='hidden' name='item_number' value='" . $order_id . "' />
        <input id='method' type='hidden' name='method' value='" . $method . "' />
        <input type='hidden' name='type' value='" . $type . "' />
        <input type='hidden' name='item_name' value='Mediation service' />
        <input type='hidden' name='item_number' value='1' />
        <input type='hidden' name='no_shipping' value='1' />
        <input type='hidden' name='business' value='info@spieletester.eu' />
        <input type='hidden' name='receiver_email' value='info@spieletester.eu' />
        <input type='hidden' name='cmd' value='_xclick' />
        <input type='hidden' name='no_note' value='1' />
        <input type='hidden' name='quantity' value='1' />
        <input type='hidden' name='currency_code' value='EUR' />
        <input type='hidden' name='amount' value='" . $price . "' />
        <input type='hidden' name='total_price' value='" . $price . "' />";

        return $output;
    }
}

$pay = new Pay();
echo $pay->payment('pay', 0.01);


echo '<br><br><br><span style="font-size:0.8em">';
echo highlight_file(str_replace('/', '', $_SERVER['REQUEST_URI']));
echo '</span>';
?>
