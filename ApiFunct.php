<?php
use Firebase\JWT\JWT;
use Mailgun\Mailgun;
require('mysqllab.php');
require('jwt/JWT.php');
require 'vendor/autoload.php';
 #endregion

define('secret_key','otuonynoye');

define('MAILGUN_KEY','284c135f4e519d546f64df153090b8d6-9b463597-571dfbf6');
define('MAILGUN_PUBKEY', 'pubkey-5171366a26a4546b3530ac13e442ac6f');

define('MAILGUN_DOMAIN', 'sandbox782b77014ac840b1b12f34e621802ae1.mailgun.org');


 #endregion
 #endregion



class coin extends HandleSql{

    public function __construct($host,$username,$password,$db_name)
    {
        parent::__construct($host,$username,$password,$db_name);
     }


     public function enc($issuer,$audience,$user_id)
     {
        $token = array(
            "iss" => $issuer,
            "aud" => $audience ,
            "id"=> $user_id,
            "iat" => time(),
            "nbf" => time()
        );
    
    
        $jwt=new JWT;
        //$jwt=JWT::encode($token, $key);
        $call=$jwt::encode($token,secret_key);
        return $call;
    
    }
  //   USER REGISTRATION
public function Register($input)
{
        $clean  = $this::clean($input);
        //print_r($clean);exit;
        $email = $clean[0];
        $username = $clean[1];
        $password = $clean[2];
        $fullname = $clean[3];
        $city = $clean[4];
        $state = $clean[5];
        $zip = $clean[6];
        $country = $clean[7];
        $address = $clean[8];
        $squestion = $clean[9];
        $sanswer = $clean[10];
        $bitcoinaddress = $clean[11];
        $time = time();
        $rand = rand(1000,10000);
        $date = date('Y-m-d');
        $e = $this::ValidateEmail($email);
        $fn = $this::pregmatch($username);

        if($e && $fn == true)
        {
            $where = "where email = '$email'";
            $w = "where username = '$username'";
            $this->selectQuery('users','email',$where);
            if($this::checkrow()>0){
                return 'email already exist';
            }else
            {
                $this->selectQuery('users','username',$w);

                if($this::checkrow()>0)
                {
                    return 'username already exist';
                }else

                {
                    $insert = $this::insertQuery('users','username,email,password,fullname,zip,city,state,country,address,squestion,sanswer,bitcoinaddress,date_created,profileId,status',"'$fn','$e','$password','$fullname','$zip','$city','$state','$country','$address','$squestion','$sanswer','$bitcoinaddress','$date','$rand','1'") ; 
                    if($insert)
                    {
                        

                        $mg = Mailgun::create(MAILGUN_KEY, 'https://api.mailgun.net');

                       $me  =  $mg->messages()->send(MAILGUN_DOMAIN,[
                           'from'  => 'support@tradepals.com',
                           'to'    => $e,
                           'subject' => 'please confirm your registration',
                           'html'  =>  "
                             <div style=background-color:#f6f6f6;width:100%!important;height:100%><div class=adM>
                    
                             </div><table class=m_-282877905690654672body-wrap style=background-color:#f6f6f6;width:100%>
                                   <tbody><tr>
                                         <td></td>
                                         <td class=m_-282877905690654672container width=600 style=display:block!important;max-width:600px!important;margin:0 auto!important;clear:both!important>
                                               <div class=m_-282877905690654672content style=max-width:600px;margin:0 auto;display:block;padding:20px>
                                                     <table class=m_-282877905690654672main width=100% cellpadding=0 cellspacing=0>
                                                           <tbody><tr>
                                                                 <td style=color:#fff;background:#ff9f00;text-align:center;padding:20px;font-weight:500;border-radius:3px 3px 0 0>
                                                                     Email Confirmation
                                                                 </td>
                                                           </tr>
                                                           <tr>
                                                                 <td class=m_-282877905690654672content-wrap style=padding:20px;background:#fff>
                                                                       <table width=100% cellpadding=0 cellspacing=0>
                                                                             <tbody><tr>
                                                                                   <td class=m_-282877905690654672content-block style=padding:20px 0 20px 0px>
                                                                                   Dear {$fullname}, 
                           
                                                                                   You signed up to  Tradepals please cnfirm your email with link below
                                                                                   </td>
                                                                             </tr>
                                                                             <tr>
                                                                                   <td class=m_-282877905690654672content-block style=padding:0 0 20px>
                                                                                         <a href=https://localhost:4200/{$username} class=m_-282877905690654672btn-primary style=background-color:#348eda;text-decoration:none;color:#fff;border:solid #348eda;border-width:10px 20px;line-height:2em;font-weight:bold;text-align:center;display:inline-block;border-radius:5px;text-transform:capitalize target=_blank >Visit <span class=il>Tradepals</span></a>
                                                                                   </td>
                                                                             </tr>
                                                                             <tr>
                                                                                   <td class=m_-282877905690654672content-block style=padding:0 0 20px>
                                                                                         Thanks for choosing <span class=il>Tradepals</span>.
                                                                                   </td>
                                                                             </tr>
                                                                       </tbody></table>
                                                                 </td>
                                                           </tr>
                                                     </tbody></table>
                                                     <div class=m_-282877905690654672footer>
                                                         
                                                     </div></div>
                                         </td>
                                         <td></td>
                                   </tr>
                             </tbody></table><div class=yj6qo></div><div class=adL>
                             
                             </div></div>
                           "

                         ]); #endregion
                        return array('code'=>'1', 'message'=>'account created','ref'=>'http://localhost:4200/'.$username);
                    }
                }
            }
        }
    }
// REFFERAL REGISTRATION
    public function Regref($input)
    {
        
        $clean  = $this::clean($input);
        //print_r($clean);exit;
        $email = $clean[0];
        $username = $clean[1];
        $password = $clean[2];
        $fullname = $clean[3];
        $city = $clean[4];
        $state = $clean[5];
        $zip = $clean[6];
       $country = $clean[7];
        $address = $clean[8];
        $squestion = $clean[9];
        $sanswer = $clean[10];
        $bitcoinaddress = $clean[11];
        $refferal = $clean[12];
        
        $date = date('Y-m-d');
        $e = $this::ValidateEmail($email);
        $fn = $this::pregmatch($username);

        if($e && $fn == true)
        {
            $where = "where email = '$email'";
            $w = "where username = '$username'";
            $this->selectQuery('users','email',$where);
            if($this::checkrow()>0){
                return 'email already exist';
            }else
            {
                $this->selectQuery('users','username',$w);

                if($this::checkrow()>0)
                {
                    return 'username already exist';
                }else

                {
                    $this::selectQuery('users','username,email',"where username='$refferal'");
                    $q = $this::fetchQuery();
                    $parent = $q[0]['email'];
                    

                     $inref =  $this::insertQuery('refferal','parent_id,child_id',"'$parent','$email'");

                     if($inref)
                     {
                        $insert = $this::insertQuery('users','username,email,password,fullname,zip,city,state,country,address,squestion,sanswer,bitcoinaddress,referral,date_created,status',"'$fn','$e','$password','$fullname','$zip','$city','$state','$country','$address','$squestion','$sanswer','$bitcoinaddress','$referral','$date','1'") ; 
                        if($insert)
                        {
                            return array('code'=>'1', 'message'=>'account created','ref'=>'http://localhost:4200/ref/'.$username);
                        }
                     } 
                  }
               }
            }
         }
     public function getRef($token)
     {
         // get last referral id
          $decoded = $this::getid($token);
          $this::lastDsc('refferal','child_id',"where parent_id ='$decoded'",'sn',1);
          $f = $this::fetchquery();
          $child_id = $f[0]['child_id'];
          $this::selectQuery('users','username,country,date_created',"where email ='$child_id'");
          $referal_id =  $this::fetchQuery();
          
           // get total ref
           $this::countQuery('refferal',"where parent_id = '$decoded'");
           $fet = $this::fetchQuery();
           $refNum = $fet[0]['COUNT(*)'];
           
           return array ('code'=>'1','refid'=>$referal_id,'refNum'=>$refNum);

     }    
  // USER LOGIN
  public function Login($input)
  {
        $eliminate = $this::clean($input);
        $email = $eliminate[0];
        $pass = $eliminate[1];
        $password = $input['password'];
        $time = date('h:i:s');

        $e = $this::ValidateEmail($email);

        $where = "where email='$e'";
        $this::selectQuery('users','email,password,type,status',$where);
        if($this::checkrow() == 1){
            $fetch = $this::fetchQuery();
            if($fetch[0]['email'] == $e && password_verify($password, $fetch[0]['password']) == true && $fetch[0]['type'] == 'member' && $fetch[0]['status'] == 1)
            {
                $issuer="http://localhost:4200";
                $audience= "http://localhost:/dashboard";
                $user_id = $e;
                $token=$this->enc($issuer,$audience,$user_id);
                $this::update('users',"last_login = '$time'",$where);
              return array('code'=>1,'message'=>$token,'time'=>$time);
            }else 
            if($fetch[0]['email'] == $e && password_verify($password, $pass) == true && $fetch[0]['type'] == 'admin')
            {
                $issuer="http://localhost:4200";
                $audience= "http://localhost:/admindash";
                $user_id = $e;
                $token=$this->enc($issuer,$audience,$user_id);
              return array('code'=>2,'message'=>$token);
            }else
            {
                return array('code'=>3,'message'=>'invalid user');
            };
         }else
         {
            return 'email does not exist';
        }
    }
//GET ALL USER INFORMATION
public function getU($token)
{
      $tot =[];
      $totwith = [];
      $totdep = [];
        $jwt= new JWT;
        $call=$jwt::decode($token,secret_key, array('HS256'));
        $decoded_array= (array) $call;
        $decoded=$decoded_array['id'];

       $this->selectQuery("users","username,fullname,mainaccountbal,earning,bitcoinaddress,email,country,state,city,address,zip,date_created,last_login","WHERE email='$decoded'");
       if($this->checkrow()==1)
       {
        $boy=$this->fetchQuery();
       
    //withdrawal informations    
      $this::selectQuery('withdrawal','withdrawamount',"where email='$decoded' AND status='0'");
      $sum = $this::fetchQuery();
     
        foreach($sum as $sum){
             array_push($tot,$sum['withdrawamount']);
        }
       $a =array_sum($tot);

       $this::selectQuery('withdrawal','withdrawamount',"where email='$decoded'");
      $sut = $this::fetchQuery();
        foreach($sut as $sut){
             array_push($totwith,$sut['withdrawamount']);
        }
       $b =array_sum($totwith);

         $this::lastDsc('withdrawal','withdrawamount',"where email='$decoded'",'sn',1);
        $t =  $this::fetchQuery();
        if($t == true)
        {
        $lastwith = $t[0]['withdrawamount'];
        }
        else
        {
            $lastwith = 0;
        }

    //deposit informations
        $this::selectQuery('deposits','amount',"where email='$decoded' and status > '0'");
        $dep = $this::fetchQuery();
          foreach($dep as $dep){
               array_push($totdep,$dep['amount']);
          }
         $totdep =array_sum($totdep);
  
          $this::lastDsc('deposits','amount',"where email='$decoded'",'sn',1);
          $td =  $this::fetchQuery();
          if($td == true)
          {
            $lastdep = $td[0]['amount'];
          }
          else
          {
              $lastdep = 0;
          }
         

       return array("code"=>"1","message"=>$boy,"pwith"=>$a,"totwith"=>$b,"lastwith"=>$lastwith,"totdep"=>$totdep,"lastdep"=>$lastdep);
    }
}



public function getP()
{
    $this->selectQuery("users","*","where type = 'member'");
    $u = $this::fetchQuery();
   return array('code'=>'1','message'=>$u);
}
public function proUser($id)
{
    $this->selectQuery("users","*","where type = 'member' and profileId = '$id'");
    $u = $this::fetchQuery();
   return array('code'=>'1','message'=>$u);
}

// PROCESS DEPOSIT // 


public function checkUserDeposit($token)
{
    $decoded = $this::getid($token);
    $this::selectQuery('deposits','status',"where email = '$decoded' and status='1'");
    if($this::checkrow()  < 1)
    {
     return true;
    }
    else
    {
     return false;
    }
}



public function process($input,$token)
{
        $decoded = $this::getid($token);
        $username = $input['username'];
        $email = $decoded;
        $plan = $input['plan'];
        $amount = $input['amount'];
        $expected_roi = $input['profit'];
        $time = time();
        $rand = rand(1000,10000);
        $date = date("Y-m-d");
        $month = date('m');
        $deposite_id = $time.$rand;

        $this::selectQuery('users','mainaccountbal',"where email ='$decoded'");
        $a =  $this::fetchQuery();
        $accot = $a[0]['mainaccountbal'];
     if($amount < $accot){
            $isactive = $this::checkUserDeposit($token);
            if($isactive == true){
           $finalbal = $accot - $amount;
           $this::update("users","mainaccountbal='$finalbal'","where email ='$decoded'");
    
        $in = $this::insertQuery('deposits','username,email,plan,amount,expected_roi,deposite_time,deposite_id,depositDate',"'$username','$email','$plan','$amount','$expected_roi','$time','$deposite_id','$date'");
            }else
            {
                return array('code'=>'3');
            }
        if($in)
        {
                
            $mon = "WHERE month='$month'";
            $this->selectQuery('depgraph',"deposits",$mon);
            $added = $this::fetchQuery();
            $mn=$added[0];
            $jf= $mn['deposits'] + $amount;
            $this::update("depgraph","deposits='$jf'",$mon);

        return array('code'=>'1');
              /*   $this::selectQuery('refferal','parent_id,child_id,num_com',"where child_id='$decoded'");
                $refF = $this::fetchQuery();
                $num_cum =$refF[0]['num_com'];
                $parent_id =$refF[0]['parent_id'];
                $num = $num_cum + 1;
                $refam = $amount * 0.1;
                
                if($num_cum < 1)
                {
                    $this::selectQuery('users','mainaccountbal,earning',"where email ='$parent_id'");
                    if($this::checkrow() == 1)
                    {
                        $nf= $this::fetchQuery();
                        $main = $nf[0]['mainaccountbal'];
                        $earn = $nf[0]['earning'];
                        $earning =$earn + $refam;
                        $mainaccount =$main + $refam;
                    $inserted = $this::update('users',"mainaccountbal='$mainaccount',earning='$earning'","where email = '$parent_id'");
                       if($inserted)
                       {
                        $this::selectQuery('refferal','parent_id,child_id,num_com',"where child_id='$decoded'");
                         if($this::checkrow() == 1)
                         {
                            $this::update('refferal',"num_com='$num' ","where child_id ='$decoded'");
                            return "complete";
                         }
                       }
                    }

                } */

            
        }
    } else 
    {
   return array('code'=>'2');
    }
    }

    // ALL EARNING
    public function earnIn($token)
    {
        $jwt= new JWT;
        $call=$jwt::decode($token,secret_key, array('HS256'));
        $decoded_array= (array) $call;
        $decoded=$decoded_array['id'];

        $this::selectQuery('deposits','plan,amount,deposite_time,address,status',"WHERE email='$decoded' AND status='1'");

        $f = $this::fetchQuery();
       
        $plan =$f[0]['plan']; 
        
        $amount = $f[0]['amount'];
        $deposite_time = $f[0]['deposite_time'];
        $status = $f[0]['status'];
        $td = time();
        $address = $f[0]['address'];
        $final_time = 86400 * 28;
        $famount ;
        $diffrence = $td - $deposite_time;
     if($status == 1){

       if($plan ==1)
       {
        $famount =  $amount * 1.4;
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
             $in = $this::update('deposits',"status = '2'","WHERE email='$decoded' and address = '$address'");
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
        } 

        if($plan ==2)
        {
            $famount =  $amount * 1.8;
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
             $in = $this::update('deposits',"status = '2'","WHERE email='$decoded' and address = '$address'");

              return  array('code'=>1,'message'=>$am);
         }else
         {
            $diffrence = $diffrence; 

            $current = ($diffrence * $famount) / ($final_time);
            $am =  round($current,2);
            $cashPerSec = round(($famount/86400),5);
           // print_r($am);exit;
   
            return  array('code'=>1,'message'=>[$am,$cashPerSec]); 
         }

         return  array('code'=>'1','message'=>$am);
         } 

         if($plan == 3)
        {
            $famount =  $amount * 2;
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
             $in = $this::update('deposits',"status = '2'","WHERE email='$decoded' and address = '$address'");

              return  array('code'=>1,'message'=>$am);
         }else
         {
            $diffrence = $diffrence; 

            $current = ($diffrence * $famount) / ($final_time);
            $am =  round($current,2);
            $cashPerSec = round(($famount/86400),5);
           // print_r($am);exit;
   
            return  array('code'=>1,'message'=>[$am,$cashPerSec]); 
         }
         return  array('code'=>'1','message'=>$am);
         } 

         if($plan == 4)
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

              return  array('code'=>1,'message'=>$am);
         }else
         {
            $diffrence = $diffrence; 

         $current = ($diffrence * $famount) / ($final_time);
         $am =  round($current,2);
         $cashPerSec = round(($famount/86400),5);
        // print_r($am);exit;

         return  array('code'=>1,'message'=>[$am,$cashPerSec]);
         } 
         return  array('code'=>'1','message'=>$am);
         } 

        }else
        {
            return  array('code'=>'1','message'=>0); 
        }

        }

    // WITHDRAW FUNCTION//
   public function withdraw($input,$token)
    {
        
        $jwt= new JWT;
        $call=$jwt::decode($token,secret_key, array('HS256'));
        $decoded_array= (array) $call;
        $decoded=$decoded_array['id'];

        $clean = $this::clean($input);
        //print_r($clean);exit;
        $withdrawamount =$clean[0];
       
        $td = date('Y-m-d');
        $time = time();
        $month =date('m');
        $withdrawtime = date('h:i:s');
        $rand = rand(1000,10000);
        $withdrawid = $time.$rand;
        
        $mon = "WHERE month='$month'";

        $this::selectQuery('users','email,username',"where email = '$decoded'");
        $f = $this::fetchQuery();
        $email = $f[0]['email'];
        $username =$f[0]['username'];

        $this::selectQuery('users','mainaccountbal',"where email= '$decoded'");
        $r = $this::fetchQuery();
        $accountbal = $r[0]['mainaccountbal'] - $withdrawamount;
        $up = $this::update('users',"mainaccountbal='$accountbal'","where email = '$decoded'");

       
            $this->selectQuery('withgraph',"withdrawal",$mon);
            $added = $this::fetchQuery();
            $mn=$added[0];
            $jf= $mn['withdrawal'] + $withdrawamount;
            $this::update("withgraph","withdrawal='$jf'",$mon);

       if($up)
       {
          $this::insertQuery('withdrawal','email,username,withdrawamount,withdrawId,withdrawtime,date,status',"'$email','$username','$withdrawamount','$withdrawid','$withdrawtime','$td','0'");
          return array('code'=>'1','message'=>'withdraw pending');
       }
       

    }

    public function getid($token){
        $jwt= new JWT;
        $call=$jwt::decode($token,secret_key, array('HS256'));
        $decoded_array= (array) $call;
        $decoded=$decoded_array['id'];
        return $decoded;
        
      }

    // TOTAL WITHDRAWAL
    public function Totwith($token)
    {
        $tot = [];
    $decoded = $this::getid($token);
    $this::selectQuery('withdrawal','username,withdrawamount,date',"where email ='$decoded'");
     $fet = $this::fetchQuery();
     $this::selectQuery('withdrawal','withdrawamount',"where email ='$decoded'");
     $met = $this::fetchQuery();

        foreach($met as $met){
            array_push($tot,$met['withdrawamount']);
        }
       $sumtot = array_sum($tot);

     return array('code'=>'1','message'=>$fet,'sum'=>$sumtot);
    }


    // TOTAL DEPOSITES
    public function Totdep($token)
    {
        $tot = [];
    $decoded = $this::getid($token);
    
    $this::selectQuery('deposits','email,plan,username,amount,depositDate',"where email ='$decoded' and status > '0'");
     $fet = $this::fetchQuery();
     $this::selectQuery('deposits','amount',"where email ='$decoded' and status > '0'");
     $met = $this::fetchQuery();

        foreach($met as $met){
            array_push($tot,$met['amount']);
        }
       $sumtot = array_sum($tot);

     return array('code'=>'1','message'=>$fet,'sum'=>$sumtot);
    }


    // GET DEPOSITE LIST
    public function deplist($token)
    {
        $decoded = $this::getid($token);  
        $this::selectQuery('deposits','email,username,plan,expected_roi,amount,depositDate',"where email ='$decoded' AND plan='1'");
        $p1 = $this::fetchQuery();
        $this::selectQuery('deposits','email,username,plan,expected_roi,amount,depositDate',"where email ='$decoded' AND plan='2'");
        $p2 = $this::fetchQuery();
        $this::selectQuery('deposits','email,username,plan,expected_roi,amount,depositDate',"where email ='$decoded' AND plan='3'");
        $p3 = $this::fetchQuery();
        $this::selectQuery('deposits','email,username,plan,expected_roi,amount,depositDate',"where email ='$decoded' AND plan='4'");
        $p4 = $this::fetchQuery();

        return array('code'=>'1','plan1'=>$p1,'plan2'=>$p2,'plan3'=>$p3,'plan4'=>$p4);
        
       
    }


    public function DepC()
    {
        $this::selectQuery("deposits",'email,username,plan,expected_roi,amount,deposite_id,status',"where status ='0'");
        $me = $this::fetchQuery();
        return array('code'=>'1','deposits'=>$me);
    }

    public function Cdep($id)
    {
       $this::selectQuery("deposits",'email,deposite_id',"where deposite_id = '$id'");
      $dep =  $this::fetchQuery();
      $depo = $dep[0]['deposite_id'];
      $this::selectQuery("activeP",'deposite_id',"where deposite_id = '$depo'");
      $depp =  $this::fetchQuery();
      $deppp = $depp[0]['deposite_id'];
      if($depo === $deppp)
      {
          $this::update('deposits',"status='1'","where deposite_id='$id'");
          $this::update('activeP',"status='1'","where deposite_id='$id'");
         
      }
    }

    public function withC()
    {
        $this::selectQuery("withdrawal",'email,username,withdrawamount,withdrawId,withdrawtime,date,status',"where status='0'");
        $me = $this::fetchQuery();
        return array('code'=>'1','withdrawals'=>$me);
    }

    public function Cwith($id)
    {
       $this::selectQuery("withdrawal",'email',"where withdrawId = '$id'");
      $dep =  $this::fetchQuery();
      $depo = $dep[0]['email'];
     $this::update('withdrawal',"status='1'","where withdrawId = '$id' and email='$depo'");
    }

    // SEARCH FUNCTION//

    public function search($input,$token)
    {
        $decoded = $this::getid($token);
        $fdate =[];
       $tdate = [];
       $tot = [];
      $fdate[0]=$input['fyear'];
      $fdate[1] =$input['fmonth'];
      $fdate[2] = $input['fday'];

      $tdate[0]=$input['tyear'];
      $tdate[1] =$input['tmonth'];
      $tdate[2] = $input['tday'];

      $space = implode("-", $fdate);
      $spac = implode("-", $tdate);

     $this::between('email,plan,username,amount,withdrawDate','deposits',"where withdrawDate between '$space' AND '$spac' AND email='$decoded'");
     $dep =  $this::fetchQuery();
     $this::between('amount','deposits',"where withdrawDate between '$space' AND '$spac' AND email='$decoded'");
     $met =  $this::fetchQuery();

     foreach($met as $met){
            array_push($tot,$met['amount']);
        }
       $sumtot = array_sum($tot);

       return array('code'=>'1','message'=>$dep,'sum'=>$sumtot);

    }
    public function searchW($input,$token)
    {
        $decoded = $this::getid($token);
        $fdate =[];
       $tdate = [];
       $tot = [];
      $fdate[0]=$input['fyear'];
      $fdate[1] =$input['fmonth'];
      $fdate[2] = $input['fday'];

      $tdate[0]=$input['tyear'];
      $tdate[1] =$input['tmonth'];
      $tdate[2] = $input['tday'];

      $space = implode("-", $fdate);
      $spac = implode("-", $tdate);

     $this::between('username,withdrawamount,date','withdrawal',"where withdrawDate between '$space' AND '$spac' AND email='$decoded'");
     $dep =  $this::fetchQuery();
     $this::between('withdrawamount','withdrawal',"where withdrawDate between '$space' AND '$spac' AND email='$decoded'");
     $met =  $this::fetchQuery();

     foreach($met as $met){
            array_push($tot,$met['withdrawamount']);
        }
       $sumtot = array_sum($tot);

       return array('code'=>'1','message'=>$dep,'sum'=>$sumtot);

    }

public function AinvestD()
{
   $this::lastDsc('deposits','username,amount','','sn',10);
   $d = $this::fetchQuery();
   $this::lastDsc('withdrawal','username,withdrawamount','','sn',10);
   $w = $this::fetchQuery();
   return array('code'=>1,'message'=>[$d,$w]);
}

public function proUp($token,$input)
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
   $this::selectQuery('users','password,city,state,country,zip,bitcoinaddress,address',"where email = '$decoded'");
   $f = $this::fetchQuery();
   $oldpass = $f[0]['password'];
   $oldcity = $f[0]['city'];
   $oldstate = $f[0]['state'];
   $oldcountry = $f[0]['country'];
   $oldzip = $f[0]['zip'];
   $oldaddress = $f[0]['address'];
   $oldbitcoinaddress = $f[0]['bitcoinaddress'];
   if($neat[7]==''){$newpass=$oldpass;}else{$newpass = $newpass;} 
   if($neat[1]==''){$city=$oldcity;}else{$city = $city;}  
   if($neat[2]==''){$state=$oldstate;}else{$state = $state;} 
   if($neat[3]==''){$country=$oldcountry;}else{$country = $country;} 
   if($neat[4]==''){$zip=$oldzip;}else{$zip = $zip;} 
   if($neat[5]==''){$address=$oldaddress;}else{$address = $address;}
   if($neat[0]==''){$bitcoinaddress=$oldbitcoinaddress;}else{$bitcoinaddress = $bitcoinaddress;} 

   if(password_verify($password,$oldpass))
   {
    $update =  $this::update('users',"bitcoinaddress = '$bitcoinaddress', city = '$city', state = '$state', country = '$country',zip ='$zip', address ='$address', password = '$newpass'","where email='$decoded'");
    if($update){ return array('code'=>'1','message'=>'update complete');}
   } else
   {
    return array('code'=>'2','message'=>'wrong pass');
   }

}

public function gtGraph()
{
    $empty =[];
    $tot = [];
    $this->selectQuery('depgraph','deposits','');
    $gb=$this::fetchQuery();
  foreach ($gb as $gb) {
    array_push($empty,$gb['deposits']);
  }

  $this->selectQuery('withgraph','withdrawal','');
    $fb=$this::fetchQuery();
  foreach ($fb as $fb) {
    array_push($tot,$fb['withdrawal']);
  }
    return array('code'=>1,"message"=>[$empty,$tot]);
}

public function gtUgraph($token)
{
    $decoded = $this::getid($token);
    $empty =[];
    $tot = [];
    $this->selectQuery('deposits','amount',"where email='$decoded'");
    $gb=$this::fetchQuery();
  foreach ($gb as $gb) {
    array_push($empty,$gb['amount']);
  }
 /* $empty = array_sum($empty); */

  $this->selectQuery('withdrawal','withdrawamount',"where email = '$decoded'");
    $fb=$this::fetchQuery();
  foreach ($fb as $fb) {
    array_push($tot,$fb['withdrawamount']);
  }
 /*  $tot = array_sum($tot); */

  
    return array('code'=>1,"message"=>[$empty,$tot]);
}

public function simDep($input)
{
    $username = $input['username'];
    
    $amount = $input['amount'];
    $this::selectQuery('deposits','username',"where username = '$username'");
   if($this::checkrow() < 1)
    {
        $this::insertQuery('deposits','username,amount,status',"'$username','$amount','3'");

        return 'inserted';
    }else
    {
       return 'username exits';
    }
    
}

public function simWith($input)
{
    $username = $input['username'];
    
    $amount = $input['amount'];
    $this::selectQuery('withdrawal','username',"where username = '$username'");
   if($this::checkrow() < 1)
    {
        $this::insertQuery('withdrawal','username,withdrawamount,status',"'$username','$amount','3'");

        return 'inserted';
    }else
    {
       return 'username exits';
    }
    
}


public function block($id)
{
    $this::update('users',"status = '2'","where profileId = '$id'");
    return 'done';
}
public function unblock($id)
{
    $this::update('users',"status = '1'","where profileId = '$id'");
    return 'done';
}

}

?>