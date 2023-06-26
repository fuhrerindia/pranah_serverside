<?php
    include('modules/tminc.php');

    if ($conn = connect()){
        if (isset($_POST['auth']) && isset($_POST['account']) && $_POST['auth'] != "" && $_POST['account'] !== ""){
            $mail = clean(base64_decode($_POST['account']));
            $otp = clean($_POST['auth']);
            $newpass = md5($_POST['pass']);
            $sql = "SELECT * FROM `users` WHERE `mail` LIKE '{$mail}' AND `reset` LIKE '{$otp}'";
            if ($check = mysqli_query($conn, $sql)){
                if (0 < mysqli_num_rows($check)){


                    while ($row = mysqli_fetch_array($check)){
                        $id = $row['id'];
                    }

                    $nsql = "UPDATE `users` SET `reset`='true', `password`='{$newpass}' WHERE `id` LIKE '{$id}'";
                    if (mysqli_query($conn, $nsql)){
                        $screen = 'true';
                    }else{
                        $screen = 'ERROR CODE: 1';
                    }

                }else{
                    $screen = 'Invalid Request, contact Pranah!';        
                }
            }else{
                $screen = 'ERROR PROCEEDING YOUR REQUEST';    
            }

        }else{
            $screen = 'ERROR';
        }
        
    }else{
        
        $screen = "ERROR";
        alert("ERROR CODE: 6");
    }
    export_screen($screen);
    mysqli_close($conn);
?>