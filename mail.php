<?php

define('MAILGUN_KEY','284c135f4e519d546f64df153090b8d6-9b463597-571dfbf6');
define('MAILGUN_PUBKEY', 'pubkey-5171366a26a4546b3530ac13e442ac6f');

define('DOMAIN', 'sandbox782b77014ac840b1b12f34e621802ae1.mailgun.org');
require 'vendor/autoload.php';

$mailgun = new Mailgun\Mailgun(MAILGUN_KEY); #endregion
$validate = new  Mailgun\Mailgun(MAILGUN_PUBKEY); #endregion

 