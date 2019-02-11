<?php
  include_once('check_login.php');
  include_once('utils.php')
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Message board</title>
    <link rel="icon" href="icon.gif" type="image/gif" sizes="16x16">
    <meta charset='utf-8' />
    <link rel='stylesheet' href='board.css' text='text/css'>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type='text/javascript 'src='board.js'></script>
  </head>
  <body>
    <?php
      include_once('board_nav.php');
      include_once('../conn.php');

      $page = 1;
      if(isset($_GET['page']) && !empty($_GET['page'])){
        $page = (int)$_GET['page'];
      }
      $each_page = 10;
      $start_page = $each_page*($page-1);
      $show_comments_sql =
      "SELECT c.comment, c.created_at, c.id, u.nickname, u.username
      FROM comments as c
      LEFT JOIN users as u ON c.username = u.username
      WHERE c.parent_id = 0
      ORDER BY c.id DESC
      LIMIT  $start_page, $each_page";

      $result = $conn->query($show_comments_sql);
    ?>
    <div class='container'>
      <?php include_once('title.php');?>
      <div class='board'>
        <?php if($login && $page == 1) {include_once('board_create.php');};?>
        <div class='board__comments'>
          <?php include('board_pages.php');?>
          <?php
            if($result){
              while($comment_row = $result->fetch_assoc()){
          ?>
                <div class='board__comments--comment'>
                  <div class='board__comments--comment-main comment-main'>

                    <div class='comment-main__profile'>
                      <div class='comment-main__profile--pic'>
                        <?php echo strtoupper(substr($comment_row['nickname'], 0, 1))?>
                      </div>
                      <div class='comment-main__profile--nickname'>
                        <?php echo escape($comment_row['nickname']); ?>
                      </div>
                    </div>
                    <div class='comment-main__msg'>
                      <?php echo nl2br(escape($comment_row['comment'])); ?>
                    </div>
                    <span class='comment-main__created-at'>
                      <?php echo substr($comment_row['created_at'], 0, 16); ?>
                    </span>
                    <?php
                      if ($comment_row['username'] == $login){
                        echo
                        "
                        <button class='comment-main__edit-btn comment-main__btn'>
                          Edit
                        </button>
                        <button class='comment-main__delete-btn comment-main__btn' data-id='{$comment_row["id"]}'>
                          Delete
                        </button>
                        ";
                      }
                    ?>
                    <?php
                      if ($login){
                        echo
                        "<button class='comment-main__reply-btn comment-main__btn'>
                          REPLY
                        </button>";
                      }
                    ?>
                    <button class='comment-main__view-reply-btn comment-main__btn'>
                    </button>
                  </div>

                  <?php
                    if ($comment_row['username'] == $login){
                      echo
                      "
                      <form method='POST' class='comment-main__edit'>
                        <div class='comment-main__edit--profile'>
                          <div class='comment-main__edit--profile-nickname'>
                            $nickname
                          </div>
                        </div>
                        <textarea class='comment-main__edit--msg' name='comment' required=''>{$comment_row['comment']}</textarea>
                        <input class='id' type='hidden' name='id' value='{$comment_row['id']}' />
                        <div class='comment-main__edit--cancel'>CANCEL</div>
                        <input type='button' value='EDIT' class='comment-main__edit--submit'></input>
                      </form>

                      ";
                    }
                  ?>
                  <form method='POST' class='comment-sub__create'>
                    <div class='comment-sub__create--profile'>
                      <div class='comment-sub__create--profile-nickname'>
                      <?php
                        if($login){
                          echo $nickname;
                        }else{
                          echo '?';
                        }
                      ?>
                      </div>
                    </div>
                    <textarea class='comment-sub__create--msg' value='' placeholder='Leave your message here' name='comment' required=''></textarea>
                    <input type='hidden' name='parent_id' class='parent_id' value='<?php echo $comment_row['id'];?>' />
                    <div class='comment-sub__create--cancel'>CANCEL</div>
                    <input type='button' value='COMMENT' class='comment-sub__create--submit'></input>
                  </form>

                  <?php

                    $show_sub_comments_sql =
                    "SELECT c.username, c.comment, c.created_at, c.id, c.parent_id, u.nickname
                    FROM comments as c
                    LEFT JOIN users as u ON c.username = u.username
                    WHERE c.parent_id = {$comment_row['id']}
                    ORDER BY c.id DESC";

                    // WHERE c.parent_id = $comment_row['id']
                    // 這樣使用會出現錯誤 : unexpected T_ENCAPSED_AND_WHITESPACE, ...
                    // 原因是因為在 "雙引號" 內只能引入變數、字串或數字
                    // 然而 $comment_row['id'] 是從 array 裡面將數字取出
                    // 雖然取出來的內容也是 string ，但是取得內容的過程不同，所以會造成錯誤
                    // 如果要使用 $comment_row['id'] 請使用大括號，像這樣 {$comment_row['id']}

                    $sub_result = $conn->query($show_sub_comments_sql);
                    if($sub_result){
                      while($sub_comment_row = $sub_result->fetch_assoc()){
                  ?>

                  <div class='board__comments--comment-sub comment-sub'>

                    <div class='comment-sub__profile'>
                      <div class='comment-sub__profile--pic'>
                        <?php echo strtoupper(substr($sub_comment_row['nickname'], 0, 1))?>
                      </div>
                      <div class='comment-sub__profile--nickname'>
                      <?php echo escape($sub_comment_row['nickname']); ?>
                      </div>
                    </div>
                    <div class='comment-sub__msg'>
                      <?php echo nl2br(escape($sub_comment_row['comment'])); ?>
                    </div>
                    <span class='comment-sub__created-at'>
                      <?php echo substr($sub_comment_row['created_at'], 0, 16); ?>
                    </span>
                    <?php
                      if ($sub_comment_row['username'] == $login){
                        echo
                        "
                        <button class='comment-sub__edit-btn comment-sub__btn'>
                          Edit
                        </button>

                        <button class='comment-sub__delete-btn comment-sub__btn' data-id='{$sub_comment_row["id"]}'>
                          Delete
                        </button>
                        ";
                      }
                    ?>

                  </div>

                  <?php
                    if ($sub_comment_row['username'] == $login){
                      echo
                      "
                      <form method='POST' class='comment-sub__edit'>
                        <div class='comment-sub__edit--profile'>
                          <div class='comment-sub__edit--profile-nickname'>
                            $nickname
                          </div>
                        </div>
                        <textarea class='comment-sub__edit--msg' name='comment' required=''>{$sub_comment_row['comment']}</textarea>
                        <input class='id' type='hidden' name='id' value='{$sub_comment_row['id']}' />
                        <div class='comment-sub__edit--cancel'>CANCEL</div>
                        <input type='button' value='EDIT' class='comment-sub__edit--submit'></input>
                      </form>

                      ";
                    }
                  ?>

                  <?php
                    }
                  }
                  ?>
                </div>
                <?php

              }
            }
          ?>
        </div>
        <?php include('board_pages.php');?>
      </div>
    </div>
  </body>
</html>
