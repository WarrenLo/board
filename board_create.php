<form method='POST' class='board__create'>
  <div class='board__create--profile'>
    <div class='board__create--profile-pic'>
      <?php  echo strtoupper(substr($nickname, 0, 1));  ?>
    </div>
    <div class='board__create--profile-nickname'>
      <?php  echo $nickname; ?>
    </div>
  </div>
  <textarea class='board__create--msg' value='' placeholder='Leave your message here' name='comment'></textarea>
  <input type='hidden' class='parent_id' name='parent_id' value='0' />
  <div class='board__create--cancel'>CANCEL</div>
  <input type='button' value='COMMENT' class='board__create--submit'></input>
</form>
