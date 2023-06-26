<?php
    // CONNECTING TO YUGAL'S SOUL
    include('modules/tminc.php');

    // GETTING POST VARIABLES
        // USER'S CREDENTIALS
        $username = array(
            "email" => clean($_GET['mail']),
            "pass" => base64_decode($_GET['pass'])
        );

        // POST DATA
        if (isset($_FILES['file'])){
            $file = upload($_FILES['file'], "posts");
        }else{
            $file = "";
        }

        $caption = clean($_GET['caption']);

        //VERIFYING FILE TYPE TO SAVE POST TYPE
        if ($file === ""){
            $type = "text";
        }else{
            $ext = explode(".", $file)[1];
            if ($ext === "mp4" || $ext === "avi"){
                $type = "vid";
            }elseif ($ext === "jpg" || $ext === "png" || $ext === "jpeg") {
                $type = "img";
            }
        }

        // CONNECTING TO DATABASE
        if ($con = connect()){
            //VERIFYING USER'S AUTHENTICATION
            $verification = "SELECT * FROM `users` WHERE `mail` LIKE '{$username['email']}' AND `password` LIKE '{$username['pass']}'";
            if ($verify = mysqli_query($con, $verification)){
                if (mysqli_num_rows($verify) > 0){
                    $post_sql = "INSERT INTO `posts`(`mail`, `url`, `caption`, `type`) VALUES ('{$username['email']}','{$file}','{$caption}','{$type}')";
                    if (mysqli_query($con, $post_sql)){
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
        @mysqli_close($con);

?>