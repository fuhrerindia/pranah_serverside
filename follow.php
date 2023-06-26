<?php
    //CONNECTING TO SOUL
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Access-Control-Allow-Origin: *");
    include('modules/tminc.php');
    
    //POST ID
    $un = clean($_POST['username']);

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
                //CHECKING IF ACCOUNT IS PRIVATE OR NOT
                $select_user = "SELECT * FROM `users` WHERE `username` LIKE '{$un}'";

                if ($got_user = mysqli_query($con, $select_user)){
                    if (0 < mysqli_num_rows($got_user)){
                        while($target = mysqli_fetch_array($got_user)){
                            $target_data = $target;
                        }

                        //CHECKING IF ALREADY FOLLOWED?
                        $already = "SELECT * FROM `follow` WHERE `follower` LIKE '{$username['email']}' AND `following` LIKE '{$target_data['mail']}'";
                        if ($al_check = mysqli_query($con, $already)){
                            if (mysqli_num_rows($al_check) == 0){
                                //UN FOLLOW
                           
                            
                        
                        if ($target_data["type"] === "public"){
                            $follow_q = "INSERT INTO `follow`(`follower`, `following`, `request`) VALUES ('{$username['email']}','{$target_data['mail']}','false')";
                            $last_output = "true";
                        }else{
                            //PRIVATE CODE
                            $follow_q = "INSERT INTO `follow`(`follower`, `following`, `request`) VALUES ('{$username['email']}','{$target_data['mail']}','true')";
                            $last_output = "requested";
                        }

                        //ADD TO ACTIVITY
                        date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)
                        $current_time = date('d/m/Y H:i');
                        $act_add_sql = "INSERT INTO `activity`(`relMail`, `mail`, `hindiSnap`, `snap`, `time`) VALUES ('{$username['email']}', '{$target_data['mail']}','आपको फॉलो करना शुरू किया।','Started following you','{$current_time}')";
                        $added_to_activity = mysqli_query($con, $act_add_sql);

                        if ($followed = mysqli_query($con, $follow_q)){
                            echo $last_output;
                        }else{
                            echo "error";
                        }


                        //CODE
                    }else{
                        //UNFOLLOWING
                        $unfollow_code = "DELETE FROM `follow` WHERE `follower` LIKE '{$username['email']}' AND `following` LIKE '{$target_data['mail']}'";
                        if ($unfollowed = mysqli_query($con, $unfollow_code)){
                            echo "unfollowed";
                        }else{
                            echo "error";
                        }
                    }
                }else{
                    echo "error";
                }
                    }else{
                        echo "unexisted";
                    }
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
    // error | unfollowed | true | requested | unexisted | invalid
?>