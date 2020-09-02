<?php

require_once 'app/helpers.php';
session_start();

$page_title = 'Home Page';

?>

<?php include 'tpl/header.php';  ?>

<main>
  <div class="container">
    <div class="row">
      <div class="col-12 text-center mt-5">
        <h1 class="display-4">Wellcome to Bubble Talk</h1>
        <p>In this site you can chat with all your friends in one place!!</p>
        <p><a class="btn btn-outline-warning btn-lg" href="blog.php">Release your Bubble!!!</a></p>
      </div>
    </div>

    <div class=" mb-4">
      <div class="row no-gutters">
        <div class="col-md-4">
          <img src="images/img_2.jpg" class="rounded-circle card-img" alt="...">
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <h5 class="card-title">Creativity</h5>
            <p class="card-text">The main gole of are comunity is to help each auter to grow togeter and lurn nuew posibilitys.</p>
            <p class="card-text"><small class="text-muted"></small></p>
          </div>
        </div>
      </div>
    </div>
    <div class="mb-3">
      <div class="row no-gutters">

        <div class="col-md-8">
          <div class="card-body">
            <h5 class="card-title">Inspireshion</h5>
            <p class="card-text">Your work is going to fill a large part of your life, and the only way to be truly satisfied is to do what you believe is great work. And the only way to do great work is to love what you do. If you haven't found it yet, keep looking. Don't settle. As with all matters of the heart, you'll know when you find it.</p>
            <p class="card-text"><small class="text-muted"></small></p>
          </div>
        </div>
        <div class="col-md-4">
          <img src="images/img_3.jpg" class="rounded-circle card-img" alt="...">
        </div>
      </div>
    </div>
    <div class="mb-3">
      <div class="row no-gutters">
        <div class="col-md-4">
          <img src="images/img_1.png" class="rounded-circle card-img" alt="...">
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <h5 class="card-title">Comyunity</h5>
            <p class="card-text">The best and most beautiful things in the world cannot be seen or even touched - they must be felt with the heart.</p>
            <p class="card-text"><small class="text-muted"></small></p>
          </div>
        </div>
      </div>
    </div>

  </div>
  </div>
</main>

<?php include 'tpl/footer.php';  ?>