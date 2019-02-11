<?php
  session_start();
  include_once('../conn.php');
  include_once('alert_and_location.php');
  // step 1. 驗證有無輸入帳號和密碼
  if (isset($_POST['username']) && isset($_POST['password']) && !empty($_POST['username']) && !empty($_POST['password'])){
    $login_username = $_POST['username'];
    $login_password = $_POST['password'];
    // 用 password_hash 無法登入

    $login_sql = " SELECT * FROM users WHERE username = '$login_username' ";
    $result = $conn->query($login_sql);
    $result_fetch = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $username = $result_fetch['username'];
    $nickname = $result_fetch['nickname'];
    $hash_password = $result_fetch['password'];
    $check_password = password_verify($login_password, $hash_password);
    // step 2. 執行 SQL 指令
    // step 3. 驗證 SQL 連線
    if(!$result){
      alert_and_location('連線錯誤，請重新輸入', './login.php');
      exit();
    }

    // step 4.驗證帳號 (不可單純只告知是帳號錯誤或是密碼錯誤)
    if($result->num_rows <= 0){
      alert_and_location('帳號或密碼錯誤，請重新輸入', './login.php');
      exit();
    }
    // step 5. 驗證密碼
    // 必須使用 hash_verify
    // 如果用 hash_password 是否相等驗證會出現錯誤
    // 因為 hash_password 會執行 salt的動作，所以相同的輸入會產生不同輸出
    if ($check_password){
      $_SESSION['username'] = $username;
      $_SESSION['nickname'] = $nickname;
      alert_and_location('登入成功', './board.php');
    }else{
      alert_and_location('帳號或密碼錯誤，請重新輸入', './login.php');
      exit();
    }

  }else{
    if(empty($_POST['username'])){
      echo "<script>alert('請輸入帳號')</script>";
    }if(empty($_POST['password'])){
      echo "<script>alert('請輸入密碼')</script>";
    }
    echo "<script>window.location = './login.php'</script>";

  }
?>
