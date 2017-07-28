<?php
if($_GET['provider']=='vk'){
if(isset($_GET['code'])){
$client_id='5449879';$client_secret='tTgiwzpiTW7WblGInFPZ';$redirect_uri='http://gallery.24myfree.ru/login/?do=social%26provider%3Dvk';$result=false;
$params=array('client_id'=>$client_id,'client_secret'=>$client_secret,'code'=>$_GET['code'],'redirect_uri'=>$redirect_uri);
$token=json_decode(file_get_contents('https://oauth.vk.com/access_token?'.urldecode(http_build_query($params))),true);
if(isset($token['access_token'])){
$params=array('uids'=>$token['user_id'],'email'=>$token['email'],'fields'=>'uid,domain,first_name,last_name,screen_name,sex,bdate,photo_max_orig','access_token'=>$token['access_token']);
$userInfo=json_decode(file_get_contents('https://api.vk.com/method/users.get?'.urldecode(http_build_query($params))),true);
if(isset($userInfo['response'][0]['uid'])){$userInfo=$userInfo['response'][0];$result=true;}}
if($result){
$email=$token['email'];
list($explode,$mail)=explode('@',$email);
$reg_time=time();
$uid=$userInfo['uid'];
$link=$userInfo['domain'];
$first_name=$userInfo['first_name'];
$last_name=$userInfo['last_name'];
$username=$userInfo['screen_name'];
$sex=$userInfo['sex'];
$birthday=$userInfo['bdate'];
list($day,$month,$year)=explode($birthday);
$birthday=mktime('0','0','0',$month,$day,$year);
$photo=$userInfo['photo_max_orig'];
require_once($_SERVER["DOCUMENT_ROOT"]."/include/connection.php");
$kol=mysql_num_rows(mysql_query("SELECT email FROM vktbl WHERE email='$email'"));
if($kol==0){
$qur=mysql_query("INSERT INTO vktbl VALUES('0','$uid','$username','$email','$first_name','$last_name','$sex','$birthday','$reg_time','$link','$photo')");
$kol=mysql_num_rows(mysql_query("SELECT email FROM usertbl WHERE email='$email'"));
if($kol==0){
$qur=mysql_query("INSERT INTO usertbl VALUES('0','0','$uid','0','0','0','$explode','$email','$first_name','$last_name','$sex','$birthday','$reg_time','$photo','0','$reg_time','0')");
$qur=mysql_query("SELECT id_user, username FROM usertbl WHERE username='$explode'");$kol=mysql_num_rows($qur);
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
$_SESSION['session_username']=mb_strtolower($explode);echo '<script>opener.window.location="http://gallery.24myfree.ru/login/";window.close();</script>';
}else{$_SESSION['session_username']=mb_strtolower($explode);$qur=mysql_query("UPDATE usertbl SET vk='$uid',last_login='$reg_time' WHERE email='$email'");echo '<script>opener.window.location="http://gallery.24myfree.ru/login/";window.close();</script>';}
}else{$_SESSION['session_username']=mb_strtolower($explode);$qur=mysql_query("UPDATE usertbl SET last_login='$reg_time' WHERE email='$email'");echo '<script>opener.window.location="http://gallery.24myfree.ru/login/";window.close();</script>';}
}else{echo '<script>opener.window.location="http://gallery.24myfree.ru/login/?message=ошибка-у-вк";window.close();</script>';}
}else{echo '<script>opener.window.location="http://gallery.24myfree.ru/login/?message=ошибка-у-вк";window.close();</script>';}
}
if($_GET['provider']=='google'){
if(isset($_GET['code'])){
$client_id='415167080739-a0j01p0ej3plh4jma986kr6de46b2tl7.apps.googleusercontent.com';$client_secret='6fphmzP1g5-bxRYA9fNFN4_2';$redirect_uri='http://gallery.24myfree.ru/login/?do=social%26provider%3Dgoogle';$result=false;
$params=array('client_id'=>$client_id,'client_secret'=>$client_secret,'redirect_uri'=>$redirect_uri,'grant_type'=>'authorization_code','code'=>$_GET['code']);
$url='https://accounts.google.com/o/oauth2/token';
$curl=curl_init();
curl_setopt($curl,CURLOPT_URL,$url);
curl_setopt($curl,CURLOPT_POST,1);
curl_setopt($curl,CURLOPT_POSTFIELDS,urldecode(http_build_query($params)));
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
$result=curl_exec($curl);
curl_close($curl);
$tokenInfo=json_decode($result,true);
if(isset($tokenInfo['access_token'])){
$params['access_token']=$tokenInfo['access_token'];
$userInfo=json_decode(file_get_contents('https://www.googleapis.com/oauth2/v1/userinfo?'.urldecode(http_build_query($params))),true);
$plusInfo=json_decode(file_get_contents('https://www.googleapis.com/plus/v1/people/'.$userInfo['id'].'?key=AIzaSyD9CkemWJMKD-SH-iraPfQaGytIUBZTJrs'),true);
if(isset($userInfo['id'])){$userInfo=$userInfo;$plusInfo=$plusInfo;$result=true;}}
if($result){
$email=$userInfo['email'];
list($explode,$mail)=explode('@',$email);
$reg_time=time();
$uid=$userInfo['id'];
$link=$userInfo['link'];
$first_name=$userInfo['given_name'];
$last_name=$userInfo['family_name'];
$username=$plusInfo['nickname'];
$sex=$userInfo['gender'];
$sex=='male'?$sex='2':$sex='1';
$birthday=$plusInfo['birthday'];
list($day,$month,$year)=explode("-",$birthday);
$birthday=mktime('0','0','0',$month,$day,$year);
$photo=$userInfo['picture'];
require_once($_SERVER["DOCUMENT_ROOT"]."/include/connection.php");
$kol=mysql_num_rows(mysql_query("SELECT email FROM googletbl WHERE email='$email'"));
if($kol==0){
$qur=mysql_query("INSERT INTO googletbl VALUES('0','$uid','$username','$email','$first_name','$last_name','$sex','$birthday','$reg_time','$link','$photo')");
$kol=mysql_num_rows(mysql_query("SELECT email FROM usertbl WHERE email='$email'"));
if($kol==0){
$qur=mysql_query("INSERT INTO usertbl VALUES('0','0','0','$uid','0','0','$explode','$email','$first_name','$last_name','$sex','$birthday','$reg_time','$photo','0','$reg_time','0')");
$qur=mysql_query("SELECT id_user, username FROM usertbl WHERE username='$explode'");$kol=mysql_num_rows($qur);
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
$_SESSION['session_username']=mb_strtolower($explode);echo '<script>opener.window.location="http://gallery.24myfree.ru/login/";window.close();</script>';
}else{$_SESSION['session_username']=mb_strtolower($explode);$qur=mysql_query("UPDATE usertbl SET google='$uid',last_login='$reg_time' WHERE email='$email'");echo '<script>opener.window.location="http://gallery.24myfree.ru/login/";window.close();</script>';}
}else{$_SESSION['session_username']=mb_strtolower($explode);$qur=mysql_query("UPDATE usertbl SET last_login='$reg_time' WHERE email='$email'");echo '<script>opener.window.location="http://gallery.24myfree.ru/login/";window.close();</script>';}
}else{echo '<script>opener.window.location="http://gallery.24myfree.ru/login/?message=ошибка-у-гугл";window.close();</script>';}
}else{echo '<script>opener.window.location="http://gallery.24myfree.ru/login/?message=ошибка-у-гугл";window.close();</script>';}
}
if($_GET['provider']=='yandex'){
if(isset($_GET['code'])){
$client_id='1f3b88c2878a4695a1ef60989fdf1b14';$client_secret='7e26c39c5d6e425bb6f5e1478291dbb3';$redirect_uri='http://gallery.24myfree.ru/login/?do=social%26provider%3Dyandex';$result=false;
$params=array('grant_type'=>'authorization_code','code'=>$_GET['code'],'client_id'=>$client_id,'client_secret'=>$client_secret);
$url='https://oauth.yandex.ru/token';
$curl=curl_init();
curl_setopt($curl,CURLOPT_URL,$url);
curl_setopt($curl,CURLOPT_POST,1);
curl_setopt($curl,CURLOPT_POSTFIELDS, urldecode(http_build_query($params)));
curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);
$result=curl_exec($curl);
curl_close($curl);
$tokenInfo=json_decode($result,true);
if(isset($tokenInfo['access_token'])){$params=array('format'=>'json','oauth_token'=>$tokenInfo['access_token']);
$userInfo=json_decode(file_get_contents('https://login.yandex.ru/info?'.urldecode(http_build_query($params))),true);
if(isset($userInfo['id'])){$userInfo=$userInfo;$result=true;}}
if($result){
$email=$userInfo['default_email'];
list($explode,$mail)=explode('@',$email);
$reg_time=time();
$uid=$userInfo['id'];
$first_name=$userInfo['first_name'];
$last_name=$userInfo['last_name'];
$username=$userInfo['login'];
$sex=$userInfo['sex'];
$sex=='male'?$sex='2':$sex='1';
$birthday=$userInfo['birthday'];
list($day,$month,$year)=explode("-",$birthday);
$birthday=mktime('0','0','0',$month,$day,$year);
$photo='http://upics.yandex.net/'.$uid.'/big';
require_once($_SERVER["DOCUMENT_ROOT"]."/include/connection.php");
$kol=mysql_num_rows(mysql_query("SELECT email FROM yandextbl WHERE email='$email'"));
if($kol==0){
$qur=mysql_query("INSERT INTO yandextbl VALUES('0','$uid','$username','$email','$first_name','$last_name','$sex','$birthday','$reg_time','$photo')");
$kol=mysql_num_rows(mysql_query("SELECT email FROM usertbl WHERE email='$email'"));
if($kol==0){
$qur=mysql_query("INSERT INTO usertbl VALUES('0','0','0','0','$uid','0','$explode','$email','$first_name','$last_name','$sex','$birthday','$reg_time','$photo','0','$reg_time','0')");
$qur=mysql_query("SELECT id_user, username FROM usertbl WHERE username='$explode'");$kol=mysql_num_rows($qur);
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
$_SESSION['session_username']=mb_strtolower($explode);echo '<script>opener.window.location="http://gallery.24myfree.ru/login/";window.close();</script>';
}else{$_SESSION['session_username']=mb_strtolower($explode);$qur=mysql_query("UPDATE usertbl SET yandex='$uid',last_login='$reg_time' WHERE email='$email'");echo '<script>opener.window.location="http://gallery.24myfree.ru/login/";window.close();</script>';}
}else{$_SESSION['session_username']=mb_strtolower($explode);$qur=mysql_query("UPDATE usertbl SET last_login='$reg_time' WHERE email='$email'");echo '<script>opener.window.location="http://gallery.24myfree.ru/login/";window.close();</script>';}
}else{echo '<script>opener.window.location="http://gallery.24myfree.ru/login/?do=register&message=ошибка-у-яндекс";window.close();</script>';}
}else{echo '<script>opener.window.location="http://gallery.24myfree.ru/login/?do=register&message=ошибка-у-яндекс";window.close();</script>';}
}
if($_GET['provider']=='mail'){
if(isset($_GET['code'])){
$client_id='744082';$client_secret='e98ba346a3c5057cf6304156a1b5481f';$redirect_uri='http://gallery.24myfree.ru/login/?do=social%26provider%3Dmail';$result=false;
$params=array('client_id'=>$client_id,'client_secret'=>$client_secret,'grant_type'=>'authorization_code','code'=>$_GET['code'],'redirect_uri'=>$redirect_uri);
$url='https://connect.mail.ru/oauth/token';
$curl=curl_init();
curl_setopt($curl,CURLOPT_URL,$url);
curl_setopt($curl,CURLOPT_POST,1);
curl_setopt($curl,CURLOPT_POSTFIELDS, urldecode(http_build_query($params)));
curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);
$result=curl_exec($curl);
curl_close($curl);
$tokenInfo=json_decode($result,true);
if(isset($tokenInfo['access_token'])){
$sign=md5("app_id={$client_id}method=users.getInfosecure=1session_key={$tokenInfo['access_token']}{$client_secret}");
$params=array('method'=>'users.getInfo','secure'=>'1','app_id'=>$client_id,'session_key'=>$tokenInfo['access_token'],'sig'=>$sign);
$userInfo=json_decode(file_get_contents('http://www.appsmail.ru/platform/api?'.urldecode(http_build_query($params))),true);
if(isset($userInfo[0]['uid'])){$userInfo=array_shift($userInfo);$result=true;}}
if($result){
$email=$userInfo['email'];
list($explode,$mail)=explode('@',$email);
$reg_time=time();
$uid=$userInfo['uid'];
$link=$userInfo['link'];
$first_name=$userInfo['first_name'];
$last_name=$userInfo['last_name'];
$username=$userInfo['nick'];
$sex=$userInfo['sex'];
$sex=='0'?$sex='2':$sex='1';
$birthday=$userInfo['birthday'];
list($day,$month,$year)=explode($birthday);
$birthday=mktime('0','0','0',$month,$day,$year);
$photo=$userInfo['pic_big'];
require_once($_SERVER["DOCUMENT_ROOT"]."/include/connection.php");
$kol=mysql_num_rows(mysql_query("SELECT email FROM mailtbl WHERE email='$email'"));
if($kol==0){
$qur=mysql_query("INSERT INTO mailtbl VALUES('0','$uid','$username','$email','$first_name','$last_name','$sex','$birthday','$reg_time','$link','$photo')");
$kol=mysql_num_rows(mysql_query("SELECT email FROM usertbl WHERE email='$email'"));
if($kol==0){
$qur=mysql_query("INSERT INTO usertbl VALUES('0','0','0','0','0','$uid','$explode','$email','$first_name','$last_name','$sex','$birthday','$reg_time','$photo','0','$reg_time','0')");
$qur=mysql_query("SELECT id_user, username FROM usertbl WHERE username='$explode'");$kol=mysql_num_rows($qur);
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
$_SESSION['session_username']=mb_strtolower($explode);echo '<script>opener.window.location="http://gallery.24myfree.ru/login/";window.close();</script>';
}else{$_SESSION['session_username']=mb_strtolower($explode);$qur=mysql_query("UPDATE usertbl SET mail='$uid',last_login='$reg_time' WHERE email='$email'");echo '<script>opener.window.location="http://gallery.24myfree.ru/login/";window.close();</script>';}
}else{$_SESSION['session_username']=mb_strtolower($explode);$qur=mysql_query("UPDATE usertbl SET last_login='$reg_time' WHERE email='$email'");echo '<script>opener.window.location="http://gallery.24myfree.ru/login/";window.close();</script>';}
}else{echo '<script>opener.window.location="http://gallery.24myfree.ru/login/?do=register&message=ошибка-у-мэйл";window.close();</script>';}
}else{echo '<script>opener.window.location="http://gallery.24myfree.ru/login/?do=register&message=ошибка-у-мэйл";window.close();</script>';}
}
?>