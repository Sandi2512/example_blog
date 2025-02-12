<?php
session_start();
require '../config/config.php';

if(empty($_SESSION['user_id'])&& empty($_SESSION['logged_in'])){
  header ('Location: login.php');
}
if($_POST){
  if(empty($_POST['name']) || empty($_POST['email'])){
    if(empty($_POST['name'])){
      $nameError ='Name cannot be null';
    }
    if(empty($_POST['email'])){
      $emailError ='Email cannot be null';
    }
   } elseif(!empty($_POST['password']) && strlen($_POST['password'])<4){
      $passwordError="Password should be at least 4 characters";
}else{
  $id =$_POST['id'];
  $name=$_POST['name'];
  $email=$_POST['email'];
  $password=password_hash($_POST['password'],PASSWORD_DEFAULT);
  if(empty($_POST['role'])){
    $role=0;
  }else{
    $role=1;
  }

  $stmt =$pdo->prepare("SELECT * FROM users WHERE email=:email AND id!=:id");;
  $stmt->execute(array(':email'=>$email, ':id'=>$id));

  $user=$stmt->fetch(PDO::FETCH_ASSOC);

  if($user){
    echo "<script>alert('Email duplicated')</script>";
  }else{
    if($password !=null){
      $stmt =$pdo->prepare("UPDATE users SET name='$name',email='$email',password='$password',role='$role' WHERE id='$id' ");
    }else{
      $stmt =$pdo->prepare("UPDATE users SET name='$name',email='$email',role='$role' WHERE id='$id' ");
    }
   
    
    $result=$stmt->execute();
    if($result){
      echo "<script>alert('Successfully Updated');window.location.href='user_details.php';</script>";
    }
  }
}
}
  
$stmt=$pdo->prepare("SELECT * FROM users WHERE id=".$_GET['id']);
$stmt->execute();
$result =$stmt->fetchAll();
?>
<?php include('header.php');?>
    <!-- Main content -->
   
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <div class="card">
          <div class="card-body">
          <form class="" action=" " method="post" enctype="multipart/form-data">
  <div class="form-group">
    <input type="hidden" name="id" value="<?php echo $result[0]['id']?>">
    <label for="name">Name</label><p style="color:red"><?php echo empty($nameError) ? '' :'*'. $nameError; ?></p>
    <input type="text" class="form-control" name="name" value="<?php echo $result[0] ['name']?>">
  </div>
  <div class="form-group">
    <label for="email">Email</label><br><p style="color:red"><?php echo empty($emailError) ? '' :'*'. $emailError; ?></p>
    <textarea class="form-control" name="email" rows="8" cols="80"><?php echo $result[0] ['email']?></textarea>
  </div>
  <div class="form-group">
    <label for="">Password</label><p style="color:red"><?php echo empty($passwordError) ? '' :'*'. $passwordError; ?></p>
    <span style="font-size:10px">The user already has a password</span>
    <input type="password" name="password" class="form-control">
</div>
  <div class="form-group">
    <label for="role">Role</label><br>
    <input type="text" class="form-control" name="role" value="<?php echo $result[0] ['role']?>" required>

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
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  
  <?php include('footer.html');