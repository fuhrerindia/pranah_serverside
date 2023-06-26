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
                    $name_caught = $row['name'];
                    $username_caught = $row['username'];
                    $bio_caught = $row['bio'];
                    $dp_caught = $row['dp'];
                }
                echo json_encode(array(
                    "name"=>$name_caught,
                    "username"=>$username_caught,
                    "bio"=>$bio_caught,
                    "dp"=>$dp_caught
                ));
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