<?php
// Шаблон для проверки формата E-mail
$pat = '^([a-z0-9\._\-]+)@([a-z0-9\.\-]+)(\.[a-z]{2,})$';
// Шаблон для проверки имени (инверсный!)
$txt_pat = "/[^0-9a-z '\.A-ZА-Яа-я--]/";
$tomail="hdmail@mail.ru"; $PROJ_NAME="www.pietrolumachi.it";
// Если массив POST не пустой, отправка состоялась
if (!empty($_POST) && !isset($sent)) {
  // «Распаковываем» массив POST и отсекаем пробельные символы
  foreach ($_POST as $var=>$val)
    // ...но проверяем, не подсунули ли нам поле с адресом
    if ($var != 'tomail') $$var = trim($val);
    // Если подсунули – прекращаем работу скрипта
    else exit;
  // Статусное сообщение. Пока оно пустое...
  $state_msg='';
  $msg_color='navy';
  // Сверяем имя с шаблоном
  $fname = (isset($fname)? preg_replace($txt_pat, '', $fname) : '');
  // Сверяем адрес E-mail с шаблоном
  $mail = ((isset($mail) && eregi($pat,$mail))? strtolower($mail) : '');

  // Теперь проверяем заполнение всех полей
  if (empty($fname)) {
    // Если имя пустое...
    $state_msg='Type your name, please.';
  } elseif (empty($mail)) {
    // Если адрес пустой...
    $state_msg='E-mail format is wrong  (of not specified).';
  } elseif (empty($comment)) {
    // Если сообщение пустое...
    $state_msg='Type a message a message, please.';
  } else { // Если все поля заполнены верно...
    // Готовим сообщение об успешной отправке...
    $msg_color='red';
    $state_msg='Your message have been sent.<br>
Click <a href="'.$_SERVER['REQUEST_URI'].'">here</a>,
if your browser does not support redirection.';
    $user_ip=$_SERVER['REMOTE_ADDR'];
    // Готовим Subject письма...
    $subj='=?utf-8?B?'. base64_encode('Request from '.$PROJ_NAME).'?=';
    // Готовим заголовки письма...
    $header='From: '.$mail."\n";
    $header.='Content-Type: text/plain; charset=utf-8"'."\n";
    $header.="Content-Transfer-Encoding: 8bit\n";
    // Собираем текст письма...
    $post_message='From: '.$fname."\n\n";
    $post_message.='E-mail: '.$mail."\n";
    $post_message.="Message:\n";
    $post_message.=$comment."\n\n";
    // На всякий случай включаем IP-адрес отправителя...
    // $post_message.='IP '.$user_ip."\nSent ".date("d-m-Y H:i:s");
    // ... и наконец, отправляем письмо.
    mail($tomail,$subj,$post_message,$header);
    // А переменная $sent – признак успешной отправки.
    $sent=1;
  }
} else { // Если в массиве POST пусто, форма еще не передавалась
  // Готовим приглашение
  $msg_color='navy';
  $state_msg='Contact Pietro Lumachi.';
  // Поля имени, адреса и текста в этом случае должны быть пустыми
  $fname=$mail=$comment='';
}

// Если сообщение еще не отправлялось, выводим форму
if (!isset($sent)) $outstr='

<form method=post action="'.$_SERVER['REQUEST_URI'].'">
  <div class="contact"><div  class="label fll"><p>Il tuo</p> <p>nome:</p></div>
  <input name="fname" type="text" 
  class="txtfield name flr"  value="'.$fname.'" size="30" /></div>
  
  <div class="contact"><div  class="label fll"><p>La tua</p> <p> Email:</p></div>

  <input name="mail"  type="text" class="txtfield name flr"
   size="30" value="'.$mail.'" /></div>
   <p>&nbsp;</p>
   <p class="label clb">Il tuo messaggio (max 200 parole)</p>   

<textarea name=comment class="message txtfield" wrap=virtual cols=58 rows=9>'.$comment.'</textarea>


 <div  class="security_code">
 <input type="submit" name="subm" class="combo butt"  value="Submit" />
 </div> <!-- end security_code -->
  </form>  


';
else { // А если сообщение уже отправлено...
  // Посылаем в заголовке редирект (303 Refresh) на этот же адрес
  // с задержкой на 3 секунды, чтобы пользователь увидел сообщение
  $ret_uri=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
  header("Refresh: 3; URL=http://".$ret_uri);
  // Выводим сообщение об отправке
  echo ("<br><br><font color=".$msg_color.">".$state_msg."</font>");
  exit;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="robots" content="all" />
    <link rel="stylesheet" href="../css/reset.css" type="text/css" />
    <link rel="stylesheet" href="../css/pages.css" type="text/css" />
    
    <title>Pietro Lumachi | Contacts</title>   
	
  </head>  
  <body>    
  <div id="wrap">
  <div id="header">
  <p><h1  class="tt_head">Pietro &nbsp;&nbsp;  Lumachi</h1></p>
  </div> <!-- end header -->
  <div id="nav">
  		<ul>      
				<li><a href="../index.html"><img class="bul" src="../images/bul_orang.png" alt="" />&nbsp;Home</a></li>   
				<li><a href="gallery.html"><img class="bul" src="../images/bul_orang.png" alt="" />&nbsp;Galleria</a></li>
				<li><a href="bio.html"><img class="bul" src="../images/bul_orang.png" alt="" />&nbsp;Note Biografiche</a></li> 
				<li><img class="bul" src="../images/bul_oliv.png" alt="" />&nbsp;Modalita' d'Acquisto</li>				
				<li><a href="blog.html"><img class="bul" src="../images/bul_orang.png" alt="" />&nbsp;Pietro Lumachi's Blog</a></li>
				<li><a href="links.html"><img class="bul" src="../images/bul_orang.png" alt="" />&nbsp;Links</a></li>           
	  </ul>
  </div> <!-- end nav -->
  <div class="title"><h2>Modalita' d'Acquisto</h2></div>
<div class="links">
 <p>Contatta Pietro Lumachi a Torriglia</p>
 
 <?php echo $outstr; ?>
 
 
  
</div> <!-- end links -->
   
  <div id="footer">
  <span class="fll tt_copyr"> &copy;2010 Emir</span> 
 <span class="flr tt_foot">E-mail:&nbsp;<a  href="">&nbsp;pietrolumachi9@gmail.com</a>&nbsp;&nbsp;&nbsp;tel.&nbsp;348/0653198&nbsp;&nbsp;&nbsp;via Ponte Nuovo 20 16029 Torriglia (Ge)</span>
 
  </div>  <!-- end footer -->
    </div> <!-- end wrap --> 
  </body>
</html>