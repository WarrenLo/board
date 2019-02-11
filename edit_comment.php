<?php
  session_start();
  include_once('../conn.php');
  // 將 id 相符的主留言 & 子留言，一起刪除
  $username = $_SESSION['username'];
  $check_sql = "SELECT * FROM comments WHERE id = {$_POST['id']} AND username = '$username'";
  $check_result = $conn->query($check_sql);

  if($check_result->num_rows > 0){
    $edit_comment_sql =
    "UPDATE comments SET comment = (?) WHERE id = (?) AND username = (?)";
    $stmt = $conn->prepare($edit_comment_sql);
    $stmt->bind_param('sis', $_POST['comment'], $_POST['id'], $username);


    if($stmt->execute()){
      $result_arr =
      array(
        'result'=>'success',
      );
      echo json_encode($result_arr);
    }else{
      $result_arr =
      array(
        'result'=>'fail',
      );
      echo json_encode($result_arr);
    }
  }else{
    $result_arr =
    array(
      'result'=>'warning',
    );
    echo json_encode($result_arr);
  }



?>
