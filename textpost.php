<?php
    include('modules/tminc.php');
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Access-Control-Allow-Origin: *");

    $client = array(
        "mail"=>$_POST['mail'],
        "pass"=>md5(base64_decode($_POST['pass']))
    );

    $caption = linient($_POST['text']);
    if ($con = connect()){
        $verify = "SELECT * FROM `users` WHERE `mail` LIKE '{$client['mail']}' AND `password` LIKE '{$client['pass']}'";
        if ($check = mysqli_query($con, $verify)){
            if (0 < mysqli_num_rows($check)){
                //SAVE POST
                $save = "INSERT INTO `posts`( `mail`, `caption`, `type`) VALUES ('{$client['mail']}','{$caption}','text')";
                if ($saved = mysqli_query($con, $save)){
                    // echo "true";
                    echo "'{$caption}'";
                    // print_r($_POST);
                }else{
                    echo "error";
                    // echo $save;
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