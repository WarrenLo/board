<!DOCTYPE html>
<html>
  <head>
    <title>Message Board - Register</title>
    <link rel="icon" href="icon.gif" type="image/gif" sizes="16x16">
    <meta charset='utf-8' />
    <link rel='stylesheet' href='board.css' text='text/css'>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
  </head>
  <body>
    <div class='container'>
      <?php include_once('title.php');?>
      <form class='register' action='./handle_register.php' method='POST' autocomplete="off">
        <h1 class='register__title'>Sign up to chat with your friends now.</h1>

        <div class='login__input'>

          <input class='login__input--input' type='text' placeholder='' name='username' required='' autocomplete="off" maxlength="20">
          </input>
          <label class='login__input--placeholder'>
            User ID
          </label>

        </div>

        <div class='login__input'>

          <input class='login__input--input' type='text' placeholder='' name='nickname' required='' autocomplete="off" maxlength="20">
          </input>
          <label class='login__input--placeholder'>
            Nickname
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
        <input class='register__input register__submit' type='submit' value='Sign up' />
        <div class='register__sign-up'>Have an account? <a class='register__sign-up--link' href='./login.php'>Log in</a></div>
      </form>
    </div>
  </body>
  <script src='login.js' type='text/javascript'></script>
</html>
