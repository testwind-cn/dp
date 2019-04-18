<!DOCTYPE html>
<html>
    <head lang="zh-cmn-Hans-CN">
        <meta charset="UTF-8">
      </head>
     <body>

<?php

/*
 * 
 *  这个是在新网上测试数据库的小程序
 * 
 * 
 * 
 * 
 * 
 */


echo "good1";

$a = 1;
echo "<br>";
$a = $a + 100;
echo "<br>";
echo "$a is";
echo "<br>";
echo '$a is';
echo "<br>";




$servername = "localhost";
$username = "root";
$password = "thbl123";
$dbname = "haolaoban";

try {
	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	// 设置 PDO 错误模式，用于抛出异常
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	// 使用 sql 创建数据表
	$sql = "CREATE TABLE MyGuests (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    email VARCHAR(50),
    reg_date TIMESTAMP
    )";

	// 使用 exec() ，没有结果返回
	$conn->exec($sql);
	echo "数据表 MyGuests 创建成功";
}
catch(PDOException $e)
{
	echo $sql . "<br>" . $e->getMessage();
}

$conn = null;


?>

</body>
</html>