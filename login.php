<link rel="stylesheet" type="text/css" href="style/enter.css">
<?php
// Страница авторизации

// Функция для генерации случайной строки
function generateCode($length=6) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0,$clen)];
    }
    return $code;
}
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
    if(count($err) == 0)
    {
    // Вытаскиваем из БД запись, у которой логин равняеться введенному
   $query = mysqli_query($link,"SELECT user_password , user_id FROM view_login_n_id_ps WHERE user_login ='".mysqli_real_escape_string($link,$_POST['login'])."' ");

    $data = mysqli_fetch_assoc($query);
print_r($data['user_login']);
echo "hellp";
    // Сравниваем пароли
    if($data['user_password'] === md5(md5($_POST['password'])))
    {
        // Генерируем случайное число и шифруем его
        $hash = md5(generateCode(10));

       
            // Переводим IP в строку
            $insip = ", user_ip=INET_ATON('".$_SERVER['REMOTE_ADDR']."')";
        

        // Записываем в БД новый хеш авторизации и IP
       mysqli_query($link, "UPDATE view_login_ip_h_id SET user_hash='".$hash."' ".$insip." WHERE user_id='".$data['user_id']."'");
        // Ставим куки
        setcookie("id", $data['user_id'], time()+60*60*24*30);
        setcookie("hash", $hash, time()+60*60*24*30,null,null,null,true); // httponly !!!

        // Переадресовываем браузер на страницу проверки скрипта
        header("Location: check.php"); exit();
    }
    else
    {
        print "Вы ввели неправильный логин/пароль";
    }
	}
	else
    {
        print "<b>При логине произошли следующие ошибки:</b><br>";
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
      <button name="submit" type="submit">Войти</button>
      <p class="message">Не зарегистрированы? <a href="register.php">Cоздайте аккаунт</a></p>
<p class="message"> <a href="index.php">Вернуться на сайт-визитку</a></p>
    </form>
  </div>
</div>