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
                $update = "DELETE FROM `follow` WHERE `id` LIKE '{$follId}' AND `following` LIKE '{$username['mail']}'";
                if ($updated = mysqli_query($con, $update)){
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