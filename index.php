<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>TMGR-Клиент для продвижения</title>

  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700,700italic|Playfair+Display:400,700&subset=latin,cyrillic">
 <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="style/main.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<script src="responsiveslides.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
<script>
	$(function(){
    $('.link').click(function(e){
        e.preventDefault();//отменяем действие по умолчанию(переход по ссылке)
        var id = $(this).attr('href');// идентификатор статьи
        
        $.ajax({
            url: 'obrab.php',//обработчик
            type:'post',//тип запроса
            data: 'id='+id,//передаем данные, в $_POST['id'] будет идентификатор статьи
            //в responce будет ответ с сервера
            success:function(responce){
                $('#aticle').html(responce);// добавляем ответ с сервера в контейнер с id="aticle"
            }
        })
    })
   
});</script>
</head>
<body>
	<header>
    <nav class="container">
      <a class="logo" href="">
        <span>T</span>
        <span>M</span>
        <span>G</span>
        <span>R</span>
      </a>
      <div class="nav-toggle"><span></span></div>
      <nav>
      <ul id="menu">
        <li><a class="link" href="1">Про продукт</a></li>
        <li><a class="link" href="2">Обновления</a></li>
        <li><a class="link" href="3">Цена</a></li>
        <li><a href="check.php">Кабинет</a></li>
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
        <div id="aticle" class="aticle">
<h2 class="post-title"><b>Программа для автоматической накрутки в телеграмм.</b></h2>
<div class="post-image"><img src="img/01.jpg"></div>
<b>TMNGR - Полностью автономный и умный телеграм клиент для продвижения.</b><br><br>

Программа работает как автономный телеграмм клиент. Для её работы не требуется ни веб версия ни дескопный телеграм.
<br>
Программа работает как обычный телеграмм клиент и имеет ряд нестандартных функций.
<br><br>
<h4><b>Функционал:</b></h4><br>
Поддержка безлимитного количества аккаунтов.<br>
Умная рассылка сообщений:
<ol>
<li>По номеру с автоматической сменой аккаунтов.</li>
<li>По логинам с автоматической сменой аккаунтов.</li></ol>
Импорт \ Экспорт номеров с аккаунта.<br>
Чекер телефонов.<br>
Накрутка ботов на канал.<br>
Накрутка просмотров.<br>
Инвайтер на канал.<br>
Авторегестрация аккаунтов через сервис simsms.org.<br>
        </div>
        <div class="post-footer">
          <a class="more-link" href="https://seoxa.club/">Продолжить чтение</a>
        </div>
      </div>
    </article>
    <article id="post-2" class="post">
    </article>
  </div> <!-- конец div class="posts-list"-->
  <aside>
  <div class="widget">
    <h3 class="widget-title">Возможно интересно</h3>
    <ul class="widget-posts-list">
      <li>
        <div class="post-image-small">
          <a href=""><img src="img/11.jpg"></a>
        </div>
        <h4 class="widget-post-title">Botnet</h4>
      </li>
      <li>
        <div class="post-image-small">
          <a href=""><img src="img/12.jpg"></a>
        </div>
        <h4 class="widget-post-title">Криптор</h4>
      </li>
    </ul>
  </div>
</aside>
</div> <!-- конец div class="container"-->
<footer>
  <div class="container">
    <div class="footer-col"><span>by zuk coprght© 2018</span></div>
    <div class="footer-col">
      <div class="social-bar-wrap">
        
      </div>
    </div>
    <div class="footer-col">
      связаться <i class="fas fa-arrow-circle-right"></i>
      <a title="Telegram" href="tg://resolve?domain=z_u_k" target="_blank"><i class="fab fa-telegram-plane"></i></a>
    </div>
  </div>
</footer>
<script>
$('.nav-toggle').on('click', function(){
$('#menu').toggleClass('active');
});
</script>
</body>
</html>