<?php
require('ApiFunct.php');
header('Content-type:application/json;charset=utf-8');
$request=json_decode(file_get_contents('php://input'),true);
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: X-Requested-With, content-type,access-control-allow-origin, access-control-allow-methods, access-control-allow-headers');
$clas= new coin('localhost','root','','tcb');


if($request['key'] == 'reg')
{
    $input = array('email'=>$request['email'],'username'=>$request['username'],'password'=>$request['password'],'fullname'=>$request['fullname'],'city'=>$request['city'],'state'=>$request['state'],'country'=>$request['country'],'address'=>$request['address'],'bitcoinaddress'=>$request['bitcoin']);

    

    $logg = $clas->Register($input);

    echo json_encode($logg);
}


if($request['key'] == 'log')
{
    $input = array('email' => $request['email'],'password'=>$request['password']);

    

    $logg = $clas->Login($input);

    echo json_encode($logg);

}

if($request['key'] == 'regref')
{
    $input = array('email'=>$request['email'],'username'=>$request['username'],'password'=>$request['password'],'fullname'=>$request['fullname'],'city'=>$request['city'],'state'=>$request['state'],'zip'=>$request['zip'],'country'=>$request['country'],'address'=>$request['address'],'squestion'=>$request['squestion'],'sanswer'=>$request['sanswer'],'bitcoinaddress'=>$request['bitcoin'],'refferal'=>$request['ref']);

    

    $logg = $clas->Regref($input);

    echo json_encode($logg);
}


if($request['key'] == 'user')
{

    $token = $request['Id'];
    

    $logg = $clas->getU($token);

    echo json_encode($logg);

}

 if($request['key'] == 'depo')
{
    $token = $request['val'];
    $input = array('plan'=>$request['plan'],'profit'=>$request['profit'],'amount'=>$request['amount'],'username'=>$request['username']);
    
      
    $logg = $clas->process($input,$token);

    echo json_encode($logg);
} 
if($request['key'] == 'depoBank')
{
    $token = $request['val'];
    $input = array('plan'=>$request['plan'],'profit'=>$request['profit'],'amount'=>$request['amount'],'username'=>$request['username']);
    
      
    $logg = $clas->processBank($input,$token);

    echo json_encode($logg);
} 

if($request['key'] == 'search')
{
    $token = $request['Id'];
    $input = array('fmonth'=>$request['fmonth'],'fday'=>$request['fday'],'fyear'=>$request['fyear'],'tmonth'=>$request['tmonth'],'tday'=>$request['tday'],'tyear'=>$request['tyear']);
    

    $logg = $clas->search($input,$token);

    echo json_encode($logg);

}
if($request['key'] == 'searchW')
{
    $token = $request['Id'];
    $input = array('fmonth'=>$request['fmonth'],'fday'=>$request['fday'],'fyear'=>$request['fyear'],'tmonth'=>$request['tmonth'],'tday'=>$request['tday'],'tyear'=>$request['tyear']);
    

    $logg = $clas->searchW($input,$token);

    echo json_encode($logg);

}

if($request['key'] == 'load')
{
$token = $request['val'];



    $logg = $clas->earnIn($token);

    echo json_encode($logg);

}


if($request['key'] == 'withdraw')
{
    $token = $request['val'];
    $input =array('withdraw'=>$request['withdraw']);

    

    $logg = $clas->withdraw($input,$token);

    echo json_encode($logg);
}

if($request['key'] == 'witH')
{
    $token = $request['Id'];
    

    $logg = $clas->Totwith($token);

    echo json_encode($logg);
}

if($request['key'] == 'depH')
{
    $token = $request['Id'];
    

    $logg = $clas->Totdep($token);

    echo json_encode($logg);
}

if($request['key'] == 'dep')
{
    $token = $request['val'];
    

    $logg = $clas->deplist($token);

    echo json_encode($logg);
}

if($request['key'] == 'admindep'){

    $logg = $clas->DepC();

    echo json_encode($logg); 
}

if($request['key'] == 'depositId')
{   

    $id = $request['depositId'];

    

    $logg = $clas->Cdep($id);

    echo json_encode($logg); 
}


if($request['key'] == 'adminwithdraw')
{

    $logg = $clas->withC();

    echo json_encode($logg);
}

 if($request['key'] == 'withdrawId')
{
    $id = $request['withdrawId'];
    

    $logg = $clas->Cwith($id);

    echo json_encode($logg);
} 

if($request['key'] == 'invest')
{
    

    $logg = $clas->AinvestD();

    echo json_encode($logg);
}

if($request['key'] == 'proUp')
{
    
    $token = $request['Id'];

    $input = array('bitcoinaddress'=>$request['bitcoinaddress'],'city'=>$request['city'],'state'=>$request['state'],'country'=>$request['country'],'zip'=>$request['zip'],'address'=>$request['address'],'password'=>$request['password'],'pass'=>$request['newpass']);


    $logg = $clas->proUp($token,$input);

    echo json_encode($logg);

}
if($request['key'] == 'graph')
{


    $logg = $clas->gtGraph();

    echo json_encode($logg);
}
if($request['key'] == 'Ugraph')
{
    $token =$request['token'];

    
     
    $logg = $clas->gtUgraph($token);

    echo json_encode($logg);
}
if($request['key'] == 'simdep')
{
    $input =array('username'=>$request['username'],'amount'=>$request['amount']);

    

    $logg = $clas->simDep($input);

    echo json_encode($logg);
}
if($request['key'] == 'simwith')
{
    $input =array('username'=>$request['username'],'amount'=>$request['amount']);


    $logg = $clas->simWith($input);

    echo json_encode($logg);
}
if($request['key'] == 'allU')
{
    

    $logg = $clas->getP();

    echo json_encode($logg);
}
if($request['key'] == 'proUser')
{
    $id = $request['proid'];
    
    $logg = $clas->proUser($id);

    echo json_encode($logg);

}
if($request['key'] == 'block')
{
    $id = $request['id'];
    $logg = $clas->block($id);

    echo json_encode($logg);
}
if($request['key'] == 'unblock')
{
    $id = $request['id'];
    $logg = $clas->unblock($id);

    echo json_encode($logg);
}
if($request['key'] == 'reff')
{
    $token = $request['val'];

    $logg = $clas->getRef($token);

    echo json_encode($logg);

}

if($request['key'] == 'subscribe'){
    $input = ['email'=>$request['email'], 'name'=>$request['name']];
    $log = $clas->subscribe($input);
    echo json_encode($log);
}

if($request['key'] == 'forgot'){
    $email = $request['email'];
    $jay = $clas->forgotPass($email);
    echo json_encode($jay);
  }

  if($request['key'] == 'tokenVerify'){
    $token = $request['token'];
    $jay = $clas->tokenVerify($token);
    echo json_encode($jay);
  }

  if($request['key'] == 'changePass'){
    $password =array('password'=>$request['pass']);
    $token = $request['token'];
  
    $jay = $clas->changePass($password,$token);
    echo json_encode($jay);
  }

  if($request['key'] == 'addAdmin'){
      $input = ['email'=>$request['email'], 'password'=>$request['password']];
      $jay = $clas->addAdmin($input);
    echo json_encode($jay);
  }
  if($request['key'] == 'addBank'){
    $input = ['bank'=>$request['bank'], 'account'=>$request['account']];
    $jay = $clas->addBank($input);
  echo json_encode($jay);
}
if($request['key'] == 'conwith'){
    $email = $request['email'];
$jay = $clas->ConWith($email);
  echo json_encode($jay);
}






?>