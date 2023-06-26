<?php
    include('modules/tminc.php');
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Access-Control-Allow-Origin: *");

    $username = base64_decode($_POST['username']);
    $start = clean($_POST['start']);

    if ($con = connect()){
        $usercall = "SELECT * FROM `users` WHERE `username` LIKE '{$username}'";
        if ($uc = mysqli_query($con, $usercall)){
            if (0 < mysqli_num_rows($uc)){
                while ($rw = mysqli_fetch_array($uc)){
                    $email_caught = $rw['mail'];
                }
                $nsql = "SELECT f.id, u.name, u.dp, u.username, u.type FROM follow f INNER JOIN users u ON f.follower=u.mail WHERE following LIKE '{$email_caught}' AND request NOT LIKE 'true' ORDER BY f.id DESC LIMIT {$start}, 20";
                if ($list = mysqli_query($con, $nsql)){
                    if (0 < mysqli_num_rows($list)){
                        $full_list = array();
                        while ($row = mysqli_fetch_array($list)){
                            if ($row['type'] === "private"){
                                $dpuri = "{$webdomain}/assets/user.png";
                            }else{
                                if ($row['dp'] === ""){
                                    $dpuri = "{$webdomain}/assets/user.png";
                                }else{
                                    $dpuri = $row['dp'];
                                }
                            }
                            $temp = array(
                                "id"=>$row['id'],
                                "name"=>$row['name'],
                                "dp"=>$dpuri,
                                "username"=>$row['username']
                            );
                            array_push($full_list, $temp);
                        }
                        echo json_encode($full_list);
                    }else{
                        echo "null";
                    }
                }else{
                    echo "error";
                }
            }else{
                echo "invalid";
                // echo "fdf: ";
            }
        }else{
            echo "error";
        }
    }else{
        echo "error";
    }
?>