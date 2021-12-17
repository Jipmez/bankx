<?php
use Firebase\JWT\JWT;

require 'mysqllab.php';
require 'mail.php';
require 'jwt/JWT.php';
require 'vendor/autoload.php';
#endregion

define('secret_key', 'otuonynoye');

#endregion
#endregion

class coin extends HandleSql
{

    public function __construct($host, $username, $password, $db_name)
    {
        parent::__construct($host, $username, $password, $db_name);
    }

    public function enc($issuer, $audience, $user_id)
    {
        $token = array(
            "iss" => $issuer,
            "aud" => $audience,
            "id" => $user_id,
            "iat" => time(),
            "nbf" => time(),
        );

        $jwt = new JWT;
        //$jwt=JWT::encode($token, $key);
        $call = $jwt::encode($token, secret_key);
        return $call;

    }

    public function card($x)
    {
        $neat = $this::neat($x);
        $email = $this::getid($neat['Id']);

        $this::selectQuery("cards", '*', "where accountN = '$email'");
        $f = $this::fetchQuery();

        return ['message' => $f];

    }

    public function bankaccounts($x)
    {
        $neat = $this::neat($x);
        $email = $this::getid($neat['Id']);

        $this::selectQuery("bank_accounts", '*', "where accountN = '$email'");
        $f = $this::fetchQuery();

        return ['message' => $f];

    }

    public function addC($x)
    {

        $id = $this::getid($x['id']);

        $clean = $this::neat($x['new']);
        $cN = $clean['cardnumber'];
        $date = $clean['expiry'];
        $cvv = $clean['cvv'];
        $cNa = $clean['cardname'];
        $ct = $clean['cardType'];
        $rand = $this::random_alphanumeric(5);

        $in = $this::insertQuery('cards', 'email,accountN,card_id,cardN,expiry_date,cvv,card_name,card_type', "'mezj972@gmail.com','$id','$rand','$cN','$date','$cvv','$cNa','$ct'");
        if ($in) {
            return ['message' => 'card added'];
        }
    }

    public function eddC($x)
    {
        $id = $x['id'];
        $clean = $this::neat($x['ecard']);

        $this::selectQuery('cards', '*', "where card_id = '$id'");
        $f = $this::fetchQuery();

        if (empty($clean['expiry'])) {
            $expiry = $f[0]['expiry_date'];
        } else {
            $expiry = $clean['expiry'];
        }

        if (empty($clean['cvv'])) {
            $cvv = $f[0]['cvv'];
        } else {
            $cvv = $clean['cvv'];
        }

        if (empty($clean['cardname'])) {
            $cN = $f[0]['card_name'];
        } else {
            $cN = $clean['cardname'];
        }

        $up = $this::update('cards', "expiry_date='$expiry', cvv = '$cvv' , card_name = '$cN'", "where card_id = '$id'");

        if ($up) {
            return ['message' => 'updated'];
        }
    }
    public function delC($x)
    {
        $id = $x['id'];

        $del = $this::delete('cards', "where cardN = '$id'");
        if ($del) {
            return ['message' => 'deleted'];
        }

    }

    public function delB($x)
    {
        $id = $x['id'];

        $del = $this::delete('bank_accounts', "where bank_id = '$id'");
        if ($del) {
            return ['message' => 'deleted'];
        }

    }

    public function getAcc($x)
    {
        $id = $this::getid($x['id']);

        $this::selectQuery('bank_accounts', '*', "where accountN = '$id'");
        $f = $this::fetchQuery();

        return ['message' => $f];
    }

    public function trx($x)
    {

        $id = $this::getid($x['id']);
        $amount = $x['data']['amount'];
        $des = $x['data']['des'];
        $this::selectQuery('users', 'email,balance,remtrx,login_token', "where accountN = '$id'");
        $f = $this::fetchQuery();
        $email = $f[0]['email'];
        /*   $balance = $f[0]['balance'] - $amount;

        $up = $this::update('users', "balance = '$balance'", "where accountN ='$id'"); */
        $date = date("m/d/y");

        $rand = $f[0]['login_token'];
        $trx_id = $this::random_alphanumeric(8);
        if($amount > $f[0]['remtrx'] || $amount > $f[0]['balance']) return ['code' => 4];
       mail::TransMail('stcbnk@stcbnk.com', $email, 'Transaction alert', $rand, $link = "", $tag = "");

        $this::insertQuery('transactions', "email,accountN,description,type,amount,date,status,trx_token,trx_id,approved", "'$email','$id','$des','debit','$amount','$date','PENDING','$rand','$trx_id','0'");

        return ['code' => 1, 'message'=>['amount'=>$amount,'trx_id' => $trx_id]];

    }

    public function trxk($x)
    {
        $id = $this::getid($x['id']);
        $token = $x['data']['token'];
        $amount = $x['amount'];
        $trx_id = $x['trx_id'];
        $this::selectQuery('users', '*', "where login_token = '$token' and accountN ='$id'");
        if ($this::checkrow() == 1) {
            $f = $this::fetchQuery();
            $accountN = $f[0]['accountN'];
            $this::selectQuery('users', 'balance,restrain,remtrx', "where accountN = '$id'");
            $p = $this::fetchQuery();
            if($p[0]['restrain'] != 0) return ['code' => 3];
            $balance = $p[0]['balance'] - $amount;
       
            if($amount > $p[0]['remtrx']) return ['code' => 4];
            $remtrx = $p[0]['remtrx'] - $amount;
          
            $up = $this::update('transactions', " approved = '1', status='COMPLETE'", "where trx_token = '$token' and trx_id ='$trx_id'");
            if ($up) {
               $this::update('users', "balance = '$balance',remtrx = '$remtrx'", "where accountN ='$id'");
                return ['code' => 1];
            }
        } else {
            return ['code' => 2];
        }
    }

    public function getP()
    {
        $this->selectQuery("users", "*", "where type = 'member'");
        $u = $this::fetchQuery();
        return array('code' => '1', 'message' => $u);
    }

    public function Ctrx($request)
    {

        $clean = $this::neat($request['data']);
        $id = $request['id'];
        $amount = $clean['amount'];
        $status = $clean['status'];
        $description = $clean['description'];
        $this::selectQuery('users', 'email,balance', "where accountN ='$id'");
        $f = $this::fetchQuery();
        $email = $f[0]['email'];
        $date = $clean['date'];
        $rand = $this::random_alphanumeric(8);
        if($status != 'FAILED'){
            $balance = $f[0]['balance'] + $amount;

            $in = $this::insertQuery('transactions', "email,accountN,description,type,amount,date,status,trx_token,approved", "'$email','$id','$description','credit','$amount','$date','$status','$rand','1'");
            if ($in) {
                $this::update('users', "balance = '$balance'", "where accountN = '$id'");
                return ['message' => 'transaction complete'];
            }
        }else{
            $in = $this::insertQuery('transactions', "email,accountN,description,type,amount,date,status,trx_token,approved", "'$email','$id','$description','credit','$amount','$date','$status','$rand','1'");
            if ($in) {
                return ['message' => 'transaction complete'];
            }
        }


    }
    
    
    public function perm($x){
         
        $perm = $x['data'];
        $id = $x['id'];
         $this::update('users', "restrain = '$perm'", "where accountN = '$id'");
         return ['message' => 'Access changed'];
    }

    public function Dtrx($request)
    {

        $clean = $this::neat($request['data']);
        $id = $request['id'];
        $amount = $clean['amount'];
        $status = $clean['status'];
        $description = $clean['description'];
        $this::selectQuery('users', 'email,balance', "where accountN ='$id'");
        $f = $this::fetchQuery();
        $email = $f[0]['email'];
        $date = $clean['date'];
        $rand = $this::random_alphanumeric(8);
       
        if($status != 'FAILED'){
            $balance = $f[0]['balance'] - $amount;

            $in = $this::insertQuery('transactions', "email,accountN,description,type,amount,date,status,trx_token,approved", "'$email','$id','$description','debit','$amount','$date','$status','$rand','1'");
            if ($in) {
                $this::update('users', "balance = '$balance'", "where accountN = '$id'");
                return ['message' => 'transaction complete'];
            }
        }else{
            $in = $this::insertQuery('transactions', "email,accountN,description,type,amount,date,status,trx_token,approved", "'$email','$id','$description','debit','$amount','$date','$status','$rand','1'");
            if ($in) {
                return ['message' => 'transaction complete'];
            }
        }

        

    }

    public function Deltrx($request)
    {
        $data = $request['data'];
        $id = $request['id'];
        $this::selectQuery('transactions', "amount, type", "where accountN ='$id' and trx_token = '$data'");
        $f = $this::fetchQuery();
        $type = $f[0]['type'];
        $amount = $f[0]['amount'];
        if ($type == 'credit') {
            $this::selectQuery('users', "balance", "where accountN ='$id'");
            $p = $this::fetchQuery();
            $balance = $p[0]['balance'] - $amount;
            $this::update('users', "balance = '$balance'", "where accountN = '$id'");

            $this::delete('transactions', "where  trx_token = '$data'");
            return ['message' => 'deleted'];
        }

        if ($type == 'debit') {
            $this::selectQuery('users', "balance", "where accountN ='$id'");
            $p = $this::fetchQuery();
            $balance = $p[0]['balance'] + $amount;
            $this::update('users', "balance = '$balance'", "where accountN = '$id'");
            $this::delete('transactions', "where  trx_token = '$data'");
            return ['message' => 'deleted'];
        }
    }

    public function addB($x)
    {

        $id = $this::getid($x['id']);
        $bankname = $x['data']['bankname'];
        $accname = $x['data']['accname'];
        $accnumber = $x['data']['accnumber'];
        $rand = $this::random_alphanumeric(5);
        $this::selectQuery('users', "email", "where accountN ='$id'");
        $f = $this::fetchQuery();
        $email = $f[0]['email'];

        $in = $this::insertQuery('bank_accounts', "email,accountN,bank_id,bank_name,account_name,account_number,bnak_country,status", "'$email','$id','$rand','$bankname','$accname','$accnumber','England','APPROVED'");
        if ($in) {
            return ['message' => 'Bank added'];
        }
    }

    //   USER REGISTRATION
    public function Register($input)
    {

        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            $linkk = "https";
        } else {
            $linkk = "http";
        }

        // Here append the common URL characters.
        $linkk .= "://";

        // Append the host(domain name, ip) to the URL.
        $linkk .= $_SERVER['HTTP_HOST'];

        $clean = $this::neat($input);
        $email = $clean['email'];
        $username = ucwords($clean['username']);
        $password = $clean['password'];
        // $fullname = ucwords($clean['fullname']);
        $country = $clean['country'];
        $time = time();
        $hash = rand(148958949, 108849958);
        $rand = $this::random_alphanumeric(8);
        $date = date('Y-m-d');
        $e = strtolower($email);
        $e = $this::ValidateEmail($e);
        $fn = $this::pregmatch($username);

        if ($e && $fn == true) {

            $where = "where email = '$e'";
            $w = "where username = '$fn'";
            $this->selectQuery('users', 'email', $where);
            if ($this::checkrow() > 0) {
                return ['message' => 'email already exists'];
            } else {
                $this->selectQuery('users', 'username', $w);

                if ($this::checkrow() > 0) {
                    return ['message' => 'username already exits'];
                } else {
                    $insert = $this::insertQuery('users', 'type,username,email,password,hash,country,date_created,profileId,status,payed', "'member','$fn','$e','$password','$hash','$country','$date','$rand','0','1'");
                    if ($insert) {

                        /*  $link = "http://www.yourwebsite.com/verify.php?email='.$email.'&hash='.$hash.'"; */
                        $link = "{$linkk}/#/verify?hash={$hash}";

                        $message = "Thank you for signing up!\r\n Your Account have been created, We may need to send you critical information about our service and it is important that we have an accurate email address.\r\n Please click on the button below";

                        $me = mail::welcomemail('noreply@Upstash.co', $e, 'Signup | Verification', $message, $fn, $link);

                        return array('code' => '1', 'message' => 'account created');
                    }
                }
            }
        } else {
            return ['message' => 'please cross-check your email'];
        }
    }
// REFFERAL REGISTRATION
    public function Regref($input)
    {

        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            $linkk = "https";
        } else {
            $linkk = "http";
        }

        // Here append the common URL characters.
        $linkk .= "://";

        // Append the host(domain name, ip) to the URL.
        $linkk .= $_SERVER['HTTP_HOST'];

        $clean = $this::neat($input);

        $email = $clean['email'];
        $username = $clean['username'];
        $password = $clean['password'];
        // $fullname = $clean['fullname'];
        $city = $clean['city'];
        $state = $clean['state'];
        $country = $clean['country'];
        $address = $clean['address'];
        //  $bitcoinaddress = $clean['bitcoinaddress'];
        $refferal = $clean['refferal'];

        $time = time();
        $hash = rand(148958949, 108849958);
        $rand = $this::random_alphanumeric(8);
        $date = date('Y-m-d');
        $e = strtolower($email);
        $e = $this::ValidateEmail($e);
        $fn = $this::pregmatch($username);

        if ($e && $fn == true) {
            $where = "where email = '$email'";
            $w = "where username = '$username'";
            $this->selectQuery('users', 'email', $where);
            if ($this::checkrow() > 0) {
                return ['message' => 'email already exists'];
            } else {
                $this->selectQuery('users', 'username', $w);

                if ($this::checkrow() > 0) {
                    return ['message' => 'username already exists'];
                } else {
                    $this::selectQuery('users', 'username,email', "where profileId='$refferal'");
                    $q = $this::fetchQuery();
                    if ($this::checkrow() == 1) {
                        $parent = $q[0]['email'];

                        $inref = $this::insertQuery('refferal', 'parent_id,child_id', "'$parent','$email'");

                        if ($inref) {
                            $insert = $this::insertQuery('users', 'type,username,email,password,hash,city,state,country,address,referral,date_created,profileId,status,payed', "'member','$fn','$e','$password','$hash','$city','$state','$country','$address','$referral','$date','$rand','0','1'");
                            if ($insert) {
                                /*  $link = "http://www.yourwebsite.com/verify.php?email='.$email.'&hash='.$hash.'"; */
                                $link = "{$linkk}/#/verify?={$hash}";

                                $message = "Thank you for signing up!\r\n Your Account have been created, We may need to send you critical information about our service and it is important that we have an accurate email address.\r\n Please click on the url below\r\n $link";

                                $me = mail::Mailling('noreply@Upstash.co', $e, 'Signup | Verification', $message, $link);

                                return array('code' => '1', 'message' => 'account created');
                            }
                        }
                    } else {
                        return array('message' => 'no such referal');
                    }

                }
            }
        } else {
            return ['message' => 'please cross-check your email'];
        }
    }

    public function getAllBank()
    {
        $this::selectQuery("banks", '*', "");
        $f = $this::fetchQuery();
        return ['message' => $f];
    }

    public function deleteBank($x)
    {

        $this::selectQuery('banks', "account", "where account = '$x'");
        if ($this::checkrow() == 1) {
            $del = $this::delete('banks', "where account = '$x'");
            if ($del) {
                return ['message' => 'Bank deleted'];
            }
        } else {
            return ['messge' => 'Error'];
        }
    }

    public function adBitcoin($input)
    {
        $bitcoin = $input['bitcoin'];
        $this::selectQuery('bit_address', 'sn', "where address = '$bitcoin'");
        $f = $this::fetchQuery();
        $fsn = $f[0]['sn'];

        $this::update('bit_address', "address='$bitcoin'", "where sn = '1'");

        return ['code' => 1];

    }
    public function getBitcoin()
    {
        $this::selectQuery('bit_address', '*', "");
        $f = $this::fetchQuery();
        return ['message' => $f];

    }

    public function getRef($token)
    {
        $sum = 0;

        $decoded = $this::getid($token);

        // get username
        $this::selectQuery('users', 'username,profileId', "where email = '$decoded'");
        $user = $this::fetchQuery();
        $user = $user[0]['profileId'];

        // get last referral id
        $this::lastDsc('refferal', 'child_id', "where parent_id ='$decoded'", 'sn', 1);
        $f = $this::fetchquery();

        if ($this::checkrow() > 0) {

            $child_id = $f[0]['child_id'];
            $this::selectQuery('users', 'username,country,date_created,profileId', "where email ='$child_id'");
            $referal_id = $this::fetchQuery();

        } else {
            $referal_id = [];
        }

        // get total ref
        $this::countQuery('refferal', "where parent_id = '$decoded'");
        $fet = $this::fetchQuery();
        $refNum = $fet[0]['COUNT(*)'];

        //get total earning
        $this::selectQuery('refferal', 'earn', "where parent_id = '$decoded'");
        $r = $this::fetchQuery();
        if (!$r) {
            $sum = $sum;
        } else {
            foreach ($r as $r) {
                $sum = $sum + array_sum($r);
            }
        }

        return array('code' => '1', 'refid' => $referal_id, 'refNum' => $refNum, 'refSum' => $sum, 'username' => $user);

    }
    // USER LOGIN
    public function Login($input)
    {
        $eliminate = $this::clean($input);
        $accountn = $eliminate[0];
        $pass = $eliminate[1];
        $password = $input['password'];
        $time = date('h:i:s');

        $where = "where accountN='$accountn' or email = '$accountn'";
        $this::selectQuery('users', 'accountN,password,type,email', $where);
        if ($this::checkrow() == 1) {
            $fetch = $this::fetchQuery();
            if ($fetch[0]['accountN'] == $accountn && password_verify($password, $fetch[0]['password']) == true && $fetch[0]['type'] == 'member') {
                $issuer = "http://localhost:4200";
                $audience = "http://localhost:/dash";
                $user_id = $accountn;
                $token = $this->enc($issuer, $audience, $user_id);

                $email = $fetch[0]['email'];
                //$id = $this::random_alphanumeric(10);
                //$this::update('users', "last_login = '$time', login_token = '$id'", $where);

                //mail::loginmail('stcbnk@stcbnk.com', $email, 'Attemted login', $id, $link = "", $tag = "");

                return array('code' => 1, 'message' => 'Token generated');

            } else
            if (($fetch[0]['email'] == $accountn || $fetch[0]['accountN'] == $accountn) && password_verify($password, $fetch[0]['password']) == true && $fetch[0]['type'] == 'admin') {

                $issuer = "http://localhost:4200";
                $audience = "http://localhost:/admindash";
                $user_id = $fetch[0]['accountN'];
                $token = $this->enc($issuer, $audience, $user_id);
                return array('code' => 2, 'message' => 'Login succesful', 'token' => $token);
            } else {
                return array('code' => 3, 'message' => 'invalid user');
            };
        } else {
            return ['message' => 'email does not exist'];
        }
    }

    public function uploadImage($p, $f)
    {

        $path = "uploads/";
        $id = $p['id'];
        $uplaod = $this::PrepareUploadedFile($f['photo'], '15556693', $path, $id);

        if ($uplaod['code'] == 1) {
            $image_url = $uplaod['picture_url'];
            $imge = $uplaod['picture'];
            $this::selectQuery("users", 'image_url', "where accountN = '$id'");
            $fp = $this::fetchQuery();

            $fimage = $fp[0]['image_url'];
            if ($fimage != '') {
                unlink($path . $fimage);
                $up = $this::update("users", "image_url = '$image_url', image = '$imge'", "where accountN = '$id'");
                return ['code' => 1, 'pics' => $image_url];
            } else {
                $up = $this::update("users", "image_url = '$image_url', image = '$imge'", "where accountN = '$id'");
                return ['code' => 1, 'pics' => $image_url];
            }
        } else {
            return ['code' => 2, 'message' => $uplaod];
        }
    }

    public function verifyToken($x)
    {
        $clean = $this::neat($x);
        $token = $clean['token'];

        $this::selectQuery('users', 'accountN,password,type,email,login_token', "where login_token = '$token'");
      
        if ($this::checkrow() == 1) {
            $fetch = $this::fetchQuery();
            $issuer = "http://localhost:4200";
            $audience = "http://localhost:/dash";
            $user_id = $fetch[0]['accountN'];
            $token = $this->enc($issuer, $audience, $user_id);
            return array('code' => 2, 'message' => 'Login succesful', 'token' => $token);
        } else {
            return ['token not valid'];
        }
    }

//GET ALL USER INFORMATION
    public function getU($token)
    {
        $jwt = new JWT;
        $call = $jwt::decode($token, secret_key, array('HS256'));
        $decoded_array = (array) $call;

        $decoded = $decoded_array['id'];

        $this->selectQuery("users", "*", "WHERE accountN='$decoded'");
        if ($this->checkrow() == 1) {
            $boy = $this->fetchQuery();

            $this::lastDsc('transactions', '*', "where accountN='$decoded' and approved = '1'", 'date', 10);
            $t = $this::fetchQuery();

            return array("code" => "1", "message" => $boy, 'trans' => $t);
        }
    }

    public function getInvest($inv, $id)
    {
        $id = $this::getid($id);
        $this::selectQuery("deposits", "*", "where deposite_id ='$inv' and email = '$id'");
        $f = $this::fetchQuery();

        return ['code' => 1, 'messsage' => $f];
    }

    public function addAdmin($input)
    {

        $pass = $input['data']['password'];

        $neat = $this::neat($input['data']);
        $email = $neat['email'];

        $password = $neat['password'];
        $fname = $neat['fname'];
        $lname = $neat['lname'];
        $time = time();
        $rand = 204;
        $rand .= rand(10000000, 100000000);
        $date = date('Y-m-d');
        $e = $this::ValidateEmail($email);
      
        $this::selectQuery('users', 'email', "where email ='$e'");
        if ($this::checkrow() > 0) {
            return ['code' => 2, 'message' => 'email already exists'];
        } else {
            $insert = $this::insertQuery('users', 'email,fname,lname,accountN,password,type', "'$e','$fname','$lname','$rand','$password','member'");
            
                $id = $this::random_alphanumeric(10);
                $this::update('users', "login_token = '$id'", "where email ='$e'");
                
            if ($insert) {
                mail::SignupMail('stcbnk@stcbnk.com', $e, 'Signup', $pass, $rand , $id );

                return array('code' => '1', 'message' => 'account created');
            }
        }
    }

    public function addBank($input)
    {
        $neat = $this::neat($input);
        $bank = strtoupper($neat['bank']);
        $accountname = strtoupper($neat['accountname']);
        $branch = strtoupper($neat['branch']);
        $account = $neat['account'];
        $this::selectQuery('banks', 'Bank', "where Bank ='$bank'");
        if ($this::checkrow() > 0) {
            $up = $this::update('banks', "Bank = '$bank', Account='$account', branch= '$branch', Accountname= '$accountname'", "where Bank = '$bank'");
            if ($up) {
                return ['code' => 1, 'message' => 'Bank updated'];
            }
        } else {
            $up = $this::insertQuery('banks', "Bank,Account,branch,Accountname", "'$bank','$account','$branch','$accountname'");
            if ($up) {
                return ['code' => 1, 'message' => 'Bank Uploaded'];
            }
        }
    }

    public function proUser($id)
    {
        $ref = [];
        $this->selectQuery("users", "*", "where type = 'member' and accountN = '$id'");
        $u = $this::fetchQuery();

        $this::selectQueryDESC("transactions","*","where accountN ='$id'", 'date');
        $fD = $this::fetchQuery();

        return array('code' => '1', 'message' => $u, 'dep' => $fD);
    }

    public function addCryp($request)
    {
        $address = $request['address'];
        $type = $request['type'];

        $this::update("bit_address", "address='$address'", "where tic ='$type'");

        return ['message' => 'updated'];
    }

// PROCESS DEPOSIT //

    public function checkUserDeposit($token)
    {
        $decoded = $this::getid($token);
        $this::selectQuery('deposits', 'status', "where email = '$decoded' and status='1'");
        if ($this::checkrow() < 1) {
            return true;
        } else {
            return false;
        }
    }

    public function checkUserDepositBank($token)
    {
        $decoded = $this::getid($token);
        $this::selectQuery('deposits', 'status', "where email = '$decoded' and status='0' and pay_mode = 'bank'");
        if ($this::checkrow() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function Lock()
    {

    }

    public function checkUserDepositCoin($token)
    {
        $decoded = $this::getid($token);
        $this::selectQuery('deposits', 'status', "where email ='$decoded' and (pay_mode = 'BTC' or pay_mode = 'ETH') and status = '0'");
        if ($this::checkrow() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function proccess($input, $token)
    {

        $decoded = $this::getid($token);
        $username = $input['username'];
        $email = $decoded;
        $plan = $input['plan'];
        $amount = $input['amount'];
        $expected_roi = $input['profit'];
        $per_incr = $input['percent'];
        $duration = $input['duration'];
        $picture = $input['picture'];
        $time = time();
        $rand = rand(1000, 10000);
        $date = date("Y-m-d");
        $month = date('m');
        $deposite_id = $time . $rand;

        $this::selectQuery('users', 'mainaccountbal', "where email ='$decoded'");
        $a = $this::fetchQuery();
        $accot = $a[0]['mainaccountbal'];

        if ($amount < $accot) {
            $finalbal = $accot - $amount;
            //   print_r($finalbal);exit;
            $this::update("users", "mainaccountbal='$finalbal'", "where email ='$decoded'");

            $in = $this::insertQuery('deposits', 'username,email,plan,amount,expected_roi,per_incr,duration,picture_url,deposite_time,deposite_id,depositDate,status', "'$username','$email','$plan','$amount','$expected_roi','$per_incr','$duration','$picture','$time','$deposite_id','$date','1'");

            if ($in) {

                $mon = "WHERE month='$month'";
                $this->selectQuery('depgraph', "deposits", $mon);
                $added = $this::fetchQuery();
                $mn = $added[0];
                $jf = $mn['deposits'] + $amount;
                $this::update("depgraph", "deposits='$jf'", $mon);

                return array('code' => '1');

            }
        } else {
            return array('code' => '2');
        }
    }

    public function checkinv($token)
    {
        $decoded = $this::getid($token);
        $this::selectQueryL('deposits', 'expected_roi,status', "where email ='$decoded' and status = '2' and cashout = '1'", 'amount', 1);
        if ($this::checkrow() < 1) {
            return 4;
        } else {
            $b = $this::fetchQuery();
            $next_inv = $b[0]['expected_roi'];
            $sub = $next_inv * 0.15;
            $status = $b[0]['status'];
            $val = 10 * round(($next_inv - $sub) / 10);
            return ['next_inv' => $val, 'status' => $status];
        }
    }

    public function process($input, $token)
    {
        $decoded = $this::getid($token);
        $username = $input['username'];
        $email = $decoded;
        $plan = $input['plan'];
        $amount = $input['amount'];
        $expected_roi = $input['profit'];
        $per_incr = $input['percent'];
        $time = time();
        $rand = rand(1000, 10000);
        $date = date("Y-m-d");
        $month = date('m');
        $deposite_id = $time . $rand;

        $this::selectQuery('users', 'mainaccountbal', "where email ='$decoded'");
        $a = $this::fetchQuery();
        $accot = $a[0]['mainaccountbal'];
        if ($this::checkinv($token) == 4) {
            if ($amount < $accot) {
                $isactive = true; //$this::checkUserDeposit($token);
                if ($isactive == true) {
                    $finalbal = $accot - $amount;
                    $this::update("users", "mainaccountbal='$finalbal'", "where email ='$decoded'");

                    $in = $this::insertQuery('deposits', 'username,email,plan,amount,expected_roi,per_incr,deposite_time,deposite_id,depositDate,status', "'$username','$email','$plan','$amount','$expected_roi','$per_incr','$time','$deposite_id','$date','1'");
                    if ($this::addReferalamount($email, $amount) == true) {
                        return array('code' => '1');
                    } else {
                        return array('code' => '1');
                    }
                } else {
                    return array('code' => '3');
                }
            } else {
                return array('code' => '2');
            }
        } else {
            $next_in = $this::checkinv($token);
            $next_inv = $next_in['next_inv'];
            $status = $next_in['status'];

            if ($status == '0') {
                if ($amount < $accot) {
                    $isactive = true; //$this::checkUserDeposit($token);
                    if ($isactive == true) {
                        print(5);exit;
                        $finalbal = $accot - $amount;
                        $this::update("users", "mainaccountbal='$finalbal'", "where email ='$decoded'");

                        $in = $this::insertQuery('deposits', 'username,email,plan,amount,expected_roi,deposite_time,deposite_id,depositDate', "'$username','$email','$plan','$amount','$expected_roi','$time','$deposite_id','$date'");
                        $up = $this::update("check_inv", "inv_amount='$amount', next_inv = '$expected_roi', status = '1'", "where email ='$decoded'");
                    } else {
                        return array('code' => '3');
                    }
                    if ($in && $up) {

                        $mon = "WHERE month='$month'";
                        $this->selectQuery('depgraph', "deposits", $mon);
                        $added = $this::fetchQuery();
                        $mn = $added[0];
                        $jf = $mn['deposits'] + $amount;
                        $this::update("depgraph", "deposits='$jf'", $mon);

                        return array('code' => '1');

                    }
                } else {
                    return array('code' => '2');
                }
            } else {
                if ($amount >= $next_inv) {
                    if ($amount < $accot) {
                        $isactive = true; // $this::checkUserDeposit($token);
                        if ($isactive == true) {

                            $finalbal = $accot - $amount;
                            $this::update("users", "mainaccountbal='$finalbal'", "where email ='$decoded'");

                            $in = $this::insertQuery('deposits', 'username,email,plan,amount,expected_roi,deposite_time,deposite_id,depositDate', "'$username','$email','$plan','$amount','$expected_roi','$time','$deposite_id','$date'");

                            $up = $this::update("check_inv", "inv_amount='$amount', next_inv = '$expected_roi', status = '1'", "where email ='$decoded'");
                        } else {
                            return array('code' => '3');
                        }
                        if ($in && $up) {

                            $mon = "WHERE month='$month'";
                            $this->selectQuery('depgraph', "deposits", $mon);
                            $added = $this::fetchQuery();
                            $mn = $added[0];
                            $jf = $mn['deposits'] + $amount;
                            $this::update("depgraph", "deposits='$jf'", $mon);

                            return array('code' => '1');

                        }
                    } else {
                        return array('code' => '2');
                    }
                } else {
                    return ['message' => "You can't invest any amount less than " . $next_inv . "!"];
                }

            }

        }

    }

    public function processBitcoin($input, $token)
    {
        $user_id = $this::getid($token);
        $username = $input['username'];
        $plan = $input['plan'];
        $amount = $input['amount'];
        $per_incr = $input['per_incr'];
        $expected_roi = $input['profit'];
        $bitcoin = $input['pay_method'];
        $time = time();
        $this::selectQuery('users', 'profileId,mainaccountbal', "where email ='$user_id'");
        $fpro = $this::fetchQuery();
        $proId = $fpro[0]['profileId'];
        $rand = rand(1000, 10000);
        $date = date("Y-m-d");
        $month = date('m');
        $deposite_id = $time . $rand;
        $accot = $fpro[0]['mainaccountbal'];

        $isDepo = $this::checkUserDepositCoin($token);

        $this::selectQuery('bit_address', 'address,tic', "where tic = '$bitcoin'");
        $fbit = $this::fetchQuery();
        $address = $fbit[0]['address'];
        $tic = $fbit[0]['tic'];

        if ($this::checkinv($token) == 4) {
            if ($isDepo == false) {
                $in = $this::insertQuery('deposits', 'email,username,profileid,plan,pay_mode,amount,per_incr,expected_roi,deposite_time,deposite_id,month,depositDate,status', "'$user_id','$username','$proId','$plan','$bitcoin','$amount','$per_incr','$expected_roi','$time','$deposite_id','$month','$date','0'");
                return array(
                    'code' => 1,
                    'amount_btc' => $amount,
                    'address' => $address,
                    'tic' => $tic,
                );
            } else {
                $date = date("Y-m-d");
                $month = date('m');

                $this::update('deposits', "plan='$plan', amount ='$amount',profileid = '$proId'  ,pay_mode= '$bitcoin',per_incr ='$per_incr' ,expected_roi='$expected_roi', deposite_time='$time', month = '$month',deposite_id='$deposite_id',depositDate= '$date',status='0'", "where email = '$user_id'  and status = '0'");
                return array(
                    'code' => 1,
                    'amount_btc' => $amount,
                    'address' => $address,
                    'tic' => $tic,
                );
            }
        } else {
            $next_in = $this::checkinv($token);
            $next_inv = $next_in['next_inv'];
            $status = $next_in['status'];

            if ($amount >= $next_inv) {
                if ($isDepo == false) {
                    print_r('reesre');exit;
                    $in = $this::insertQuery('deposits', 'email,username,profileid,plan,pay_mode,amount,per_incr,expected_roi,deposite_time,deposite_id,month,depositDate,status', "'$user_id','$username','$proId','$plan','$bitcoin','$amount','$per_incr','$expected_roi','$time','$deposite_id','$month','$date','0'");
                    return array(
                        'code' => 1,
                        'amount_btc' => $amount,
                        'address' => $address,
                        'tic' => $tic,
                    );
                } else {

                    $date = date("Y-m-d");
                    $month = date('m');

                    $this::update('deposits', "plan='$plan', amount ='$amount',profileid = '$proId' , pay_mode= '$bitcoin', per_incr ='$per_incr' ,expected_roi='$expected_roi', deposite_time='$time', month = '$month',deposite_id='$deposite_id',depositDate= '$date',status='0'", "where email = '$user_id' and status = '0'");
                    return array(
                        'code' => 1,
                        'amount_btc' => $amount,
                        'address' => $address,
                        'tic' => $tic,
                    );
                }
            } else {
                return ['message' => "You can't invest any amount less than " . $next_inv . "!"];
            }

        }

    }

    public function processBank($input, $token)
    {
        $decoded = $this::getid($token);
        $username = $input['username'];
        $email = $decoded;
        $time = time();
        $plan = $input['plan'];
        $amount = $input['amount'];
        $expected_roi = $input['profit'];
        $pay_mode = $input['pay_mode'];
        $per_incr = $input['per_incr'];
        $rand = rand(1000, 10000);
        $date = date("Y-m-d");
        $month = date('m');
        $this::selectQuery('users', 'profileId', "where email ='$decoded'");
        $fpro = $this::fetchQuery();
        $proId = $fpro[0]['profileId'];

        if ($this::checkinv($token) == 4) {
            if ($this::checkUserDepositBank($token) == false) {
                $in = $this::insertQuery('deposits', 'username,email,profileId,plan,pay_mode,amount,expected_roi,per_incr,deposite_time,month,deposite_id,depositDate,status', "'$username','$email','$proId','$plan','$pay_mode','$amount','$expected_roi','$per_incr','$time','$month','$rand','$date','0'");
            } else {
                $in = $this::update('deposits', "plan = '$plan', amount = '$amount', expected_roi ='$expected_roi', per_incr ='$per_incr',deposite_time = '$time', month='$month', deposite_id = '$rand', depositDate='$date'", "where email = '$decoded' and pay_mode = 'bank'");
            }
            if ($in) {
                $mon = "WHERE month='$month'";
                $this->selectQuery('depgraph', "deposits", $mon);
                $added = $this::fetchQuery();
                $mn = $added[0];
                $jf = $mn['deposits'] + $amount;
                $this::update("depgraph", "deposits='$jf'", $mon);

                $this::selectQuery("banks", '*', '');
                $f = $this::fetchQuery();

                return array('code' => '1', 'banks' => $f, 'amount' => $amount, 'payment' => $rand);
            };
        } else {
            $next_in = $this::checkinv($token);
            $next_inv = $next_in['next_inv'];
            $status = $next_in['status'];
            if ($amount >= $next_inv) {
                if ($this::checkUserDepositBank($token) == false) {
                    $in = $this::insertQuery('deposits', 'username,email,profileId,plan,pay_mode,amount,expected_roi,per_incr,deposite_time,month,deposite_id,depositDate,status', "'$username','$email','$proId','$plan','$pay_mode','$amount','$expected_roi','$per_incr','$time','$month','$rand','$date','0'");
                } else {
                    $in = $this::update('deposits', "plan = '$plan', amount = '$amount', expected_roi ='$expected_roi', per_incr ='$per_incr',deposite_time = '$time', month='$month', deposite_id = '$rand', depositDate='$date'", "where email = '$decoded' and pay_mode = 'bank'");
                }
                if ($in) {
                    $mon = "WHERE month='$month'";
                    $this->selectQuery('depgraph', "deposits", $mon);
                    $added = $this::fetchQuery();
                    $mn = $added[0];
                    $jf = $mn['deposits'] + $amount;
                    $this::update("depgraph", "deposits='$jf'", $mon);

                    $this::selectQuery("banks", '*', '');
                    $f = $this::fetchQuery();

                    return array('code' => '1', 'banks' => $f, 'amount' => $amount, 'payment' => $rand);
                };
            } else {
                return ['message' => "You can't invest any amount less than " . $next_inv . "!"];
            }
        }

    }

    public function getreferral($email)
    {
        $this::selectQuery('refferal', 'parent_id', "where child_id = '$email'");
        if ($this::checkrow() > 0) {
            $f = $this::fetchQuery();
            return $f[0]['parent_id'];
        } else {
            return false;
        }
    }

    public function getAinvest()
    {
        $this::selectQueryDESC('available_stock', "*", 'where category ="1"', 'price');
        $f = $this::fetchQuery();

        return ['message' => $f];
    }

    public function getCrypInvest()
    {
        $this::selectQueryDESC('available_stock', "*", 'where category ="2"', 'price');
        $f = $this::fetchQuery();

        return ['message' => $f];
    }

    public function getAfixed($request)
    {
        $this::selectQuery('available_stock', "*", "where id ='2'");
        $f = $this::fetchQuery();

        return ['message' => $f];
    }

    public function getdetailId($x)
    {
        $neat = $this::neat($x);
        $det = $neat['detail'];

        $this::selectQuery('available_stock', "*", "where inv_id = '$det'");
        $f = $this::fetchQuery();

        return ['message' => $f];
    }

// FIXME:
    public function addReferalamount($email, $amount)
    {

        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            $linkk = "https";
        } else {
            $linkk = "http";
        }

        $linkk .= "://";

        $linkk .= $_SERVER['HTTP_HOST'];

        $this::selectQuery('users', 'username', "where email='$email'");
        $fnm = $this::fetchQuery();
        $childUser = $fnm[0]['username'];
        $this::selectQuery('refferal', 'parent_id,child_id', "where child_id='$email'");
        if ($this::checkrow() == 1) {
            $refF = $this::fetchQuery();

            $parent_id = $refF[0]['parent_id'];
            $refam = $amount * 0.05;

            $this::selectQuery('users', 'username,mainaccountbal,earning', "where email ='$parent_id'");
            if ($this::checkrow() == 1) {
                $nf = $this::fetchQuery();
                $main = $nf[0]['mainaccountbal'];
                $earn = $nf[0]['earning'];
                $username = $nf[0]['username'];
                $earning = $earn + $refam;
                $mainaccount = $main + $refam;
                $inserted = $this::update('users', "mainaccountbal='$mainaccount',earning='$earning'", "where email = '$parent_id'");

                $this::selectQuery('refferal', 'parent_id,child_id,earn', "where parent_id='$parent_id' and child_id = '$email'");
                if ($this::checkrow() == 1) {
                    $f = $this::fetchQuery();
                    $earn = $f[0]['earn'] + $refam;

                    $this::update('refferal', "earn='$earn'", "where parent_id ='$parent_id' and child_id = '$email'");

                    $message = "Dear $username.<br>You have recieved a referral commission of $refam dollars from $childUser.<br>Thank you.<br> <br>upstash team<br> $linkk";

                    $me = mail::allMail('admin@upstash.co', $parent_id, 'Referral bonus', $message, $linkk, 'referal earn');

                    return true;
                }

            }
        }

        return true;
    }

    // ALL EARNING
    public function earnIn($token)
    {
        $jwt = new JWT;
        $call = $jwt::decode($token, secret_key, array('HS256'));
        $decoded_array = (array) $call;
        $decoded = $decoded_array['id'];

        $this::selectQuery('deposits', 'plan,amount,deposite_time,deposite_id,address,pay_mode,updated,status', "WHERE email='$decoded' AND status='1'");

        $f = $this::fetchQuery();

        $plan = $f[0]['plan'];

        $updated = $f[0]['updated'];
        $amount = $f[0]['amount'];
        $deposite_time = $f[0]['deposite_time'];
        $status = $f[0]['status'];
        $td = time();
        $address = $f[0]['address'];
        $deposite_id = $f[0]['deposite_id'];
        $pay_mode = $f[0]['pay_mode'];
        $final_time = 86400 * 28;

        $famount;
        $diffrence = $td - $deposite_time;
        if ($status == 1) {

            if ($plan == 1) {
                $famount = $amount * 1.8260;
                if ($diffrence >= $final_time) {
                    $diffrence = $final_time;

                    $current = ($diffrence * $famount) / ($final_time);
                    $am = round($current, 2);

                    $this::selectQuery('users', 'mainaccountbal,earning,currentearn', "where email ='$decoded'");
                    $accF = $this::fetchQuery();
                    $cash = $accF[0]['mainaccountbal'];
                    $cashE = $accF[0]['earning'] + $am;
                    $curearn = $accF[0]['currentearn'];

                    $diffrenceEarn = round($am - $curearn, 2);

                    $cash = round($cash + $diffrenceEarn, 2);

                    $this::update('users', "mainaccountbal = '$cash',earning = '$cashE',currentearn =  '0'", "where email = '$decoded'");
                    $am = 0;
                    if ($pay_mode == 'bitcoin') {
                        $in = $this::update('deposits', "status = '2'", "WHERE email='$decoded' and address = '$address'");
                    } else {
                        $in = $this::update('deposits', "status = '2'", "WHERE email='$decoded' and address = '$deposite_id'");
                    }
                    $pro = (($am / $famount) * 100);
                    return array('code' => 1, 'message' => number_format($am), 'per' => $pro);
                } else {
                    $diffrence = $diffrence;

                    $current = ($diffrence * $famount) / ($final_time);
                    $am = round($current, 2);
                    $cashPerSec = round(($famount / 86400), 5);
                    $this::selectQuery('users', 'mainaccountbal,earning,currentearn', "where email ='$decoded'");
                    $fct = $this::fetchQuery();
                    $main = $fct[0]['mainaccountbal'];
                    $earncurr = $fct[0]['currentearn'];
                    $diffrenceEarn = round($am - $earncurr, 2);
                    $main = round($main + $diffrenceEarn, 2);
                    $tendays = 86400 * 10;

                    if ($updated == '0' || null) {
                        if ($diffrence >= $tendays) {
                            $this::update('users', "mainaccountbal = '$main', currentearn = '$am'", "where email = '$decoded'");

                            $this::update('deposits', "updated ='1'", "where email = '$decoded' AND status ='1'");

                            $pro = (($am / $famount) * 100);
                            return array('code' => 1, 'message' => [number_format($am), number_format($cashPerSec)], 'per' => $pro);
                        } else {
                            $this::update('users', "currentearn = '$am'", "where email = '$decoded'");

                            $pro = (($am / $famount) * 100);
                            return array('code' => 1, 'message' => [number_format($am), number_format($cashPerSec)], 'per' => $pro);
                        }
                    } else {
                        $this::update('users', "mainaccountbal = '$main', currentearn = '$am'", "where email = '$decoded'");

                        $pro = (($am / $famount) * 100);
                        return array('code' => 1, 'message' => [number_format($am), number_format($cashPerSec)], 'per' => $pro);
                    }

                    $pro = (($am / $famount) * 100);

                    return array('code' => 1, 'message' => [number_format($am), number_format($cashPerSec)], 'per' => $pro);
                }
                return array('code' => '1', 'message' => number_format($am));
            }

            if ($plan == 2) {
                $famount = $amount * 2.106;
                if ($diffrence >= $final_time) {
                    $diffrence = $final_time;

                    $current = ($diffrence * $famount) / ($final_time);
                    $am = round($current, 2);

                    $this::selectQuery('users', 'mainaccountbal,earning,currentearn', "where email ='$decoded'");
                    $accF = $this::fetchQuery();
                    $cash = $accF[0]['mainaccountbal'];
                    $cashE = $accF[0]['earning'] + $am;
                    $curearn = $accF[0]['currentearn'];

                    $diffrenceEarn = round($am - $curearn, 2);

                    $cash = round($cash + $diffrenceEarn, 2);

                    $this::update('users', "mainaccountbal = '$cash',earning = '$cashE',currentearn =  '0'", "where email = '$decoded'");
                    $am = 0;
                    if ($pay_mode == 'bitcoin') {
                        $in = $this::update('deposits', "status = '2'", "WHERE email='$decoded' and address = '$address'");
                    } else {
                        $in = $this::update('deposits', "status = '2'", "WHERE email='$decoded' and address = '$deposite_id'");
                    }
                    $pro = (($am / $famount) * 100);
                    return array('code' => 1, 'message' => number_format($am), 'per' => $pro);

                } else {
                    $diffrence = $diffrence;

                    $current = ($diffrence * $famount) / ($final_time);
                    $am = round($current, 2);
                    $cashPerSec = round(($famount / 86400), 5);
                    $this::selectQuery('users', 'mainaccountbal,earning,currentearn', "where email ='$decoded'");
                    $fct = $this::fetchQuery();
                    $main = $fct[0]['mainaccountbal'];
                    $earncurr = $fct[0]['currentearn'];
                    $diffrenceEarn = round($am - $earncurr, 2);
                    $main = round($main + $diffrenceEarn, 2);
                    $tendays = 86400 * 10;

                    if ($updated == '0' || null) {
                        if ($diffrence >= $tendays) {
                            $this::update('users', "mainaccountbal = '$main', currentearn = '$am'", "where email = '$decoded'");

                            $this::update('deposits', "updated ='1'", "where email = '$decoded' AND status ='1'");

                            $pro = (($am / $famount) * 100);
                            return array('code' => 1, 'message' => [number_format($am), number_format($cashPerSec)], 'per' => $pro);
                        } else {
                            $this::update('users', "currentearn = '$am'", "where email = '$decoded'");

                            $this::update('users', "mainaccountbal = '$main', currentearn = '$am'", "where email = '$decoded'");

                            $pro = (($am / $famount) * 100);
                            return array('code' => 1, 'message' => [number_format($am), number_format($cashPerSec)], 'per' => $pro);
                        }
                    } else {
                        $this::update('users', "mainaccountbal = '$main', currentearn = '$am'", "where email = '$decoded'");

                        $pro = (($am / $famount) * 100);
                        return array('code' => 1, 'message' => [number_format($am), number_format($cashPerSec)], 'per' => $pro);
                    }

                    $pro = (($am / $famount) * 100);
                    return array('code' => 1, 'message' => [number_format($am), number_format($cashPerSec)], 'per' => $pro);

                }

                return array('code' => '1', 'message' => number_format($am));
            }

            if ($plan == 3) {
                $famount = $amount * 2.946;

                if ($diffrence >= $final_time) {
                    $diffrence = $final_time;

                    $current = ($diffrence * $famount) / ($final_time);
                    $am = round($current, 2);

                    $this::selectQuery('users', 'mainaccountbal,earning,currentearn', "where email ='$decoded'");
                    $accF = $this::fetchQuery();
                    $cash = $accF[0]['mainaccountbal'];
                    $cashE = $accF[0]['earning'] + $am;
                    $curearn = $accF[0]['currentearn'];

                    $diffrenceEarn = round($am - $curearn, 2);

                    $cash = round($cash + $diffrenceEarn, 2);

                    $this::update('users', "mainaccountbal = '$cash',earning = '$cashE',currentearn =  '0'", "where email = '$decoded'");
                    $am = 0;
                    if ($pay_mode == 'bitcoin') {
                        $in = $this::update('deposits', "status = '2'", "WHERE email='$decoded' and address = '$address'");
                    } else {
                        $in = $this::update('deposits', "status = '2'", "WHERE email='$decoded' and address = '$deposite_id'");
                    }
                    $pro = (($am / $famount) * 100);
                    return array('code' => 1, 'message' => number_format($am), 'per' => $pro);
                } else {
                    $diffrence = $diffrence;

                    $current = ($diffrence * $famount) / ($final_time);
                    $am = round($current, 2);
                    $cashPerSec = round(($famount / 86400), 5);
                    $this::selectQuery('users', 'mainaccountbal,earning,currentearn', "where email ='$decoded'");
                    $fct = $this::fetchQuery();
                    $main = $fct[0]['mainaccountbal'];
                    $earncurr = $fct[0]['currentearn'];
                    $diffrenceEarn = round($am - $earncurr, 2);
                    $main = round($main + $diffrenceEarn, 2);
                    $tendays = 86400 * 10;

                    if ($updated == '0' || null) {
                        if ($diffrence >= $tendays) {
                            $this::update('users', "mainaccountbal = '$main', currentearn = '$am'", "where email = '$decoded'");

                            $this::update('deposits', "updated ='1'", "where email = '$decoded' AND status ='1'");

                            $pro = (($am / $famount) * 100);
                            return array('code' => 1, 'message' => [number_format($am), number_format($cashPerSec)], 'per' => $pro);
                        } else {
                            $this::update('users', "currentearn = '$am'", "where email = '$decoded'");

                            $pro = (($am / $famount) * 100);
                            return array('code' => 1, 'message' => [number_format($am), number_format($cashPerSec)], 'per' => $pro);
                        }
                    } else {
                        $this::update('users', "mainaccountbal = '$main', currentearn = '$am'", "where email = '$decoded'");

                        $pro = (($am / $famount) * 100);
                        return array('code' => 1, 'message' => [number_format($am), number_format($cashPerSec)], 'per' => $pro);
                    }

                    $pro = (($am / $famount) * 100);
                    return array('code' => 1, 'message' => [number_format($am), number_format($cashPerSec)], 'per' => $pro);
                }
                return array('code' => '1', 'message' => number_format($am));
            }
            /*  if($plan == 4)
        {
        $famount =  $amount * 2.4;
        if($diffrence >= $final_time)
        {
        $diffrence = $final_time;

        $current = ($diffrence * $famount) / ($final_time);
        $am =  round($current,2);

        $this::selectQuery('users','mainaccountbal,earning',"where email ='$decoded'");
        $accF = $this::fetchQuery();
        $cash = $accF[0]['mainaccountbal'] + $am;
        $cashE = $accF[0]['earning'] + $am;
        $this::update('users',"mainaccountbal = '$cash',earning = '$cashE'","where email = '$decoded'");
        $am = 0;
        $in = $this::update('deposits',"status = '2'","WHERE email='$decoded' and  address= '$address'");
        $pro = (($am/$famount)*100);
        return  array('code'=>1,'message'=>$am,'per'=>$pro);

        }else
        {
        $diffrence = $diffrence;

        $current = ($diffrence * $famount) / ($final_time);
        $am =  round($current,2);
        $cashPerSec = round(($famount/86400),5);
        // print_r($am);exit;
        $pro = (($am/$famount)*100);
        return  array('code'=>1,'message'=>[$am,$cashPerSec],'per'=>$pro);
        }
        return  array('code'=>'1','message'=>$am);
        }  */

        } else {
            return array('code' => '1', 'message' => 0);
        }

    }

    public function earn($token)
    {
        $jwt = new JWT;
        $call = $jwt::decode($token, secret_key, array('HS256'));
        $decoded_array = (array) $call;
        $decoded = $decoded_array['id'];

        $this::selectQuery('users', 'mainaccountbal,earning,currentearn', "where email ='$decoded'");
        $accF = $this::fetchQuery();
        $cash = $accF[0]['mainaccountbal'];

        $this::selectQuery('deposits', 'plan,amount,deposite_time,deposite_id,address,per_incr,pay_mode,status,per', "WHERE email='$decoded' AND status='1'");
        $f = $this::fetchQuery();
        /*   $final_time = 86400 * $duration;

        $your_date =  strtotime("+ $duration days", $deposite_time ) ;
        $datediff =   $your_date - $td;

        $datediff = round($datediff / (60 * 60 * 24)); */

        if ($this::checkrow() > 0) {
            foreach ($f as $f) {

                foreach ($f as $key => $value) {

                    $plan = $f['plan'];

                    $amount = $f['amount'];
                    $deposite_time = $f['deposite_time'];
                    $status = $f['status'];
                    $per_incr = $f['per_incr'];
                    $td = time();
                    $address = $f['address'];
                    $deposite_id = $f['deposite_id'];
                    $pay_mode = $f['pay_mode'];

                    $famount;
                    $diffrence = $td - $deposite_time;

                    if ($status == 1) {

                        if ($plan == 'STARTER') {

                            $final_time = 86400 * 2;
                            $famount = $amount * $per_incr;
                            if ($diffrence >= $final_time) {
                                $diffrence = $final_time;

                                $current = ($diffrence * $famount) / ($final_time);
                                $am = round($current, 2);

                                $pro = (($am / $famount) * 100);
                                $this::update('deposits', "current_amount = '$am',status ='2',cashout= '1', per='$pro'", "where deposite_id= '$deposite_id'");

                                $cas = $cash + $am;

                                $this::update('users', "mainaccountbal = '$cas'", "where email= '$decoded'");

                            } else {
                                $diffrence = $diffrence;

                                $current = ($diffrence * $famount) / ($final_time);
                                $am = round($current, 2);
                                $cashPerSec = round(($famount / 86400), 5);

                                $pro = (($am / $famount) * 100);

                                $this::update('deposits', "current_amount = '$am', per='$pro'", "where deposite_id= '$deposite_id'");

                            }
                        }
                        if ($plan == 'SILVER') {

                            $final_time = 86400 * 4;
                            $famount = $amount * $per_incr;
                            if ($diffrence >= $final_time) {
                                $diffrence = $final_time;

                                $current = ($diffrence * $famount) / ($final_time);
                                $am = round($current, 2);

                                $pro = (($am / $famount) * 100);
                                $this::update('deposits', "current_amount = '$am',status ='2',cashout= '1', per='$pro'", "where deposite_id= '$deposite_id'");

                                $cas = $cash + $am;
                                $this::update('users', "mainaccountbal = '$cas'", "where email= '$decoded'");

                            } else {
                                $diffrence = $diffrence;

                                $current = ($diffrence * $famount) / ($final_time);
                                $am = round($current, 2);
                                $cashPerSec = round(($famount / 86400), 5);

                                $pro = (($am / $famount) * 100);

                                $this::update('deposits', "current_amount = '$am', per='$pro'", "where deposite_id= '$deposite_id'");

                            }

                        }
                        if ($plan == 'DIAMOND') {

                            $final_time = 86400 * 6;
                            $famount = $amount * $per_incr;
                            if ($diffrence >= $final_time) {
                                $diffrence = $final_time;
                                $current = ($diffrence * $famount) / ($final_time);
                                $am = round($current, 2);
                                $pro = (($am / $famount) * 100);
                                $this::update('deposits', "current_amount = '$am',status ='2',cashout= '1', per='$pro'", "where deposite_id= '$deposite_id'");

                                $cas = $cash + $am;
                                $this::update('users', "mainaccountbal = '$cas'", "where email= '$decoded'");

                            } else {
                                $diffrence = $diffrence;
                                $current = ($diffrence * $famount) / ($final_time);
                                $am = round($current, 2);
                                $cashPerSec = round(($famount / 86400), 5);
                                $pro = (($am / $famount) * 100);
                                $this::update('deposits', "current_amount = '$am', per='$pro'", "where deposite_id= '$deposite_id'");

                            }

                            //  return array('code' => '1', 'message' => number_format($am));
                        }

                        if ($plan == 'GOLD') {

                            $final_time = 86400 * 8;
                            $famount = $amount * $per_incr;
                            if ($diffrence >= $final_time) {
                                $diffrence = $final_time;
                                $current = ($diffrence * $famount) / ($final_time);
                                $am = round($current, 2);
                                $pro = (($am / $famount) * 100);
                                $this::update('deposits', "current_amount = '$am',status ='2',cashout= '1', per='$pro'", "where deposite_id= '$deposite_id'");

                                $cas = $cash + $am;
                                $this::update('users', "mainaccountbal = '$cas'", "where email= '$decoded'");

                            } else {
                                $diffrence = $diffrence;
                                $current = ($diffrence * $famount) / ($final_time);
                                $am = round($current, 2);
                                $cashPerSec = round(($famount / 86400), 5);
                                $pro = (($am / $famount) * 100);
                                $this::update('deposits', "current_amount = '$am', per='$pro'", "where deposite_id= '$deposite_id'");

                            }

                            //  return array('code' => '1', 'message' => number_format($am));
                        }

                    }

                }

            }

        } else if ($this::checkrow() < 0) {
            $this::selectQuery('deposits', '*', "WHERE email='$decoded' and cashout ='0'");
            $fd = $this::fetchQuery();
            return ['code' => 1, 'message' => $fd];
        } else {
            return ['code' => 1, 'message' => $f];
        }

        $this::selectQuery('deposits', 'plan,amount,deposite_time,deposite_id,address,per_incr,pay_mode,status,per', "WHERE email='$decoded' AND status='1'");
        $f = $this::fetchQuery();

        return ['code' => 1, 'message' => $f];

    }

    public function upPerson($input)
    {
        $clean = $this::neat($input);
        $fullname = $clean['fullname'];
        $email = $clean['email'];
        $phone = $clean['phone'];
        $id = $clean['id'];
        $ud = $this::update('users', "fullname ='$fullname', email='$email', phone ='$phone'", "where profileId = '$id'");
        if ($ud) {
            return ['code' => 1, 'message' => 'updated'];
        }
    }

    public function upAccount($input)
    {
        $clean = $this::neat($input);
        $bitad = $clean['bitad'];
        $trust = $clean['trust'];
        $account = $clean['account'];
        $id = $clean['id'];
        $this::selectQuery('users', "mainaccountbal,trust_fund", "where profileId = '$id'");
        $f = $this::fetchQuery();

        $account = $f[0]['mainaccountbal'] + $account;
        $trust = $f[0]['trust_fund'] + $trust;

        $ud = $this::update('users', "bitcoinaddress ='$bitad', mainaccountbal ='$account', trust_fund = '$trust'", "where profileId = '$id'");
        if ($ud) {
            return ['code' => 1, 'message' => 'updated'];
        }
    }

    public function Cashout($id, $token)
    {
        $jwt = new JWT;
        $call = $jwt::decode($token, secret_key, array('HS256'));
        $decoded_array = (array) $call;
        $decoded = $decoded_array['id'];

        $this::selectQuery('deposits', 'current_amount', "WHERE email='$decoded' and deposite_id='$id'");
        $fd = $this::fetchQuery();
        $amount = $fd[0]['current_amount'];

        $this::selectQuery('users', 'mainaccountbal,earning', "where email ='$decoded'");
        $accF = $this::fetchQuery();
        $cash = $accF[0]['mainaccountbal'] + $amount;
        $cashE = $accF[0]['earning'] + $amount;

        $up = $this::update('users', "mainaccountbal = '$cash',earning = '$cashE'", "where email = '$decoded'");

        $ud = $this::update('deposits', "cashout = '1'", "where email = '$decoded' and deposite_id= '$id'");
        if ($up && $ud) {
            return ['code' => 1, 'message' => 'cashed'];
        }
    }

    public function nRange($price)
    {
        $price = round($price);
        $div = 0;
        $duration = 0;

        if (($price < 1)) {
            $div = 1.14;
            $duration = 2;
        }
        if (($price > 0) && ($price <= 250)) {
            $div = 1.3;
            $duration = 4;
        }
        if (($price >= 251) && ($price <= 500)) {
            $div = 1.4;
            $duration = 6;
        }
        if (($price >= 501) && ($price <= 750)) {
            $div = 1.45;
            $duration = 8;
        }
        if (($price >= 751) && ($price <= 1000)) {
            $div = 1.5;
            $duration = 10;
        }
        if (($price >= 1001) && ($price <= 2000)) {
            $div = 1.6;
            $duration = 12;
        }

        if (($price > 2001)) {
            $div = 1.63;
            $duration = 12;
        }
        return [$div, $duration];
    }

    public function inRange($x, $div)
    {
        $x = round($x);
        $startDiv = 1.1;
        if ($x > 1000) {
            $div = 2.19;
            if (('9000' <= $x) && ($x <= '10000')) {
                $div = round($div + (2 / 1.1), 3);
            }
            if (('8000' <= $x) && ($x <= '8999')) {
                $div = round($div + (2 / 1.2), 3);
            }
            if (('7000' <= $x) && ($x <= '7999')) {
                $div = round($div + (2 / 1.3), 3);
            }
            if (('6000' <= $x) && ($x <= '6999')) {
                $div = round($div + (2 / 1.4), 3);
            }
            if (('5000' <= $x) && ($x <= '5999')) {
                $div = round($div + (2 / 1.5), 3);
            }
            if (('4000' <= $x) && ($x <= '4999')) {
                $div = round($div + (2 / 1.6), 3);
            }
            if (('3000' <= $x) && ($x <= '3999')) {
                $div = round($div + (2 / 1.7), 3);
            }
            if (('2000' <= $x) && ($x <= '2999')) {
                $div = round($div + (2 / 1.8), 3);
            }
            if (('1000' <= $x) && ($x <= '1999')) {
                $div = round($div + (2 / 1.9), 3);
            }
            return $div;
        } else {
            $div = 2.19;
            if (('900' <= $x) && ($x <= '999')) {
                $div = round($div + (1 / 1.1), 3);
            } else
            if (('800' <= $x) && ($x <= '899')) {
                $div = round($div + (1 / 1.2), 3);
            } else
            if (('700' <= $x) && ($x <= '799')) {
                $div = round($div + (1 / 1.3), 3);
            } else
            if (('600' <= $x) && ($x <= '699')) {
                $div = round($div + (1 / 1.4), 3);
            } else
            if (('500' <= $x) && ($x <= '599')) {
                $div = round($div + (1 / 1.5), 3);
            } else
            if (('400' <= $x) && ($x <= '499')) {
                $div = round($div + (1 / 1.6), 3);
            } else
            if (('300' <= $x) && ($x <= '399')) {
                $div = round($div + (1 / 1.7), 3);
            } else
            if (('200' <= $x) && ($x <= '299')) {
                $div = round($div + (1 / 1.8), 3);
            } else
            if (('100' <= $x) && ($x <= '199')) {
                $div = round($div + (1 / 1.9), 3);
            } else
            if (('10' <= $x) && ($x <= '99')) {
                $div = round($div + (1 / 2), 3);
            }
            return $div;
        }

    }

    public function addStock($request)
    {
        foreach ($request as $request) {
            $ticker = $request->symbol;
            $companyName = $request->companyName;
            $price = round($request->price, 2);
            $changess = $this::nRange($price);
            $changes = $changess[0];
            $duration = $changess[1];
            $per_day = round((((($changes - 1) * 100) / 100) / $duration) * $price, 2);
            $sector = $request->sector;
            $industry = $request->industry;
            $exchange = $request->exchange;
            $description = $request->description;
            $website = $request->website;
            $image = $request->image;
            $id = $this::random_alphanumeric(10);
            $this::selectQuery('available_stock', 'Ticker', "where Ticker = '$ticker'");
            if ($this::checkrow() < 1) {
                $this::insertQuery('available_stock', 'companyName,category,icker,inv_id,price,duration,changes,per_day,sector,industry,exchange,discription,website,image', "'$companyName','1','$ticker','$id','$price','$duration','$changes','$per_day','$sector','$industry','$exchange','$description','$website','$image'");
            } else {
                $ud = $this::update('available_stock', "price='$price',duration = '$duration',changes ='$changes',per_day = '$per_day' ,category='1'", "where Ticker = '$ticker'");
            }
        }

        return ['message' => 'updated'];
    }

    public function refPer($request)
    {
        $this::selectQuery('available_stock', 'changes,price,duration,inv_id', '');
        $f = $this::fetchQuery();
        foreach ($f as $f) {

            $changes = $f['changes'];
            $duration = $f['duration'];
            $price = $f['price'];
            $id = $f['inv_id'];

            $per_day = round((((($changes - 1) * 100) / 100) / $duration) * $price, 2);

            $ud = $this::update('available_stock', "per_day = '$per_day'", "where inv_id = '$id'");
        }

        return ['message' => 'updated'];
    }

    public function addCoin($request)
    {
        foreach ($request as $request) {
            $ticker = $request->symbol;
            $companyName = $request->name;
            $price = round($request->price, 2);
            $changess = $this::nRange($price);
            $changes = $changess[0];
            $duration = $changess[1];
            $per_day = round((((($changes - 1) * 100) / 100) / $duration) * $price, 3);
            $image = $request->logo_url;
            $id = $this::random_alphanumeric(10);
            $this::selectQuery('available_stock', 'Ticker', "where Ticker = '$ticker'");
            if ($this::checkrow() < 1) {
                $this::insertQuery('available_stock', 'companyName,category,Ticker,inv_id,price,duration,changes,per_day,image', "'$companyName','2','$ticker','$id','$price','$duration','$changes','$per_day','$image'");
            } else {
                $ud = $this::update('available_stock', "price='$price',duration = '$duration',changes ='$changes',per_day = '$per_day' ,category='2'", "where Ticker = '$ticker'");
            }
        }
        return ['message' => 'updated'];
    }

    // WITHDRAW FUNCTION//
    public function withdraw($input, $token)
    {
        $jwt = new JWT;
        $call = $jwt::decode($token, secret_key, array('HS256'));
        $decoded_array = (array) $call;
        $decoded = $decoded_array['id'];
        $this::selectQuery('withdrawal', 'status', "where status = '0' and email = '$decoded'");
        if ($this::checkrow() > 0) {
            return ['code' => 2, 'message' => 'You have a pending withdrawal'];
        } else {
            $neat = $this::neat($input);
            //print_r($clean);exit;
            $withdrawamount = $neat['withdraw'];
            $withdrawto = $neat['withdrawto'];
            $withdrawfrom = $neat['withdrawfrom'];

            $td = date('Y-m-d');
            $time = time();
            $month = date('m');
            $withdrawtime = date('h:i:s');
            $rand = rand(1000, 10000);
            $withdrawid = $time . $rand;

            $mon = "WHERE month='$month'";

            $this::selectQuery('users', 'email,username,profileId,mainaccountbal,trust_fund,trust_access', "where email = '$decoded'");
            $f = $this::fetchQuery();
            $email = $f[0]['email'];
            $username = $f[0]['username'];
            $profileId = $f[0]['profileId'];
            $trust = $f[0]['trust_fund'];
            $trust_access = $f[0]['trust_access'];
            if ($withdrawfrom == 'wallet') {
                $accountbal = $f[0]['mainaccountbal'] - $withdrawamount;
                $up = $this::update('users', "mainaccountbal='$accountbal'", "where email = '$decoded'");

                $this->selectQuery('withgraph', "withdrawal", $mon);
                $added = $this::fetchQuery();
                $mn = $added[0];
                $jf = $mn['withdrawal'] + $withdrawamount;
                $this::update("withgraph", "withdrawal='$jf'", $mon);

                if ($up) {
                    $this::insertQuery('withdrawal', 'email,username,profileid,withdrawamount,withdrawId,withdrawtime,withdrawto,date,status', "'$email','$username','$profileId','$withdrawamount','$withdrawid','$withdrawtime','$withdrawto','$td','0'");
                    return array('code' => '1', 'message' => 'withdraw pending');
                }
            }
        }
    }

    public function getid($token)
    {
        $jwt = new JWT;
        $call = $jwt::decode($token, secret_key, array('HS256'));
        $decoded_array = (array) $call;
        $decoded = $decoded_array['id'];
        return $decoded;

    }

    // TOTAL WITHDRAWAL
    public function Totwith($token)
    {
        $tot = [];
        $decoded = $this::getid($token);
        $this::selectQuery('withdrawal', 'username,withdrawamount,date', "where email ='$decoded'");
        $fet = $this::fetchQuery();
        $this::selectQuery('withdrawal', 'withdrawamount', "where email ='$decoded'");
        $met = $this::fetchQuery();

        foreach ($met as $met) {
            array_push($tot, $met['withdrawamount']);
        }
        $sumtot = array_sum($tot);

        return array('code' => '1', 'message' => $fet, 'sum' => $sumtot);
    }

    // TOTAL DEPOSITES
    public function Totdep($token)
    {
        $tot = [];
        $decoded = $this::getid($token);

        $this::selectQuery('deposits', 'email,plan,username,amount,depositDate', "where email ='$decoded' and status > '0'");
        $fet = $this::fetchQuery();
        $this::selectQuery('deposits', 'amount', "where email ='$decoded' and status > '0'");
        $met = $this::fetchQuery();

        foreach ($met as $met) {
            array_push($tot, $met['amount']);
        }
        $sumtot = array_sum($tot);

        return array('code' => '1', 'message' => $fet, 'sum' => $sumtot);
    }

    // GET DEPOSITE LIST
    public function deplist($token)
    {
        $decoded = $this::getid($token);
        $this::selectQuery('deposits', '*', "where email ='$decoded' and status < '2'");
        $p1 = $this::fetchQuery();
        /* $this::selectQuery('deposits', 'email,username,plan,expected_roi,amount,depositDate', "where email ='$decoded' AND plan='2'");
        $p2 = $this::fetchQuery();
        $this::selectQuery('deposits', 'email,username,plan,expected_roi,amount,depositDate', "where email ='$decoded' AND plan='3'");
        $p3 = $this::fetchQuery();
        $this::selectQuery('deposits', 'email,username,plan,expected_roi,amount,depositDate', "where email ='$decoded' AND plan='4'");
        $p4 = $this::fetchQuery(); */

        return array('code' => '1', 'plan' => $p1);

    }

    public function deplistCom($token)
    {
        $decoded = $this::getid($token);
        $this::selectQuery('deposits', '*', "where email ='$decoded' and status > '1'");
        $p1 = $this::fetchQuery();
        /* $this::selectQuery('deposits', 'email,username,plan,expected_roi,amount,depositDate', "where email ='$decoded' AND plan='2'");
        $p2 = $this::fetchQuery();
        $this::selectQuery('deposits', 'email,username,plan,expected_roi,amount,depositDate', "where email ='$decoded' AND plan='3'");
        $p3 = $this::fetchQuery();
        $this::selectQuery('deposits', 'email,username,plan,expected_roi,amount,depositDate', "where email ='$decoded' AND plan='4'");
        $p4 = $this::fetchQuery(); */

        return array('code' => '1', 'plan' => $p1);

    }

    public function deplistNot($token)
    {
        $decoded = $this::getid($token);
        $this::selectQuery('deposits', '*', "where email ='$decoded' and status = '1'");
        $p1 = $this::fetchQuery();
        /* $this::selectQuery('deposits', 'email,username,plan,expected_roi,amount,depositDate', "where email ='$decoded' AND plan='2'");
        $p2 = $this::fetchQuery();
        $this::selectQuery('deposits', 'email,username,plan,expected_roi,amount,depositDate', "where email ='$decoded' AND plan='3'");
        $p3 = $this::fetchQuery();
        $this::selectQuery('deposits', 'email,username,plan,expected_roi,amount,depositDate', "where email ='$decoded' AND plan='4'");
        $p4 = $this::fetchQuery(); */

        return array('code' => '1', 'plan' => $p1);

    }

    public function DepC()
    {
        $this::selectQuery("deposits", '*', "where status < 1");
        $me = $this::fetchQuery();
        return array('code' => '1', 'deposits' => $me);
    }

    public function Cdep($id)
    {
        $this::selectQuery("deposits", 'email,deposite_id', "where deposite_id = '$id'");
        $dep = $this::fetchQuery();
        $depo = $dep[0]['deposite_id'];
        $this::selectQuery("activeP", 'deposite_id', "where deposite_id = '$depo'");
        $depp = $this::fetchQuery();
        $deppp = $depp[0]['deposite_id'];
        if ($depo === $deppp) {
            $this::update('deposits', "status='1'", "where deposite_id='$id'");
            $this::update('activeP', "status='1'", "where deposite_id='$id'");

        }
    }

    public function withC()
    {
        $this::selectQuery("withdrawal", 'email,username,profileid,withdrawamount,withdrawId,withdrawtime,date,status', "where status='0'");
        $me = $this::fetchQuery();
        return array('code' => '1', 'withdrawals' => $me);
    }

    public function Cwith($id)
    {
        $this::selectQuery("withdrawal", 'email', "where withdrawId = '$id'");
        $dep = $this::fetchQuery();
        $depo = $dep[0]['email'];
        $this::update('withdrawal', "status='1'", "where withdrawId = '$id' and email='$depo'");
    }

    // SEARCH FUNCTION//

    public function search($input, $token)
    {
        $decoded = $this::getid($token);
        $fdate = [];
        $tdate = [];
        $tot = [];
        $fdate[0] = $input['fyear'];
        $fdate[1] = $input['fmonth'];
        $fdate[2] = $input['fday'];

        $tdate[0] = $input['tyear'];
        $tdate[1] = $input['tmonth'];
        $tdate[2] = $input['tday'];

        $space = implode("-", $fdate);
        $spac = implode("-", $tdate);

        $this::between('email,plan,username,amount,depositDate', 'deposits', "where depositDate between '$space' AND '$spac' AND email='$decoded'");
        $dep = $this::fetchQuery();
        $this::between('amount', 'deposits', "where depositDate between '$space' AND '$spac' AND email='$decoded'");
        $met = $this::fetchQuery();

        foreach ($met as $met) {
            array_push($tot, $met['amount']);
        }
        $sumtot = array_sum($tot);

        return array('code' => '1', 'message' => $dep, 'sum' => $sumtot);

    }
    public function searchW($input, $token)
    {
        $decoded = $this::getid($token);
        $fdate = [];
        $tdate = [];
        $tot = [];
        $fdate[0] = $input['fyear'];
        $fdate[1] = $input['fmonth'];
        $fdate[2] = $input['fday'];

        $tdate[0] = $input['tyear'];
        $tdate[1] = $input['tmonth'];
        $tdate[2] = $input['tday'];

        $space = implode("-", $fdate);
        $spac = implode("-", $tdate);

        $this::between('username,withdrawamount,date', 'withdrawal', "where withdrawDate between '$space' AND '$spac' AND email='$decoded'");
        $dep = $this::fetchQuery();
        $this::between('withdrawamount', 'withdrawal', "where withdrawDate between '$space' AND '$spac' AND email='$decoded'");
        $met = $this::fetchQuery();

        foreach ($met as $met) {
            array_push($tot, $met['withdrawamount']);
        }
        $sumtot = array_sum($tot);

        return array('code' => '1', 'message' => $dep, 'sum' => $sumtot);

    }

    public function AinvestD()
    {

        $this::lastDsc('deposits', 'username,amount', 'where status = "1"', 'sn', 6);
        $d = $this::fetchQuery();
        $this::lastDsc('withdrawal', 'username,withdrawamount', 'where status = "1" ', 'sn', 6);
        $w = $this::fetchQuery();

        //get  total deposit
        $totdep = [];
        $this::selectQuery('deposits', 'amount', "where status > '0'");
        $dep = $this::fetchQuery();

        foreach ($dep as $dep) {
            array_push($totdep, $dep['amount']);
        }
        $totdep = array_sum($totdep);

        //withdrawal informations
        $tot = [];
        $this::selectQuery('withdrawal', 'withdrawamount', " ");
        $sum = $this::fetchQuery();
        foreach ($sum as $sum) {
            array_push($tot, $sum['withdrawamount']);
        }
        $a = array_sum($tot);

        $this::lastDsc('users', 'username', "where type='member'", 'sn', 1);
        $t = $this::fetchQuery();
        if ($t == true) {
            $lastwith = $t[0]['username'];
        } else {
            $lastwith = 'None';
        }

        return array('code' => 1, 'message' => [$d, $w], 'dep' => $totdep, 'with' => $a, 'user' => $lastwith);
    }

    public function proUp($token, $input)
    {
        $decoded = $this::getid($token);

        $neat = $this::clean($input);

        $bitcoinaddress = $neat[0];
        $city = $neat[1];
        $state = $neat[2];
        $country = $neat[3];
        $zip = $neat[4];
        $address = $neat[5];
        $currentpass = $neat[6];
        $password = $input['password'];
        $newpass = $this::hash_pword($neat[7]);
        $bank = $neat[8];
        $account = $neat[9];
        $this::selectQuery('users', 'password,city,state,country,bank,bitcoinaddress,address', "where email = '$decoded'");
        $f = $this::fetchQuery();
        $oldpass = $f[0]['password'];
        $oldcity = $f[0]['city'];
        $oldstate = $f[0]['state'];
        $oldcountry = $f[0]['country'];
        $oldbank = $f[0]['bank'];
        $oldzip = $f[0]['zip'];
        $oldaddress = $f[0]['address'];
        $oldbitcoinaddress = $f[0]['bitcoinaddress'];
        if ($neat[7] == '') {$newpass = $oldpass;} else { $newpass = $newpass;}
        if ($neat[8] == '') {$bank = $oldbank;} else { $bank = $bank;}
        if ($neat[1] == '') {$city = $oldcity;} else { $city = $city;}
        if ($neat[2] == '') {$state = $oldstate;} else { $state = $state;}
        if ($neat[3] == '') {$country = $oldcountry;} else { $country = $country;}
        if ($neat[5] == '') {$address = $oldaddress;} else { $address = $address;}
        if ($neat[0] == '') {$bitcoinaddress = $oldbitcoinaddress;} else { $bitcoinaddress = $bitcoinaddress;}

        if (password_verify($password, $oldpass)) {
            $update = $this::update('users', "bitcoinaddress = '$bitcoinaddress', city = '$city', state = '$state', country = '$country', address ='$address',bank ='$bank', accountnumber ='$account', password = '$newpass'", "where email='$decoded'");
            if ($update) {return array('code' => '1', 'message' => 'update complete');}
        } else {
            return array('code' => '2', 'message' => 'wrong pass');
        }

    }

    public function gtGraph()
    {
        $empty = [];
        $tot = [];
        $this->selectQuery('depgraph', 'deposits', '');
        $gb = $this::fetchQuery();
        foreach ($gb as $gb) {
            array_push($empty, $gb['deposits']);
        }

        $this->selectQuery('withgraph', 'withdrawal', '');
        $fb = $this::fetchQuery();
        foreach ($fb as $fb) {
            array_push($tot, $fb['withdrawal']);
        }
        return array('code' => 1, "message" => [$empty, $tot]);
    }

    public function gtUgraph($token)
    {
        $decoded = $this::getid($token);
        $empty = [];
        $tot = [];
        $this->selectQuery('deposits', 'amount', "where email='$decoded'");
        $gb = $this::fetchQuery();
        foreach ($gb as $gb) {
            array_push($empty, $gb['amount']);
        }
        /* $empty = array_sum($empty); */

        $this->selectQuery('withdrawal', 'withdrawamount', "where email = '$decoded'");
        $fb = $this::fetchQuery();
        foreach ($fb as $fb) {
            array_push($tot, $fb['withdrawamount']);
        }
        /*  $tot = array_sum($tot); */

        return array('code' => 1, "message" => [$empty, $tot]);
    }

    public function simDep($input)
    {
        $username = $input['username'];

        $amount = $input['amount'];
        $this::selectQuery('deposits', 'username', "where username = '$username'");
        if ($this::checkrow() < 1) {
            $this::insertQuery('deposits', 'username,amount,status', "'$username','$amount','3'");

            return 'inserted';
        } else {
            return 'username exits';
        }

    }

    public function simWith($input)
    {
        $username = $input['username'];

        $amount = $input['amount'];
        $this::selectQuery('withdrawal', 'username', "where username = '$username'");
        if ($this::checkrow() < 1) {
            $this::insertQuery('withdrawal', 'username,withdrawamount,status', "'$username','$amount','3'");

            return 'inserted';
        } else {
            return 'username exits';
        }

    }

    public function block($id)
    {
        $this::update('users', "status = '2'", "where profileId = '$id'");
        return ['message' => 'Blocked'];
    }
    public function unblock($id)
    {
        $this::update('users', "status = '1'", "where profileId = '$id'");
        return ['message' => 'Unblocked'];
    }

    public function subscribe($input)
    {
        $neat = $this::neat($input);
        $email = $neat['email'];
        $name = $neat['name'];
        $me = mail::subscribe($email, $name);
        $this::selectQuery('newslater', '*', "where email = '$email'");
        if ($this::checkrow() < 1) {
            $in = $this::insertQuery('newslater', 'email,name', "'$email','$name'");
            if ($in);
            return ['code' => 1];
        } else {
            return ['code' => 2];
        }

    }

    public function forgotPass($email)
    {
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            $linkk = "https";
        } else {
            $linkk = "http";
        }

// Here append the common URL characters.
        $linkk .= "://";

// Append the host(domain name, ip) to the URL.
        $linkk .= $_SERVER['HTTP_HOST'];

        if ($this::ValidateEmail($email)) {
            $this::selectQuery('users', "email", "where email = '$email'");
            if ($this::checkrow() == 1) {
                $f = $this::fetchQuery();
                $reg_email = $f[0]['email'];

                $token = openssl_random_pseudo_bytes(32);
                $token = bin2hex($token);

                $endTime = strtotime("+15 minutes");
                $insert = $this::replace("access_tokens", "email, token, date_expires", "'$reg_email','$token','$endTime'");
                if ($insert) {
                    $link = "{$linkk}/#/reset_pass?verify={$token}";
                    $message = "This email is in response to a forgotten password reset request at Upstash.co . If you did make this request,click the  link below to be able to access your account
       $link
      For security purposes, you have 15 minutes to do this. If you do not click this link within 15 minutes, you’ll need to request a password reset again.
      If you have not forgotten your password, you can safely ignore this message and you will still be able to login with your existing password.

      $id = $this::random_alphanumeric(10);
      ";

                    $me = mail::allMail('noreply@upstash.co', $reg_email, 'Reset Password Request', $message, $link);

                    if ($me = true) {return array('code' => 1);}
                }
            } else {
                return ['code' => 2];
            }
        }
    }

    public function tokenVerify($token)
    {
        $time = time();
        $this::selectQuery('access_tokens', "email", "where token = '$token' and date_expires > '$time'");
        if ($this::checkrow() === 1) {
            $f = $this::fetchQuery();
            $reg_id = $f[0]['email'];

            $issuer = "http://localhost:4200";
            $audience = "http://localhost:/dashboard";
            $user_id = [$f[0]['email']];

            $tok = $this->enc($issuer, $audience, $user_id);

            $this::delete("access_tokens", "where token = '$token'");
            return array('code' => 1, 'message' => $tok);
        } else {
            return array('code' => 2);
        }
    }

    public function changePass($password, $token)
    {
        $neat = $this::neat($password);
        $id_no = $this::getid($token);

        $reg_email = $id_no[0];
        $pass = $neat['password'];
        $update = $this::update("users", "password ='$pass'", "where email= '$reg_email'");
        if ($update) {
            return array('code' => 1);
        }
    }

    public function ConWith($email, $id)
    {

        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            $linkk = "https";
        } else {
            $linkk = "http";
        }

        $linkk .= "://";
        // Append the host(domain name, ip) to the URL.
        $linkk .= $_SERVER['HTTP_HOST'];

        $this::selectQuery('users', 'bitcoinaddress,username', "where email ='$email'");
        $fd = $this::fetchQuery();
        $userad = $fd[0]['bitcoinaddress'];
        $usern = $fd[0]['username'];
        $this::selectQuery('withdrawal', 'withdrawid,withdrawamount,withaddress', "where email = '$email' and status = '0' and withdrawId = '$id'");
        if ($this::checkrow() == 1) {
            $f = $this::fetchQuery();
            $withdrawid = $f[0]['withdrawid'];
            $amount = $f[0]['withdrawamount'];
            $address = $f[0]['withaddress'];
            $date = '20, july';
            $this::update('withdrawal', "status = '1'", "where withdrawid = '$withdrawid'");

            $mail = mail::withdrawmail('withdrawal@upstash.com', $email, 'Payment processed', $usern, $date, $amount, $address, $link = "", $tag = "");

            return ['message' => 'Withdrawal confirmed'];
        } else {
            return ['message' => 'No pending withdrawal'];
        }
    }

    public function ConDep($email, $id)
    {

        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            $linkk = "https";
        } else {
            $linkk = "http";
        }

        $linkk .= "://";
        // Append the host(domain name, ip) to the URL.
        $linkk .= $_SERVER['HTTP_HOST'];

        $today = time();
        $this::selectQuery('deposits', 'deposite_id,amount,email,username,plan', "where deposite_id ='$id' and status='0'");
        if ($this::checkrow() == 1) {
            $f = $this::fetchQuery();
            $deposite_id = $f[0]['deposite_id'];
            $amount = $f[0]['amount'];
            $e = $f[0]['email'];
            $username = $f[0]['username'];
            $scheme = $f[0]['plan'];

            $up = $this::update('deposits', "status ='1',deposite_time = '$today'", "where deposite_id ='$id'");
            if ($up) {
                $me = mail::depositmail('admin@wen.com', $e, 'Investment|confirmation', $username, $scheme, $amount, $link = "", $tag = "");

                if ($this::addReferalamount($email, $amount) == true) {
                    return ['message' => 'Deposit Confirmed'];
                } else {
                    return ['message' => 'Deposit Confirmed'];
                };
            }
        } else {
            return ['message' => 'No pending Deposits'];
        }
    }

    public function Mailconfirm($hash)
    {
        $this::selectQuery('users', '*', "where hash ='$hash'");
        if ($this::checkrow() == 1) {
            $this::update('users', "status = '1'", "where hash = '$hash'");
            return ['code' => 1, 'message' => 'mail confirmed'];
        } else {
            return ['code' => 2, 'message' => 'failed confirmation'];
        }
    }

    public function ContactUs($input)
    {
        $neat = $this::neat($input);
        $name = $neat['name'];
        $email = $neat['email'];
        $phone = $neat['phone'];
        $text = $neat['text'];

        $email_message = "Details below.\n\n";
        $email_message .= "First Name: " . $this::clean_string($name) . "\n";
        $email_message .= "Email: " . $this::clean_string($email) . "\n";
        $email_message .= "Telephone: " . $this::clean_string($phone) . "\n";
        $email_message .= "Comments: " . $this::clean_string($text) . "\n";

        $headers = 'From: ' . $email . "\r\n";

        // $headers = 'From: '.$email."\r\n".'Reply-To: '.$email."\r\n" .'X-Mailer: PHP/' . phpversion();

//mail('support@startradeonline.com', 'Contact me', $email_message, $headers);

        $me = mail::passmail($email, 'support@startradeonline.com', $headers, $email_message, '');
        if ($me === null) {
            return ['message' => 'Thank you for contacting us, we well get back to you as soon as possible'];
        }

    }

    public function Recharge($request)
    {
        $neat = $this::neat($request);

        $username = $neat['username'];
        $pay = $neat['pay'];
        $amount = $neat['amount'];

        $network = $neat['network'];
        $phone = $neat['number'];

        $ref = $this::random_alphanumeric(12);

        $this::selectQuery('users', 'naira_balance', "where username = '$username'");
        $f = $this::fetchQuery();
        $naira_balance = $f[0]['naira_balance'] - $pay;

        $recharge = Recharge::Airtime($network, $phone, $amount, $ref);

        if ($recharge->code == 100) {
            $this::update('users', "naira_balance = '$naira_balance'", "where username = '$username'");

            return ['code' => 1];
        }
    }

    public function Walletrx($request)
    {
        $neat = $this::neat($request);
        $wallet = $neat['wallet'];
        $famount = $neat['famount'];
        $amount = $neat['amount'];

        $id_no = $this::getid($neat['id']);
        $this::selectQuery('users', 'mainaccountbal,naira_balance', "where email = '$id_no'");
        $f = $this::fetchQuery();
        $naira_balance = $f[0]['naira_balance'];
        $dollar_balance = $f[0]['mainaccountbal'];

        if ($wallet == 1) {
            if ($amount <= $dollar_balance) {
                $naira_balance = $naira_balance + $famount;
                $dollar_balance = $dollar_balance - $amount;

                $this::update('users', "naira_balance = '$naira_balance', mainaccountbal = '$dollar_balance'", "where email = '$id_no'");

                return ['code' => 1];
            } else {
                return ['code' => 2];
            }
        }

        if ($wallet == 2) {
            if ($amount <= $naira_balance) {
                $naira_balance = $naira_balance - $amount;
                $dollar_balance = $dollar_balance + $famount;

                $this::update('users', "naira_balance = '$naira_balance', mainaccountbal = '$dollar_balance'", "where email = '$id_no'");

                return ['code' => 1];
            } else {
                return ['code' => 2];
            }
        }
    }

    public function Mamb($email)
    {
        $up = $this::update('users', "ambassador ='1'", "where email = '$email'");
        if ($up) {
            return ['message' => 'Promoted to ambassador'];
        }
    }

    public function Ramb($email)
    {
        $up = $this::update('users', "ambassador ='0'", "where email = '$email'");
        if ($up) {
            return ['message' => 'Demoted to user'];
        }
    }

    public function Taccess($email)
    {
        $up = $this::update('users', "trust_access ='1'", "where email = '$email'");
        if ($up) {
            return ['message' => 'Access Granted'];
        }
    }
}
