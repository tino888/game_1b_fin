<?php
require_once "admin/connCMS.php";
//得到所有分类信息
$query="select * from users";
$info=mysql_query($query);
$typearr=array();
while($result=mysql_fetch_array($info,MYSQL_ASSOC)){
	$typearr[]=$result;
}
//得到十条最近发布信息
/*$query="select * from content c,type t where c.tid=t.tid order by dateline desc limit 0,10";
$info=mysql_query($query);
$contentarr=array();
while($result=mysql_fetch_array($info,MYSQL_ASSOC)){
	$result[dateline]=date("Y-m-d",$result[dateline]);
	$result[message]=substr($result[message],0,400)."...... ......";
	$contentarr[]=$result;
}

mysql_close($connection);*/
//v=======================================================================================================
?>


<!doctype html>
<html>
 <head>
  <meta charset="utf-8">
  <title>注册</title>
 <meta name="viewport" content="width=750,maximum-scale=1.0, user-scalable=no"/>
  <style type="text/css">
	    * {
	  margin:0;
	  padding:0;
    }
	html{
		width:100%;height:100%;
		margin:0;padding:0;
	}
	body {
		height:100%;
		margin:0;padding:0;
		background-color: #F0F1F3;
	   	font-family:Microsoft YaHei,微软雅黑,Arial,MS PGothic,helvetica,clean,sans-serif;/*'MisoRegular'*/
	}
	  
	.Ctt1Nav{
		  height:90px;
	      border-bottom:1px #dddddd solid; box-sizing: border-box;background-color: #ffffff;
		  color:#0071FF; font-size:32px; font-weight:bold; text-align: center;line-height:90px;
	}
	.Register{
	    height: calc(100% - 113px - 90px ); overflow-y: scroll;font-family:"微软雅黑";
	}
.login {
	width: 75%;height:296px;
	position:  absolute;margin:auto;left:0px;right: 0px;top:0px;bottom: 0px;
	background-color: #FFF;
}
.UName,.PWord{
	font-size:30px;
}
	  
	  
  </style>
  
  <script src="Scripts/jquery-1.11.3.min.js"></script>
 </head>


<body>
<div id="ctt1Nav" class="Ctt1Nav" >按钮4（注册）</div>
 <div id="register" class="Register">
  <div class="login" align="center">
    </br><h2>用户注册</h2><br>
    <form action="post.php?action=register" method="post">
      <table border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><div class="UName" align="right" >用户名:</div></td>
          <td><input name="username" type="text" size="22"></td>
        </tr>
        <tr>
          <td><div class="PWord" align="right">密码:</div></td>
          <td><input name="passwd" type="password" size="22"></td>
        </tr>
      </table>
      <br>
      <input type="submit" name="Submit" value="注册">&nbsp;
      <input type="reset" name="reset" value="取消">
    </form>
    <br>
  </div>
</div>


 <script>

 </script>
</body>
</html>

