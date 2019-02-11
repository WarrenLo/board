<?php
  session_start();
  if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
    $login = $_SESSION['username'];
    $nickname = $_SESSION['nickname'];
  }else{
    $login = '';
  }
?>
