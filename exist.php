<?php
    include('modules/tminc.php');

    if ($conn = connect()){
        if (isset($_GET['username'])){
            $username = clean($_GET['username']);
            $sql = "SELECT * FROM `users` WHERE `username` LIKE '{$username}'";
            if ($get = mysqli_query($conn, $sql)){
                if (0 < mysqli_num_rows($get)){
                    echo "false";
                }else{
                    echo "true";
                }
            }else{
                echo "ERROR CODE 3";
            }
        }else{
            echo "ERROR CODE 2";
        }
    }else{
        echo "ERROR CODE 1";
    }
    mysqli_close($conn);
?>