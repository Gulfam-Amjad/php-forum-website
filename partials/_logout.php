
<?php  
session_start();
echo "you are logging out,Please wait a while....";

session_destroy();
header("Location: /forum/index.php");
?>