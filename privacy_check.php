<?php
    include('modules/tminc.php');
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Access-Control-Allow-Origin: *");

    $data = array(
        "mail"=>clean($_POST['mail']),
        "pass"=>md5(base64_decode($_POST['pass']))
    );

    if ($con = connect()){
        $uveri = "SELECT * FROM `users` WHERE `mail` LIKE '{$data['mail']}' AND `password` LIKE '{$data['pass']}'";
        if ($call = mysqli_query($con, $uveri)){
            if (0 < mysqli_num_rows($call)){
                while ($row = mysqli_fetch_array($call)){
                    $private = $row['type'];
                }
                echo $private;
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