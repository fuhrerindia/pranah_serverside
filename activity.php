<?php
    include('modules/tminc.php');
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Access-Control-Allow-Origin: *");

    $user_app = array(
        "mail"=>$_POST['mail'],
        "pass"=>md5(base64_decode($_POST['pass']))
    );

    if ($con = connect()){
        $verify_user = "SELECT * FROM `users` WHERE `mail` LIKE '{$user_app['mail']}' AND `password` LIKE '{$user_app['pass']}'";
        if ($ver  = mysqli_query($con, $verify_user)){
            if (0 < mysqli_num_rows($ver)){
                $get = "SELECT a.id, a.relMail, a.snap, a.date, a.time, u.name, u.dp, u.username 
                FROM activity a 
                INNER JOIN users u 
                ON u.mail=a.relMail
                WHERE a.mail LIKE '{$user_app['mail']}'
                ORDER BY a.id DESC
                LIMIT 0, 20";
                if ($actrows = mysqli_query($con, $get)){
                    $activity_json = array();
                    while ($row = mysqli_fetch_array($actrows)){
                        $temp_json = array(
                            "src"=>$row['relMail'],
                            "snap"=>$row['snap'],
                            "date"=>$row['date'],
                            "time"=>$row['time'],
                            "username"=>$row['username'],
                            "name"=>$row['name'],
                            "dp"=>$row['dp']
                        );
                        array_push($activity_json, $temp_json);
                    }
                    echo json_encode($activity_json);
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