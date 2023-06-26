<?php
    include_once('./string.php');
    
    function errorc($msg){
        ?>
        <script>
            var errmsg = 'Error shooted!, see CONSOLE for issue and its fix.';
           alert(errmsg);
           console.error('SOME ERROR FOUND! CHECK BELOW');
           console.warn('<?php echo $msg; ?>');
           </script>
            <?php
    }

    function backend($array){
        foreach ($array as $key => $val){
            if ($key === "import"){
                foreach ($val as $path){
                if (file_exists("lib/".$path."/index.php")){
                    include_once("lib/".$path."/index.php");
                }
            }
            }
        }
    }

    function prettyPrint( $json )
{
    $result = '';
    $level = 0;
    $in_quotes = false;
    $in_escape = false;
    $ends_line_level = NULL;
    $json_length = strlen( $json );

    for( $i = 0; $i < $json_length; $i++ ) {
        $char = $json[$i];
        $new_line_level = NULL;
        $post = "";
        if( $ends_line_level !== NULL ) {
            $new_line_level = $ends_line_level;
            $ends_line_level = NULL;
        }
        if ( $in_escape ) {
            $in_escape = false;
        } else if( $char === '"' ) {
            $in_quotes = !$in_quotes;
        } else if( ! $in_quotes ) {
            switch( $char ) {
                case '}': case ']':
                    $level--;
                    $ends_line_level = NULL;
                    $new_line_level = $level;
                    break;

                case '{': case '[':
                    $level++;
                case ',':
                    $ends_line_level = $level;
                    break;

                case ':':
                    $post = " ";
                    break;

                case " ": case "\t": case "\n": case "\r":
                    $char = "";
                    $ends_line_level = $new_line_level;
                    $new_line_level = NULL;
                    break;
            }
        } else if ( $char === '\\' ) {
            $in_escape = true;
        }
        if( $new_line_level !== NULL ) {
            $result .= "\n".str_repeat( "\t", $new_line_level );
        }
        $result .= $char.$post;
    }

    return $result;
}



    function clean($string) {
        $string = str_replace(".", "-dot-pranah-", $string);
        $string = str_replace("@", "-at-the-rate-", $string);
        $string = str_replace(' ', '', $string);
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);
        $string = str_replace("-dot-pranah-", ".", $string);
        $string = str_replace("-at-the-rate-", "@", $string);
        return str_replace("-", "", $string);  // Removes special chars. 
    }
    function cleanWithSpaces($string) {
        $string = str_replace(".", "-dot-pranah-", $string);
        $string = str_replace("@", "-at-the-rate-", $string);
        $string = str_replace(' ', '--tmincspaces--', $string);
        $string = str_replace('+', '--tmincadd--', $string);
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);
        $string = str_replace("-dot-pranah-", ".", $string);
        $string = str_replace('--tmincadd--', '+', $string);
        $string = str_replace("-at-the-rate-", "@", $string);
        $string = str_replace("--tmincspaces--", " ", $string);  // Removes special chars. 
        $string = str_replace("--", "", $string);
        return $string;
    }
    function linient($string){
        $string = str_replace("--", "", $string);
        $string = str_replace("'", "\'", $string);
        return $string;
    }
    function alert($msg){
        echo "<script>alert('{$msg}');</script>";
    }
    function export_screen($screen){
        echo $screen;
    }
    function upload($files, $directory){
        $size = $files['size'];
        $filename = $files['name'];
        $namear = explode(".", $filename);
        $fname = date("Ymd") ."". time()."".$namear[0];
        $fname = md5(base64_encode($fname));
        $fname = "{$fname}.{$namear[1]}";
        $tempname = $files['tmp_name'];
        $folder = $_SERVER['DOCUMENT_ROOT']."/pranah"."/".$directory."/".str_replace(" ", "", $fname);
        move_uploaded_file($tempname, $folder);
        return "http://ac6f0eda748b.ngrok.io/photos/{$fname}"; //RETURNS FILE PATH
        // return $folder;
    }
    function save_cookie($key, $val){
        setcookie($key, $val, time() + (86400 * 30), "/"); // 86400 = 1 day 
    }
    function cookie($cookiename){
        return $_COOKIE[$cookiename];
    }
    function style($code){
        ?>
            <style><?php echo $code; ?></style>
        <?php
    }
    function delete_cookie($cookiename){
        ?><script>
        document.cookie = "<?php echo $cookiename ?>=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/";
        </script>
        <?php
        if (!isset($_COOKIE[$cookiename])){
            return true;
        }else{
            return false;
        }
    }
    function open($dest){
        ?>
            <script>
                window.location="<?php echo $dest; ?>";
            </script>
        <?php
    }
    function error($msg){
        ?>
            <script>
                console.error('<?php echo str_replace("'", "\'", $msg); ?>');
            </script>
        <?php
    }
    // function interval
    function console($msg){
        ?>
            <script>
                console.log('<?php echo str_replace("'", "\'", $msg); ?>');
            </script>
        <?php
    }
    function warn($msg){
        ?>
            <script>
                console.warn('<?php echo str_replace("'", "\'", $msg); ?>');
            </script>
        <?php
    }
    function encrypt($tag, $value){
        setcookie(md5($tag), base64_encode($value), time() + (86400 * 30), "/"); // 86400 = 1 day 
    }
    function md5cook($tag, $val){
        setcookie(md5($tag), base64_encode(md5($val)), time() + (86400 * 30), "/"); // 86400 = 1 day 
    }
    function dccook($key){
        return base64_decode(
            $_COOKIE[md5($key)]
        );
    }
    
    function save_local($tag, $val){
        ?>
        <script>
        localStorage.setItem($tag, $val);
        </script>
        <?php
    }
    function del_local($tag){
        ?>
        <script>
        localStorage.removeItem($tag);
        </script>
        <?php
    }
    function loadevent($function){
        ?>
        <script>
        $(document).ready(function() {
            <?php echo $function; ?>
        });
        </script>
        <?php
    }
    function import($arr){
        foreach($arr as $each){
            include_once('./comp/'.$each.'.php');
        }
    }
    function clicked($id, $function){
        ?>
            <script>
                document.getElementById("<?php echo $id; ?>").addEventListener("click", ()=>{<?php echo $function; ?>});
            </script>
        <?php
    }
    function mouseover($id, $function){
        ?>
            <script>
                document.getElementById("<?php echo $id; ?>").addEventListener("mouseover", ()=>{<?php echo $function; ?>});
            </script>
        <?php
    }
    function notify($title, $message){
        ?>
            <script>
            notify("<?php echo $title; ?>", "<?php echo $message; ?>");
            </script>
        <?php
    }

    function addActivityNotice($array, $con){
        $rel = $array['rel'];
        $for = $array['for'];
        $hindi = $array['hindi'];
        $english = $array['english'];

        date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)
        $current_time = date('d/m/Y H:i');

        $sql_to_hit = "INSERT INTO `activity`(`relMail`, `mail`, `hindiSnap`, `snap`, `time`) VALUES ('{$rel}','{$for}','{$hindi}','{$english}','{$current_time}')";
        if (mysqli_query($con, $sql_to_hit)){
            echo $sql_to_hit;
        }else{
            echo $sql_to_hit;
        }
    }
?>