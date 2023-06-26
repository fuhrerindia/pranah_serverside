<?php
    //CONNECTING TO SOUL
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Access-Control-Allow-Origin: *");
    include('modules/tminc.php');

    $username = array(
        "mail"=>clean($_POST['mail']),
        "pass"=>md5(base64_decode($_POST['pass']))
    );
    $follId = clean(base64_decode($_POST['follId']));

    if ($con = connect()){
        $ver = "SELECT * FROM `users` WHERE `mail` LIKE '{$username['mail']}' AND `password` LIKE '{$username['pass']}'";
        if ($call = mysqli_query($con, $ver)){
            if (0 < mysqli_num_rows($call)){
                $update = "UPDATE `follow` SET `request` = 'false' WHERE `id` LIKE '{$follId}' AND `following` LIKE '{$username['mail']}'";
                if ($updated = mysqli_query($con, $update)){
                    date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)
                    $current_time = date('d/m/Y H:i');
                    $act_add_sql = "INSERT INTO `activity`(`relMail`, `mail`, `hindiSnap`, `snap`, `time`) VALUES ('{$username['mail']}',(SELECT follower FROM follow WHERE id = {$follId}),'आपका अनुरोध को स्वीकार कर लिया है। ','Accepted your follow request','{$current_time}')";
                    $added_to_activity = mysqli_query($con, $act_add_sql);
                    echo "true";
                }else{
                    echo "error";
                }
            }else{
                echo "invalid";
            }
        }else{
            echo "error";
        }
    }else{
        echo "error";
    }
?>