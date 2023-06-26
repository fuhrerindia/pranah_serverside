<?php
    //CONNECTING TO SOUL
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Access-Control-Allow-Origin: *");
    include('modules/tminc.php');

    $username = array(
        "mail"=>clean($_POST['mail']),
        "pass"=>md5(base64_decode($_POST['pass']))
    );
    $start = isset($_POST['start']) ? clean($_POST['start']) : 0; 

    if ($con = connect()){

        $ver = "SELECT * FROM `users` WHERE `mail` LIKE '{$username['mail']}' AND `password` LIKE '{$username['pass']}'";
        if ($verd = mysqli_query($con, $ver)){
            if (0 < mysqli_num_rows($verd)){
                    $sql = "SELECT f.id, u.name, u.dp, u.username, f.follower, f.request
                    FROM follow f 
                    INNER JOIN users u 
                    ON f.follower=u.mail
                    WHERE `request` LIKE 'true' AND f.following LIKE '{$username['mail']}'
                    ORDER BY f.id DESC
                    LIMIT {$start}, 20";
                if ($got = mysqli_query($con, $sql)){
                    $list = array();
                    while ($row = mysqli_fetch_array($got)) {
                        $col = array(
                            "id"=>base64_encode($row['id']),
                            "name"=>$row['name'],
                            "dp"=>$row['dp'],
                            "username"=>$row['username']
                        );
                        array_push($list, $col);
                    }
                   echo json_encode($list);
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