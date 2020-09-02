<?php

require_once 'app/helpers.php';
session_start();

if (!auth_user()) {
  header('location: signin.php');
  exit;
}

$pid = filter_input(INPUT_GET, 'pid', FILTER_SANITIZE_STRING);

if ($pid && is_numeric($pid)) {

  $uid = $_SESSION['user_id'];
  $link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);
  $pid = mysqli_real_escape_string($link, $pid);
  mysqli_query($link, "SET NAMES utf8");
  $sql = "SELECT * FROM posts WHERE id = $pid AND user_id = $uid";

  $result = mysqli_query($link, $sql);

  if ($result && mysqli_num_rows($result) == 1) {

    $post = mysqli_fetch_assoc($result);
  } else {
    header('location: blog.php');
    exit;
  }
} else {

  header('location: blog.php');
  exit;
}

$page_title = 'Edit post form';

$errors = [
  'title' => '',
  'article' => '',
];

if (isset($_POST['submit'])) {

  $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
  $article = filter_input(INPUT_POST, 'article', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
  $form_valid = true;

  if (!$title || mb_strlen($title) < 3) {
    $errors['title'] = ' * Title is required for min 3 chars.';
    $form_valid = false;
  }

  if (!$article || mb_strlen($article) < 3) {
    $errors['article'] = ' * Article is required for min 3 chars.';
    $form_valid = false;
  }

  if ($form_valid) {
    $uid = $_SESSION['user_id'];
    $link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);
    mysqli_query($link, "SET NAMES utf8");
    $title = mysqli_real_escape_string($link, $title);
    $article = mysqli_real_escape_string($link, $article);
    $sql = "UPDATE posts SET title = '$title',article = '$article' WHERE id = $pid AND user_id = $uid";
    mysqli_query($link, $sql);
    header('location: blog.php');
    exit;
  }
}

?>

<?php include 'tpl/header.php';  ?>

<main>
  <div class="container">
    <div class="row">
      <div class="col-12 mt-5">
        <h1>Edit Post Form</h1>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <form action="" method="POST" autocomplete="off" novalidate="novalidate">
          <div class="form-group">
            <label for="title">* Title:</label>
            <input value="<?= $post['title']; ?>" type="text" name="title" id="title" class="form-control">
            <span class="text-danger"><?= $errors['title']; ?></span>
          </div>
          <div class="form-group">
            <label for="article">* Article:</label>
            <textarea class="form-control" name="article" id="article" cols="30" rows="10"><?= $post['article']; ?></textarea>
            <span class="text-danger"><?= $errors['article']; ?></span>
          </div>
          <a class="btn btn-secondary" href="blog.php">Cancel</a>
          <input type="submit" value="Update post" name="submit" class="btn btn-primary">
        </form>
      </div>
    </div>
  </div>
</main>

<?php include 'tpl/footer.php';  ?>