<?php

require_once 'app/helpers.php';
session_start();

if (!auth_user()) {
  header('location: signin.php');
  exit;
}

$page_title = 'Add post form';

$errors = [
  'title' => '',
  'article' => '',
];
$form_valid = true;
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
    //mysqli_set_charset($link, 'utf8');
    $title = mysqli_real_escape_string($link, $title);
    $article = mysqli_real_escape_string($link, $article);
    $sql = "INSERT INTO posts VALUES(null, $uid, '$title', '$article', NOW())";
    $result = mysqli_query($link, $sql);

    if ($result && mysqli_affected_rows($link) > 0) {
      header('location: blog.php');
      exit;
    }
  }
}

?>

<?php include 'tpl/header.php';  ?>

<main>
  <div class="container">
    <div class="row">
      <div class="col-12 mt-5">
        <h1>Add Post Form</h1>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <form action="" method="POST" autocomplete="off" novalidate="novalidate">
          <div class="form-group">
            <label for="title">* Title:</label>
            <input value="<?= old('title'); ?>" type="text" name="title" id="title" class="form-control">
            <span class="text-danger"><?= $errors['title']; ?></span>
          </div>
          <div class="form-group">
            <label for="article">* Article:</label>
            <textarea class="form-control" name="article" id="article" cols="30" rows="10"><?= old('article'); ?></textarea>
            <span class="text-danger"><?= $errors['article']; ?></span>
          </div>
          <a class="btn btn-secondary" href="blog.php">Cancel</a>
          <input type="submit" value="Save" name="submit" class="btn btn-primary">
        </form>
      </div>
    </div>
  </div>
</main>

<?php include 'tpl/footer.php';  ?>