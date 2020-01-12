<link rel="stylesheet" type="text/css" href="style/enter.css">
<?php
// Страница регистрации нового пользователя

// Соединямся с БД
require_once 'connection.php';

if(isset($_POST['submit']))
{
    $err = [];

    // проверям логин
    if(!preg_match("/^[a-zA-Z0-9]+$/",$_POST['login']))
    {
        $err[] = "Логин может состоять только из букв английского алфавита и цифр";
    }

    if(strlen($_POST['login']) < 3 or strlen($_POST['login']) > 30)
    {
        $err[] = "Логин должен быть не меньше 3-х символов и не больше 30";
    }
if(strlen($_POST['password']) < 3 or strlen($_POST['password']) > 30)
    {
        $err[] = "пароль должен быть не меньше 3-х символов и не больше 30";
    }

    // проверяем, не сущестует ли пользователя с таким именем
  $query = mysqli_query($link, "SELECT user_id FROM view_login_n_id_ps WHERE user_login='".mysqli_real_escape_string($link, $_POST['login'])."'");
    if(mysqli_num_rows($query) > 0)
    {
        $err[] = "Пользователь с таким логином уже существует в базе данных";
    }

    // Если нет ошибок, то добавляем в БД нового пользователя
    if(count($err) == 0)
    {

        $login = $_POST['login'];

        // Убераем лишние пробелы и делаем двойное хеширование
        $password = md5(md5(trim($_POST['password'])));

        mysqli_query($link,"INSERT INTO users SET user_login='".$login."', user_password='".$password."'");
        sleep(2);
        $query = mysqli_query($link, "SELECT user_id FROM users WHERE user_login='".$login."'");
$userdata = mysqli_fetch_assoc($query);
mysqli_query($link,"INSERT INTO `products_lic`(`user_id`) VALUES ('".$userdata[user_id]."') ");
        header("Location: login.php"); exit();
    }
    else
    {
        print "<b>При регистрации произошли следующие ошибки:</b><br>";
        foreach($err AS $error)
        {
            print $error."<br>";
        }
    }
}
?>

<div class="login-page">
  <div class="form">
    <form class="login-form" method="post">
      <input type="text" name="login" placeholder="Логин" required>
      <input type="password" name="password" placeholder="Пароль" required>
      <button name="submit" type="submit">Зарегистрироваться</button>
<p class="message">Зарегистрированы? <a href="login.php">Cтраница входа</a></p>
    </form>
  </div>
</div>