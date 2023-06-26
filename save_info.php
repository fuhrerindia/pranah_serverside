<?php
    include('modules/tminc.php');
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Access-Control-Allow-Origin: *");

    $data = array(
        "mail"=>clean($_POST['mail']),
        "pass"=>md5(base64_decode($_POST['pass'])),
        "name"=>$_POST['name'],
        "username"=>cleanWithSpaces($_POST['username']),
        "bio"=>$_POST['bio']
    );

    if ($con = connect()){
        mysqli_set_charset($con, 'utf8');
        $uveri = "UPDATE `users` SET `name` = '{$data['name']}', `username`='{$data['username']}', `bio`='{$data['bio']}' WHERE `mail` LIKE '{$data['mail']}' AND `password` LIKE '{$data['pass']}'";
        if ($call = mysqli_query($con, $uveri)){
            echo "true";
        }else{
            echo "error";
        }
    }else{
        echo "error";
    }
?>