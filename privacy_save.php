<?php
    include('modules/tminc.php');
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Access-Control-Allow-Origin: *");

    $data = array(
        "mail"=>clean($_POST['mail']),
        "pass"=>md5(base64_decode($_POST['pass'])),
        "dest"=>$_POST['dest']
    );

    if ($con = connect()){
        $uveri = "UPDATE `users` SET `type`='{$data['dest']}' WHERE `mail` LIKE '{$data['mail']}' AND `password` LIKE '{$data['pass']}'";
        if ($call = mysqli_query($con, $uveri)){
            if ($data['dest'] === "public"){
                $accept_all = "UPDATE `follow` SET `request`='false' WHERE `following` LIKE '{$data['mail']}'";
                if (mysqli_query($con, $accept_all)){
                    echo "true";
                }else{
                    echo "error";
                }
            }else{
            echo "true";
            }
        }else{
            echo "error";
        }
    }else{
        echo "error";
    }
?>