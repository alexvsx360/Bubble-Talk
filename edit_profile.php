<?php

require_once 'app/helpers.php';
session_start();

if (!auth_user()) {
  header('location: signin.php');
  exit;
}





$page_title = 'edit info form';

$ext = ['png', 'jpeg', 'jpg', 'gif', 'bmp'];
define('MAX_SIZE', 1024 * 1024 * 5);

$errors = [
  'name' => '',
  'email' => '',
  'password'=>'',
];

if (isset($_POST['submit'])) {
 
  $link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);
  mysqli_query($link,'SET NAMES utf8');
  $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
  
  $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
 
  $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

  $form_valid = true;

  if (!$name || mb_strlen($name) < 3) {
    $errors['name'] = ' * name is required for min 3 chars.';
    $form_valid = false;
  }

  if (!$email || mb_strlen($email) < 3) {
    $errors['email'] = ' * email is not valid.';
    $form_valid = false;
  }
  if (!$password || mb_strlen($password) < 3) {
    $errors['password'] = ' * password is required for min 3 chars.';
    $form_valid = false;
  }
  $file_name = 'default.png';
  if ($form_valid) {
   
  
  if (isset($_FILES['image']['error']) && $_FILES['image']['error'] == 0) {

    if (isset($_FILES['image']['tmp_name']) && is_uploaded_file($_FILES['image']['tmp_name'])) {

      if (isset($_FILES['image']['size']) && $_FILES['image']['size'] <= MAX_SIZE) {

        if (isset($_FILES['image']['name'])) {

          $fileinfo = pathinfo($_FILES['image']['name']);

          if (in_array(strtolower($fileinfo['extension']), $ext)) {

            $file_name = date('Y.m.d.H.i.s') . '-' .   $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], 'images/' . $file_name);
        
          }
        }
      }
    }
  }



  $uid = $_SESSION['user_id'];
  $sql2 = "SELECT avatar,user_id FROM users_profile WHERE users_profile.user_id = '$uid'";
$result2 = mysqli_query($link,$sql2);
if(!empty($result2)){
$sql3 = "DELETE FROM users_profile WHERE users_profile.user_id = '$uid'";
$result3 = mysqli_query($link,$sql3);

}

    
    
    $link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);
    $name = mysqli_real_escape_string($link, $name);
    $email = mysqli_real_escape_string($link, $email);
    $password = mysqli_real_escape_string($link, $password);
    $password = password_hash($password, PASSWORD_BCRYPT);
    $sql = "UPDATE users SET name = '$name',email = '$email',password = '$password' WHERE id =  $uid";
    $result = mysqli_query($link,$sql);
    header("location: blog.php");
  

    if ($result && mysqli_affected_rows($link) > 0) {

      
      $uid = $_SESSION['user_id'];
      $sql = "INSERT INTO users_profile VALUES(null,'$uid','$file_name')";
      $result = mysqli_query($link, $sql);

      if ($result && mysqli_affected_rows($link) > 0) {

        $_SESSION['user_name'] = $name;
        $_SESSION['user_id'] = $uid;
        $_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR'];
        $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];

        header('location: blog.php');
        exit;
      }
    }

  }


}

?>

<?php include 'tpl/header.php';  ?>

<main>
  <div class="container">
    <div class="row">
      <div class="col-12 mt-5">
        <h1>edit information Form</h1>

        <small>*<b>note:</b> you need to change the name email and password*</small>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <form method="POST" action="" novalidate="novalidate" autocomplete="off" enctype="multipart/form-data">
          <div class="form-group">
            <label for="name">* Name:</label>
            <input value="<?=
             old('name');?>" type="text" name="name" id="name" class="form-control">
            <span class="text-danger"><?= $errors['name']; ?></span>
          </div>
          <div class="form-group">
            <label for="password">* password:</label>
            <input value="<?=
             old('email');?>" type="text" name="password" id="password" class="form-control">
            <span class="text-danger"><?= $errors['password']; ?></span>
          </div>
          <div class="form-group">
            <label for="email">* email:</label>
            <input value="<?=
             old('password');?>" type="text" name="email" id="email" class="form-control">
            <span class="text-danger"><?= $errors['email']; ?></span>
          </div>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
            </div>
            <div class="custom-file">
              <input type="file" name="image" class="custom-file-input" id="inputGroupFile01"
                aria-describedby="inputGroupFileAddon01">
              <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
            </div>
          </div>
          <a class="btn btn-secondary" href="blog.php">Cancel</a>
          <input type="submit" value="Update info" name="submit" class="btn btn-primary" id="sub">
        </form>
      </div>
    </div>
  </div>
</main>

<?php include 'tpl/footer.php';  ?>