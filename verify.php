<?php
    include('modules/tminc.php');
    meta(
        array(
            "title"=>"Verification",
            "custom"=>'<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">'
        )
    );

    if ($conn = connect()){
        if (isset($_GET['auth']) && isset($_GET['account']) && $_GET['auth'] != ""){
            $mail = clean(base64_decode($_GET['account']));
            $otp = clean($_GET['auth']);
            $sql = "SELECT * FROM `users` WHERE `mail` LIKE '{$mail}' AND `verify` LIKE '{$otp}'";
            if ($check = mysqli_query($conn, $sql)){
                if (0 < mysqli_num_rows($check)){


                    while ($row = mysqli_fetch_array($check)){
                        $id = $row['id'];
                    }

                    $nsql = "UPDATE `users` SET `verify`='true' WHERE `id` LIKE '{$id}'";
                    if (mysqli_query($conn, $nsql)){
                        $screen = '<div class="alert alert-success" role="alert">
                        Verification Done!
                    </div>';
                    ?>
                        <script>
                            setTimeout(() => {
                                window.close();
                            }, 10000);
                        </script>
                    <?php 
                    }else{
                        $screen = '<div class="alert alert-danger" role="alert">Error.</div>';
                    }

                }else{
                    $screen = '<div class="alert alert-danger" role="alert">
                                Data Missing, Wrong URL
                            </div>';        
                }
            }else{
                $screen = '<div class="alert alert-danger" role="alert">
                                Data Missing, Wrong URL
                            </div>';    
            }

        }else{
            $screen = '<div class="alert alert-danger" role="alert">
                            Data Missing, Wrong URL
                        </div>';
        }
        
    }else{
        
        $screen = prnt(
            "Error While Verification"
        );
        alert("Error");
        script("window.close()");
        
    }
    export_screen($screen);
    close();
    mysqli_close($conn);
?>