<?php
header("Access-Control-Allow-Origin: *");
use Workerman\Worker;
require_once __DIR__ . '/libs/Workerman/Autoloader.php';
//require_once "admin/connCMS.php";


// 注意：这里与上个例子不同，使用的是websocket协议
// $ws_worker = new Worker("websocket://0.0.0.0:9000");
$ws_worker = new Worker("websocket://192.168.43.88:3356");

//=============================================================================================
// 启动4个进程对外提供服务
$ws_worker->count = 5000;//10000
// 新增加一个属性，用来保存uid到connection的映射(uid是用户id或者客户端唯一标识)
$ws_worker->uidConnections = array();

// 当收到客户端发来的数据后返回hello $data给客户端
$ws_worker->onMessage = function($connection, $data)
{   
	global $ws_worker;
	// 判断当前客户端是否已经验证,即是否设置了uid
	if(!isset($connection->uid))
	{
	   // 没验证的话把第一个包当做uid（这里为了方便演示，没做真正的验证）
	   $connection->uid = $data;
	   /* 保存uid到connection的映射，这样可以方便的通过uid查找connection，
		* 实现针对特定uid推送数据
		*/
	   $ws_worker->uidConnections[$connection->uid] = $connection;
	   return $connection->send('login success, your uid is ' . $connection->uid);
	}
	// 其它逻辑，针对某个uid发送 或者 全局广播
	// 假设消息格式为 uid:message 时是对 uid 发送 message
	// uid 为 all 时是全局广播
	list($recv_uid, $message) = explode(':', $data);
	// 全局广播
	if($recv_uid == 'all')
	{
		broadcast($message);
	}
	//gps对应uid入库,也是接受心跳
	elseif(strpos($message,'gps')!=-1){
		echo('收到心跳');
		sendMessageByUid($recv_uid, $message);
		$message=substr($message,3);
		$query="update users set curr_gps='".$message."' WHERE uid = '$recv_uid'";
		$info=mysql_query($query);
		// mysql_close($connection);
	}
	// 给特定uid发送
	else
	{   
		// $connection->send($message);//可以不要为妙
		sendMessageByUid($recv_uid, $message);
	}
	
    // 向客户端发送hello $data
    // $connection->send($connection->id.'hello ' . $data." ip:". $connection->getRemoteIp().":".$connection->getRemotePort());
    //	echo $connection->getRemoteIp() ;
  
};

// 当有客户端连接断开时
$ws_worker->onClose = function($connection)
{
    global $ws_worker;
    if(isset($connection->uid))
    {
        // 连接断开时删除映射
        unset($ws_worker->uidConnections[$connection->uid]);
    }
};


//======================================================================================
// 向所有验证的用户推送数据
function broadcast($message)
{
   global $ws_worker;
   foreach($ws_worker->uidConnections as $connection)
   {
        $connection->send($message);
   }
}

// 针对uid推送数据
function sendMessageByUid($uid, $message)
{
    global $ws_worker;
    if(isset($ws_worker->uidConnections[$uid]))
    {
        $connection = $ws_worker->uidConnections[$uid];
        $connection->send($message);
	
    }
}


// 运行所有的worker（其实当前只定义了一个）
Worker::runAll();


//E:\phpstudy_pro\Extensions\php\php5.4.45nts
//php ws_s.php start

?>