<?php
// CONNECTING TO FRAMEWORK'S SOUL
    include('modules/tminc.php');
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Access-Control-Allow-Origin: *");

    $dest = clean(base64_decode($_POST['dest']));
    $otptosend = clean($_POST['auth']);

    if ($con = connect()){
        $sql = "UPDATE `users` SET `reset`='{$otptosend}' WHERE `mail` LIKE '{$dest}'";
        if ($run = mysqli_query($con, $sql)){
            echo "true";
        }else{
            echo "error";
        }
    }else{
        echo "error";
    }
?>