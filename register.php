<?php
    include('modules/tminc.php');
    include('lib/gmail/index.php');

    if (isset($_POST['mail']) && isset($_POST['pass']) && isset($_POST['name']) && isset($_POST['token'])){
        if ($con = connect()){

            $password = md5(base64_decode($_POST['pass']));
            $mail = clean($_POST['mail']);
            $name = clean($_POST['name']);
            $username = clean($_POST['username']);
            $otp = clean($_POST['token']);

            $verification = "SELECT * FROM `users` WHERE `username` LIKE '{$username}'";
            if ($verify = mysqli_query($con, $verification)){
                if (0 == mysqli_num_rows($verify)){

                    $ckemail = "SELECT * FROM `users` WHERE `mail` LIKE '{$mail}'";

                    if ($run = mysqli_query($con, $ckemail)){
                        if (0 == mysqli_num_rows($run)){
                            $encrypted_mail = base64_encode($mail);
                            $mail_body = "
                                <div style='width:100%;text-align:center'>
                                    <div style='display:inline-block'>
                                         <h1>Pranah</h1>
                                        <p>
                                            Thanks for creating account on Pranah! Please verify your account with the button below.
                                        </p>
                                        <a href='http://localhost/pranah_backend/verify?account={$encrypted_mail}&auth={$otp}'><button style='border:0;padding:5px;border-radius:5px;background:red;color:#fff'>VERIFY</button></a>
                                    </div>
                                </div>
                            ";
                            $sql = "INSERT INTO `users`(`name`, `mail`, `password`, `dp`, `username`, `verify`) VALUES ('{$name}','{$mail}','{$password}','','{$username}', '{$otp}');
                                INSERT INTO `follow`(`follower`, `following`, `request`) VALUES ('{$mail}','{$mail}','false')
                            ";
                            // if (gmail($mail, "OTP For Creating Pranah Account", "{$mail_body}")){
                                    //CREATING ACCOUNT
                                if ($fetch = mysqli_multi_query($con, $sql)){
                                    echo "true";
                                }else{
                                    echo "error";
                                }
                                //CREATED ACCOUNT
                            // }else{
                            //     echo "error";
                            // }

                }else{
                    echo "mailtaken";
                }
            }else{
                echo "error";
            }

                }else{
                    echo "taken";
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
    mysqli_close($con);

    // true | taken | missing | error | mailtaken
?>