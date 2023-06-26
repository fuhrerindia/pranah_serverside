<?php
    // CONNECTING TO FRAMEWORK'S SOUL
    include('modules/tminc.php');
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Access-Control-Allow-Origin: *");


    $username = clean($_POST['mail']);
    $password = md5(base64_decode($_POST['pass']));


    //CHECKING IF START VALUE IS SET OR NOT
    if (!isset($_POST['start']) || $_POST['start'] === ""){
        $start = 0;
        // START VALUE WAS NOT SET, HENCE 0 IS DEFINED AS START
     }else{
        $start = clean($_POST['start']);
        // CLEANED START VALUE SO THAT NO HACKING ATTEMPT WORK, AND SAVED IT 
    }


    if ($con = connect()) {
        //VERIFYING USER'S USERNAME AND password
        $verify = "SELECT * FROM `users` WHERE `mail` LIKE '{$username}' AND `password` LIKE '{$password}'";
        // CREATED A QUERY

        // RUNNING QUERY BELOW
        if ($verification = mysqli_query($con, $verify)) {
            if (0 < mysqli_num_rows($verification)) {
                //GETTING FOLLOWER LIST
                $followers = "SELECT * FROM `follow` WHERE `follower` LIKE '{$username}' AND `request` LIKE 'false'";
                //FETCHING FROM DB
                if ($list = mysqli_query($con, $followers)) {
                    if (0 < mysqli_num_rows($list)){
                        $querycont = "";
                        $count = 0;
                        while($person = mysqli_fetch_array($list)){
                            $count = $count + 1;
                            if ($count == 1){
                                $prov = "";
                            }else{
                                $prov = " OR ";
                            }

                            $querycont = $querycont.$prov."p.mail LIKE '{$person['following']}'";
                        }
                        $postfetch = "SELECT p.id, u.name, u.dp, u.username, p.url, p.fav, p.caption, p.type 
                        FROM posts p 
                        INNER JOIN users u 
                        ON p.mail=u.mail
                        WHERE {$querycont}
                        ORDER BY p.id DESC
                        LIMIT {$start}, 20
                        ";
                        //GETTING FEEDS..
                        if ($feed_data = mysqli_query($con, $postfetch)) {
                            if (0 < mysqli_num_rows($feed_data)){
                                $toreturn = array();
                                while ($data = mysqli_fetch_array($feed_data)){
                                    $like_check = "SELECT * FROM `likes` WHERE `liker` LIKE '{$username}' AND `post` LIKE '{$data['id']}'";
                                    if ($check_if_liked = mysqli_query($con, $like_check)){
                                        if (mysqli_num_rows($check_if_liked) > 0){
                                            //LIKED
                                            $like_prov_var = "true";
                                        }else{
                                            //NOT LIKED
                                            $like_prov_var = "false";
                                        }
                                        $prov_arr = array(
                                            "id"=>base64_encode($data['id']),
                                            "name"=>$data['name'],
                                            "dp"=>$data['dp'] === "" ? "{$webdomain}/assets/user.png" : $data['dp'],
                                            "username"=>$data['username'],
                                            "url"=>$data['url'],
                                            "fav"=>mysqli_num_rows(mysqli_query($con, "SELECT * FROM `likes` WHERE `post` LIKE '{$data['id']}'")),
                                            "caption"=>$data['caption'],
                                            "type"=>$data['type'],
                                            "liked"=>$like_prov_var
                                        );
                                        array_push($toreturn, $prov_arr);
                                    }else{
                                        echo $like_check;
                                    }
                                }
                                echo json_encode($toreturn, JSON_PRETTY_PRINT);
                                // echo $postfetch;
                                // echo "dta mil gaya";
                                // echo $postfetch;
                            }else{
                                echo "nomore";
                            }
                        } else {
                            // echo "error1";
                            echo $postfetch;
                        }
                        
                    }else{
                        echo "followernull";
                    }
                } else {
                    echo "error";
                }
                


            } else {
                echo "invalid";
            }
            
        }else{
            echo "error";
        }
    } else {
        echo "error";
    }
    @mysqli_close($con);


    /*
        ACCEPTS 
        mail | pass | start (optional)

        RETURNS
        nomore | followernull | error | invalid | data
    */
?>