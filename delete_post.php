<?php

require_once 'app/helpers.php';
session_start();

if (!auth_user()) {
  header('location: signin.php');
  exit;
}

$pid = filter_input(INPUT_GET, 'pid', FILTER_SANITIZE_STRING);
$uid = $_SESSION['user_id'];

if ($pid && is_numeric($pid)) {

  $link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);
  $pid = mysqli_real_escape_string($link, $pid);
  $sql = "DELETE FROM posts WHERE id = $pid AND user_id = $uid";
  $result = mysqli_query($link, $sql);
  header('location: blog.php');
}
