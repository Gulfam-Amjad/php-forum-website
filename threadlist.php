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
    <?php include 'partials/_header.php'; ?>
    <?php include 'partials/_dbconnect.php'; ?>

    <!-- this will fecth the titile and disc from DB and show in card -->
    <?php
    $id=$_GET['catid'];
    $sql="SELECT * FROM `categories` WHERE category_id=$id";
    $result=mysqli_query($conn,$sql);
    while ($row=mysqli_fetch_assoc($result)) {
        $catname=$row['category_name'];
        $catdesc=$row['category_discription'];
    }
    ?>

    <?php
    $method=$_SERVER['REQUEST_METHOD'];
    $showalert=false;
    // echo $request;
    // inserting the data into the table which i filled intothe form
    if ($method=='POST') {
    $th_title=$_POST['title'];
    $th_disc=$_POST['disc'];
    $sno=$_POST['sno'];

    $sql="INSERT INTO `threads` ( `thread_title`, `thread_disc`, `thread_cat_id`, `thread_user_id`, `created`) VALUES ( '$th_title', '$th_disc', '$id', '$sno', current_timestamp());";
    $result=mysqli_query($conn,$sql);

    $showalert=true;
    if ($showalert) {
        echo '
        <div class="alert alert-success alert-dismissible fade show" role="alert">
             <strong>Success!</strong> you have successfully sumited your thread.
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <span aria-hidden="true">&times;</span>
           </button>
        </div>
        ';
    }
}
    ?>
    <!-- its a jambotron -->
    <div class="container">
        <div class="jumbotron">
            <h1 class="display-4 text-center">Welcome to <?php echo $catname ;?> forum</h1>
            <p class="lead"><?php echo $catdesc ;?></p>
            <hr class="my-4">
            <p>These forums define spam as unsolicited advertisement for goods, services and/or other web sites, orposts
                with little, or completely unrelated content. Do not spam the forumsproduct.</p>

        </div>

        <!-- form -->
        <?php
         if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
         echo'
        <div class="container">
            <form action=" '.$_SERVER['REQUEST_URI'].' " method="post">
                <div class="form-group">
                    <label for="title">Title of problem</label>
                    <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                    <small id="emailHelp" class="form-text text-muted">keep your titile asshort as posible
                        pleease.</small>
                </div>
                <div class="form-group">
                    <label for="text">Description of problem</label>
                    <textarea class="form-control" id="disc" name="disc" rows="3"></textarea>
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
            <p class="lead my-5" style="color: red;"><b> You are not loggedin,Please login first to be start the discussion.</b> </p>
        </div>';
        }
       ?>
        <!-- here are the questions under the jambotron -->
        <div class="container my-3">
            <h1 class="text-center">Browse Questions</h1>

            <?php 
        $id=$_GET['catid'];
        $sql="SELECT * FROM `threads` WHERE thread_cat_id=$id";
        $result=mysqli_query($conn,$sql);
        $noresult=true;
        while ($row=mysqli_fetch_assoc($result)) {
            $noresult=false;
            $threadid=$row['thread_id'];
            $threadtitle=$row['thread_title'];
            $threaddisc=$row['thread_disc'];
            $time=$row['created'];
            $thread_user=$row['thread_user_id'];

            $sql2="SELECT user_email FROM `users` WHERE sno='$thread_user'";
            $resul2=mysqli_query($conn,$sql2);
            $row=mysqli_fetch_assoc($resul2);
     
           echo '<div class="media">
                <img src="img/defaultuser.jpeg" width="40px" class="mr-3" alt="...">
                <div class="media-body">
                    <p class="font-weight-bold m-0">' .$row['user_email']. ' at '.$time.'</p>
                    <h5 class="mt-0"><a href="thread.php?threadid='.$id.'">'.$threadtitle.'</a></h5>
                    <p> '.$threaddisc.' </p>
                </div>
            </div>';

        }

        // echo var_dump($noresult);
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



    </div>



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