<?php
    include('modules/tminc.php');
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Access-Control-Allow-Origin: *");
    $query = clean($_POST['q']);
    $start = $_POST['start'];

    if ($con = connect()){
        $get = "SELECT * FROM `users` WHERE `name` LIKE '%{$query}%' OR `username` LIKE '%{$query}%' OR `bio` LIKE '%{$query}%' LIMIT {$start}, 20";
        if ($results = mysqli_query($con, $get)){
            if (mysqli_num_rows($results) > 0){
                $output = array();
                while($r = mysqli_fetch_array($results)){
                    $prov_res = array(
                        "user"=>$r['username'],
                        "name"=>$r['name'],
                        "dp"=>$r['type'] === "public" ? $r['dp'] : "{$webdomain}/assets/user.png"
                    );
                    array_push($output, $prov_res);
                }
                echo json_encode($output, isset($_GET['pre']) && @$_GET['pre'] === "true" ? JSON_PRETTY_PRINT : null);
            }else{
                echo "null";
            }
        }else{
            echo "error";
        }
    }else{
        echo "error";
    }
    @mysqli_close($con);


?>