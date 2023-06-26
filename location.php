<?php
    //CONNECT TO YUGAL SOUL
    include('modules/tminc.php');
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Access-Control-Allow-Origin: *");

    // $username = clean($_POST['mail']);
    // $password = md5(base64_decode($_POST['pass']));
    $username = base64_decode($_POST['mail']);
    $password = md5(base64_decode($_POST['pass']));

    $output = array();
    if ($con = connect()){
        $verify_account = "SELECT * FROM `users` WHERE `mail` LIKE '{$username}' AND `password` LIKE '{$password}'";
        if ($verify = mysqli_query($con, $verify_account)){
            if (0 < mysqli_num_rows($verify)){
                $following = "SELECT `following` FROM `follow` WHERE `follower` LIKE '{$username}'";
                $follower = "SELECT `follower` FROM `follow` WHERE `following` LIKE '{$username}'";
                if ($get_following = mysqli_query($con, $following)) {
                    # code...
                    $following_list = array();
                    while ($row = mysqli_fetch_array($get_following)){
                        array_push($following_list, $row['following']);
                    }
                }else{
                    $output=array("status"=>"error");
                }

                // FOLLOWER PROCESS
                if ($get_follower = mysqli_query($con, $follower)) {
                    # code...
                    $follower_list = array();
                    while ($row = mysqli_fetch_array($get_follower)){
                        array_push($follower_list, $row['follower']);
                    }
                }else{
                    $output=array("status"=>"error");
                }
                $list = array_intersect($follower_list, $following_list);
                $string = "";
                $val = 0;
                foreach($list as $each){
                    if ($val == 0){
                        $string = "`mail` LIKE '{$each}'";
                    }else{
                        $string = "{$string} OR `mail` LIKE '{$each}'";
                    }
                    $val = $val + 1;
                }
                $query = "SELECT `name`, `mail`, `dp`, `lat`, `lng`, `public_location` FROM `users` WHERE {$string}";
                // FETCH LOCATION
                if ($get_loc = mysqli_query($con, $query)){
                    $loc_list = array();
                    while ($row = mysqli_fetch_array($get_loc)){
                        $temp = array(
                            "name" => $row['name'],
                            "mail" => $row['mail'],
                            "dp" => $row['dp'],
                            "lat" => $row['lat'],
                            "lng" => $row['lng']
                        );
                        if ($row['public_location'] === "true"){
                            array_push($loc_list, $temp);
                        }
                    }
                    $output = array(
                        "status"=>"success",
                        "data"=>$loc_list
                    );
                }else{
                    $output = array("status"=>"error");
                }

            }else{
                $output = array("status"=>"invalid");
            }
        }else{
            $output = array("status"=>"error");
        }
    }else{
        $output = array("status"=>"error");
    }
    echo json_encode($output, JSON_PRETTY_PRINT);
?>