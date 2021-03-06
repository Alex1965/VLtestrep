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
    $subject = "Bevestiging van uw aanvraag bij VerweyLetselschade.";
    $emailText = "Bedankt voor uw aanvraag!\r\nEen van onze collega's neemt binnenkort contact met u op!\r\nOnderstaand vindt u uw verstuurde gegevens.\r\n\rMet Vriendelijke groet,\r\nHet Verweyletselschade Team\r\n\r";
    $emailText .= "Verstuurde gegevens:\n\r"; 
   
    
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

    header('Location: http://evaldesite.verweyletselschade.com/success.html');
}
else {
    //error redirect
    header('Location: http://evaldesite.verweyletselschade.com/error.html');
}
