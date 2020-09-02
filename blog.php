<?php

require_once 'app/helpers.php';
session_start();

$page_title = 'Blog Page';
$link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);
mysqli_query($link, "SET NAMES utf8");
$sql = "SELECT up.avatar,u.name,p.*,DATE_FORMAT(p.date, '%d/%m/%Y %H:%i:%s') pdate,p.user_id FROM posts p 
        JOIN users u on u.id = p.user_id 
        JOIN users_profile up ON u.id = up.user_id
        ORDER BY p.date DESC";

$result = mysqli_query($link, $sql);

?>

<?php include 'tpl/header.php';  ?>

<main>
  <div class="container">
    <div class="row">
      <div class="col-12 mt-5">
        <h1>Blog Page</h1>
        <p class="mt-3">
          <?php if (auth_user()) : ?>
            <a class="btn btn-primary" href="add_post.php">
              <i class="fas fa-plus-circle"></i>
              Add Post
            </a>
          <?php else : ?>
            <a class="btn btn-primary" href="signup.php">
              Signup for new account
            </a>
          <?php endif; ?>
        </p>
      </div>
    </div>
    <?php if ($result && mysqli_num_rows($result) > 0) : ?>
      <div class="row">
        <?php while ($post = mysqli_fetch_assoc($result)) : ?>
          <div class="col-12 mt-5">
            <div class="card">
              <div class="card-header">
                <img class="rounded-circle" width="30" src="images/<?= $post['avatar']; ?>" alt="">
                <?= htmlentities($post['name']); ?>
                <span class="float-right"><?= $post['pdate']; ?></span>
              </div>
              <div class="card-body">
                <h3><?= htmlentities($post['title']); ?></h3>
                <p><?= str_replace("\n", '<br>', htmlentities($post['article'])); ?></p>
                <?php if (auth_user() && $post['user_id'] == $_SESSION['user_id']) : ?>
                  <div class="float-right">
                    <div class="dropdown">
                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="edit_post.php?pid=<?= $post['id']; ?>"><i class="fas fa-pencil-alt"></i> Edit</a>
                        <a class="dropdown-item delete-post-btn" href="delete_post.php?pid=<?= $post['id']; ?>"><i class="fas fa-trash-alt"></i> Delete</a>
                      </div>
                    </div>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    <?php endif; ?>
  </div>
</main>

<?php include 'tpl/footer.php';  ?>