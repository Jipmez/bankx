<?php
require('ApiFunct.php');
header('Content-type:application/json;charset=utf-8');
$request=json_decode(file_get_contents('php://input'),true);
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: X-Requested-With, content-type,access-control-allow-origin, access-control-allow-methods, access-control-allow-headers');


require 'vendor/autoload.php';

use Coinbase\Wallet\Client;
use Coinbase\Wallet\Configuration;
use Coinbase\Wallet\Resource\Address;

   
  $clas= new coin('localhost','root','','tcb');

if($_POST){
    if($_POST['key'] == 'depo'){
    //Post Data 
    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : 2717171771;
    $amount = isset($_POST['amount']) ? $_POST['amount'] : 1000;
    $plan = $_POST['plan'];
    $username = $_POST['username'];
    $expected_roi = $_POST['profit'];
    $time = time();
    $rand = rand(1000,10000);
    $date = date("Y-m-d");
    $month = date('m');
    $deposite_id = $time.$rand;
    

    $isActive = $clas->checkUserDeposit($user_id);
    if($isActive == true){
    $user_id = $clas-> getid($user_id);


    //API Configuration
    $api_key = "ZDR09y0uGs8Zx4RA";
    $api_secret = "YpY9X2kIDE490ssEK8dxsCSrnN0pF709";
    $configuration = Configuration::apiKey($api_key, $api_secret);
    $client = Client::create($configuration);

    //Set The Bitcoin Price To The Minimum
    $buy_price = $client->getBuyPrice('BTC-USD')->getAmount();
    $sell_price = $client->getSellPrice('BTC-USD')->getAmount();
    $price = ( $buy_price <= $sell_price ) ? $buy_price : $sell_price;
    $account = $client->getAccount("447ef7e7-ab8b-5edf-83a0-ce3551e5febc");

    //Errors

    //Create Bitcoin Address
    $address = new Address([
        'name' => $username
    ]);
    $new_address = $client->createAccountAddress($account, $address);
    $btc_address = $new_address->getAddress();
    $mysqli = new mysqli("localhost", "root", "", "tcb");
    if ($mysqli->connect_errno) {
        $error_array = array('error' => 'Connection Issue');
        $error = json_encode($error_array);
        echo $error;
        exit();
    }
    if (!($stmt = $mysqli->prepare("INSERT INTO deposits(email,username,plan,pay_mode,amount, amount_btc,address,expected_roi,deposite_time,deposite_id,month,depositDate,status) VALUES (?,?,?,?, ?, ?, ?, ?, ?, ?, ?, '$date', 0)"))) {
        $error_array = array('error' => $stmt->error);
        $error = json_encode($error_array);
        echo $error;
        exit();
    }
$bitcoin ='bitcoin';
    $amount_btc = $amount/$price;
    if (!$stmt->bind_param("ssisddsdiid",$user_id,$username,$plan,$bitcoin,$amount,$amount_btc,$btc_address,$expected_roi,$time,$deposite_id,$month)) {
        $error_array = array('error' => $stmt->error);
        $error = json_encode($error_array);
        echo $error;
        exit();
    } 
    
    if (!$stmt->execute()) {
        $error_array = array('error' => $stmt->error);
        $error = json_encode($error_array);
        echo $error;
        exit();
    }

    $stmt->close();

    $result = array(
        'code'=> 1,
        'amount_btc' => $amount_btc,
        'address' => $btc_address,
        'transaction_id' => $mysqli->insert_id
    );
    $me = json_encode($result);
    echo $me;
}
else{
    echo 2;
}
}
}