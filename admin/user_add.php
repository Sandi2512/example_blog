<?php
session_start();
require '../config/config.php';

if(empty($_SESSION['user_id'])&& empty($_SESSION['logged_in'])){
  header ('Location: login.php');
}

if($_POST){
  $name =$_POST['name'];
  $email=$_POST['email'];
  if(empty($_POST['role'])){
    $role=0;
  }else{
    $role=1;
  }

  $stmt =$pdo->prepare("SELECT * FROM users WHERE email=:email");

  $stmt->bindValue(':email',$email);
  $stmt->execute();
  $user=$stmt->fetch(PDO:FETCH_ASSOC);

  if($user) {
    echo"<script>alert('Email duplicated')</script>";
  }else{
    $stmt= $pdo->prepare("INSERT INTO users(name,email,role) VALUES (:name,:email,:role)");
    $result= $stmt->execute(
    array(':name'=>$name,'email'=>$email,':role'=>$role)
    );
    if($result){
      echo"<script>alert('Successfully added');window.location.href='user_list.php';</script>";
    }
  }
 
}
?>

<?php include('header.html');?>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <div class="card">
          <div class="card-body">
          <form action="user_details.php" method="post">
  <div class="form-group">
    <label for="name">Name</label>
    <input type="text" class="form-control" name="name" required>
  </div>
  <div class="form-group">
    <label for="email">Email</label>
    <input type="email" class="form-control" name="email" required>
  </div>
  <div class="form-group">
    <label for="vechicle3">Admin</label>
    <input type="checkbox"  name="role">
  </div>
  <div class="form-group">
    <input type="submit" class="btn btn-success" value="Submit">
    <a href="user_details.php" class="btn btn-warning">Back</a>
  </div>
</form>

          </div>


            </div>
            <!-- /.card -->

           
            </div>
            </div>
           
            </div>
          </div>
          <!-- /.col-md-6 -->
        </div>