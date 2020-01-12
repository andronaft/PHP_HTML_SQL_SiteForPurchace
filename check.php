<?php
// Скрипт проверки

// Соединямся с БД
require_once 'connection.php';

if (isset($_COOKIE['id']) and isset($_COOKIE['hash']))
{
    $query = mysqli_query($link, "SELECT *,INET_NTOA(user_ip) AS user_ip FROM users WHERE user_id = '".intval($_COOKIE['id'])."' LIMIT 1");
    $userdata = mysqli_fetch_assoc($query);

    if(($userdata['user_hash'] !== $_COOKIE['hash']) /* or ($userdata['user_id'] !== $_COOKIE['id'])
 or (($userdata['user_ip'] !== $_SERVER['REMOTE_ADDR'])  and  or ($userdata['user_ip'] !== "0"))*/)
    {
        setcookie("id", "", time() - 3600*24*30*12, "/");
        setcookie("hash", "", time() - 3600*24*30*12, "/");
        print "Хм, что-то не получилось";
        sleep(1);
        header("Location: login.php"); exit();
    }
    else
    {
        //print "Привет, ".$userdata['user_ip']."".$userdata['user_login'].". Всё работает!";
    }
}
else
{
    print "Включите куки, переход на страницу входа через 5 секунд";
    sleep(1);
    header("Location: login.php"); exit();
}
echo $_COOKIE['hash'];
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Кабинет</title>

  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700,700italic|Playfair+Display:400,700&subset=latin,cyrillic">
 <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="style/main.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<script src="responsiveslides.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
</head>
<body>
    <header>
    <nav class="container">
      <a class="logo" href="">
        <span>T</span>
        <span>M</span>
        <span>G</span>
        <span>R</span>
        -ROOM
      </a>
      <div class="nav-toggle"><span></span></div>
      <nav>
      <ul id="menu">
        <?php echo $userdata['user_login']; ?>
        <li><a href="login.php">Выйти</a></li>
      </ul>
      </nav>
    </nav>
  </header>
<div class="container">
<div class="posts-list">
    <article id="post-1" class="post">
    <div class="post-image">
      </div>
      <div class="post-content">
        <h2 class="post-title"><b>Информация о лицензии.</b></h2><br>
        <?php 
     
$query ="SELECT  uid , date FROM products_lic WHERE user_id='".$userdata['user_id']."'";
 
$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
if($result)
{
    $rows = mysqli_num_rows($result); // количество полученных строк
     
    echo "<table border=1><tr><th>Uid</th><th>Дата окончания лицензии</th></tr>";
    for ($i = 0 ; $i < $rows ; ++$i)
    {
        $row = mysqli_fetch_row($result);
        echo "<tr>";
            for ($j = 0 ; $j < 3 ; ++$j) echo "<td>$row[$j]</td>";
        echo "</tr>";
    }
    echo "</table>";
     
    // очищаем результат
    mysqli_free_result($result);
}
 
mysqli_close($link);
?><br>
<h3><b>Uid</b></h3>Идентификатор вашего устройства, он создается при запуске программы в корневой папке проекта (uid.info), и привязывается к аппаратной части вашего компьютера. Он служит защитой от пиратского распространения продукта. Если у вас это поле пустое , пожалуйста заполните его , иначе программа не будет работать.
        <div id="dialog" title="Смена Uid">
            <form method='post' action='newuid.php'>
                <input type='text' name='newuid' maxlength="39">
                <input type='submit' value='Ok'>
            </form>
        </div>
        <div id="dialog1" title="Все хорошо">
            <form >
                <center>Отправлено
                <input type='submit' value='Ok'></center>
            </form>
        </div>
        <div><input type='button' name="button" value='Сменить Uid'></div>
        <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
        <script src="http://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css"><br><br>
<h3><b>Дата окончания лицензии</b></h3>Дата по которую вы сможете пользоваться программой . Если вы еще не покупали подписку это поле будет выглядеть (0000-00-00).
<br><br>
<h2>Ссылка на скачивание <a href="Release.zip" download><i class="fa fa-download" aria-hidden="true"></i></a></h2>


        <div class="post-footer">
            <form method="post" action="request.php">
            <input type="text"  name="reqq" maxlength="40" placeholder="Отзыв, баг , пожелания"><input name="button1" class="more-link" type="submit" value="Отослать"></form>
        </div>
      </div>
    </article>
  </div> <!-- конец div class="posts-list"-->
  <aside>
  <div class="widget">
    <h3 class="widget-title">Купить подписку на неделю</h3>
    <ul class="widget-posts-list">
      <center>
        <form method="POST" action="https://money.yandex.ru/quickpay/confirm.xml">    
    <input type="hidden" name="receiver" value="410017069033665">
    <li>логин:  <input type="text" name="label" maxlength="30" placeholder="<?php echo ( htmlspecialchars($userdata['user_login'])); ?>" value="<?php echo ( htmlspecialchars($userdata['user_login'])); ?>"></li>
    <input type="hidden" name="quickpay-form" value="small"> 
    <input type="hidden" name="targets" value="Покупка подписки">
    <input type="hidden" name="sum" value="150" data-type="number">
    <li><label><input type="radio" name="paymentType" value="PC">With Yandex.Money</label>
    <label><input type="radio" name="paymentType" value="AC">With bank card</label></li>
    <li><input type="submit" value="Оплатить"></li>
   </form><!-- 
<form method="POST" accept-charset="utf-8" action="https://www.liqpay.ua/api/3/checkout">
  <input type="hidden" name="data" value="eyJ2ZXJzaW9uIjozLCJhY3Rpb24iOiJwYXkiLCJwdWJsaWNfa2V5IjoiaTQ1MzM2NjgwODYyIiwiYW1vdW50IjoiNzAiLCJjdXJyZW5jeSI6IlVBSCIsImRlc2NyaXB0aW9uIjoi0J/QvtC00L/QuNGB0LrQsCDQvdCwINC90LXQtNC10LvRjiIsInR5cGUiOiJidXkiLCJsYW5ndWFnZSI6InJ1In0=" />
  <input type="hidden" name="signature" value="RBpH39hRwBki3bxKnUBgUsyvDoQ=" />
        <input type="text" name="description" placeholder="login" value="" />
  <button style="border: none !important; display:inline-block !important;text-align: center !important;padding: 7px 20px !important;
    color: #fff !important; font-size:16px !important; font-weight: 600 !important; font-family:OpenSans, sans-serif; cursor: pointer !important; border-radius: 2px !important;
    background: rgb(196,222,37) !important;"onmouseover="this.style.opacity='0.5';" onmouseout="this.style.opacity='1';">
    <img src="https://static.liqpay.ua/buttons/logo-small.png" name="btn_text"
      style="margin-right: 7px !important; vertical-align: middle !important;"/>
    <span style="vertical-align:middle; !important">Оплатить 70 UAH</span>
  </button>
</form> -->
    </center>
    </ul>
  </div>
</aside>
</div>
<footer>
  <div class="container">
    <div class="footer-col"><span>by zuk coprght© 2018</span></div>
    <div class="footer-col">
      <div class="social-bar-wrap">
        
      </div>
    </div>
    <div class="footer-col">
      связаться <i class="fas fa-arrow-circle-right"></i><a title="Telegram" href="tg://resolve?domain=z_u_k" target="_blank"><i class="fab fa-telegram-plane"></i></a>
    </div>
  </div>
</footer>
<script>
$('.nav-toggle').on('click', function(){
$('#menu').toggleClass('active');
});
</script>
<script>
    var dialog1 = $("#dialog1").dialog({autoOpen: false});
            $("input[name=button1]").click(function ()
                {
                dialog1.dialog( "open" );
                });
            var dialog = $("#dialog").dialog({autoOpen: false});
            $("input[name=button]").click(function ()
                {
                dialog.dialog( "open" );
                });
            
        </script>

</body>
</html>


    
