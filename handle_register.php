<?php
  session_start();
  include_once('../conn.php');
  include_once('alert_and_location.php');
  if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['nickname'])
  && !empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['nickname'])){
    $nickname = $_POST['nickname'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sign_up_sql =
    "INSERT INTO users(nickname, username, password)
    VALUES ('$nickname', '$username', '$password')";
    // 檢查帳號 (username) 使否已經被註冊過
    // 取出 usermane = $_POST['username'](輸入的帳號) 條件下的欄位
    $check_username_sql = "SELECT * FROM users WHERE username = '$username'";
    $check_nickname_sql = "SELECT * FROM users WHERE nickname = '$nickname'";
    $result_check_username = $conn->query($check_username_sql);
    $result_check_nickname = $conn->query($check_nickname_sql);
    // 如果可以取出欄位 (num_rows > 0)，代表此帳號已經被註冊過
    if($result_check_username->num_rows > 0){
      alert_and_location("此帳號已經存在，請重新輸入", "./register.php");
      exit();
    }
    if($result_check_nickname->num_rows > 0){
      alert_and_location("此暱稱已經存在，請重新輸入", "./register.php");
      exit();
    }
    if($conn->query($sign_up_sql)){
      $_SESSION['username'] = $username;
      $_SESSION['nickname'] = $nickname;
      alert_and_location("註冊成功", "./board.php");
    }else{
      //alert_and_location($conn->error, "./register.php");
      alert_and_location("連線錯誤", "./register.php");
    }

  }else{
    alert_and_location("請輸入帳號或密碼", "./register.php");
  }
?>
