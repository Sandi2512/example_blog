 <?php
session_start();
require '../config/config.php';

if(empty($_SESSION['user_id'])&& empty($_SESSION['logged_in'])){
  header ('Location: login.php');
}

if($_POST){
  
  if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']) || strlen($_POST['password'])<4){
    if(empty($_POST['name'])){
      $nameError ='Name cannot be null';
    }
    if(empty($_POST['email'])){
      $emailError ='Email cannot be null';
    }
    if(empty($_POST['password'])){
      $passwordError ='Password cannot be null';
    }
    if(strlen($_POST['password'])<4){
      $passwordError="Password should be at least 4 characters";
    }
  }else{
  $name =$_POST['name'];
  $email=$_POST['email'];
  $password=password_hash($_POST['password'],PASSWORD_DEFAULT);
      if(empty($_POST['role'])){
        $role=0;
      }else{
        $role=1;
      }
    
      $stmt =$pdo->prepare("SELECT * FROM users WHERE email=:email");
    
      $stmt->bindValue(':email',$email);
      $stmt->execute();
      $user=$stmt->fetch(PDO::FETCH_ASSOC);
    
      if($user) {
        echo"<script>alert('Email duplicated')</script>";
      }else{
        $stmt= $pdo->prepare("INSERT INTO users(name,email,password,role) VALUES (:name,:email,:password,:role)");
        $result= $stmt->execute(
        array(':name'=>$name,'email'=>$email,':password'=>$password,':role'=>$role)
        );
        if($result){
          echo"<script>alert('Successfully added');window.location.href='user_details.php';</script>";
        }
      }
    }
  }
?>

<?php include('header.php');?>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <div class="card">
          <div class="card-body">
          <form action="user_add.php" method="post">
  <div class="form-group">
    <label for="name">Name</label><p style="color:red"><?php echo empty($nameError) ? '' :'*'. $nameError; ?></p>
    <input type="text" class="form-control" name="name">
  </div>
  <div class="form-group">
    <label for="email">Email</label><p style="color:red"><?php echo empty($emailError) ? '' :'*'. $emailError; ?></p>
    <input type="email" class="form-control" name="email">
  </div>
  <div class="form-group">
    <label for="">Password</label><p style="color:red"><?php echo empty($passwordError) ? '' :'*'. $passwordError; ?></p>
  <input type="password" name="password" class="form-control"><br>
</div>
  <div class="form-group">
    <label for="vechicle3">Admin</label><br>
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

        
