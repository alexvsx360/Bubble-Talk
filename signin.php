<?php

require_once 'app/helpers.php';
session_start();

if (auth_user()) {

  header('location: ./');
  exit;
}

$page_title = 'Sign in';
$error = '';

if (isset($_POST['submit'])) { // אם הגולש לחץ על הכפתור

  if (isset($_POST['token']) && isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token']) {

    // איסוף הנתונים וניקוי רווחים למשתנים רגילים
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    if (!$email) { // אם הגולש לא הזין שום תו בשדה של האימייל

      $error =  ' * A valid email is reuqired';
    } elseif (!$password) { // אם הגולש לא הזין שום תו בשדה של הסיסמה

      $error = ' * Your password is required';
    } else {

      $link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);
      mysqli_query($link, "SET NAMES utf8");
      $email = mysqli_real_escape_string($link, $email);
      $password = mysqli_real_escape_string($link, $password);
      $sql = "SELECT * FROM users WHERE email = '$email'";
      $result = mysqli_query($link, $sql);

      if ($result && mysqli_num_rows($result) > 0) {

        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {

          $_SESSION['user_name'] = $user['name'];
          $_SESSION['user_id'] = $user['id'];
          $_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR'];
          $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
          header('location: ./');
          exit;
        } else {

          $error = ' * Wrong email or password combination';
        }
      } else {

        $error = ' * Wrong email or password combination';
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
        <h1>Here you can sign in with your account</h1>
        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Perspiciatis repellat sunt illum!</p>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <form method="POST" action="" novalidate="novalidate" autocomplete="off">
          <input type="hidden" name="token" value="<?= $token; ?>">
          <div class="form-group">
            <label for="email">Email:</label>
            <input class="form-control" type="email" name="email" id="email" value="<?= old('email'); ?>">
          </div>
          <div class="form-group">
            <label for="password">Password:</label>
            <input class="form-control" type="password" name="password" id="password">
          </div>
          <input type="submit" name="submit" value="Signin" class="btn btn-primary">
          <span class="text-danger"><?= $error; ?></span>
        </form>
      </div>
    </div>
  </div>
</main>

<?php include 'tpl/footer.php';  ?>