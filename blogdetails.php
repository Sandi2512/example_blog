<?php

require 'config/config.php';
session_start();

// Redirect to login if the user is not logged in
if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
    header('Location: login.php');
    exit;
}

// Validate and sanitize the 'id' parameter from the URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    // Invalid post ID, handle the error (e.g., show an error page)
    die("Invalid post ID");
}

$blogId = $_GET['id'];

// Use prepared statements with placeholders to avoid SQL injection
$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = :id");
$stmt->bindParam(':id', $blogId, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetchAll();

// Check if post exists
if (empty($result)) {
    die("Post not found");
}

// Get comments related to the post
$stmtcmt = $pdo->prepare("SELECT * FROM comments WHERE post_id = :post_id");
$stmtcmt->bindParam(':post_id', $blogId, PDO::PARAM_INT);
$stmtcmt->execute();
$cmResult = $stmtcmt->fetchAll();

// Check if comments exist
if (!empty($cmResult)) {
    $authorId = $cmResult[0]['author_id'];

    // Fetch the author details
    $stmtau = $pdo->prepare("SELECT * FROM users WHERE id = :author_id");
    $stmtau->bindParam(':author_id', $authorId, PDO::PARAM_INT);
    $stmtau->execute();
    $auResult = $stmtau->fetchAll();
} else {
    // Handle case where there are no comments
    $auResult = null; // No author details if there are no comments
}






$blogId =$_GET['id'];
if($_POST){
  $comment =$_POST['comment'];
  $stmt =$pdo->prepare("INSERT INTO comments(content,author_id,post_id) VALUES (:content,:author_id,:post_id)");
  $result=$stmt->execute(
    array(':content'=>$comment,'author_id'=>$_SESSION['user_id'],':post_id'=>$blogId)
      );
    if ($result){
     header('Location: blogdetails.php?id='.$blogId);
    }
  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Blog Site</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->

    <!-- Right navbar links -->
    

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="margin-left:0px !important">
    <!-- Content Header (Page header) -->
    <!-- /.container-fluid -->
      <div class="row">
          <div class="col-md-12">
            <!-- Box Comment -->
            <div class="card card-widget">
            <div class="card-header">
                <div style="text-align:center !important;float:none" class="card-title">
                  <h4><?php echo $result[0]['title']?></h4>
              </div>
              
                <!-- /.user-block -->
               
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <img class="img-fluid pad" src="admin/images/<?php echo $result[0]['image']?>" style="height:200px  !important";>
<br><br>

                <p><?php echo $result[0]['content']?></p>
                <h3>Comments</h3><hr>
                <a href="/blog/blog" type="button" class="btn btn-default">Go Back</a>
              </div>
              <!-- /.card-body -->
              
              <div class="card-footer card-comments">
                <div class="card-comment">
                  <!-- User image -->
                  
                  <div class="comment-text" style="margin-left:0px !important">
                  <?php
// Display the author's name and comment content only if available

if (!empty($auResult) && isset($auResult[0]['name'])) {
    echo '<span class="username">' . htmlspecialchars($auResult[0]['name']) . '</span>';
} else {
    echo '<span class="username">Unknown Author</span>';
}

// Display the comment's creation date and content only if available
if (!empty($cmResult) && isset($cmResult[0]['created_at']) && isset($cmResult[0]['content'])) {
    echo '<span class="text-muted float-right">' . htmlspecialchars($cmResult[0]['created_at']) . '</span>';
    echo htmlspecialchars($cmResult[0]['content']);
} else {
    echo '<span class="text-muted float-right">No comments available</span>';
    echo '<p>No content available for this comment.</p>';
}
?>

                  </div>
                  <!-- /.comment-text -->
                </div>
                <!-- /.card-comment -->
                
                  <!-- User image -->
                  

                  
                  <!-- /.comment-text -->
                
                <!-- /.card-comment -->
              </div>

              
              <!-- /.card-footer -->
              <div class="card-footer">
                <form action=" " method="post">
                  
                  <!-- .img-push is used to add margin to elements next to floating images -->
                  <div class="img-push">
                    <input type="text" name="comment" class="form-control form-control-sm" placeholder="Press enter to post comment">
                  </div>
                </form>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          
    <!-- Main content -->
    
    <!-- /.content -->

    <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a>
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer" style="margin-left:0px !important">
  <!-- To the right -->
  <div class="float-right d-none d-sm-inline">
    <a href="logout.php" type="button" class="btn btn-default">Log Out</a>
  </div>
  <!-- Default to the left -->
  <strong>Copyright &copy; 2025 <a href="#">A Programmer</a>.</strong> Blog Post
</footer>
</div>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>