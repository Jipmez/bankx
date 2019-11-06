<?php
require('ApiFunct.php');
header('Content-type:application/json;charset=utf-8');
$request=json_decode(file_get_contents('php://input'),true);
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: X-Requested-With, content-type,access-control-allow-origin, access-control-allow-methods, access-control-allow-headers');


if($request['key'] == 'reg')
{
    $input = array('email'=>$request['email'],'username'=>$request['username'],'password'=>$request['password'],'fullname'=>$request['fullname'],'city'=>$request['city'],'state'=>$request['state'],'zip'=>$request['zip'],'country'=>$request['country'],'address'=>$request['address'],'squestion'=>$request['squestion'],'sanswer'=>$request['sanswer'],'bitcoinaddress'=>$request['bitcoin']);

    $clas= new coin('localhost','root','','tcb');

    $logg = $clas->Register($input);

    echo json_encode($logg);
}


if($request['key'] == 'log')
{
    $input = array('email' => $request['email'],'password'=>$request['password']);

    $clas= new coin('localhost','root','','tcb');

    $logg = $clas->Login($input);

    echo json_encode($logg);

}

if($request['key'] == 'regref')
{
    $input = array('email'=>$request['email'],'username'=>$request['username'],'password'=>$request['password'],'fullname'=>$request['fullname'],'city'=>$request['city'],'state'=>$request['state'],'zip'=>$request['zip'],'country'=>$request['country'],'address'=>$request['address'],'squestion'=>$request['squestion'],'sanswer'=>$request['sanswer'],'bitcoinaddress'=>$request['bitcoin'],'refferal'=>$request['ref']);

    $clas= new coin('localhost','root','','tcb');

    $logg = $clas->Regref($input);

    echo json_encode($logg);
}


if($request['key'] == 'user')
{

    $token = $request['Id'];
    $clas= new coin('localhost','root','','tcb');

    $logg = $clas->getU($token);

    echo json_encode($logg);

}

 if($request['key'] == 'depo')
{
    $token = $request['val'];
    $input = array('plan'=>$request['plan'],'profit'=>$request['profit'],'amount'=>$request['amount'],'username'=>$request['username']);
    $clas= new coin('localhost','root','','tcb');
      
    $logg = $clas->process($input,$token);

    echo json_encode($logg);
} 

if($request['key'] == 'search')
{
    $token = $request['Id'];
    $input = array('fmonth'=>$request['fmonth'],'fday'=>$request['fday'],'fyear'=>$request['fyear'],'tmonth'=>$request['tmonth'],'tday'=>$request['tday'],'tyear'=>$request['tyear']);
    $clas= new coin('localhost','root','','tcb');

    $logg = $clas->search($input,$token);

    echo json_encode($logg);

}
if($request['key'] == 'searchW')
{
    $token = $request['Id'];
    $input = array('fmonth'=>$request['fmonth'],'fday'=>$request['fday'],'fyear'=>$request['fyear'],'tmonth'=>$request['tmonth'],'tday'=>$request['tday'],'tyear'=>$request['tyear']);
    $clas= new coin('localhost','root','','tcb');

    $logg = $clas->searchW($input,$token);

    echo json_encode($logg);

}

if($request['key'] == 'load')
{
$token = $request['val'];

$clas= new coin('localhost','root','','tcb');

    $logg = $clas->earnIn($token);

    echo json_encode($logg);

}


if($request['key'] == 'withdraw')
{
    $token = $request['val'];
    $input =array('withdraw'=>$request['withdraw']);

    $clas= new coin('localhost','root','','tcb');

    $logg = $clas->withdraw($input,$token);

    echo json_encode($logg);
}

if($request['key'] == 'witH')
{
    $token = $request['Id'];
    $clas= new coin('localhost','root','','tcb');

    $logg = $clas->Totwith($token);

    echo json_encode($logg);
}

if($request['key'] == 'depH')
{
    $token = $request['Id'];
    $clas= new coin('localhost','root','','tcb');

    $logg = $clas->Totdep($token);

    echo json_encode($logg);
}

if($request['key'] == 'dep')
{
    $token = $request['val'];
    $clas= new coin('localhost','root','','tcb');

    $logg = $clas->deplist($token);

    echo json_encode($logg);
}

if($request['key'] == 'admindep')
{
    $clas= new coin('localhost','root','','tcb');

    $logg = $clas->DepC();

    echo json_encode($logg); 
}

if($request['key'] == 'depositId')
{   

    $id = $request['depositId'];

    $clas= new coin('localhost','root','','tcb');

    $logg = $clas->Cdep($id);

    echo json_encode($logg); 
}


if($request['key'] == 'adminwithdraw')
{

    $clas= new coin('localhost','root','','tcb');

    $logg = $clas->withC();

    echo json_encode($logg);
}

 if($request['key'] == 'withdrawId')
{
    $id = $request['withdrawId'];
    $clas= new coin('localhost','root','','tcb');

    $logg = $clas->Cwith($id);

    echo json_encode($logg);
} 

if($request['key'] == 'invest')
{
    $clas= new coin('localhost','root','','tcb');

    $logg = $clas->AinvestD();

    echo json_encode($logg);
}

if($request['key'] == 'proUp')
{
    
    $token = $request['Id'];

    $input = array('bitcoinaddress'=>$request['bitcoinaddress'],'city'=>$request['city'],'state'=>$request['state'],'country'=>$request['country'],'zip'=>$request['zip'],'address'=>$request['address'],'password'=>$request['password'],'pass'=>$request['newpass']);

    $clas= new coin('localhost','root','','tcb');

    $logg = $clas->proUp($token,$input);

    echo json_encode($logg);

}
if($request['key'] == 'graph')
{
    $clas= new coin('localhost','root','','tcb');

    $logg = $clas->gtGraph();

    echo json_encode($logg);
}
if($request['key'] == 'Ugraph')
{
    $token =$request['token'];

    $clas= new coin('localhost','root','','tcb');
     
    $logg = $clas->gtUgraph($token);

    echo json_encode($logg);
}
if($request['key'] == 'simdep')
{
    $input =array('username'=>$request['username'],'amount'=>$request['amount']);

    $clas= new coin('localhost','root','','tcb');

    $logg = $clas->simDep($input);

    echo json_encode($logg);
}
if($request['key'] == 'simwith')
{
    $input =array('username'=>$request['username'],'amount'=>$request['amount']);

    $clas= new coin('localhost','root','','tcb');

    $logg = $clas->simWith($input);

    echo json_encode($logg);
}
if($request['key'] == 'allU')
{
    $clas= new coin('localhost','root','','tcb');

    $logg = $clas->getP();

    echo json_encode($logg);
}
if($request['key'] == 'proUser')
{
    $id = $request['proid'];
    $clas= new coin('localhost','root','','tcb');

    $logg = $clas->proUser($id);

    echo json_encode($logg);

}
if($request['key'] == 'block')
{
    $id = $request['id'];
    $clas= new coin('localhost','root','','tcb');

    $logg = $clas->block($id);

    echo json_encode($logg);
}
if($request['key'] == 'unblock')
{
    $id = $request['id'];
    $clas= new coin('localhost','root','','tcb');

    $logg = $clas->unblock($id);

    echo json_encode($logg);
}
if($request['key'] == 'reff')
{
    $token = $request['val'];

    $clas= new coin('localhost','root','','tcb');

    $logg = $clas->getRef($token);

    echo json_encode($logg);

}










?>