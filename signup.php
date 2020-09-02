<?php

require_once 'app/helpers.php';
session_start();

if (auth_user()) {

  header('location: ./');
  exit;
}

$page_title = 'Sign up';

$errors = [
  'name' => '',
  'email' => '',
  'password' => '',
];

$ext = ['png', 'jpeg', 'jpg', 'gif', 'bmp'];
define('MAX_SIZE', 1024 * 1024 * 5);

if (isset($_POST['submit'])) {

  if (isset($_POST['token']) && isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token']) {

    $link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);
    mysqli_query($link, "SET NAMES utf8");
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $name = mysqli_real_escape_string($link, $name);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $email = mysqli_real_escape_string($link, $email);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $password = mysqli_real_escape_string($link, $password);
    $form_valid = true;

    if (!$name || mb_strlen($name) < 3 || mb_strlen($name) > 100) {

      $errors['name'] = ' * Name is required for min: 3 and max: 100';
      $form_valid = false;
    }

    if (!$email) {

      $errors['email'] = ' * A valid email is required';
      $form_valid = false;
    } elseif (email_exists($link, $email)) {

      $errors['email'] = '* Email is taken';
      $form_valid = false;
    }

    if (!$password || strlen($password) < 6 || strlen($password) > 20) {

      $errors['password'] = ' * Password is required for min:6 and max: 20';
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

                $file_name = date('Y.m.d.H.i.s') . '-' . $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], 'images/' . $file_name);
              }
            }
          }
        }
      }

      $password = password_hash($password, PASSWORD_BCRYPT);
      $sql = "INSERT INTO users VALUES(null,'$name','$email','$password')";
      $result = mysqli_query($link, $sql);

      if ($result && mysqli_affected_rows($link) > 0) {

        $uid = mysqli_insert_id($link);
        $sql = "INSERT INTO users_profile VALUES(null,$uid,'$file_name')";
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
  $token = csrf_token();
} else {

  $token = csrf_token();
}


?>

<?php include 'tpl/header.php';  ?>

<main>
  <div class="container">
    <div class="row">
      <div class="col-12 mt-5">
        <h1>Here you can signup for new account</h1>
        <p>Lorem ipsum dolor sit amet.</p>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <form method="POST" action="" novalidate="novalidate" autocomplete="off" enctype="multipart/form-data">
          <input type="hidden" name="token" value="<?= $token; ?>">
          <div class="form-group">
            <label for="name">Name:</label>
            <input class="form-control" type="text" name="name" id="name" value="<?= old('name'); ?>">
            <span class="text-danger"><?= $errors['name']; ?></span>
          </div>
          <div class="form-group">
            <label for="email">Email:</label>
            <input class="form-control" type="email" name="email" id="email" value="<?= old('email'); ?>">
            <span class="text-danger"><?= $errors['email']; ?></span>
          </div>
          <div class="form-group">
            <label for="password">Password:</label>
            <input class="form-control" type="password" name="password" id="password">
            <span class="text-danger"><?= $errors['password']; ?></span>
          </div>
          <div class="form-group">
            <label for="">Profile Image:</label>
          </div>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
            </div>
            <div class="custom-file">
              <input type="file" name="image" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
              <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
            </div>
          </div>
          <input type="submit" name="submit" value="Signup" class="btn btn-primary">
        </form>
      </div>
    </div>
  </div>
</main>

<?php include 'tpl/footer.php';  ?>