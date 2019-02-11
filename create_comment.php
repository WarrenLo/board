<?php
  session_start();
  include_once('../conn.php');

  if (isset($_POST['comment']) && !empty($_POST['comment'])){

    $username = $_SESSION['username'];
    $comment = $_POST['comment'];
    $parent_id = $_POST['parent_id'];

    $create_comment_sql =
    "INSERT INTO comments(parent_id, username, comment) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($create_comment_sql);
    $stmt->bind_param('iss', $parent_id, $username, $comment);

    if ($stmt->execute()){

      $return_sql = "SELECT * FROM comments WHERE parent_id = ? AND username = ? AND comment = ? ORDER BY id DESC";
      $stmt_return = $conn->prepare($return_sql);
      $stmt_return->bind_param('iss', $parent_id, $username, $comment);
			$stmt_return->execute();
      $return_result = $stmt_return->get_result();
      if($return_result->num_rows > 0){
        $result =  $return_result->fetch_assoc();
        $result_arr =
        array(
          'result'=>'success',
          'id'=> $result['id'],
          'parent_id'=> $result['parent_id'],
          'created_at'=> $result['created_at']
        );
        echo json_encode($result_arr);
      }
    }
  }

?>
