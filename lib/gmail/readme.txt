# gmail
Send Mail via a GMAIL account in TMINC PHP EXTENSION.
Import this Library on the Page where you want to use it by PHP EXTENSION meta() function.
Open string.php file in root directory and
 Define variables as of below.
    $gmail_username = "-- YOUR GMAIL ID --";
    $gmail_password = "-- YOUR GMAIL PASSWORD --";
    $gmail_from = "-- SET FROM MAIL --";
    FROM MAIL: This will be visible to mail recievers af "From" mail.
    
    
   #How to send Mail?
   After importing, use gmai() function to send mail.
   Parameters in gmail()
   gmail("--TO / RECIEVERS E-MAIL ADDRESS --", "-- MAIL SUBJECT --", "-- MAIL BODY (Can accept HTML)--");
   
   If Mail is sent, this function will return true, if mail is not sent due to some reason, this function will return false so that you can use it like normal mail() funtion.
   for eg:
    if (gmail($to, $subject, $body)){
     echo "Mail Sent";
    }else{
     echo "Mail Not sent";
    }
   
   You can delete this file, if you know how to use this Library.
   
