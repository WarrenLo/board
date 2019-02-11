<?php include_once('check_login.php'); ?>
<nav class='nav'>
  <div class='nav__container'>
    <ul class='nav__container--left col-4'>
      <a href='./board.php' class='nav__container--left-logo'>
        M
      </a>
    </ul>
    <ul class='nav__container--right'>

      <?php
        if($login){
          echo "<a class='nav__container--right-btn' href='./logout.php'>Log out</a>";
        }else{
          echo
          "
          <a class='nav__container--right-btn pulse' href='./login.php'>Log in</a>
          <a href='./register.php' class='nav__container--right-btn nav__container--right-sign_up'>
            Sign up
          </a>
          ";
        }
      ?>


    </ul>
  </div>
</nav>
