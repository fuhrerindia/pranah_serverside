<?php
    // CONNECTING TO SOUL
    include('modules/tminc.php');
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Access-Control-Allow-Origin: *");


    //SAVING VARIABLES
    $account = base64_decode($_POST['username']);
    $username = array(
        "email"=>clean($_POST['mail']),
        "pass"=>md5(base64_decode($_POST['pass']))
    );
    $start = clean($_POST['start']);
    // $start = 0;
    //username | mail | pass
    

    if ($con = connect()){
        function getNumRows($sql){
            global $con;
            return mysqli_num_rows(mysqli_query($con, $sql));
        }
        $sql = "SELECT * FROM `users` WHERE `mail` LIKE '{$username['email']}' AND `password` LIKE '{$username['pass']}'";
        
        // CHECKING ACCOUNT OF REQUESTED USER
        if ($verify = mysqli_query($con, $sql)){
            if (0 < mysqli_num_rows($verify)){
                //FETCHING TARGET ACCOUNT
                $acc = "SELECT * FROM `users` WHERE `username` LIKE '{$account}'";
                if ($got = mysqli_query($con, $acc)){
                if (0 < mysqli_num_rows($got)){
                    $target_account = mysqli_fetch_array($got);


                    //CHECKING IF FOLLOWING.
                    $getting_from_db = "SELECT * FROM `follow` WHERE `follower` LIKE '{$username['email']}' AND `following` LIKE '{$target_account['mail']}'";

                    if ($got_row = mysqli_query($con, $getting_from_db)){
                        if (0 < mysqli_num_rows($got_row)){
                            $got_column = mysqli_fetch_array($got_row);
                            if ($got_column['request'] === "true"){
                                $isFollowing = "requested";
                            }else{
                                $isFollowing = "true";
                            }
                        }else{
                            $isFollowing = "false";
                        }
                    }else{
                        echo "error";
                    }


                    $tar_cred = array(
                        "name"=>$target_account['name'],
                        "username"=>$target_account['username'],
                        "bio"=>$target_account['bio'],
                        "dp"=>$target_account['dp'] === "" ? "{$webdomain}/assets/user.png" : $target_account['dp'],
                        "follower"=>getNumRows("SELECT * FROM `follow` WHERE `following` LIKE '{$target_account['mail']}' AND `request` NOT LIKE 'true'"),
                        "following"=>getNumRows("SELECT * FROM `follow` WHERE `follower` LIKE '{$target_account['mail']}' AND `request` NOT LIKE 'true'"),
                        "postCount"=>getNumRows("SELECT * FROM `posts` WHERE `mail` LIKE '{$target_account['mail']}'"),
                        "isFollowing"=>$isFollowing
                    );
                    if ($target_account['type'] === "public"){
                        //CALL POSTS
                        $fetch_post = "SELECT * FROM `posts` WHERE `mail` LIKE '{$target_account['mail']}' ORDER BY `id`DESC LIMIT {$start}, 20";
                        if ($post_list = mysqli_query($con, $fetch_post)){
                            if (0 < mysqli_num_rows($post_list)){
                            $all_posts = array();
                            while ($row = mysqli_fetch_array($post_list)){
                                $each_post = array(
                                    "url"=>$row['url'],
                                    "caption"=>$row['caption'],
                                    "type"=>$row['type'],
                                    "id"=>base64_encode($row['id'])
                                );
                                array_push($all_posts, $each_post);
                            }
                            $tar_cred['posts'] = $all_posts;
                        }else{
                            $tar_cred['posts'] = "null"; 
                        }
                        }else{
                            echo "error";
                        }
                    }else{
                        //some checks
                        $fol_check = "SELECT * FROM `follow` WHERE `follower` LIKE '{$username['email']}' AND `following` LIKE '{$target_account['mail']}'";
                        if ($foll = mysqli_query($con, $fol_check)){
                            if (0 < mysqli_num_rows($foll)){
                                $val = mysqli_fetch_array($foll);
                                if ($val['request'] === "true"){
                                    $all_posts = "requested";
                                }else{
                                    $fetch_p_post = "SELECT * FROM `posts` WHERE `mail` LIKE '{$target_account['mail']}' ORDER BY `id` DESC LIMIT {$start}, 20";
                                    if ($caught = mysqli_query($con, $fetch_p_post)){
                                        if (0 < mysqli_num_rows($caught)){
                                            $all_posts = array();
                                            while ($rw = mysqli_fetch_array($caught)){
                                                $epst = array(
                                                    "url"=>$rw['url'],
                                                    "caption"=>$rw['caption'],
                                                    "type"=>$rw['type'],
                                                    "id"=>base64_encode($rw['id'])
                                                );
                                                array_push($all_posts, $epst);
                                            }
                                        }else{
                                            $all_posts = "null";
                                        }
                                    }else{
                                        echo "error";
                                    }
                                }
                            }else{
                                $all_posts = "private";
                            }
                            $tar_cred['posts'] = $all_posts;
                            if ($tar_cred['posts'] === "private" || $tar_cred['posts'] === "requested"){
                                $tar_cred['dp'] = "{$webdomain}/assets/user.png";
                            }
                        }else{
                            echo "error";
                        }
                    }
                    //PRINT ACCOUNT
                    echo json_encode($tar_cred);
                }else{
                    echo "notFound";
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

?>