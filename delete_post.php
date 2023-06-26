<?php
    //CONNECTING TO SOUL
    include('modules/tminc.php');

    //POST ID
    $post = base64_decode($_GET['post']);
        // USER'S CREDENTIALS
    $username = array(
         "email" => clean($_GET['mail']),
         "pass" => base64_decode($_GET['pass'])
    );

    // CONNECTING TO DATABASE
    if ($con = connect()) {
        //USER VERIFICATION FRAMEWORK
        $verification = "SELECT * FROM `users` WHERE `mail` LIKE '{$username['email']}' AND `password` LIKE '{$username['pass']}'";

        //RUNNING VERIFICATION
        if ($verify = mysqli_query($con, $verification)){
            if (mysqli_fetch_array($verify) > 0){
                
                /*CHECKING IF POST BELONGS TO THIS USER
                    NOT RUNNING DELETE FROM `post` WHERE `mail` LIKE 'something' AND `id` LIKE 'something';
                    as WE NEED TO DELETE ALL LIKES AND COMMENTS AS WELL!
                */
                $post_ver = "SELECT * FROM `posts` WHERE `mail` LIKE '{$username['email']}' AND `id` LIKE '{$post}'";
                if ($post_verification = mysqli_query($con, $post_ver)){
                    if (0 < mysqli_num_rows($post_verification)){
                        //QUERY TO DELETE POST, RELATED LIKES AND COMMENTS!
                        $delete = "DELETE FROM `posts` WHERE `id` LIKE '{$post}' AND `mail` LIKE '{$username['email']}';\n";
                        $delete .= "DELETE FROM `likes` WHERE `post` LIKE '{$post}';\n";
                        $delete .= "DELETE FROM `comment` WHERE `post` LIKE '{$post}';";
                        if ($deleted = mysqli_multi_query($con, $delete)){
                            echo "true";
                        }else{
                            echo $delete;
                        }
                    }else{
                        echo "action denied";
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