<?php
  $mail = $_GET['mail'];
  $pass = $_GET['pass'];
  $user = $_GET['username'];
?>
<script>
  localStorage.setItem("mail", "<?php echo $mail ?>");
  localStorage.setItem("pass", "<?php echo $pass ?>");
  localStorage.setItem("username", "<?php echo $user ?>");
  window.location = "http://pranah.ml";
  </script>
