<?php
    $theme_color = '#FFFFFF'; 
    $favicon = array(false, false); 
    /*
        ENTER PATH OF YOUR FAVICON OR UPLOAD FAVICON IN ROOT FOLDER WITH NAME 'favicon.ico' 
        or NO FAVICON WILL BE SET,
        eg: $favicon = array("assets/favicon.png", "png");
    */

    $common_head_tag = ''; //ADD A COMMON HTML <HEAD> TAG HERE FOR ALL PAGES!
    // THIS FESTURE IS GIVEN TO ADD ANY ANALYTIC CODE OR EXTERNAL LINK, CSS ETC.

    $text_accent_heading = "#000000";
    $text_accent_cont = "#000000";

    $universal_library = array(); 
    //All univarsal library should be in Array


    $site_title = "Pranah Backend"; 
    //This will be used by Framework and external Library will be able to reach it.
    
    $webdomain = "http://192.168.43.53/pranah";
    $webapp = false; //ENTER true if you are building webapp, else false. If you are not building webapp then you can delete 'menifest.webmenifest' file from dir.
    $yugal_enable_spa = false;
    //TRUE IF YOU WANT TO USE SPA FEATURE IN IT.

    $gmail_username = "noreply.pranah@gmail.com";
    $gmail_password = "do you think you'll get real password here?";
    $gmail_from = $gmail_username;
    //MYSQL / MARIADB DETAIL FOR EACH PAGE
    //OPTIONAL, IGNORE, EDIT,DELETE DO WHATEVER YOU WANT.
    $server = 'localhost'; 
    $user = 'root'; 
    $pass = ''; 
    $db = 'pranah'; 
    //END OF MYSQL / MARIA DB CREDENTIALS, NOW YOU CAN USE THESE VARIABLE FOR DB CONNECTIONS AND USAGE.
    function connect(){
        global $server;
        global $user;
        global $pass;
        global $db;
        return mysqli_connect($server, $user, $pass, $db);
    }
?>
