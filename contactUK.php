<?php
/*
 * A.Jaspers 2020
 */
$from = 'contact@verweyletselschade.com';
$sendTo = 'info@verweyletselschade.com';
$subject = 'New message from contact form';
$fields = array('name' => 'Name','phone' => 'Phone', 'email' => 'Email','subject' => 'Subject','message' => 'Message'); 
// if you are not debugging and don't need error reporting, turn this off by error_reporting(0);
error_reporting(0);

try
{

    if(count($_POST) == 0) throw new \Exception('Form is empty');
            
    $emailText = "You have a new message from your contact form\n=============================\n";

    foreach ($_POST as $key => $value) {
        if (isset($fields[$key])) {
            $emailText .= "$fields[$key]: $value\n";
        }
   
    }

    //headers for the email.
    $headers = array('Content-Type: text/plain; charset="UTF-8";',
        'From: ' . $from,
        'Reply-To: ' . $from,
        'Return-Path: ' . $from,
    );
    
    // Send email to info@verweyletselschade.com
    mail($sendTo, $subject, $emailText, implode("\n", $headers));
        
    //and to the sender
    $sendTo = $_POST['email']; 
    $from = 'info@verweyletselschade.com';
    $subject = "Confirmation of your request at VerweyLetselschade.";
    $emailText = "Thank you for getting in touch with us!\r\nOne of our colleagues will contact you soon!\r\nBelow you find the information you provided.\r\n\rKind Regards,\r\nThe Verweyletselschade Team\r\n\r";
    $emailText .= "provided information:\n\r"; 
   
    
    foreach ($_POST as $key => $value) {
        if (isset($fields[$key])) {
            $emailText .= "$fields[$key]: $value\n";
        }
    }
    $headers = array('Content-Type: text/plain; charset="UTF-8";',
        'From: ' . $from,
        'Reply-To: ' . $from,
        'Return-Path: ' . $from,
    );
    mail($sendTo, $subject, $emailText, implode("\n", $headers));

    


    $responseArray = array('type' => 'success', 'message' => $okMessage);


}
catch (\Exception $e)
{
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}

if ($responseArray['type'] == 'success') {
    // success redirect

    header('Location: http://evaldesite.verweyletselschade.com/successUK.html');
}
else {
    //error redirect
    header('Location: http://evaldesite.verweyletselschade.com/error.html');
}
