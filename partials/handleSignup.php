<?php
$showalart= "false";
if($_SERVER['REQUEST_METHOD']== "POST"){
    
    include "_dbconnect.php";
    
    $user_email=$_POST['signupEmail'];
    $pass=$_POST['signupPassword'];
    $cpass=$_POST['signupcPassword'];

    $sql="SELECT * FROM `users` WHERE user_email='$user_email'";
    $result=mysqli_query($conn,$sql);

    // check wheather the email is alredy existed?
    $numrows=mysqli_num_rows($result);
    if ($numrows>0) {
       $showerror="email is already in use";
    }

    else {
       if ($pass==$cpass) {
        $hash=password_hash($pass, PASSWORD_DEFAULT);
        $sql="INSERT INTO `users` ( `user_email`, `user_pass`, `timestamp`) VALUES ('$user_email', '$hash', current_timestamp());";
        $result=mysqli_query($conn, $sql);
        if ($result) {
            $showalart=true;
            header("Location: /forum/index.php?signupsuccess=true");
            exit();
        }


       }
       else {
        $showerror="passwords do not match";
       }
       header("Location: /forum/index.php?signupsuccess=false&error=$showerror");
    }
}

?>