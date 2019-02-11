<?php
  session_start();
  include_once('../conn.php');




  $username = $_SESSION['username'];
  // 檢查刪除權限
  // 就算 data-id 被竄改，也不會刪除到其他使用者的留言
  $check_sql = "SELECT * FROM comments WHERE (id = {$_POST['id']} or parent_id={$_POST['id']}) AND username = '$username'";

  $check_result = $conn->query($check_sql);
  if($check_result->num_rows > 0){

    // 將 id 相符的主留言 & 子留言，一起刪除
    $delete_comment_sql =
    "DELETE FROM comments WHERE (id = {$_POST['id']} or parent_id={$_POST['id']}) AND username = '$username'";

    $result = $conn->query($delete_comment_sql);

    if($result === TRUE){
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
      'result'=>'error',
    );
    echo json_encode($result_arr);
  }




?>
