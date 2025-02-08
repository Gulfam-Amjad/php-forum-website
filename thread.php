<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title>idiscuss-community app</title>
</head>

<body>
    <?php include 'partials/_dbconnect.php'; ?>
    <?php include 'partials/_header.php'; ?>


    <!-- this will fecth the titile and disc from DB and show in card -->
    <?php
$id = $_GET['threadid'];
$sql = "SELECT * FROM `threads` WHERE thread_cat_id = $id";
$result = mysqli_query($conn, $sql);

// Check if query returned any rows
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $catname = $row['thread_title'];
    $catdesc = $row['thread_disc'];
    $thread_user_id = $row['thread_user_id'];

    // here i am gettig the user name from the users table..because thread_user_id and the user sno are same
    $sql2="SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
    $resul2=mysqli_query($conn,$sql2);
    $row=mysqli_fetch_assoc($resul2);
    $posted_by=$row['user_email'];

 }
 else {
     $catname = "Thread not found";
     $catdesc = "The thread you are looking for does not exist.";
  }
?>


    <div class="container">
        <!-- its a jambotron -->

        <div class="jumbotron">
            <h1 class="display-4 text-center" style="color:green;"><?php echo $catname ;?> forum</h1>
            <p class="lead"><?php echo $catdesc ;?></p>
            <hr class="my-4">
            <h5>Rules must have to follow:</h5>
            <p class="style" style="color:bule;">These forums define spam as unsolicited advertisement for goods, services and/or other web sites, orposts
                with little, or completely unrelated content. Do not spam the forumsproduct.</p>
                <p class="style" style="color: black;">Posted by: <b> <?php echo $posted_by ?> </b></p>
        </div>

 
    </div>

    <!-- this is the php part for POST method -->

    <?php
    $method=$_SERVER['REQUEST_METHOD'];
    $showalert=false;
    // echo $request;
    // inserting the data into the table which i filled intothe form
    if ($method=='POST') {
    $comment=$_POST['comment'];
    $sno=$_POST['sno'];

    $sql="INSERT INTO `comments` ( `comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ('$comment', '$id', '$sno', current_timestamp());";
    $result=mysqli_query($conn,$sql);

    $showalert=true;
    if ($showalert) {
        echo '
        <div class="alert alert-success alert-dismissible fade show" role="alert">
             <strong>Success!</strong> you have successfully sumited your Comment.
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <span aria-hidden="true">&times;</span>
           </button>
        </div>
        ';
    }
}
    
?>

    <!-- here are the questions under the jambotron -->

    <?php
         if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
         echo'
        <div class="container my-3">
           <h1 class="text-center">Browse Questions</h1>
        </div>
        <div class="container">
             <form action="'.$_SERVER['REQUEST_URI'].'" method="post">

               <div class="form-group">
                 <label for="text">Type your comment</label>
                 <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                </div>
                <input type="hidden" name="sno" value=" '.$_SESSION["sno"].' ">
                  <button type="submit" class="btn btn-primary">Submit</button>
             </form>
         </div>';
        }

        else {
            echo'
        <div class="container">
            <h1 class="text-center">Start discustion</h1>
            <p class="lead my-5" style="color: red;"><b> You are not loggedin,Please signup/login first to be start the comments.</b> </p>
        </div>';
        }
?>

    <div class="container my-3">
        <?php 
        $id=$_GET['threadid'];
        $sql="SELECT * FROM `comments` WHERE thread_id=$id";
        $result=mysqli_query($conn,$sql);
        
        $noresult=true;
        while ($row=mysqli_fetch_assoc($result)) {
            $noresult=false;
            $id=$row['comment_id'];
            $content=$row['comment_content'];
            $time=$row['comment_time'];
            $thread_user=$row['comment_by'];

            $sql2="SELECT user_email FROM `users` WHERE sno='$thread_user'";
            $resul2=mysqli_query($conn,$sql2);
            $row=mysqli_fetch_assoc($resul2);
     
           echo '<div class="media">
                <img src="img/defaultuser.jpeg" width="40px" class="mr-2" alt="...">
                <div class="media-body ">
                    <p class="font-weight-bold m-0">' .$row['user_email']. ' at '.$time.'</p>
                    '.$content.'
                </div>
            </div>';

        }

        if ($noresult) {
            echo '
            <div class="jumbotron jumbotron-fluid">
              <div class="container">
                 <p class="display-4">No result Found</p>
                 <p class="lead">Be the efirst person to ask the question.</p>
               </div>
             </div>';
        }
        ?>

    </div>





    <?php include 'partials/_footer.php'; ?>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    -->
</body>

</html>