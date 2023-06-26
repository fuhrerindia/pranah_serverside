<?php
        //CONNECTING TO SOUL
        include('modules/tminc.php');
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Access-Control-Allow-Origin: *");

        $mail = clean(base64_decode($_POST['mail']));
        $passw = md5(base64_decode($_POST['pass']));
        $post = clean(base64_decode($_POST['post']));

        if ($con = connect()){
            $user = "SELECT * FROM `users` WHERE `mail` LIKE '{$mail}' AND `password` LIKE '{$passw}'";
            if ($userf = mysqli_query($con, $user)){
                if (0 < mysqli_num_rows($userf)){
                    $postSql = "SELECT p.id, p.mail, p.url, p.fav, p.caption, p.type, u.type AS acctype, u.dp, u.name, u.username
                    FROM posts p 
                    INNER JOIN users u 
                    ON u.mail=p.mail
                    WHERE p.id LIKE '{$post}'";

                    if ($get = mysqli_query($con, $postSql)){
                        if (mysqli_num_rows($get) > 0){
                            $tp = array();
                            while ($row = mysqli_fetch_array($get)){
                                if ($row['acctype'] === "public"){
                                    //PUBLIC ACCOUNT
                                    $lkesql = "SELECT * FROM `likes` WHERE `post` LIKE '{$post}' AND `liker` LIKE '{$mail}'";
                                    if ($liked = mysqli_query($con, $lkesql)){
                                        if (0 < mysqli_num_rows($liked)){
                                            $likeval = "true";
                                        }else{
                                            $likeval = "false";
                                        }
                                    }else{
                                        $likeval = "false";
                                    }
                                    $tp = array(
                                        "id"=>base64_encode($row['id']),
                                        "mail"=>base64_encode($row['mail']),
                                        "url"=>$row['url'],
                                        "fav"=>mysqli_num_rows(mysqli_query($con, "SELECT * FROM `likes` WHERE `post` LIKE '{$row['id']}'")),
                                        "name"=>$row['name'],
                                        "username"=>$row['username'],
                                        "dp"=>$row['dp'] === "" ? "{$webdomain}/assets/user.png": $row['dp'],
                                        "caption"=>$row['caption'],
                                        "liked"=>$likeval,
                                        "type"=>$row['type']
                                    );
                                    echo json_encode($tp);
                                }else{
                                    //PRIVATE ACCOUNT 
                                    $check = "SELECT * FROM `follow` WHERE `follower` LIKE '{$mail}' AND `following` LIKE '{$row['mail']}' AND `request` NOT LIKE 'true'";
                                    if ($ver = mysqli_query($con, $check)){
                                        if (mysqli_num_rows($ver) > 0){
                                            if ($liked = mysqli_query($con, "SELECT * FROM `likes` WHERE `post` LIKE '{$post}' AND `liker` LIKE '{$mail}'")){
                                                if (0 < mysqli_num_rows($liked)){
                                                    $likeval = "true";
                                                }else{
                                                    $likeval = "false";
                                                }
                                            }else{
                                                $likeval = "false";
                                            }
                                            $tp = array(
                                                "id"=>base64_encode($row['id']),
                                                "mail"=>base64_encode($row['mail']),
                                                "url"=>$row['url'],
                                                "fav"=>$row['fav'],
                                                "name"=>$row['name'],
                                                "username"=>$row['username'],
                                                "dp"=>$row['dp'] === "" ? "{$webdomain}/assets/user.png": $row['dp'],
                                                "caption"=>$row['caption'],
                                                "liked"=>$likeval,
                                                "type"=>$row['type']
                                            );
                                            echo json_encode($tp);
                                        }else{
                                            echo "private";
                                        }
                                    }else{
                                        echo "error";
                                    }
                                }
                            }
                        }else{
                            echo "null";
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
        // echo mysqli_error($con);
?>
