<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
if(!empty($_POST['user_login'])&&!empty($_POST['user_password1'])){
require_once($_SERVER["DOCUMENT_ROOT"]."/include/connection.php");
$success=false;$username=trim($_POST['user_login']);$password1=trim(htmlspecialchars($_POST['user_password1']));
if(trim(preg_match('/^[a-zA-Z0-9_-]{3,20}$/',$username))){$strtolower=strtolower($username);
$kol=mysql_num_rows(mysql_query("SELECT LOWER(username) FROM usertbl WHERE username='$strtolower'"));
if($kol!=0){if(strlen($password1)>=8){
$qur=mysql_query("SELECT LOWER(username), password FROM usertbl WHERE username='$strtolower'");$kol=mysql_num_rows($qur);
if($kol!=0){while($rez=mysql_fetch_assoc($qur)){$hash=$rez['password'];$username=$rez['username'];}
if(password_verify($password1,$hash)){$_SESSION['session_username']=$strtolower;$auth_time=time();
$qur=mysql_query("UPDATE usertbl SET last_login='$auth_time' WHERE username='$username'");
$success=true;echo json_encode(array($success,$username,$error));
}else{$error="Неверный пароль!";echo json_encode(array($success,$username,$error));}
}else{$error="Пользователь под таким логином не зарегистрирован!";echo json_encode(array($success,$username,$error));}
}else{$error="Длина пароля должна быть не менее 8 символов!";echo json_encode(array($success,$username,$error));}
}else{$error="Данное имя не зарегистрировано!";echo json_encode(array($success,$username,$error));}
}else{$error="Вы используете недопустимое имя!";echo json_encode(array($success,$username,$error));}
}else{$error="Все поля обязательны для заполнения!";echo json_encode(array($success,$username,$error));}}
?>