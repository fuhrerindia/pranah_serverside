<?php
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Access-Control-Allow-Origin: *");
        include('modules/tminc.php');

        $userdet = array(
            "mail"=>clean($_POST['mail']),
            "pass"=>md5(base64_decode($_POST['pass']))
        );

        if ($con = connect()){
            $ver_sql = "SELECT * FROM `users` WHERE `mail` LIKE '{$userdet['mail']}' AND `password` LIKE '{$userdet['pass']}'";
            if ($got = mysqli_query($con, $ver_sql)){
                if (0 < mysqli_num_rows($got)){
                    $act_sql = "SELECT a.id, u.name, u.dp, u.username, a.relMail, a.hindiSnap, a.snap, a.time, u.mail
                    FROM activity a 
                    INNER JOIN users u 
                    ON a.mail=u.mail
                    WHERE a.mail LIKE '{$userdet['mail']}'
                    ORDER BY a.id DESC
                    LIMIT 0, 30
                    ";
                    if ($caught = mysqli_query($con, $act_sql)){
                        $array = array();
                        while ($row = mysqli_fetch_array($caught)){
                            $temp = array(
                                "rel"=>$row['relMail'],
                                "hindi"=>$row['hindiSnap'],
                                "snap"=>$row['snap'],
                                "time"=>$row['time'],
                                "name"=>$row['name'],
                                "dp"=>$row['dp'] === "" ? "{$webdomain}/assets/user.png" : $row['dp'],
                                "username"=>$row['username']    
                            );
                            array_push($array, $temp);
                        }
                        echo json_encode($array);

                    }else{
                        echo "error1";
                    }
                }else{
                    echo "invalid";
                }
            }else{
                echo "error2";
            }
        }else{
            echo "error3";
        }
?>
