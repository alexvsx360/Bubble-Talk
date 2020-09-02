<?php

require_once 'db_config.php';

if (!function_exists('old')) {

  /**
   *
   * Keep the prev value of a field.
   *
   * @param    string  $fn The field name
   * @return      string
   *
   */
  function old($fn)
  {
    return $_REQUEST[$fn] ??  '';
  }
}

if (!function_exists('csrf_token')) {

  /**
   *
   * Generate random string.
   * 
   * @return      string
   *
   */
  function csrf_token()
  {

    $token = sha1('$$' . rand(1, 1000) . 'digg');
    $_SESSION['token'] = $token;
    return $token;
  }
}

if (!function_exists('auth_user')) {

  function auth_user()
  {

    $auth = false;

    if (isset($_SESSION['user_id'])) {

      if (isset($_SESSION['user_ip']) && $_SERVER['REMOTE_ADDR'] == $_SESSION['user_ip']) {

        if (isset($_SESSION['user_agent']) && $_SERVER['HTTP_USER_AGENT'] == $_SESSION['user_agent']) {

          $auth = true;
        }
      }
    }

    return $auth;
  }
}


if (!function_exists('email_exists')) {

  function email_exists($link, $email)
  {

    $exists = false;

    $sql = "SELECT email FROM users WHERE email = '$email'";
    $result = mysqli_query($link, $sql);

    if ($result && mysqli_num_rows($result) > 0) {

      $exists = true;
    }

    return $exists;
  }
}
