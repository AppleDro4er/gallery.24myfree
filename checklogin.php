<?php
if($_SERVER['REQUEST_METHOD']=='POST'){if(!empty($_POST['user_login'])){
require_once($_SERVER["DOCUMENT_ROOT"]."/include/connection.php");$success=false;$username=trim($_POST['user_login']);
if(preg_match('/^[a-zA-Z0-9_-]{3,20}$/',$username)){
$kol=mysql_num_rows(mysql_query("SELECT username FROM usertbl WHERE username='$username'"));
if($kol==0){$success=true;echo json_encode(array($success,$username,$error));
}else{$error="Данное имя уже зарегистрировано!";echo json_encode(array($success,$username,$error));}
}else{$error="Вы используете недопустимое имя!";echo json_encode(array($success,$username,$error));}
}else{$error="Недопустимая длина имени. Логин не может быть менее 3 символов и более 20 символов!";echo json_encode(array($success,$username,$error));}}
?>