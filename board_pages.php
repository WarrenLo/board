<?php  include_once('check_login.php'); ?>
<div class='board__comments--pages'>
  <div class='board__comments--pages-page'>
  <?php
    $count_sql =
    "SELECT COUNT(*) as count FROM comments WHERE parent_id = 0";
    $count_result = $conn->query($count_sql);
    if($count_result && $count_result->num_rows >0){
      $comments_num = $count_result->fetch_assoc()['count'];
      $total_pages = ceil($comments_num / $each_page);
      if($page != 1){
        $page_previous = $page-1;
        echo "<a href='./board.php?page=$page_previous' class='page' style='line-height: 30px'>&lt</a>";
      }else if($page == 1){
        echo "<div class='page' style='line-height: 30px; cursor: not-allowed'>&lt</div>";
      }
      for($page_num = 1; $page_num <= $total_pages; $page_num++){
        if($page_num == $page){
          echo "<a href='./board.php?page=$page_num' class='page active'>$page_num</a>";
        }else{
          echo "<a href='./board.php?page=$page_num' class='page'>$page_num</a>";
        }
      }
      if($page != $total_pages){
        $page_next = $page+1;
        echo "<a href='./board.php?page=$page_next' class='page' style='line-height: 30px'>&gt</a>";
      }else if($page == $total_pages){
        echo "<div class='page' style='line-height: 30px; cursor: not-allowed'>&gt</div>";
      }
    }
  ?>
  </div>
  <?php
    if($login && $page != 1){
      echo "<a href='./board.php?page=1' class='board__comments--pages-message'>Create Comment</a>";
    }
  ?>
</div>
