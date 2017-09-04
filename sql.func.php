<?php
// sql.func.php 

	$db = null;

	function _query($_sql){
    if(!$_result = mysql_query($_sql)){
        exit('SQL执行失败'.mysql_error());
    }
    return $_result;
	}


	function openDB()
	{
		global $db;
		
		$db=mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
		if($db) {
			mysql_select_db(SAE_MYSQL_DB,$db);
		}
	}
	
	function closeDB()
	{
		global $db;
		mysql_close($db);//关闭mysql连接
		$db = null;
	}
		
	function 	_fetch_array( $pushmsg ) {
		$sql = "SELECT * FROM `product_msg` where `id` > 0 ORDER BY `id` ";
		$result=mysql_query($sql);
		$row =  mysql_fetch_array($result); $pushmsg[0] = $row['msg'];
		$row = mysql_fetch_array($result); $pushmsg[1] = $row['msg'];
		$row = mysql_fetch_array($result); $pushmsg[2] = $row['msg'];
		mysql_free_result($result);//释放mysql内存
	}
	
	function _free_result($result)
	{
		mysql_free_result($result);//释放mysql内存
	}
	
	function _fetch_array_list($result)
	{
		return mysql_fetch_array($result);
	}
		
?>