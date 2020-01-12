<?php 
        if(!empty($_POST))
{
 //$mysqli = new mysqli($host['127.0.0.1'],$username['andronaft'],$password['Aa29071999'],$dbname['andronaft']);
require_once 'connection.php';

    if (mysqli_connect_errno())
    {
        printf("Подключение невозможно: %s\n", mysqli_connect_error());
header("Location: login.php");
        exit();
    }
 
    if ($stmt = $link->prepare("SELECT `description` FROM `products` WHERE `id` = ?"))   
    {
        $stmt->bind_param("i", $id);
        $id = $_POST['id'];
 
        $stmt->execute();
 
        $stmt->bind_result( $description);
        $result = '<div class="aticle">';
      
        while ($stmt->fetch())      
        {
            //$result .= '<h>'.$title.'</h>';
            $result .= '<p>'.$description.'</p>';
        }
        $result .= '</div>';
    }
    $stmt->close();
    $link->close();
        
    echo $result;
}
?>