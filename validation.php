<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
if(!empty($_POST['user_login'])&&!empty($_POST['user_email'])&&!empty($_POST['user_password1'])&&!empty($_POST['user_password2'])){
require_once($_SERVER["DOCUMENT_ROOT"]."/include/connection.php");
$success=false;$username=trim($_POST['user_login']);$email=strtolower(trim(htmlspecialchars($_POST['user_email'])));$password1=trim(htmlspecialchars($_POST['user_password1']));$password2=trim(htmlspecialchars($_POST['user_password2']));
if(preg_match('/^[a-zA-Z0-9_-]{3,20}$/',$username)){
$kol=mysql_num_rows(mysql_query("SELECT username FROM usertbl WHERE username='$username'"));
if($kol==0){if(preg_match('/^([a-zA-Z0-9_\.-]+)@([a-zA-Z0-9_\.-]+)\.([a-zA-Z\.]{2,6})$/',$email)){
$kol=mysql_num_rows(mysql_query("SELECT email FROM usertbl WHERE email='$email'"));
if($kol==0){if(!preg_match('([а-яА-ЯёЁ]+)',$password1)){
if(strlen($password1)>=8){if(preg_match('([a-zA-Z0-9"№;%:?.*()_+-=!@#$^&<>]+)',$password1)){
if(!ctype_digit($password1)){if(!ctype_alpha($password1)){
//if(!ctype_alnum($password1)){
if(!preg_match('/^(.)\1{3,}&/',$password1)){if($password1==$password2){
$recaptcha=$_POST['captcha_response'];if(!empty($recaptcha)){
require_once($_SERVER["DOCUMENT_ROOT"]."/test/getCurlData.php");
$url="https://www.google.com/recaptcha/api/siteverify?secret=6Ld_RRkTAAAAACsQFQ9vV9nbc6PrpXEyF6D9gHTY&response=".$recaptcha."&remoteip=".$_SERVER['REMOTE_ADDR'];
$res=getCurlData($url);$res=json_decode($res,true);if($res['success']){
$password=password_hash($password1,PASSWORD_DEFAULT);$reg_time=time();
$qur=mysql_query("INSERT INTO usertbl VALUES('0','0','0','0','0','0','$username','$email','0','0','$sex','0','$reg_time','0','$password','0','0')");
$qur=mysql_query("SELECT id_user, username FROM usertbl WHERE username='$username'");$kol=mysql_num_rows($qur);
if($qur&&$kol){while($rez=mysql_fetch_assoc($qur)){
mkdir($_SERVER["DOCUMENT_ROOT"]."/personal/".$rez["id_user"]."/",0777,true);
$text='<?php include_once($_SERVER["DOCUMENT_ROOT"]."/include/personal.php"); ?>
<div class="MainMenuSkew">
<ul class="MainMenu">
<li class="SelectedMM"><a href="/">Свежее</a></li>
<li><a href="/top/">Топ</a></li>
<li><a href="/old/">Старое</a></li>
</ul>
</div>
</div>
<div class="WidthMain"><div class="UserProfile">
<div class="ProfilePhoto">
<div class="ProfileImg">
<div class="ProfileImgOverlay"></div>
<img src="/img/no_profile.png" width="170" height="170" alt="">
</div>
</div>
<div class="ProfileInfo">
<?php
function declOfNum($number, $titles) {
$cases = array (2, 0, 1, 1, 1, 2);  
return $number." ".$titles[ ($number%100 > 4 && $number %100 < 20) ? 2 : $cases[min($number%10, 5)] ];  
}
$sql = "SELECT * FROM usertbl WHERE id_user='.$rez["id_user"].'";
$qur=mysql_query($sql); $kol=mysql_num_rows($qur);
if ($qur&&$kol) {
while($rez = mysql_fetch_assoc($qur)) {
$global_time = "";
$time = time();
$user_name = $rez["username"];
$reg_time = date("d.m.Y H:i",$rez["reg_time"]);
$fdate = $rez["last_login"];
$tm = date("H:i",$fdate);
$y = date("Y", $fdate);
$d = date("d", $fdate);
$m = date("m", $fdate);
$i_fdate = date("d.m.Y H:i",$fdate);
$last = round(($time - $fdate)/60);
$decl = declOfNum($last, array("минуту", "минуты", "минут"));
if($last < 60) $global_time = "$decl назад";
elseif($i_fdate == date("d.m.Y",$time)) $global_time = "Сегодня, $tm";
elseif($i_fdate == date("d.m.Y", strtotime("-1 day"))) $global_time = "Вчера, $tm";
elseif($y == date("d.m.Y",$time)) $global_time = "$tm $d/$m";
else $global_time = "$i_fdate";
echo "<p>Псевдоним: $user_name</p>
<p>Зарегистрирован: $reg_time</p>
<p>Последний раз был: $global_time</p>
<br>Тут \"в среду\" будет много всего...";
}}
?>
</div></div>
<div class="B"></div>
</div>
<?php
include_once($_SERVER["DOCUMENT_ROOT"]."/include/footer.php");
?>';
$fp=fopen($_SERVER["DOCUMENT_ROOT"]."/personal/".$rez["id_user"]."/index.php", "w+");
fwrite($fp,$text);fclose($fp);}}
$success=true;echo json_encode(array($success,$username,$error));
}else{$error="Подтвердите, что вы не робот!";echo json_encode(array($success,$username,$error));}
}else{$error="Подтвердите, что вы не робот!";echo json_encode(array($success,$username,$error));}
}else{$error="Пароли должны совпадать!";echo json_encode(array($success,$username,$error));}
}else{$error="Пароль не должен состоять из повторяющихся символов!";echo json_encode(array($success,$username,$error));}
//}else{$error="Пароль должен содержать хотя бы один специальный символ!";echo json_encode(array($success,$username,$error));}
}else{$error="Пароль не должен состоять только из букв!";echo json_encode(array($success,$username,$error));}
}else{$error="Пароль не должен состоять только из цифр!";echo json_encode(array($success,$username,$error));}
}else{$error="Поле с паролем содержит недопустимый символ!";echo json_encode(array($success,$username,$error));}
}else{$error="Длина пароля должна быть не менее 8 символов!";echo json_encode(array($success,$username,$error));}
}else{$error="Пароль должен состоять из латинских букв!";echo json_encode(array($success,$username,$error));}
}else{$error="Почта уже используется!";echo json_encode(array($success,$username,$error));}
}else{$error="Некорректная почта!";echo json_encode(array($success,$username,$error));}
}else{$error="Данное имя уже зарегистрировано!";echo json_encode(array($success,$username,$error));}
}else{$error="Вы используете недопустимое имя!";echo json_encode(array($success,$username,$error));}
}else{$error="Все поля обязательны для заполнения!";echo json_encode(array($success,$username,$error));}}
?>