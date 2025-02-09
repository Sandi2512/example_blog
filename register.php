<?php
session_start();
require 'config/config.php';

if($_POST){
$name =$_POST['name'];
$email=$_POST['email'];
$password=$_POST['password'];

$stmt =$pdo->prepare("SELECT * FROM users WHERE email=:email");

$stmt-> bindValue(':email',$email);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if($user){
  echo"<script>alert('Email duplicated')</script>";
}else{
  

  $stmt =$pdo->prepare("INSERT INTO users(name,email,password) VALUES (:name,:email,:password)");
  $result=$stmt->execute(
    array(':name'=>$name,':email'=>$email,':password'=>$password)
    );
  if ($result){
    echo "<script>alert('Successfully Registered! You can now login');window.location.href='login.php';</script>";
  }

}

}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Blog Register</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>Blog</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Register New Account</p>

      <form action="register.php" method="post">
      <div class="input-group mb-3">
      <input type="text" name="name" class="form-control" placeholder="Name"><br><br>
      <div class="input-group mb-3">
      <input type="email" name="email" class="form-control" placeholder="Email"><br><br>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password"><br>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
       
        
          <!-- /.col -->
          <div class="container">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
            <a href="login.php" class="btn btn-default btn-block">Go Login</a>
          </div>
          <!-- /.col -->
        </div>
      </form>

      
      <!-- /.social-auth-links -->

      
      
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

</body>
</html>