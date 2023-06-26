<?php
        include('modules/tminc.php');
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Access-Control-Allow-Origin: *");
        // echo upload($_FILES['photo'], "photos");
        $Imagefile = $_FILES['photo'];
        $userCred = array(
            "mail"=>clean($_POST['mail']),
            "pass"=>md5(base64_decode($_POST['pass']))
        );
        $captionGot = cleanWithSpaces(base64_decode($_POST['postCaption']));

        if ($con = connect()){
            $check_user = "SELECT * FROM `users` WHERE `mail` LIKE '{$userCred['mail']}' AND `password` LIKE '{$userCred['pass']}'";
            if ($got = mysqli_query($con, $check_user)){
                if (0 < mysqli_num_rows($got)){
                    $filepath = upload($Imagefile, "posts");
                    $savePost = "INSERT INTO `posts`(`mail`, `url`, `caption`, `type`) VALUES ('{$userCred['mail']}','{$filepath}','{$captionGot}','media')";
                    if ($saved = mysqli_query($con, $savePost)){
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