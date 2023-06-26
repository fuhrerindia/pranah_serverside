<?php
    include('modules/tminc.php');
    header("Access-Control-Allow-Origin: *");
    if (isset($_POST['mail']) && isset($_POST['pass'])){
        if ($con = connect()){

            $password = md5(base64_decode($_POST['pass']));
            $mail = clean($_POST['mail']);
            $sql = "SELECT * FROM `users` WHERE `mail` LIKE '{$mail}' AND `password` LIKE '{$password}'";
            if ($fetch = mysqli_query($con, $sql)){
                if (0 < mysqli_num_rows($fetch)){
                    while ($row = mysqli_fetch_array($fetch)){
                        $rw = $row;
                    }
                    echo json_encode(
                        array(
                            "username"=>$rw['username']
                        )
                    );
                }else{
                    echo "false";
                }
            }else{
                echo "error";
            }

        }else{
            echo "error";
        }
    }else{
        echo "missing";
    }
    if (isset($con)){
        mysqli_close($con);
    }

    /*
    OUTPUTS THE FOLLOWING DATA
    true | false | error | missing
    */
?>