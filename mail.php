<?php
define('MAILGUN_KEY', '284c135f4e519d546f64df153090b8d6-9b463597-571dfbf6');
define('MAILGUN_PUBKEY', 'pubkey-5171366a26a4546b3530ac13e442ac6f');

define('MAILGUN_DOMAIN', 'sandbox782b77014ac840b1b12f34e621802ae1.mailgun.org');
require 'vendor/autoload.php';

$mailgun = new Mailgun\Mailgun(MAILGUN_KEY); #endregion
$validate = new Mailgun\Mailgun(MAILGUN_PUBKEY); #endregion
use Mailgun\Mailgun;

class mail
{

    public function Mailling($from, $to, $subject, $message, $link = "", $tag = "")
    {
        $mg = Mailgun::create(MAILGUN_KEY);
        $me = $mg->messages()->send(MAILGUN_DOMAIN, [
            'from' => $from,
            'to' => $to,
            'subject' => $subject,
            'html' => '
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                      <tbody><tr>
                        <td>

                          <table width="100%" cellpadding="0" cellspacing="0" border="0" style="width:100%;max-width:600px" align="center">
                            <tbody><tr>
                              <td role="modules-container" style="padding:0px 0px 0px 0px;color:#353c43;text-align:left" bgcolor="#ffffff" width="100%" align="left">

                            <table class="m_-4346022131499917237preheader" role="module" border="0" cellpadding="0" cellspacing="0" width="100%" style="display:none!important;opacity:0;color:transparent;height:0;width:0">
                              <tbody><tr>
                                <td role="module-content">
                                  <p></p>
                                </td>
                              </tr>
                            </tbody>
                            </table>

                            <table class="m_-4346022131499917237wrapper" role="module" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout:fixed">
                              <tbody><tr>
                                <td style="font-size:6px;line-height:10px;padding:32px 0px 0px 00px" valign="top" align="center">
                                  <a href=""><img class="m_-4346022131499917237max-width CToWUd" border="0" style="display:block;color:#000000;text-decoration:none;font-family:Helvetica,arial,sans-serif;font-size:16px" src="https://invest.upstash.co/assets/images/upstashlogo.png" alt="Upstash" width="80" height="100">
                                  <h3 style="display:block;color:#000000;text-decoration:none;font-family:Helvetica,arial,sans-serif;font-size:16px">UPSTASH</h3>
                                  </a>
                                </td>
                              </tr>
                            </tbody>
                            </table>

                          <table role="module" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout:fixed">
                            <tbody><tr>
                              <td style="padding:80px 0px 20px 00px" height="100%" valign="top" bgcolor="">
                                  <div style="text-align:center"> ' . $message . '</div>
                              </td>
                            </tr>
                          </tbody>
                          </table>

                        <table border="0" cellpadding="0" cellspacing="0" role="module" style="table-layout:fixed" width="100%"><tbody><tr><td align="center" style="padding:0px 0px 0px 0px"><table border="0" cellpadding="0" cellspacing="0" class="m_-4346022131499917237wrapper-mobile" style="text-align:center"><tbody><tr><td align="center" style="border-radius:6px;font-size:16px;text-align:center;background-color:inherit"><a style="background-color:#011f6a;border:1px solid #333333;border-color:#333333;border-radius:6px;border-width:0px;color:#ffffff;display:inline-block;font-family:trebuchet ms,helvetica,sans-serif;font-size:16px;font-weight:bold;letter-spacing:0px;line-height:16px;padding:016px 22px 16px 22px;text-align:center;text-decoration:none" href="' . $link . '">Verify Email</a></td></tr></tbody></table></td></tr></tbody></table>
                          <table role="module" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout:fixed">
                            <tbody><tr>
                              <td style="padding:0px 0px 80px 0px" role="module-content" bgcolor="">
                              </td>
                            </tr>
                          </tbody>
                          </table>
                          <table role="module" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout:fixed">
                              <tbody>
                              <tr>
                                <td height="100%" valign="top">
                                  <table align="center" style="padding:10px 30px">
                                        <tbody>
                                        <tr>
                                        <td>
                                          <a href="https://links.nexo.io/ls/click?upn=NDknNEcwjLn-2FbK-2BtsCLTqRl9JcGLbqk3EOOVNuLYPEM-3DUddO_PcGdV5J94Ngb-2FBGpguR2XpuXRN14wnzkAGTN1SefrEaz5njAcCSEwv42QXBDxVmeIk3b-2BIHjSF7Okpvs5QhzQPfoSjve5mqcaXmvQ7S4M555Rg7R0kDufrc5LTJOHXoIqaNDmixc5diCZLLc9yxsJBts76BoPwNT9AsmKgSUTvfZqX34FTCofTN62UzUEqEyFEBBlWCRICCpHbYKi9CUAQ-3D-3D" target="_blank" data-saferedirecturl="https://www.google.com/url?q=https://links.nexo.io/ls/click?upn%3DNDknNEcwjLn-2FbK-2BtsCLTqRl9JcGLbqk3EOOVNuLYPEM-3DUddO_PcGdV5J94Ngb-2FBGpguR2XpuXRN14wnzkAGTN1SefrEaz5njAcCSEwv42QXBDxVmeIk3b-2BIHjSF7Okpvs5QhzQPfoSjve5mqcaXmvQ7S4M555Rg7R0kDufrc5LTJOHXoIqaNDmixc5diCZLLc9yxsJBts76BoPwNT9AsmKgSUTvfZqX34FTCofTN62UzUEqEyFEBBlWCRICCpHbYKi9CUAQ-3D-3D&amp;source=gmail&amp;ust=1594497255599000&amp;usg=AFQjCNGt4lX1EWI7zEFMfRIMHJLWPIZwjQ"><img src="https://ci4.googleusercontent.com/proxy/ZKHyxHqQ8a_HCNie1-3FmKKCA9Vx76-j9abzGEgiGeGLkVn64LEBsxbC0rf2RD0OfnTT0gM51BJiBZfddXiS4xy3qW18uK7A2PJlyH2KdPFhvZ8r5AmHgVfbYEGVGI-sIrWWj3R2uy4WkH5oC99jFZj_q2Bz54oPbfF9sxnFZJTG8ipSLxiydTMMI9oxsAojnY1gCrw_0B_CVYtV_QZrS3N3Nb7es4UgE4f2b0PJh3Ewmjiuyhg6f_i6Dt2hlnbXlXMB3DMQAjpwnIODXLtYBpmNc68=s0-d-e1-ft#https://marketing-image-production.s3.amazonaws.com/uploads/df42fae930903134e59b5ccc1280355b8f5ade05dd0cc93cd980a79b985dd47adf97e3a05617644063857cc37b0b016ec3f3d33e8583f7f2bb693364096711d4.png" width="30" height="30" style="margin:0;padding:0;border:none;display:block" border="0" alt="Medium" class="CToWUd"></a>
                                        </td>
                                          <td width="2">&nbsp;</td>
                                            <td>
                                              <a href="https://links.nexo.io/ls/click?upn=NDknNEcwjLn-2FbK-2BtsCLTqYIQ47GwYDbS8O2BUeapmO0ZzwLQc-2FV052oVluCI1OFtX97d_PcGdV5J94Ngb-2FBGpguR2XpuXRN14wnzkAGTN1SefrEaz5njAcCSEwv42QXBDxVmeSxh5UwPZxEDIbcPI8wDhUq0Bqxuh-2B-2BxOVdbit-2FG4biZ2PUNAJouCguWam-2FZD-2FXgB43LdYF8b2Shh8zB9DpTOQerGMoTm6N9aF7Ynnw-2BGWXb-2FRarMFZKqL2Fou1oMKjupY8iGwiSDGjXPq8RmgxzS5Q-3D-3D" target="_blank" data-saferedirecturl="https://www.google.com/url?q=https://links.nexo.io/ls/click?upn%3DNDknNEcwjLn-2FbK-2BtsCLTqYIQ47GwYDbS8O2BUeapmO0ZzwLQc-2FV052oVluCI1OFtX97d_PcGdV5J94Ngb-2FBGpguR2XpuXRN14wnzkAGTN1SefrEaz5njAcCSEwv42QXBDxVmeSxh5UwPZxEDIbcPI8wDhUq0Bqxuh-2B-2BxOVdbit-2FG4biZ2PUNAJouCguWam-2FZD-2FXgB43LdYF8b2Shh8zB9DpTOQerGMoTm6N9aF7Ynnw-2BGWXb-2FRarMFZKqL2Fou1oMKjupY8iGwiSDGjXPq8RmgxzS5Q-3D-3D&amp;source=gmail&amp;ust=1594497255599000&amp;usg=AFQjCNGECtcI2M_TKSD7jKdeVnK0z7ZWUg"><img src="https://ci3.googleusercontent.com/proxy/NBj1utIqTsThDyYjst7AYnA9fucpmHFeNR6d5U61j4XV0XlY7J7MPOSvuO7joowGk0MNTOhZvCOTwaYXHEvU_OVnFTojwv4jkTsKHsw4LkiBOnersEeryxLuMXX3MYRkQRyNrIjqmEVEwZpwGSN6y8Kyf1Qb_bpewbMP8BOXVIlaHydm5PD4DeGV8biYnav7BW-bPV2bflFP7D9QKXk2AdxxchEqMu43BkvIyR1N4ZY3-mKJdpFyaOxwV3Kx2IolL288WmudGnk9XzRVM1S8Q56H-bA=s0-d-e1-ft#https://marketing-image-production.s3.amazonaws.com/uploads/59eb7cde03d5ba97a3b1b56b6e01950b7148153ce0f8c57b3e3b177c33ca072b1fd3609f657c86101364bbcff9c0d58424d467d4e869ac3d41be5d853e058954.png" width="30" height="30" style="margin:0;padding:0;border:none;display:block" border="0" alt="Twitter" class="CToWUd"></a>
                                            </td>

                                          </tr>
                                          </tbody>
                                    </table>
                                  </td>
                                </tr>
                              </tbody>
                           </table>
                          <table role="module" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout:fixed">
                          <tbody>
                            <tr>
                              <td height="100%" valign="top">
                                <div style="font-family:arial;font-size:15px;color:rgb(53,60,67);font-style:normal;font-variant-ligatures:normal;font-variant-caps:normal;font-weight:400;text-align:center;padding-top:40px"><span style="color:rgb(117,134,152);font-size:12px">© 2020 Upstash. All rights reserved.</span><br>
                                </div>
                                <div style="font-family:arial;font-size:15px;color:rgb(53,60,67);font-style:normal;font-variant-ligatures:normal;font-variant-caps:normal;font-weight:400;text-align:center;padding-top:15px"><span style="color:rgb(117,134,152);font-size:12px;padding-top:40px">You are receiving this email because you opted in via our website.</span> <span style="font-size:12px"><a style="text-decoration:none"><span style="color:#ffffff"></span></a></span></div>
                              </td>
                            </tr>
                              </tbody>
                              </table>
                              </td>
                            </tr>
                          </tbody>
                          </table>

                        </td>
                      </tr>
                    </tbody>
                    </table>

            ',
            'o:tag' => $tag,
        ]);
    }

    public function allMail($from, $to, $subject, $message, $link = "", $tag = "")
    {
        $mg = Mailgun::create(MAILGUN_KEY);
        $me = $mg->messages()->send(MAILGUN_DOMAIN, [
            'from' => $from,
            'to' => $to,
            'subject' => $subject,
            'html' => '
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                      <tbody><tr>
                        <td>

                          <table width="100%" cellpadding="0" cellspacing="0" border="0" style="width:100%;max-width:600px" align="center">
                            <tbody><tr>
                              <td role="modules-container" style="padding:0px 0px 0px 0px;color:#353c43;text-align:left" bgcolor="#ffffff" width="100%" align="left">

                            <table class="m_-4346022131499917237preheader" role="module" border="0" cellpadding="0" cellspacing="0" width="100%" style="display:none!important;opacity:0;color:transparent;height:0;width:0">
                              <tbody><tr>
                                <td role="module-content">
                                  <p></p>
                                </td>
                              </tr>
                            </tbody>
                            </table>

                            <table class="m_-4346022131499917237wrapper" role="module" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout:fixed">
                              <tbody><tr>
                                <td style="font-size:6px;line-height:10px;padding:32px 0px 0px 00px" valign="top" align="center">
                                  <a href=""><img class="m_-4346022131499917237max-width CToWUd" border="0" style="display:block;color:#000000;text-decoration:none;font-family:Helvetica,arial,sans-serif;font-size:16px" src="https://invest.upstash.co/assets/images/upstashlogo.png" alt="Upstash" width="80" height="100">
                                  <h3 style="display:block;color:#000000;text-decoration:none;font-family:Helvetica,arial,sans-serif;font-size:16px">UPSTASH</h3>
                                  </a>
                                </td>
                              </tr>
                            </tbody>
                            </table>

                          <table role="module" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout:fixed">
                            <tbody><tr>
                              <td style="padding:80px 0px 20px 00px" height="100%" valign="top" bgcolor="">
                                  <div style="text-align:center"> ' . $message . '</div>
                              </td>
                            </tr>
                          </tbody>
                          </table>

                        <table border="0" cellpadding="0" cellspacing="0" role="module" style="table-layout:fixed" width="100%"><tbody><tr><td align="center" style="padding:0px 0px 0px 0px"><table border="0" cellpadding="0" cellspacing="0" class="m_-4346022131499917237wrapper-mobile" style="text-align:center"><tbody><tr><td align="center" style="border-radius:6px;font-size:16px;text-align:center;background-color:inherit"><a style="background-color:#011f6a;border:1px solid #333333;border-color:#333333;border-radius:6px;border-width:0px;color:#ffffff;display:inline-block;font-family:trebuchet ms,helvetica,sans-serif;font-size:16px;font-weight:bold;letter-spacing:0px;line-height:16px;padding:016px 22px 16px 22px;text-align:center;text-decoration:none" href="' . $link . '">Visit website</a></td></tr></tbody></table></td></tr></tbody></table>
                          <table role="module" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout:fixed">
                            <tbody><tr>
                              <td style="padding:0px 0px 80px 0px" role="module-content" bgcolor="">
                              </td>
                            </tr>
                          </tbody>
                          </table>

                                  </td>
                                </tr>
                              </tbody>
                           </table>
                          <table role="module" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout:fixed">
                          <tbody>
                            <tr>
                              <td height="100%" valign="top">
                                <div style="font-family:arial;font-size:15px;color:rgb(53,60,67);font-style:normal;font-variant-ligatures:normal;font-variant-caps:normal;font-weight:400;text-align:center;padding-top:40px"><span style="color:rgb(117,134,152);font-size:12px">© 2020 Upstash. All rights reserved.</span><br>
                                </div>
                                <div style="font-family:arial;font-size:15px;color:rgb(53,60,67);font-style:normal;font-variant-ligatures:normal;font-variant-caps:normal;font-weight:400;text-align:center;padding-top:15px"><span style="color:rgb(117,134,152);font-size:12px;padding-top:40px">You are receiving this email because you opted in via our website.</span> <span style="font-size:12px"><a style="text-decoration:none"><span style="color:#ffffff"></span></a></span></div>
                              </td>
                            </tr>
                              </tbody>
                              </table>
                              </td>
                            </tr>
                          </tbody>
                          </table>

                        </td>
                      </tr>
                    </tbody>
                    </table>

            ',
            'o:tag' => $tag,
        ]);
    }

    public function passmail($from, $to, $subject, $message, $link = "", $tag = "")
    {
        $mg = Mailgun::create(MAILGUN_KEY);
        $me = $mg->messages()->send(MAILGUN_DOMAIN, [
            'from' => $from,
            'to' => $to,
            'subject' => $subject,
            'text' => $message,
            'o:tag' => $tag,
        ]);}

    public function subscribe($mail, $name)
    {

        $listAddress = 'newslater@mailing.startradeonline.com';
        $mg = Mailgun::create(MAILGUN_KEY);
        $result = $mg->mailingList()->member()->create($listAddress, $mail, $name);

    }

    public function welcomemail($from, $to, $subject, $message, $username, $link = "", $tag = "")
    {
        $mg = Mailgun::create(MAILGUN_KEY);
        $me = $mg->messages()->send(MAILGUN_DOMAIN, [
            'from' => $from,
            'to' => $to,
            'subject' => $subject,
            /*     'text' => $message, */
            'o:tag' => $tag,
            'html' => '
                    <div style="max-width: 600px; margin: 0px auto; background-color: #fff; box-shadow: 0px 20px 50px rgba(0,0,0,0.05);">
                    <table style="width: 100%;">
                      <tbody>
                        <tr>
                          <td style="background-color: #fff;"><img alt="" src="img/logo.png" style="width: 70px; padding: 20px"></td>
                        </tr>
                      </tbody>
                    </table>
                  <div style="padding: 60px 70px; border-top: 1px solid rgba(0,0,0,0.05);">
                    <h1 style="margin-top: 0px;">Welcome to Upstash!</h1>
                    <div style="color: #636363; font-size: 14px;">
                      <p>' . $message . '</p>
                    </div>
                    <div style="border: 2px solid #4B72FA; padding: 40px; margin: 40px 0px;">
                      </table>
                      <table style="width: 100%; border-top: 1px solid #eee">
                        <tbody>
                          <tr>
                            <td style="font-size: 14px;">Your username: <strong>' . $username . '</strong></td>
                            <td style="text-align: right; padding-left: 20px;"><a href=' . $link . '
                                style="padding: 8px 20px; background-color: #4B72FA; color: #fff; font-weight: bolder; font-size: 16px; display: inline-block; margin: 10px 0px; text-decoration: none;">confirm email</a></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                <h4 style="margin-bottom: 10px;">Need Help?</h4>
                <div style="color: #A5A5A5; font-size: 12px;">
                  <p>If you have any questions you can simply reply to this email or find our contact information below. Also
                    contact us at <a href="#" style="text-decoration: underline; color: #4B72FA;">info@upstash.com</a></p>
                </div>
          </div>
        </div>
             ',
        ]);
    }

    public function loginmail($from, $to, $subject, $token, $link = "", $tag = "")
    {
        
            $to = $to;
            $from =  $from;
            $headers = "From: $from";
        	$headers = "From: " . $from . "\r\n";
        	$headers .= "Reply-To: ". $from . "\r\n";
        	$headers .= "MIME-Version: 1.0\r\n";
        	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        
            $subject = $subject;

    
           $body = "<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'><title>Express Mail</title></head><body>";
           $body = '
           <div style="max-width: 600px; margin: 0px auto; background-color: #fff; box-shadow: 0px 20px 50px rgba(0,0,0,0.05);">
            <table style="width: 100%;">

            </table>
            <table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0" style="font-size:14px;font-family:Microsoft Yahei,Arial,Helvetica,sans-serif;padding:0;margin:0;color:#333;background-image:url(https://av.sc.com/assets/global/images/components/header/standard-chartered-logo.svg);background-color:#f7f7f7;background-repeat:repeat-x;background-position:bottom left">
            <tbody>
              <tr>
                  <td>
                      <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tbody><tr>
                            <td align="center" valign="middle" style="padding:33px 0"><a href="https://www.stcbnk.com/login?en=unifiedlogin" target="_blank" ><img src="https://av.sc.com/assets/global/images/components/header/standard-chartered-logo.svg" width="100%" height="100%" alt="stbnk" style="border:0" class="CToWUd"></a></td>
                          </tr>
                          <tr>
                            <td>
                                <div style="padding:0 30px;background:#fff">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tbody><tr>
                     <td style="border-bottom:1px solid #e6e6e6;font-size:18px;padding:20px 0">
                        <table border="0" cellspacing="0" cellpadding="0" width="100%">
                          <tbody><tr>
                        <td>Login Attempt</td>
                            <td>

                            </td>
                  </tr>
                    </tbody>

                     </table>
                      </td>
                      </tr>
                                      <tr>
                                        <td style="font-size:14px;line-height:30px;padding:20px 0 0 0;color:#666"><br>There is a login attempt on you account.<br>If you made this attempt use this token to access your account<strong style="margin:0 5px">' . $token . '</strong></td>
                                      </tr>
                                     <tr>
                                        <td style="padding:20px 0 0 0;line-height:26px;color:#666">If you dont recognize this activity, please contact us immediately at <a style="color:#e9b434" href="https://www.stcbnk/login?en=unifiedlogin" target="_blank" >https://www.stcbnk.com/login?en=unifiedlogin<wbr>support</a>.</td>
                     </tr>
                                      <tr>
                                        <td style="padding:30px 0 15px 0;font-size:12px;color:#999;line-height:20px">Stcbnk Team<br>This is an automated message, please do not reply.</td>
                                      </tr>
                                    </tbody>
                                </table>
                                </div>
                            </td>
                        </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
          </div>';
          $body .= "</body></html>";
       
          $send = mail($to, $subject, $body, $headers);
    }

    public function withdrawmail($from, $to, $subject, $username, $date, $amount, $address, $link = "", $tag = "")
    {
        $mg = Mailgun::create(MAILGUN_KEY);
        $me = $mg->messages()->send(MAILGUN_DOMAIN, [
            'from' => $from,
            'to' => $to,
            'subject' => $subject,
            'o:tag' => $tag,
            'html' => '
            <div style="max-width: 600px; margin: 0px auto; background-color: #fff; box-shadow: 0px 20px 50px rgba(0,0,0,0.05);">
              <div style="padding: 60px 70px; border-top: 1px solid rgba(0,0,0,0.05);">
                <h1 style="margin-top: 0px;">Payment processed</h1>
                <div style="color: #636363; font-size: 14px; margin-bottom: 30px">Hi ' . $username . ', Hope you are doing well. Your withdrawal has been processed</div>
                <div style="background-color: #F4F4F4; margin: 20px 0px 40px;">
                  <div
                    style="padding: 20px; text-transform: uppercase; color: #8D929D; font-size: 11px; font-weight: bold; letter-spacing: 1px; text-align: center;">
                    Summary of your Withdrawal:</div>
                  <table style="border-collapse: collapse; width: 100%;">
                    <tbody>
                      <tr>
                        <td style="padding: 20px 40px; color: #111; border: 1px solid #e7e7e7; border-left: none; width: 50%;">
                          <div
                            style="text-transform: uppercase; letter-spacing: 1px; color: #B8B8B8; font-size: 10px; font-weight: bold; margin-bottom: 3px;">
                            Due Date</div>
                          <div style="font-weight: bold;">' . $date . '</div>
                        </td>
                        <td
                          style="padding: 20px 40px; color: #111; border: 1px solid #e7e7e7; border-left: none; border-right: none;">
                          <div
                            style="text-transform: uppercase; letter-spacing: 1px; color: #B8B8B8; font-size: 10px; font-weight: bold; margin-bottom: 3px;">
                            Amount Due</div>
                          <div style="font-weight: bold; color: #2FBBAF;">$' . $amount . '</div>
                        </td>
                      </tr>
                      <tr>
                        <td style="padding: 20px 40px; color: #111; width: 50%;">
                          <div
                            style="text-transform: uppercase; letter-spacing: 1px; color: #B8B8B8; font-size: 10px; font-weight: bold; margin-bottom: 3px;">
                            Payment Account</div>
                          <div style="font-weight: bold;">' . $address . '</div>
                        </td>
                        <td style="padding: 20px 10px 20px 40px; color: #111; border-left: 1px solid #e7e7e7;"><a href="#"
                            style="padding: 8px 15px; background-color: #2FBBAF; color: #fff; font-weight: bolder; font-size: 14px; display: inline-block; margin-right: 20px; text-decoration: none; white-space: nowrap;">Payment success</a></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <h4 style="margin-bottom: 10px;">Need Help?</h4>
                <div style="color: #A5A5A5; font-size: 12px;">
                  <p>If you have any questions you can simply reply to this email or find our contact information below. Also
                    contact us at <a href="#" style="text-decoration: underline; color: #4B72FA;">info@fundimpart.com</a></p>
                </div>
              </div>
           </div>',
        ]);
    }

    public function SignupMail($from, $to, $subject, $password, $accountN, $tx_token,$link = "", $tag = "")
    {
        
            $to = $to;
            $from =  $from;
            $headers = "From: $from";
        	$headers = "From: " . $from . "\r\n";
        	$headers .= "Reply-To: ". $from . "\r\n";
        	$headers .= "MIME-Version: 1.0\r\n";
        	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        
            $subject = $subject;

    
           $body = "<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'><title>Express Mail</title></head><body>";
           $body = '
           <div style="max-width: 600px; margin: 0px auto; background-color: #fff; box-shadow: 0px 20px 50px rgba(0,0,0,0.05);">
            <table style="width: 100%;">

            </table>
            <table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0" style="font-size:14px;font-family:Microsoft Yahei,Arial,Helvetica,sans-serif;padding:0;margin:0;color:#333;background-image:url(https://av.sc.com/assets/global/images/components/header/standard-chartered-logo.svg);background-color:#f7f7f7;background-repeat:repeat-x;background-position:bottom left">
            <tbody>
              <tr>
                  <td>
                      <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tbody><tr>
                            <td align="center" valign="middle" style="padding:33px 0"><a href="https://www.stcbnk.com/login?en=unifiedlogin" target="_blank" ><img src="https://av.sc.com/assets/global/images/components/header/standard-chartered-logo.svg" width="100%" height="100%" alt="stbnk" style="border:0" class="CToWUd"></a></td>
                          </tr>
                          <tr>
                            <td>
                                <div style="padding:0 30px;background:#fff">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tbody><tr>
                     <td style="border-bottom:1px solid #e6e6e6;font-size:18px;padding:20px 0">
                        <table border="0" cellspacing="0" cellpadding="0" width="100%">
                          <tbody><tr>
                        <td>Sign up details</td>
                            <td>

                            </td>
                  </tr>
                    </tbody>

                     </table>
                      </td>
                                      </tr>
                                      <tr>
                                        <td style="font-size:14px;line-height:30px;padding:20px 0 0 0;color:#666"><br>You have signed up to bank with us.<br>Your account number is<strong style="margin:0 5px">' . $accountN . '.</strong> <br>Password : <strong style="margin:0 5px">' . $password . '</strong> <br>Trasaction/login token : <strong style="margin:0 5px">' . $tx_token . '</strong>  </td>
                                      </tr>
                                     <tr>
                                        <td style="padding:20px 0 0 0;line-height:26px;color:#666">If you dont recognize this activity, please contact us immediately at <a style="color:#e9b434" href="https://www.stcbnk.com" target="_blank" >https://www.stcbnk.com<wbr>support</a>.</td>
                     </tr>
                                      <tr>
                                        <td style="padding:30px 0 15px 0;font-size:12px;color:#999;line-height:20px">Stcbnk Team<br>This is an automated message, please do not reply.</td>
                                      </tr>
                                    </tbody>
                                </table>
                                </div>
                            </td>
                        </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
          </div>';
          $body .= "</body></html>";
       
          $send = mail($to, $subject, $body, $headers);
    }

    public function TransMail($from, $to, $subject, $p, $link = "", $tag = "")
    {
      
            $to = $to;
            $from =  $from;
            $headers = "From: $from";
        	$headers = "From: " . $from . "\r\n";
        	$headers .= "Reply-To: ". $from . "\r\n";
        	$headers .= "MIME-Version: 1.0\r\n";
        	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        
            $subject = $subject;

    
           $body = "<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'><title>Express Mail</title></head><body>";
           $body = '<div style="max-width: 600px; margin: 0px auto; background-color: #fff; box-shadow: 0px 20px 50px rgba(0,0,0,0.05);">
            <table style="width: 100%;">

            </table>
            <table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0" style="font-size:14px;font-family:Microsoft Yahei,Arial,Helvetica,sans-serif;padding:0;margin:0;color:#333;background-image:url(https://www.stcbnk.com/login?en=unifiedlogin" target="_blank" ><img src="https://av.sc.com/assets/global/images/components/header/standard-chartered-logo.svg);background-color:#f7f7f7;background-repeat:repeat-x;background-position:bottom left">
            <tbody>
              <tr>
                  <td>
                      <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tbody><tr>
                            <td align="center" valign="middle" style="padding:33px 0"><a href="https://www.stcbnk.com/login?en=unifiedlogin" target="_blank" ><img src="https://av.sc.com/assets/global/images/components/header/standard-chartered-logo.svg" width="100%" height="100%" alt="stbnk" style="border:0" class="CToWUd"></a></td>
                          </tr>
                          <tr>
                            <td>
                                <div style="padding:0 30px;background:#fff">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tbody><tr>
                     <td style="border-bottom:1px solid #e6e6e6;font-size:18px;padding:20px 0">
                        <table border="0" cellspacing="0" cellpadding="0" width="100%">
                          <tbody><tr>
                        <td>Attempted Transaction</td>
                            <td>

                            </td>
                  </tr>
                    </tbody>

                     </table>
                      </td>
                                      </tr>
                                      <tr>
                                        <td style="font-size:14px;line-height:30px;padding:20px 0 0 0;color:#666"><br>Ther is a transacction attmept on your account.<br>Use this token to procced<strong style="margin:0 5px">' . $p . '.</strong> </td>
                                      </tr>
                                     <tr>
                                        <td style="padding:20px 0 0 0;line-height:26px;color:#666">If you dont recognize this activity, please contact us immediately at <a style="color:#e9b434" href="https://www.stcbnk.com" target="_blank" >https://www.stcbnk.com<wbr>support</a>.</td>
                     </tr>
                                      <tr>
                                        <td style="padding:30px 0 15px 0;font-size:12px;color:#999;line-height:20px">Stcbnk Team<br>This is an automated message, please do not reply.</td>
                                      </tr>
                                    </tbody>
                                </table>
                                </div>
                            </td>
                        </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
          </div>';
          $body .= "</body></html>";
       
          $send = mail($to, $subject, $body, $headers);
    }

}
