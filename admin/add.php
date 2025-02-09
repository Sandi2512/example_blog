<?php
session_start();
require '../config/config.php';

if(empty($_SESSION['user_id'])&& empty($_SESSION['logged_in'])){
  header ('Location: login.php');
}

if($_POST){
  if(empty($_POST['title']) || empty($_POST['content']) || empty($_FILES['image'])){
    if(empty($_POST['title'])){
      $titleError ='Title cannot be null';
    }
    if(empty($_POST['content'])){
      $contentError ='Content cannot be null';
    }
    if(empty($_FILES['image'])){
      $imageError ='Image cannot be null';
    }
  }else{
  $file='images/'.($_FILES['image'] ['name']);
  $imageType=pathinfo($file,PATHINFO_EXTENSION);

  if($imageType != 'png' && $imageType !='jpeg' && $imageType !='jpg'){
    echo "<script>alert('Image must be png.jpg.jpeg')</script>";
  }else{
    $title=$_POST['title'];
    $content=$_POST['content'];
    $image =$_FILES['image']['name'];

    move_uploaded_file($_FILES['image']['tmp_name'],$file);

    $stmt =$pdo->prepare("INSERT INTO posts(title,content,image,author_id) VALUES (:title,:content,:image,:author_id)");
    $result=$stmt->execute(
      array(':title'=>$title,':content'=>$content,':image'=>$image,'author_id'=>$_SESSION['user_id'])
      );
    if ($result){
      echo "<script>alert('Successfully added');window.location.href='index.php';</script>";
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
          <form action="add.php" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label for="title">Title</label><p style="color:red"><?php echo empty($titleError) ? '' :'*'. $titleError; ?></p>
    <input type="text" class="form-control" name="title" >
  </div>
  <div class="form-group">
    <label for="content">Content</label><p style="color:red"><?php echo empty($contentError) ? '' : '*'. $contentError; ?></p>
    <textarea class="form-control" name="content" rows="8"></textarea>
  </div>
  <div class="form-group">
    <label for="image">Image</label><p style="color:red"><?php echo empty($imagetError) ? '' : '*'. $imageError; ?></p><br>
    <input type="file" name="image" >
  </div>
  <div class="form-group">
    <input type="submit" class="btn btn-success" value="Submit">
    <a href="index.php" class="btn btn-warning">Back</a>
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
