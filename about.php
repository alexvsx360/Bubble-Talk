<?php

require_once 'app/helpers.php';
session_start();

$page_title = 'About us';

?>

<?php include 'tpl/header.php';  ?>

<main>
  <div class="container">
    <div class="row">
      <div class="col-12 mt-5">
        <h1>We're on a mission.</h1>
        <p>
          Everyone has a right to feel safe and secure, and security comes from having the information you want when you want it. It’s the guiding principle behind our work, and reinforces our belief that the best technology makes you smarter, puts you in control, and gives you access to the information you need. That’s why we’re dedicated to developing easy-to-use technology that protects, empowers, and has a meaningful impact on people, families, and their communities.</p>
      </div>
      <div class="container">
        <div class="row">

          <div class="col-md-6 border border-dark rounded">
            <div class="team block image-block text-center">
              <img style="height: 350px !important" src="http://localhost:8888/harokemet/public/img/ALEXANDER.jpg" alt="">
              <div class="team-content inner-space bg-white">
                <h6 class="box-title">ALEXANDER RICHKOVE</h6>
                <p class="p-2 mb-0 text-sm"><b>WEBSITE CREATOR & TEC MANAGER</b></p>

              </div>
            </div>
          </div>
          <div class="col-md-6 border border-dark rounded">
            <div class="team block image-block text-center">
              <img style="height: 350px !important" src="http://localhost:8888/harokemet/public/img/sherlok.jpeg" alt="">
              <div class="team-content inner-space bg-white">
                <h6 class="box-title">SHERLOCK </h6>
                <p class="p-2 mb-0 text-sm"><b>INSPIRATION MANAGER</b></p>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<?php include 'tpl/footer.php';  ?>