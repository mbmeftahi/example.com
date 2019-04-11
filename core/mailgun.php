<?php

require  '../config/keys.php';
# Include the Autoloader (see "Libraries" for install instructions)
require '../vendor/autoload.php';
use Mailgun\Mailgun;

# Instantiate the client.
$mgClient = new Mailgun(MG_KEY);
$domain = MG_DOMAIN;
$from = "Mailgun Sandbox <postmaster@{$domain}>";
$to = 'Mohammad Meftahi <jsnider@microtrain.net>';
$subject = 'Hello Mohammad';
$text = 'Congratulations Mohammad, you just sent an email with Mailgun!'
        . ' You are truly awesome! ';
# Make the call to the client.
$result = $mgClient->sendMessage("$domain",
          array('from'    => $from,
                'to'      => $to,
                'subject' => $subject,
                'text'    => $text
            ));

var_dump($result);
#var_dump ($mgClient);

