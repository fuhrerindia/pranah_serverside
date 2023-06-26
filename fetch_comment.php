<?php
    //CONNECTING TO SOUL
    include('modules/tminc.php');
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Access-Control-Allow-Origin: *");

    $username = array(
        "email"=>base64_decode($_POST['mail']),
        "pass"=>md5(base64_decode($_POST['pass']))
    );
    //POST ID
    $post = base64_decode($_POST['post']);
    if (isset($_POST['start'])){
        $start = $_POST['start'];
    }else{
        $start = 0;
    }
    // CONNECTING TO DATABASE
    if ($con = connect()) {
        //USER VERIFICATION FRAMEWORK
        $verification = "SELECT * FROM `users` WHERE `mail` LIKE '{$username['email']}' AND `password` LIKE '{$username['pass']}'";

        //RUNNING VERIFICATION
        if ($verify = mysqli_query($con, $verification)){
            if (mysqli_fetch_array($verify) > 0){
                $fetch_comments = "SELECT c.id, c.post, u.mail,u.name, u.dp, u.username, c.comment 
                FROM comment c 
                INNER JOIN users u 
                ON u.mail=c.commentBy
                WHERE `post` LIKE '{$post}'
                ORDER BY c.id DESC
                LIMIT {$start}, 20";
                if ($fetch = mysqli_query($con, $fetch_comments)){
                    if (0 < mysqli_num_rows($fetch)){
                        $tmp_data = array();
                        while ($row = mysqli_fetch_array($fetch)){
                            $tmp_id = $row['post'];
                            $tmp_name = $row['name'];
                            $tmp_dp = $row['dp'];
                            $tmp_username = $row['username'];
                            $tmp_comment = $row['comment'];
                            $tmp_email = $row['mail'];

                            $tmp_json = array(
                                "id"=>base64_encode($tmp_id),
                                "mail"=>base64_encode($tmp_email),
                                "name"=>$tmp_name,
                                "dp"=>$tmp_dp,
                                "username"=>$tmp_username,
                                "comment"=>$tmp_comment
                            );
                            array_push($tmp_data, $tmp_json);
                        }
                        echo json_encode($tmp_data);

                    }else{
                        echo "null";
                    }
                }else{
                    // echo "error";
                    echo $fetch_comments;
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