<?php
// filepath: c:\Apache24\htdocs\IAP\testmail.php

require_once 'ClassAutoLoad.php';

$mail = new SendMail();
$mail->sendTestEmail('Test User', 'richard.arnold@strathmore.edu');