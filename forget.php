<?php
    include('modules/tminc.php');
    meta(
        array(
            "title"=>"Reset Password",
            "custom"=>'<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">'
        )
    );

    $screen = prnt(
        '
        <section>
        <h4 style="display:inline-block;font-weight:bold;margin-bottom:20px">Reset Password</h4>
        <div class="form-group">
          <label for="exampleInputEmail1">New Password</label>
          <input type="password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Password">
          <small id="emailHelp" class="form-text text-muted">Recommended: Make long and complex password out of dictionary.</small>
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Confirm Password</label>
          <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Confirm Password">
        </div>
        <div class="alert alert-primary" role="alert" id="loadingeffect" style="display:none">
            Please Wait...
        </div>
        <button type="submit" id="resetbtn" class="btn btn-primary">Reset</button>
      </section>
        '
    );
    style("
        section{
            width: 70%;
    display: inline-block;
    text-align: left;
    margin-top: 51px;
    background: #ededed;
    padding: 10px;
        }
        body{
            text-align:center
        }
        @media screen and (max-width: 900px){
            section{
                width:95%;
            }

        }
    ");
    export_screen($screen);
    ?>
        <script>
                    console.log('%cNot what you think.', "color: red; font-size: x-large");
            console.log('%cThis is a browser feature intended for developers. If someone told you to copy and paste something here to enable a Pranah feature or "hack" someone\'s account, it is a scam and will give them access to your Pranah account.', "background:black ;color: white; font-size: x-large");
            console.warn("%cBy Entering JS or Commands, etc here you accept that you know all about the code you are enterring, in case if the code exploits your account, Pranah will not be responsible for your account, and in case if it affects Pranah's Server, legal steps will be taken against you, so never try enerring code here.", "font-size:20px");
            console.log("%cBe Wise, don't enter anything here.", "font-size:30px");
            console.log("%cNEVER!.", "font-size:30px");
            console.log("%cNEVER!.", "font-size:30px");
            console.log("%cNEVER!.", "font-size:30px");
            console.log("%cNEVER!.", "font-size:30px");
            console.log("%cNEVER!.", "font-size:30px");
            const auth = "<?php echo $_GET['auth']; ?>";
            const reset = "<?php echo $_GET['account']; ?>";


           
            document.getElementById("resetbtn").addEventListener("click", ()=>{


                if (document.getElementById("exampleInputEmail1").value === document.getElementById("exampleInputPassword1").value && document.getElementById("exampleInputEmail1").value.length > 6){
                    document.getElementById("loadingeffect").style.display="block";
                    $.post(
                    "reset",
                    {
                        account: reset,
                        auth: auth,
                        pass: document.getElementById("exampleInputEmail1").value
                    },
                    function(result){
                        document.getElementById("loadingeffect").style.display="none";
                        if (result.replace(" ", "") === "true"){
                            alert('Account password is now changed, you can now proceed with new password.');
                            window.close();
                        }else{
                            alert(result);
                            window.close();
                        }
                    }
                );
            }
                else{
                    alert('Enter Same and Strong Passwords');
                }
            });
        </script>
    <?php
    close();
?>