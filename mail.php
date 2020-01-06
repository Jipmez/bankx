<?php
define('MAILGUN_KEY','284c135f4e519d546f64df153090b8d6-9b463597-571dfbf6');
define('MAILGUN_PUBKEY', 'pubkey-5171366a26a4546b3530ac13e442ac6f');

define('MAILGUN_DOMAIN', 'sandbox782b77014ac840b1b12f34e621802ae1.mailgun.org');
require 'vendor/autoload.php';

$mailgun = new Mailgun\Mailgun(MAILGUN_KEY); #endregion
$validate = new  Mailgun\Mailgun(MAILGUN_PUBKEY); #endregion
use Mailgun\Mailgun;



class mail {
   
 

    public function Mailling($from,$to,$subject,$message,$link){
        $mg = Mailgun::create(MAILGUN_KEY);
        $me  =  $mg->messages()->send(MAILGUN_DOMAIN,[
          'from'  => $from,
          'to'    => $to,
          'subject' => $subject,
          'html'  =>  '
        
          <body itemscope itemtype="http://schema.org/EmailMessage" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
      
          <table class="body-wrap" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6"><tr style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
              <td class="container" width="600" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
                <div class="content" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
                  <table class="main" width="100%" cellpadding="0" cellspacing="0" itemprop="action" itemscope itemtype="http://schema.org/ConfirmAction" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff"><tr style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-wrap" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 20px;" valign="top">
                        <meta itemprop="name" content="Confirm Email" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;" /><table width="100%" cellpadding="0" cellspacing="0" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><tr style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                              Please confirm your email address by clicking the link below.
                            </td>
                          </tr><tr style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                              '.$message.'
                            </td>
                          </tr><tr style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" itemprop="handler" itemscope itemtype="http://schema.org/HttpActionHandler" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                              <a href='.$link.'  class="btn-primary" itemprop="url" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #348eda; margin: 0; border-color: #348eda; border-style: solid; border-width: 10px 20px;">Confirm email address</a>
                            </td>
                          </tr><tr style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                              &mdash; The Mailgunners
                            </td>
                          </tr></table></td>
                    </tr></table><div class="footer" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;">
                    <table width="100%" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><tr style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="aligncenter content-block" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0 0 20px;" align="center" valign="top">Follow <a href="http://twitter.com/mail_gun" style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; color: #999; text-decoration: underline; margin: 0;">@Mail_Gun</a> on Twitter.</td>
                      </tr></table></div></div>
              </td>
              <td style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
            </tr></table></body>
      
          ',
    ]);
      }


public function passmail($from,$to,$subject,$message,$link){
    $mg = Mailgun::create(MAILGUN_KEY);
    $me  =  $mg->messages()->send(MAILGUN_DOMAIN,[
      'from'  => $from,
      'to'    => $to,
      'subject' => $subject,
       'text'=> "
       $message
       ",
      // 'html'  =>  '
    
      // <div>
      //   <center>
      //     <table cellpadding="0" cellspacing="0" style="width:640px!important;background:#fffcf8!important">
      //        <tbody>
      //          <tr>
      //          <td>
      //          <table cellpadding="0" cellspacing="0" width="100%" style="width:640px!important;background-color:transparent;background-image:url(https://ci5.googleusercontent.com/proxy/htckZtxsl4LPV2thnnXALkdYuDke1pCJASRVNs1zE2K60IFUR-l9PFolU2VMokCrm7U=s0-d-e1-ft#https://i.imgur.com/itTN85b.png);background-position:top center;background-repeat:no-repeat;background-size:cover">
      //            <tbody>
      //              <tr style="width:100%">
      //                <td style="width:640px">
      //                  <center>
      //                    <div style="width:120px;padding:25px 0">
      //                      <a href="https://api.mixpanel.com/track?redirect=https%3A%2F%2Fflutterwave.com&amp;data=eyJldmVudCI6ICIkY2FtcGFpZ25fbGlua19jbGljayIsICJwcm9wZXJ0aWVzIjogeyJ1cmwiOiAiaHR0cHM6Ly9mbHV0dGVyd2F2ZS5jb20iLCAiY2FtcGFpZ25faWQiOiA0MjgzNTQ0LCAidG9rZW4iOiAiZWViMDEwMzQwNGEyODU3ZGVjNGMzMjRkMmYyMTA4YzUiLCAiZGlzdGluY3RfaWQiOiAibWV6ajk3MkBnbWFpbC5jb20iLCAidHlwZSI6ICJlbWFpbCIsICJtZXNzYWdlX2lkIjogOTcxNzY5fX0%3D" title="Visit Flutterwave Website" target="_blank" data-saferedirecturl="https://www.google.com/url?q=https://api.mixpanel.com/track?redirect%3Dhttps%253A%252F%252Fflutterwave.com%26data%3DeyJldmVudCI6ICIkY2FtcGFpZ25fbGlua19jbGljayIsICJwcm9wZXJ0aWVzIjogeyJ1cmwiOiAiaHR0cHM6Ly9mbHV0dGVyd2F2ZS5jb20iLCAiY2FtcGFpZ25faWQiOiA0MjgzNTQ0LCAidG9rZW4iOiAiZWViMDEwMzQwNGEyODU3ZGVjNGMzMjRkMmYyMTA4YzUiLCAiZGlzdGluY3RfaWQiOiAibWV6ajk3MkBnbWFpbC5jb20iLCAidHlwZSI6ICJlbWFpbCIsICJtZXNzYWdlX2lkIjogOTcxNzY5fX0%253D&amp;source=gmail&amp;ust=1569615358007000&amp;usg=AFQjCNFuQL6vWFAHb_Hunp2l7EEsZ-wLHw">
      //                        <img src="https://ci3.googleusercontent.com/proxy/FkrfGbjxIu5ykfMRDV5f0c4B4qpo0pDwkrUWU9KlAq7l0SudfqK1SbJumvzvSUU6c5M=s0-d-e1-ft#https://i.imgur.com/NEGYU4M.png" alt="Flutterwave Logo" style="max-width:100%" class="CToWUd">
      //                      </a>
      //                    </div>
      //                  </center>
      //                </td>
      //              </tr>
      //            </tbody>
      //          </table>
      //        </td>
      //          <tr>
      //          <td>
      //          <center>
      //            <table cellpadding="0" cellspacing="0" width="100%" style="max-width:640px!important">
      //              <tbody>
      //                <tr>
      //                  <td style="padding-bottom:0px;padding-top:50px;padding-right:30px;padding-left:30px">
      //                    <div style="padding-bottom:10px">
      //                      <p style="line-height:24px;padding-top:0px;padding-bottom:15px;font-weight:600;font-size:24px;color:rgb(100,100,100)">
      //                        Hello Mezue,</p>
                           
      //                      <p style="line-height:27px;padding-bottom:14px">
      //                        <font color="#6a6a6a"><span style="font-size:18px"> '.$message.'</span></font>
      //                      </p>
                           
      //                      <table cellpadding="0" cellspacing="0" width="100%" style="max-width:640px!important;margin:0px 0px 25px;border-top:2px solid #2a3a3a;border-bottom:2px solid #2a3a3a">
      //                          <tbody><tr>
      //                              <td width="640" align="left" valign="top" style="max-width:640px!important;padding:15px 5px">
      //                                  <p style="line-height:24px;padding-bottom:0px;margin:0px;text-align:center">
      //                                    <font color="#2a3a3a"><span style="font-size:16px;font-weight:500">Please login to your dashboard to complete the verification process.</span></font></p><p style="line-height:24px;padding-bottom:0px;margin:0px;text-align:center"><font color="#2a3a3a"><span style="font-size:16px;font-weight:500"><br></span></font></p><p style="line-height:24px;padding-bottom:0px;margin:0px;text-align:center"><font color="#2a3a3a"><span style="font-size:16px;font-weight:500"></span></font>&nbsp;
      //                                    <a href='.$link.' title="Reset password" style="color:#ffffff!important;background:#f5a622!important;font-weight:600;font-style:normal;padding:12px 75px;font-size:16px;border-radius:5px;height:20px;line-height:20px;margin-left:2px;margin-right:2px;text-decoration:none!important;word-spacing:1px" target="_blank" data-saferedirecturl='.$link.'>Reset password</a>
      //                                  </p>
      //                              </td>
                                   
                                   
                                   
      //                          </tr>
      //                      </tbody></table>
                           
      //                      <p></p>
      //                      <p style="line-height:27px;padding-bottom:14px">
      //                        <font color="#6a6a6a"><span style="font-size:18px">If you are experiencing difficulties submitting these documents, kindly respond to this email.</span></font><span style="font-size:18px;color:rgb(106,106,106)">&nbsp;</span></p>
      //                      <p style="padding-bottom:14px;font-family:Flutterwave,&quot;Open Sans&quot;,-apple-system,system-ui,&quot;Segoe UI&quot;,Roboto,Oxygen-Sans,Ubuntu,Cantarell,&quot;Helvetica Neue&quot;,system-ui,sans-serif;line-height:27px">
      //                        <font color="#6a6a6a"><span style="font-size:18px">With <img goomoji="2764" data-goomoji="2764" style="margin:0 0.2ex;vertical-align:middle;max-height:24px" alt="❤" src="https://mail.google.com/mail/e/2764" data-image-whitelisted="" class="CToWUd">️,</span></font>
      //                      </p>
      //                      <p style="padding-bottom:14px;font-family:Flutterwave,&quot;Open Sans&quot;,-apple-system,system-ui,&quot;Segoe UI&quot;,Roboto,Oxygen-Sans,Ubuntu,Cantarell,&quot;Helvetica Neue&quot;,system-ui,sans-serif;line-height:27px"><span style="color:rgb(106,106,106);font-size:18px">Flutterwave</span></p>
      //                      <p style="text-align:center;line-height:1.4;padding:30px 10px;margin:50px 0px 20px;border-top:1px solid rgb(219,219,219);border-bottom:1px solid rgb(219,219,219)"><span style="text-align:left"><font color="#5a6a6a"><i>If you are experiencing any issues, please contact us via the following avenues:<br></i></font></span></p>
      //                      <div style="text-align:left">
      //                        <font color="#5a6a6a"><i><em style="font-family:Avenir,Helvetica,sans-serif;text-align:center">&nbsp;</em><span style="color:rgb(63,65,69);font-family:Avenir,Helvetica,sans-serif;font-style:normal"><font color="#5a6a6a"><i>Email: <a href="mailto:hi@flutterwavego.com" target="_blank">hi@flutterwavego.com</a> </i></font></span><span style="color:rgb(63,65,69);font-family:Avenir,Helvetica,sans-serif;font-style:normal"><font color="#5a6a6a"><i>Social Media: <a href="https://api.mixpanel.com/track?redirect=https%3A%2F%2Ftwitter.com%2Ftheflutterwave&amp;data=eyJldmVudCI6ICIkY2FtcGFpZ25fbGlua19jbGljayIsICJwcm9wZXJ0aWVzIjogeyJ1cmwiOiAiaHR0cHM6Ly90d2l0dGVyLmNvbS90aGVmbHV0dGVyd2F2ZSIsICJjYW1wYWlnbl9pZCI6IDQyODM1NDQsICJ0b2tlbiI6ICJlZWIwMTAzNDA0YTI4NTdkZWM0YzMyNGQyZjIxMDhjNSIsICJkaXN0aW5jdF9pZCI6ICJtZXpqOTcyQGdtYWlsLmNvbSIsICJ0eXBlIjogImVtYWlsIiwgIm1lc3NhZ2VfaWQiOiA5NzE3Njl9fQ%3D%3D" target="_blank" data-saferedirecturl="https://www.google.com/url?q=https://api.mixpanel.com/track?redirect%3Dhttps%253A%252F%252Ftwitter.com%252Ftheflutterwave%26data%3DeyJldmVudCI6ICIkY2FtcGFpZ25fbGlua19jbGljayIsICJwcm9wZXJ0aWVzIjogeyJ1cmwiOiAiaHR0cHM6Ly90d2l0dGVyLmNvbS90aGVmbHV0dGVyd2F2ZSIsICJjYW1wYWlnbl9pZCI6IDQyODM1NDQsICJ0b2tlbiI6ICJlZWIwMTAzNDA0YTI4NTdkZWM0YzMyNGQyZjIxMDhjNSIsICJkaXN0aW5jdF9pZCI6ICJtZXpqOTcyQGdtYWlsLmNvbSIsICJ0eXBlIjogImVtYWlsIiwgIm1lc3NhZ2VfaWQiOiA5NzE3Njl9fQ%253D%253D&amp;source=gmail&amp;ust=1569615358008000&amp;usg=AFQjCNENyyloOe2OFpveBn_F3y1Qd7CFpQ">@theflutterwave</a> <a href="https://api.mixpanel.com/track?redirect=https%3A%2F%2Ftwitter.com%2FFlutterwaveHelp&amp;data=eyJldmVudCI6ICIkY2FtcGFpZ25fbGlua19jbGljayIsICJwcm9wZXJ0aWVzIjogeyJ1cmwiOiAiaHR0cHM6Ly90d2l0dGVyLmNvbS9GbHV0dGVyd2F2ZUhlbHAiLCAiY2FtcGFpZ25faWQiOiA0MjgzNTQ0LCAidG9rZW4iOiAiZWViMDEwMzQwNGEyODU3ZGVjNGMzMjRkMmYyMTA4YzUiLCAiZGlzdGluY3RfaWQiOiAibWV6ajk3MkBnbWFpbC5jb20iLCAidHlwZSI6ICJlbWFpbCIsICJtZXNzYWdlX2lkIjogOTcxNzY5fX0%3D" target="_blank" data-saferedirecturl="https://www.google.com/url?q=https://api.mixpanel.com/track?redirect%3Dhttps%253A%252F%252Ftwitter.com%252FFlutterwaveHelp%26data%3DeyJldmVudCI6ICIkY2FtcGFpZ25fbGlua19jbGljayIsICJwcm9wZXJ0aWVzIjogeyJ1cmwiOiAiaHR0cHM6Ly90d2l0dGVyLmNvbS9GbHV0dGVyd2F2ZUhlbHAiLCAiY2FtcGFpZ25faWQiOiA0MjgzNTQ0LCAidG9rZW4iOiAiZWViMDEwMzQwNGEyODU3ZGVjNGMzMjRkMmYyMTA4YzUiLCAiZGlzdGluY3RfaWQiOiAibWV6ajk3MkBnbWFpbC5jb20iLCAidHlwZSI6ICJlbWFpbCIsICJtZXNzYWdlX2lkIjogOTcxNzY5fX0%253D&amp;source=gmail&amp;ust=1569615358008000&amp;usg=AFQjCNESSOEKWz7NyTzolVe9cq6bfPincA">@flutterwavehelp</a>&nbsp;Phone:&nbsp;</i></font></span>+<wbr>23412809030</i></font>
      //                      </div>
      //                      <p></p>
      //                      <p style="font-size:16px;line-height:24px;color:#4a4a4a;padding-top:10px;padding-bottom:0px;text-align:center">
      //                        <a href="https://api.mixpanel.com/track?redirect=https%3A%2F%2Frave.flutterwave.com&amp;data=eyJldmVudCI6ICIkY2FtcGFpZ25fbGlua19jbGljayIsICJwcm9wZXJ0aWVzIjogeyJ1cmwiOiAiaHR0cHM6Ly9yYXZlLmZsdXR0ZXJ3YXZlLmNvbSIsICJjYW1wYWlnbl9pZCI6IDQyODM1NDQsICJ0b2tlbiI6ICJlZWIwMTAzNDA0YTI4NTdkZWM0YzMyNGQyZjIxMDhjNSIsICJkaXN0aW5jdF9pZCI6ICJtZXpqOTcyQGdtYWlsLmNvbSIsICJ0eXBlIjogImVtYWlsIiwgIm1lc3NhZ2VfaWQiOiA5NzE3Njl9fQ%3D%3D" title="Login to Rave" style="color:#ffffff!important;background:#f5a622!important;font-weight:600;font-style:normal;padding:12px 75px;font-size:16px;border-radius:5px;height:20px;line-height:20px;margin-left:2px;margin-right:2px;text-decoration:none!important;word-spacing:1px" target="_blank" data-saferedirecturl="https://www.google.com/url?q=https://api.mixpanel.com/track?redirect%3Dhttps%253A%252F%252Frave.flutterwave.com%26data%3DeyJldmVudCI6ICIkY2FtcGFpZ25fbGlua19jbGljayIsICJwcm9wZXJ0aWVzIjogeyJ1cmwiOiAiaHR0cHM6Ly9yYXZlLmZsdXR0ZXJ3YXZlLmNvbSIsICJjYW1wYWlnbl9pZCI6IDQyODM1NDQsICJ0b2tlbiI6ICJlZWIwMTAzNDA0YTI4NTdkZWM0YzMyNGQyZjIxMDhjNSIsICJkaXN0aW5jdF9pZCI6ICJtZXpqOTcyQGdtYWlsLmNvbSIsICJ0eXBlIjogImVtYWlsIiwgIm1lc3NhZ2VfaWQiOiA5NzE3Njl9fQ%253D%253D&amp;source=gmail&amp;ust=1569615358008000&amp;usg=AFQjCNEuAMemCFxz9dbvhE4AMlTG4nso1w">Go to Rave</a>
      //                      </p>
      //                    </div>
      //                  </td>
      //                </tr>
      //              </tbody>
      //            </table>
      //          </center>
      //        </td>


      //          <tr>
               
      //          <tr>
      //          <tr>
               
      //          <tr>
      //        <tbody>
      //     </table>
      //   <center>
      // </div>
  
      // ',
]);}


public function subscribe(){

  $listAddress = 'subscribe@sandbox782b77014ac840b1b12f34e621802ae1.mailgun.org';
  $mg = Mailgun::create(MAILGUN_KEY);
  $mail="ori@gmial.com";
  $name ='uiuui';
  $result = $mg->mailingList()->member()->create($listAddress,$mail,$name);

}




}




 