<?php
    //CONNECTING TO SOUL
    include('modules/tminc.php');
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Access-Control-Allow-Origin: *");


    //POST ID
    $post = base64_decode($_POST['post']);
    $comment = linient(base64_decode($_POST['comment']));

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
                
                //CHECKING IF USER HAS ALREADY COMMENTED OR NOT
                $comment_check = "SELECT * FROM `comment` WHERE `commentBy` LIKE '{$username['email']}' AND `post` LIKE '{$post}'";
                if ($check = mysqli_query($con, $comment_check)){
                    if (0 == mysqli_num_rows($check)){
                        //ADD COMMENT
                        //CHECKING IF POST EXISTS
                        $post_valid = "SELECT * FROM `posts` WHERE `id` LIKE '{$post}'";
                        if ($check_post = mysqli_query($con, $post_valid)){
                            if (mysqli_num_rows($check_post) > 0){
                                #code...

                            $new = "INSERT INTO `comment`(`post`, `commentBy`, `comment`) VALUES ('{$post}','{$username['email']}','{$comment}')";
                            if ($save = mysqli_query($con, $new)){
                                                        //ADD TO ACTIVITY
                                                        date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)
                                                        $current_time = date('d/m/Y H:i');
                        $act_add_sql = "INSERT INTO `activity`(`relMail`, `mail`, `hindiSnap`, `snap`, `time`) VALUES ('{$username['email']}',(SELECT mail FROM posts WHERE id = {$post}),'आपकी पोस्ट पर टिपण्णी की ','Commented on Your Post','{$current_time}')";
                        $added_to_activity = mysqli_query($con, $act_add_sql);
                                echo "true";
                            }else{
                                echo "error";
                            }
                        }else{
                            echo "deleted";
                        }
                    }else{
                        echo "error";
                    }
                            //COMMENT ADDING CODE ABOVE
                    }else{
                        echo "already";
                    }
                }else{
                    echo "error";
                }

            }else{
                //INVALID USER
                echo "invalid";
            }
        }else{
            echo "error";
            //VERIFICATION ERROR
        }
    } else {
        echo "error";
    }
    @mysqli_close($con);

    
?>