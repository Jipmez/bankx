<?php
    require 'vendor/autoload.php';
    
    use Coinbase\Wallet\Client;
    use Coinbase\Wallet\Resource\Notification;

    //API Configuration
    $api_key = "Igb4Fp6bhpk2gqiZ";
    $api_secret = "6MhO8hkYXDKjJzVvIwpze1LeyzNzZaqK";
    $configuration = Configuration::apiKey($api_key, $api_secret);
    $client = Client::create($configuration);
     
    $raw_body = file_get_contents("php://input");
    //$signature = $_SERVER['HTTP_CB_SIGNATURE'];
    $authentic = true;//$client->verifyCallback($raw_body, $signature); // boolean

    if ( $authentic ) {
        $notification = $client->parseNotification($raw_body);
        $type = $notification->getType();
        $data = $notification->getData();
        $additional_data = $notification->getAdditionalData();
        if ( $type == "wallet:addresses:new-payment" ) {
            $address = $data['address'];
            $paid_amount = $additional_data['amount']['amount'];
            
            $mysqli = new mysqli("localhost", "root", "", "chris");
            if ($mysqli->connect_errno) {
                exit();
            }

            $query = "SELECT amount, id, amount_btc FROM transaction WHERE address = {$address}";
            $res = $mysqli->query($query);
            $row = $res->fetch_assoc();
            $amount = $row['amount'];
            $amount_btc = $row['amount_btc'];
            $ninety_percent = 0.95 * $amount;
            $transaction_id = $row['id'];
            if ( $paid_amount > $ninety_percent ) {
                $mysqli->query("UPDATE transaction SET status = 1 WHERE id = {$transaction_id}");
            }
        }
    }