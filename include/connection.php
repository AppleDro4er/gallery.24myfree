<?php
function startSession($isUserActivity=true,$prefix=null){
$sessionLifetime=3000;
$idLifetime=600;
if(session_id())return true;
session_name('MYPROJECT'.($prefix?'_'.$prefix:''));
ini_set('session.cookie_lifetime',0);
if(!session_start())return false;
$t=time();
if($sessionLifetime){
if(isset($_SESSION['lastactivity'])&&$t-$_SESSION['lastactivity']>=$sessionLifetime){destroySession();return false;}
else{if($isUserActivity)$_SESSION['lastactivity']=$t;}
}
if($idLifetime){
if(isset($_SESSION['starttime'])){if($t-$_SESSION['starttime']>=$idLifetime){session_regenerate_id(true);$_SESSION['starttime']=$t;}}
else{$_SESSION['starttime']=$t;}
}
return true;
}
function destroySession(){
if(session_id()){
$username=$_SESSION['session_username'];
$full_date=time();
$query=mysql_query("UPDATE usertbl SET last_logout='".$full_date."' WHERE username='".$username."'");
session_unset();
setcookie(session_name(),session_id(),time()-60*60*24);
session_destroy();
header("Location:".$_SERVER['HTTP_REFERER']);
}
}
startSession();
require($_SERVER['DOCUMENT_ROOT']."/include/constants.php");
$con=mysql_connect(DB_SERVER,DB_USER,DB_PASS)or die(mysql_error());
mysql_select_db(DB_NAME)or die("Cannot select DB");
mysql_set_charset('utf8');
?>