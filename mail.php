<?php
session_start();

require_once "Mail.php";  //this includes the pear SMTP mail library
$from = "Password Helper Thing Man <noreply@loki.trentu.ca>";
$to = $_SESSION['resetPW'];  //put user's email here
$subject = "Password being reset";
$body = "don't @ this email, it doesn't go anywhere. your password has been reset to Password1, please log in with it to change it right away" ;
$host = "smtp.trentu.ca";
$headers = array ('From' => $from,
  'To' => $to,
  'Subject' => $subject);
$smtp = Mail::factory('smtp',
  array ('host' => $host));
  
$mail = $smtp->send($to, $headers, $body);
if (PEAR::isError($mail)) {
  echo("<p>" . $mail->getMessage() . "</p>");
 } else {
  echo("<p>Message successfully sent! Please check your inbox for password reset instructions </p>");
 }

?>