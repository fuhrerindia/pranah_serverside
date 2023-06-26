<?php
    //CONNECTING TO SOUL
    include('modules/tminc.php');
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Access-Control-Allow-Origin: *");

    $username = array(
        "mail"=>$_POST['mail'],
        "pass"=>md5(base64_decode($_POST['pass']))
    );
    $post = base64_decode($_POST['post']);

    if ($con = connect()){
        $ver = "SELECT * FROM `users` WHERE `mail` LIKE '{$username['mail']}' AND `password` LIKE '{$username['pass']}'";
        if ($get = mysqli_query($con, $ver)){
            $get_post = "SELECT * FROM `posts` WHERE `id` LIKE '{$post}'";
            if ($fetch = mysqli_query($con, $get_post)){
                if (0 < mysqli_num_rows($fetch)){
                    while ($row = mysqli_fetch_array($fetch)){
                        $row_got = $row;
                    }

                    $rptd = $row_got['reposted'] === "" ? $post : $row_got['reposted'];
                    $post_q = "INSERT INTO `posts`(`mail`, `url`, `fav`, `caption`, `type`, `reposted`) VALUES ('{$username['mail']}','{$row_got['url']}','0','{$row_got['caption']}','{$row_got['type']}','{$rptd}')";
                    if (mysqli_query($con, $post_q)){
                        echo "true";
                    }else{
                        echo "error";
                    }

                }else{
                    echo "error";
                }
            }else{
                echo "error";
            }
        }else{
            echo "error";
        }
    }else{
        echo "error";
    }
?>