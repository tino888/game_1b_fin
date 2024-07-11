<?php
//这个文件是对应admincp.php的usercp.php
session_start();

header("Access-Control-Allow-Origin: *");
//header('Content-Type:application/json; charset=utf-8');


//var===============================================================================================================================


//init===============================================================================================================================	
if($_GET["action"]=='logout'){
//注销管理=========================================
	session_unset();
	session_destroy();
?>
<script language="javascript">
		alert("已注销");
		location.href="usercp2.php";
</script>

<?php
}elseif($_SESSION['uid']){

//3.可编辑，有sessionA===============================
echo "<script language=\"javascript\">
		alert(\"已登录\");
		location.href=\"index.php\";
</script>";


}elseif($_GET["action"]=='login'){
//2.验证登录=========================================
if(!$_POST[username]||!$_POST[passwd]){
	echo "<script language=\"javascript\">
		alert(\"Please type username and password!\");
		location.href=\"usercp2.php\";
		</script>";
		exit();
}
require_once "admin/connCMS.php";
$query="select * from users where username='".$_POST[username]."' and passwd='".md5($_POST[passwd])."'";
	$info=mysql_query($query);
	if($result=mysql_fetch_array($info,MYSQL_ASSOC)){
		$_SESSION[uid]=$result[uid];//vip
		$_SESSION[username]=$result[username];//vip
	}else{
	echo "<script language=\"javascript\">
		alert(\"username or password error!\");
		location.href=\"usercp2.php\";
		</script>";
		exit();
	}
	?>
	&uid=<?= $_SESSION[uid] ?>&username=<?= $_SESSION[username] ?>
	<?php
}else{ 
//1.最开始未登录没session==================================

?>
<?php

}
?>


<?php 
//func==============================================================================================================================







?>
