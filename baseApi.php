<?php
require 'ApiFunct.php';
header('Content-type:application/json;charset=utf-8');
$request = json_decode(file_get_contents('php://input'), true);
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: X-Requested-With, content-type,access-control-allow-origin, access-control-allow-methods, access-control-allow-headers');
$clas = new coin("127.0.0.1", "stcbhsjm_scbnk", "admin@scbnk", "stcbhsjm_scbnk");

if ($_POST) {

    if ($_POST['key'] == 'uPix') {

        $logg = $clas->uploadImage($_POST, $_FILES);

        echo json_encode($logg);
    }

}

if (isset($request['key'])) {

    if ($request['key'] == 'card') {

        $logg = $clas->card($request);
        echo json_encode($logg);

    }

    if ($request['key'] == 'bankaccounts') {

        $logg = $clas->bankaccounts($request);
        echo json_encode($logg);

    }

    if ($request['key'] == 'addC') {

        $logg = $clas->addC($request);
        echo json_encode($logg);

    }

    if ($request['key'] == 'eddC') {

        $logg = $clas->eddC($request);
        echo json_encode($logg);

    }
    if ($request['key'] == 'delC') {

        $logg = $clas->delC($request);
        echo json_encode($logg);

    }
    if ($request['key'] == 'delB') {

        $logg = $clas->delB($request);
        echo json_encode($logg);

    }
    if ($request['key'] == 'token') {

        $logg = $clas->verifyToken($request);
        echo json_encode($logg);

    }

    if ($request['key'] == 'getAcc') {
        $logg = $clas->getAcc($request);
        echo json_encode($logg);
    }

    if ($request['key'] == 'trx') {
        $logg = $clas->trx($request);
        echo json_encode($logg);
    }

    if ($request['key'] == 'trxk') {
        $logg = $clas->trxk($request);
        echo json_encode($logg);
    }

    if ($request['key'] == 'allU') {

        $logg = $clas->getP();

        echo json_encode($logg);
    }

    if ($request['key'] == 'proUser') {
        $id = $request['proid'];

        $logg = $clas->proUser($id);

        echo json_encode($logg);

    }

    if ($request['key'] == 'Ctrx') {

        $logg = $clas->Ctrx($request);

        echo json_encode($logg);

    }
    
    
    if ($request['key'] == 'perm') {

        $logg = $clas->perm($request);

        echo json_encode($logg);

    }

    if ($request['key'] == 'Dtrx') {

        $logg = $clas->Dtrx($request);

        echo json_encode($logg);

    }

    if ($request['key'] == 'Deltrx') {

        $logg = $clas->Deltrx($request);

        echo json_encode($logg);

    }

    if ($request['key'] == 'addAdmin') {

        $jay = $clas->addAdmin($request);
        echo json_encode($jay);
    }

    if ($request['key'] == 'addB') {

        $logg = $clas->addB($request);
        echo json_encode($logg);

    }

//dfdfdfdkjsfjksdjhjsdhjk
    if ($request['key'] == 'reg') {
        $input = array('email' => $request['email'], 'username' => $request['username'], 'password' => $request['password'], 'country' => $request['country']);

        $logg = $clas->Register($input);

        echo json_encode($logg);
    }

    if ($request['key'] == 'log') {
        $input = array('accountn' => $request['accountn'], 'password' => $request['password']);

        $logg = $clas->Login($input);

        echo json_encode($logg);

    }
    if ($request['key'] == 'adBitcoin') {
        $input = array('bitcoin' => $request['bitcoin']);

        $logg = $clas->adBitcoin($input);

        echo json_encode($logg);

    }

    if ($request['key'] == 'getAinvest') {

        $logg = $clas->getAinvest($request);
        echo json_encode($logg);

    }

    if ($request['key'] == 'getCrypInvest') {

        $logg = $clas->getCrypInvest($request);
        echo json_encode($logg);

    }

    if ($request['key'] == 'getAfixed') {

        $logg = $clas->getAfixed($request);
        echo json_encode($logg);

    }

    if ($request['key'] == 'getdetailId') {

        $logg = $clas->getdetailId($request);

        echo json_encode($logg);

    }

    if ($request['key'] == 'walletrx') {

        $logg = $clas->Walletrx($request);

        echo json_encode($logg);

    }
/*     */

    if ($request['key'] == 'addStock') {
        set_time_limit(0);

        $url_info = 'https://financialmodelingprep.com/api/v3/profile/AAPL,YELP,COKE,AMD,COST,AKR,ADBE,ALTR,AMZN,DELL,HPQ?apikey=78860d8e8216c2d4c543065759b604de';

        $channel = curl_init();

        curl_setopt($channel, CURLOPT_AUTOREFERER, true);
        curl_setopt($channel, CURLOPT_HEADER, 0);
        curl_setopt($channel, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($channel, CURLOPT_URL, $url_info);
        curl_setopt($channel, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($channel, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($channel, CURLOPT_TIMEOUT, 0);
        curl_setopt($channel, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($channel, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($channel, CURLOPT_SSL_VERIFYPEER, false);

        $output = curl_exec($channel);

        if (curl_error($channel)) {
            return 'error:' . curl_error($channel);
        } else {
            $outputJSON = json_decode($output);

            $logg = $clas->addStock($outputJSON);

            echo json_encode($logg);
        }

    }

    if ($request['key'] == 'addCoin') {
        set_time_limit(0);

        $url_info = 'https://api.nomics.com/v1/currencies/ticker?key=demo-26240835858194712a4f8cc0dc635c7a&ids=BTC,ETH,XRP,ETC&interval=1d,30d&convert=USD';

        $channel = curl_init();

        curl_setopt($channel, CURLOPT_AUTOREFERER, true);
        curl_setopt($channel, CURLOPT_HEADER, 0);
        curl_setopt($channel, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($channel, CURLOPT_URL, $url_info);
        curl_setopt($channel, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($channel, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($channel, CURLOPT_TIMEOUT, 0);
        curl_setopt($channel, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($channel, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($channel, CURLOPT_SSL_VERIFYPEER, false);

        $output = curl_exec($channel);

        if (curl_error($channel)) {
            return 'error:' . curl_error($channel);
        } else {
            $outputJSON = json_decode($output);

            $logg = $clas->addCoin($outputJSON);

            echo json_encode($logg);
        }
    }

    if ($request) {
        if ($request['key'] == 'getBank') {
            $logg = $clas->getAllBank();

            echo json_encode($logg);
        }
    }

    if ($request['key'] == 'refPer') {
        $logg = $clas->refPer($request);

        echo json_encode($logg);
    }

    if ($request['key'] == 'upPerson') {
        $input = ['fullname' => $request['fullname'], 'email' => $request['email'], 'phone' => $request['phone'], 'id' => $request['id']];

        $logg = $clas->upPerson($input);

        echo json_encode($logg);

    }

    if ($request['key'] == 'recharge') {

        $logg = $clas->Recharge($request);

        echo json_encode($logg);

    }

    if ($request['key'] == 'upAccount') {
        $input = ['bitad' => $request['bitad'], 'trust' => $request['trust'], 'account' => $request['account'], 'id' => $request['id']];

        $logg = $clas->upAccount($input);

        echo json_encode($logg);
    }

    if ($request['key'] == 'getBitcoin') {
        $logg = $clas->getBitcoin();

        echo json_encode($logg);
    }

    if ($request['key'] == 'inv') {

        $logg = $clas->getInvest($request['inv'], $request['val']);

        echo json_encode($logg);
    }

    if ($request['key'] == 'delBank') {

        $logg = $clas->deleteBank($request['id']);

        echo json_encode($logg);
    }

    if ($request['key'] == 'regref') {
        $input = array('email' => $request['email'], 'username' => $request['username'], 'password' => $request['password'], 'fullname' => $request['fullname'], 'city' => $request['city'], 'state' => $request['state'], 'country' => $request['country'], 'address' => $request['address'], 'bitcoinaddress' => $request['bitcoin'], 'refferal' => $request['ref']);

        $logg = $clas->Regref($input);

        echo json_encode($logg);
    }

    if ($request['key'] == 'cashout') {
        $id = $request['depID'];
        $token = $request['token'];
        $logg = $clas->Cashout($id, $token);

        echo json_encode($logg);
    }

    if ($request['key'] == 'ramb') {
        $email = $request['email'];
        $logg = $clas->Ramb($email);
        echo json_encode($logg);
    }

    if ($request['key'] == 'mamb') {
        $email = $request['email'];
        $logg = $clas->Mamb($email);
        echo json_encode($logg);
    }

    if ($request['key'] == 'taccess') {
        $email = $request['email'];
        $logg = $clas->Taccess($email);
        echo json_encode($logg);
    }

    if ($request['key'] == 'user') {

        $token = $request['Id'];

        $logg = $clas->getU($token);

        echo json_encode($logg);

    }

    if ($request['key'] == 'depo') {
        $token = $request['val'];
        $input = array('plan' => $request['plan'], 'profit' => $request['profit'], 'amount' => $request['amount'], 'username' => $request['username'], 'percent' => $request['percent']);

        $logg = $clas->process($input, $token);

        echo json_encode($logg);
    }

    if ($request['key'] == 'addCryp') {
        $logg = $clas->addCryp($request);

        echo json_encode($logg);
    }

    if ($request['key'] == 'depoBitcoin') {
        $token = $request['user_id'];

        $input = array('plan' => $request['plan'], 'profit' => $request['profit'], 'amount' => $request['amount'], 'username' => $request['username'], 'per_incr' => $request['percent'], 'pay_method' => $request['paymethod']);

        $logg = $clas->processBitcoin($input, $token);

        echo json_encode($logg);
    }

    if ($request['key'] == 'depoBank') {
        $token = $request['user_id'];

        $input = array('plan' => $request['plan'], 'profit' => $request['profit'], 'amount' => $request['amount'], 'username' => $request['username'], 'pay_mode' => $request['paymethod'], 'per_incr' => $request['percent']);

        $logg = $clas->processBank($input, $token);

        echo json_encode($logg);
    }

    if ($request['key'] == 'search') {
        $token = $request['Id'];
        $input = array('fmonth' => $request['fmonth'], 'fday' => $request['fday'], 'fyear' => $request['fyear'], 'tmonth' => $request['tmonth'], 'tday' => $request['tday'], 'tyear' => $request['tyear']);

        $logg = $clas->search($input, $token);

        echo json_encode($logg);

    }
    if ($request['key'] == 'searchW') {
        $token = $request['Id'];
        $input = array('fmonth' => $request['fmonth'], 'fday' => $request['fday'], 'fyear' => $request['fyear'], 'tmonth' => $request['tmonth'], 'tday' => $request['tday'], 'tyear' => $request['tyear']);

        $logg = $clas->searchW($input, $token);

        echo json_encode($logg);

    }

    if ($request['key'] == 'load') {
        $token = $request['val'];

        $logg = $clas->earn($token);

        echo json_encode($logg);

    }

    if ($request['key'] == 'withdraw') {
        $token = $request['val'];
        $input = $request;

        $logg = $clas->withdraw($input, $token);

        echo json_encode($logg);
    }

    if ($request['key'] == 'lock') {
        $logg = $clas->Lock();

        echo json_encode($logg);
    }

    if ($request['key'] == 'witH') {
        $token = $request['Id'];

        $logg = $clas->Totwith($token);

        echo json_encode($logg);
    }

    if ($request['key'] == 'depH') {
        $token = $request['Id'];

        $logg = $clas->Totdep($token);

        echo json_encode($logg);
    }

    if ($request['key'] == 'dep') {
        $token = $request['val'];

        $logg = $clas->deplist($token);

        echo json_encode($logg);
    }

    if ($request['key'] == 'depCom') {
        $token = $request['val'];

        $logg = $clas->deplistCom($token);

        echo json_encode($logg);
    }

    if ($request['key'] == 'depN') {
        $token = $request['val'];

        $logg = $clas->deplistNot($token);

        echo json_encode($logg);
    }

    if ($request['key'] == 'admindep') {

        $logg = $clas->DepC();

        echo json_encode($logg);
    }

    if ($request['key'] == 'depositId') {

        $id = $request['depositId'];

        $logg = $clas->Cdep($id);

        echo json_encode($logg);
    }

    if ($request['key'] == 'adminwithdraw') {

        $logg = $clas->withC();

        echo json_encode($logg);
    }

    if ($request['key'] == 'withdrawId') {
        $id = $request['withdrawId'];

        $logg = $clas->Cwith($id);

        echo json_encode($logg);
    }

    if ($request['key'] == 'invest') {

        $logg = $clas->AinvestD();

        echo json_encode($logg);
    }

    if ($request['key'] == 'proUp') {

        $token = $request['Id'];

        $input = array('bitcoinaddress' => $request['bitcoinaddress'], 'city' => $request['city'], 'state' => $request['state'], 'country' => $request['country'], 'zip' => $request['zip'], 'address' => $request['address'], 'password' => $request['password'], 'pass' => $request['newpass'], 'bank' => $request['bank'], 'account' => $request['account']);

        $logg = $clas->proUp($token, $input);

        echo json_encode($logg);

    }
    if ($request['key'] == 'graph') {

        $logg = $clas->gtGraph();

        echo json_encode($logg);
    }
    if ($request['key'] == 'Ugraph') {
        $token = $request['token'];

        $logg = $clas->gtUgraph($token);

        echo json_encode($logg);
    }
    if ($request['key'] == 'simdep') {
        $input = array('username' => $request['username'], 'amount' => $request['amount']);

        $logg = $clas->simDep($input);

        echo json_encode($logg);
    }
    if ($request['key'] == 'simwith') {
        $input = array('username' => $request['username'], 'amount' => $request['amount']);

        $logg = $clas->simWith($input);

        echo json_encode($logg);
    }
}

if ($request['key'] == 'block') {
    $id = $request['id'];
    $logg = $clas->block($id);

    echo json_encode($logg);
}
if ($request['key'] == 'unblock') {
    $id = $request['id'];
    $logg = $clas->unblock($id);

    echo json_encode($logg);
}
if ($request['key'] == 'reff') {
    $token = $request['val'];

    $logg = $clas->getRef($token);

    echo json_encode($logg);

}

if ($request['key'] == 'subscribe') {
    $input = ['email' => $request['email'], 'name' => $request['name']];
    $log = $clas->subscribe($input);
    echo json_encode($log);
}

if ($request['key'] == 'contactus') {
    $input = ['name' => $request['name'], 'email' => $request['email'], 'phone' => $request['phone'], 'text' => $request['text']];
    $log = $clas->ContactUs($input);
    echo json_encode($log);
}

if ($request['key'] == 'forgot') {
    $email = $request['email'];
    $jay = $clas->forgotPass($email);
    echo json_encode($jay);
}

if ($request['key'] == 'tokenVerify') {
    $token = $request['token'];
    $jay = $clas->tokenVerify($token);
    echo json_encode($jay);
}

if ($request['key'] == 'changePass') {
    $password = array('password' => $request['pass']);
    $token = $request['token'];

    $jay = $clas->changePass($password, $token);
    echo json_encode($jay);
}

if ($request['key'] == 'addBank') {
    $input = ['bank' => $request['bank'], 'account' => $request['account'], 'accountname' => $request['accountname'], 'branch' => $request['branch']];
    $jay = $clas->addBank($input);
    echo json_encode($jay);
}
if ($request['key'] == 'conwith') {
    $email = $request['email'];
    $id = $request['id'];
    $jay = $clas->ConWith($email, $id);
    echo json_encode($jay);
}

if ($request['key'] == 'condep') {
    $email = $request['email'];
    $id = $request['id'];
    $jay = $clas->ConDep($email, $id);
    echo json_encode($jay);
}
if ($request['key'] == 'mailconfirm') {
    $hash = $request['hash'];
    $jay = $clas->Mailconfirm($hash);
    echo json_encode($jay);
}
