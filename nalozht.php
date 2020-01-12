<?php

class ttfTextOnImage
{  
  // Качество jpg по-умолчанияю
  public   $jpegQuality = 100;      
  
  // Каталог шрифтов
  public   $ttfFontDir   = 'ttf';  
  
  private $ttfFont    = false;
  private $ttfFontSize  = false;
    
  private $hImage      = false;
  private $hColor      = false;

  public function __construct($imagePath)
  {
    if (!is_file($imagePath) || !list(,,$type) = @getimagesize($imagePath)) return false;
        
    switch ($type) 
    {      
      case 1:  $this->hImage = @imagecreatefromgif($imagePath);  break;
      case 2:  $this->hImage = @imagecreatefromjpeg($imagePath);  break;
      case 3:  $this->hImage = @imagecreatefrompng($imagePath);  break;        
      default: $this->hImage = false;
    }
  }
  
  public function __destruct()
  {
    if ($this->hImage) imagedestroy($this->hImage);
  }
  
  /**
   * Устанавливает шрифт
   *
   */  
  public function setFont($font, $size = 14, $color = false, $alpha = false)
  {
    if (!is_file($font) && !is_file($font = $this->ttfFontDir.'/'.$font))
    return false;
    
    $this->ttfFont     = $font;
    $this->ttfFontSize   = $size;
    
    if ($color) $this->setColor($color, $alpha);
  }
  
  /**
   * Пишет текст
   *
   */    
  public function writeText ($x, $y, $text, $angle = 0)
  {
    if (!$this->ttfFont || !$this->hImage || !$this->hColor) return false;
    
    imagettftext(
      $this->hImage, 
      $this->ttfFontSize, $angle, $x, $y + $this->ttfFontSize, 
      $this->hColor, $this->ttfFont, $text);  
  }
  
  /**
   * Форматирует текст (согласно текущему установленному шрифту), 
   * что бы он не вылезал за рамки ($bWidth, $bHeight)
   * Убирает слишком длинные слова
   */
  public function textFormat($bWidth, $bHeight, $text)
  {
    // Если в строке есть длинные слова, разбиваем их на более короткие
    // Разбиваем текст по строкам
    
    $strings   = explode("\n", 
      preg_replace('!([^\s]{24})[^\s]!su', '\\1 ', 
        str_replace(array("\r", "\t"),array("\n", ' '), $text)));        
        
    $textOut   = array(0 => ''); 
    $i = 0;
          
    foreach ($strings as $str)
    {
      // Уничтожаем совокупности пробелов, разбиваем по словам
      $words = array_filter(explode(' ', $str)); 
      
      foreach ($words as $word) 
      {
        // Какие параметры у текста в строке?
        $sizes = imagettfbbox($this->ttfFontSize, 0, $this->ttfFont, $textOut[$i].$word.' ');  
        
        // Если размер линии превышает заданный, принудительно 
        // перескакиваем на следующую строку
        // Иначе пишем на этой же строке
        if ($sizes[2] > $bWidth) $textOut[++$i] = $word.' '; else $textOut[$i].= $word.' '; 
        
        // Если вышли за границы текста по вертикали, то заканчиваем
        if ($i*$this->ttfFontSize >= $bHeight) break(2);
      }
      
      // "Естественный" переход на новую строку 
      $textOut[++$i] = ''; if ($i*$this->ttfFontSize >= $bHeight) break; 
    }
    
    return implode ("\n", $textOut);
  }
  
  /**
   * Устанваливет цвет вида #34dc12
   *
   */
  public function setColor($color, $alpha = false)
  {
    if (!$this->hImage) return false; 
    
    list($r, $g, $b) = array_map('hexdec', str_split(ltrim($color, '#'), 2));
    
    return $alpha === false ? 
      $this->hColor = imagecolorallocate($this->hImage, $r+1, $g+1, $b+1) :
      $this->hColor = imagecolorallocatealpha($this->hImage, $r+1, $g+1, $b+1, $alpha);    
  }
  
  /**
   * Выводит картинку в файл. Тип вывода определяется из расширения.
   *
   */
  public function output ($target, $replace = true)
  {
    if (is_file ($target) && !$replace) return false;
      
    $ext = strtolower(substr($target, strrpos($target, ".") + 1));    

    switch ($ext) 
    {
      case "gif":        
        imagegif ($this->hImage, $target);        
        break;
                
      case "jpg" :
      case "jpeg":
        imagejpeg($this->hImage, $target, $this->jpegQuality);        
        break;
        
      case "png":
        imagepng($this->hImage, $target);
        break;
        
      default: return false;
    }
    return true;     
  }
}
// Берем какую-нибудь картинку
$ttfImg = new ttfTextOnImage('img/00.jpg');
      
// Пишем шрифтом Scrawn размером 64 пункта бордовым цветом с 80%-ой прозрачностью 
$ttfImg->setFont('font/Seconda Soft W00 Medium.ttf', 12, "#6D6D6D", 0);      
$message = $ttfImg->textFormat(400, 500, "01. mar");
$ttfImg->writeText(24, 111, $message,0);



// Шрифтом Constantin размером 15 пунктов оранжевым цветом с 90%-ой прозрачностью 
$ttfImg->setFont('font/Seconda Soft W00 Medium.ttf', 13, "#6D6D6D", 0);      

// Хотим написать много, поэтому сначала отформатируем наш текст
$message = $ttfImg->textFormat(400, 500, "Daniil");

// Пишем (чуть-чуть наклоним)
$ttfImg->writeText(25, 47, $message, 0);



$ttfImg->setFont('font/Seconda Soft W00 Medium.ttf', 23, "#6D6D6D", 0);      
$message = $ttfImg->textFormat(400, 500, "24. jan. 2019");
$ttfImg->writeText(23, 320, $message,0);


$ttfImg->setFont('font/Seconda Soft W00 Medium.ttf', 23, "#396E9A", 0);      
$message = $ttfImg->textFormat(400, 500, "23. apr. 2019");
$ttfImg->writeText(23, 405, $message,0);

$ttfImg->setFont('font/Seconda Soft W00 Medium.ttf', 13, "#707070", 0);      
$message = $ttfImg->textFormat(400, 500, "27. jan. 2019 kl");
$ttfImg->writeText(105, 612, $message,0);

// и вывод в файл


$ttfImg->output('img/postcard.jpg');


?>