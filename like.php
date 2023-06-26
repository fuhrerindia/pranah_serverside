<?php
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Access-Control-Allow-Origin: *");
    //CONNECTING TO SOUL
    include('modules/tminc.php');

    //POST ID
    $post = base64_decode($_POST['post']);

        // USER'S CREDENTIALS
    $username = array(
         "email" => clean($_POST['mail']),
         "pass" => md5(base64_decode($_POST['pass']))
    );

    // CONNECTING TO DATABASE
    if ($con = connect()) {
        //USER VERIFICATION FRAMEWORK
        $verification = "SELECT * FROM `users` WHERE `mail` LIKE '{$username['email']}' AND `password` LIKE '{$username['pass']}'";

        //RUNNING VERIFICATION
        if ($verify = mysqli_query($con, $verification)){
            if (mysqli_fetch_array($verify) > 0){
                // CHECKING IF THE POST IS ALREADY LIKED OR NOT
                $already = "SELECT * FROM `likes` WHERE `post` LIKE '{$post}' AND `liker` LIKE '{$username['email']}'";
                
                if ($exist = mysqli_query($con, $already)){
                    
                    if (mysqli_num_rows($exist) > 0){
                        //dislike
                        $like = "DELETE FROM `likes` WHERE `post` LIKE '{$post}' AND `liker` LIKE '{$username['email']}';
                        ";
                        //SAVING LIKE
                        if ($liked = mysqli_multi_query($con, $like)) {
                            echo "true";
                        } else {
                            echo "error1";
                        }
                    }else{
                        //like
                        date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)
                        $current_time = date('d/m/Y H:i');
                        $like = "INSERT INTO `likes`(`post`, `liker`) VALUES ('{$post}','{$username['email']}');
                        ";

                        //ADD TO ACTIVITY
                        $act_add_sql = "INSERT INTO `activity`(`relMail`, `mail`, `hindiSnap`, `snap`, `time`) VALUES ('{$username['email']}',(SELECT mail FROM posts WHERE id = {$post}),'आपकी पोस्ट पसंद की','Liked your post','{$current_time}')";
                        $added_to_activity = mysqli_query($con, $act_add_sql);

                
                        //SAVING LIKE
                        if ($liked = mysqli_multi_query($con, $like)) {
                            echo "true";
                        } else {
                            echo "error";
                        }
                    }

                }else{
                    echo "error3";
                }
                

            }else{
                //INVALID USER
                echo "invalid";
            }
        }else{
            echo "error4";
            //VERIFICATION ERROR
        }
    } else {
        echo "error5";
    }
//    @mysqli_close($con);

    /*
    RETURNS
    true | error | invalid
    */
