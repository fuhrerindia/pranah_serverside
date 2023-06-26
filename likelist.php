<?php
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Access-Control-Allow-Origin: *");
        //CONNECTING TO SOUL
        include('modules/tminc.php');

    //POST ID
    $post = base64_decode($_POST['post']);
    $start = $_POST['start'];

    $sql = "SELECT l.id, u.name, u.dp, u.username
    FROM likes l
    INNER JOIN users u 
    ON l.liker=u.mail
    WHERE l.post LIKE '{$post}'
    ORDER BY l.id DESC
    LIMIT {$start}, 20";

    if ($con = connect()){
        if ($get = mysqli_query($con, $sql)){
            if (0 < mysqli_num_rows($get)){
                $list = array();
                while($row = mysqli_fetch_array($get)){
                    $element = array(
                        "name"=>$row['name'],
                        "dp"=>$row['dp'],
                        "username"=>$row['username']
                    );
                    array_push($list, $element);
                }
                echo json_encode($list);
            }else{
                echo "null";
                // echo $sql;
            }
        }else{
            echo "error";
        }
    }else{
        echo "error";
    }

?>