<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
  <link href="css/style.css" rel="stylesheet">
  <title>Bubble Talk | <?= $page_title; ?></title>
</head>

<body>

  <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
      <div class="container">
        <a class="navbar-brand text-primary" href="./"><i class="far fa-comments fa-2x"></i></i></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link text-dark" href="about.php">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-dark" href="blog.php">Blog</a>
            </li>
          </ul>
          <ul class="navbar-nav ml-auto">
            <?php if (!auth_user()) : ?>
              <li class="nav-item">
                <a class="nav-link text-dark" href="signin.php">Signin</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="signup.php">Signup</a>
              </li>
            <?php else : ?>
              <li class="nav-item">
                <a class="nav-link text-dark" href="edit_profile.php"><?= htmlentities($_SESSION['user_name']); ?></a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="logout.php">Logout</a>
              </li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </nav>
  </header>