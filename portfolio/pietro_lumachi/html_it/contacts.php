<?php
// ������ ��� �������� ������� E-mail
$pat = '^([a-z0-9\._\-]+)@([a-z0-9\.\-]+)(\.[a-z]{2,})$';
// ������ ��� �������� ����� (���������!)
$txt_pat = "/[^0-9a-z '\.A-Z�-��-�--]/";
$tomail="hdmail@mail.ru"; $PROJ_NAME="www.pietrolumachi.it";
// ���� ������ POST �� ������, �������� ����������
if (!empty($_POST) && !isset($sent)) {
  // �������������� ������ POST � �������� ���������� �������
  foreach ($_POST as $var=>$val)
    // ...�� ���������, �� ��������� �� ��� ���� � �������
    if ($var != 'tomail') $$var = trim($val);
    // ���� ��������� � ���������� ������ �������
    else exit;
  // ��������� ���������. ���� ��� ������...
  $state_msg='';
  $msg_color='navy';
  // ������� ��� � ��������
  $fname = (isset($fname)? preg_replace($txt_pat, '', $fname) : '');
  // ������� ����� E-mail � ��������
  $mail = ((isset($mail) && eregi($pat,$mail))? strtolower($mail) : '');

  // ������ ��������� ���������� ���� �����
  if (empty($fname)) {
    // ���� ��� ������...
    $state_msg='Type your name, please.';
  } elseif (empty($mail)) {
    // ���� ����� ������...
    $state_msg='E-mail format is wrong  (of not specified).';
  } elseif (empty($comment)) {
    // ���� ��������� ������...
    $state_msg='Type a message a message, please.';
  } else { // ���� ��� ���� ��������� �����...
    // ������� ��������� �� �������� ��������...
    $msg_color='red';
    $state_msg='Your message have been sent.<br>
Click <a href="'.$_SERVER['REQUEST_URI'].'">here</a>,
if your browser does not support redirection.';
    $user_ip=$_SERVER['REMOTE_ADDR'];
    // ������� Subject ������...
    $subj='=?utf-8?B?'. base64_encode('Request from '.$PROJ_NAME).'?=';
    // ������� ��������� ������...
    $header='From: '.$mail."\n";
    $header.='Content-Type: text/plain; charset=utf-8"'."\n";
    $header.="Content-Transfer-Encoding: 8bit\n";
    // �������� ����� ������...
    $post_message='From: '.$fname."\n\n";
    $post_message.='E-mail: '.$mail."\n";
    $post_message.="Message:\n";
    $post_message.=$comment."\n\n";
    // �� ������ ������ �������� IP-����� �����������...
    // $post_message.='IP '.$user_ip."\nSent ".date("d-m-Y H:i:s");
    // ... � �������, ���������� ������.
    mail($tomail,$subj,$post_message,$header);
    // � ���������� $sent � ������� �������� ��������.
    $sent=1;
  }
} else { // ���� � ������� POST �����, ����� ��� �� ������������
  // ������� �����������
  $msg_color='navy';
  $state_msg='Contact Pietro Lumachi.';
  // ���� �����, ������ � ������ � ���� ������ ������ ���� �������
  $fname=$mail=$comment='';
}

// ���� ��������� ��� �� ������������, ������� �����
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
else { // � ���� ��������� ��� ����������...
  // �������� � ��������� �������� (303 Refresh) �� ���� �� �����
  // � ��������� �� 3 �������, ����� ������������ ������ ���������
  $ret_uri=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
  header("Refresh: 3; URL=http://".$ret_uri);
  // ������� ��������� �� ��������
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