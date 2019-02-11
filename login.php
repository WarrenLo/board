<!DOCTYPE html>
<html>
  <head>
    <title>Message Board - Login</title>
    <link rel="icon" href="icon.gif" type="image/gif" sizes="16x16">
    <meta charset='utf-8' />
    <link rel='stylesheet' href='board.css' text='text/css'>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

  </head>
  <body>
    <div class='container'>
      <?php include_once('title.php');?>
      <form class='login' action='./handle_login.php' method='POST'>
        <h1 class='login__title'>Log in to see messages from your friends.</h1>

        <div class='login__input'>

          <input class='login__input--input' type='text' placeholder='' name='username' required='' autocomplete="off" maxlength="20">
          </input>
          <label class='login__input--placeholder'>
            User ID
          </label>

        </div>
        <div class='login__input'>

          <input class='login__input--input' type='password' placeholder='' name='password' required='' autocomplete="off" maxlength="20">
          </input>
          <label class='login__input--placeholder'>
            Password
          </label>
          <div class='login__input--eye'><i class="fas fa-eye"></i></div>


        </div>
        <input class='login__input login__submit' type='submit' value='Log in' />
        <div class='login__sign-up'>Don't have an account? <a class='login__sign-up--link' href='./register.php'>Sing up now</a></div>
      </form>
    </div>
  </body>
  <script type='text/javascript 'src='login.js'></script>
</html>
