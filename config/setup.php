<?php
	include_once '../core/init.php';
	include_once './database.php';
	
	ini_set("display_errors", 1);
	ini_set("display_startup_errors", 1);
	error_reporting(E_ALL);

	echo "trying to connect";
	
	$Dbo = DB::getInstance();

	
	$pdo = $Dbo->getConnection();

echo "connected";

	try
	{
		$stmt = $pdo->query("CREATE DATABASE IF NOT EXISTS db_camagru");
		$stmt->execute();

		$stmt = $pdo->query("CREATE TABLE IF NOT EXISTS `users` ( 
		`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		`email` varchar(50) DEFAULT NULL,
		`verified` tinyint(1) DEFAULT NULL,
		`bio` varchar(146) DEFAULT NULL,
		`propic` mediumblob,
		`username` varchar(20) NOT NULL,
		`password` varchar(255) NOT NULL,
		`salt` varchar(32) NOT NULL,
		`joined` datetime DEFAULT NULL,
		`group_type` int(11) DEFAULT NULL,
		`activation_key` varbinary(16) DEFAULT NULL,
		`forgot_key` varbinary(16) DEFAULT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=utf8");
		$stmt->execute();

	  /*$stmt = $pdo->query("INSERT INTO `users` (`id`, `email`, `verified`, `bio`, `propic`, `username`, `password`, `salt`, `joined`, `group_type`, `activation_key`, `forgot_key`) VALUES
	  (22, 'camagru@mailinator.com', 1, NULL, NULL, 'tester', '', '1', '2018-12-04 01:27:25', 1, 0xc744aa635a801ee41c49, 0x30),
	  (23, 'camagrutest@mailinator.com', 1, NULL, NULL, 'mailtester', '', '1', '2018-12-04 06:01:39', 1, 0x02c77f195874015f583c, NULL),
	  (24, 'noellemostert@gmail.com', 0, NULL, NULL, 'nmostert', '', '1', '2018-12-16 08:56:47', 1, 0xfbf5894c790c86e39121, NULL)");
	  $stmt->execute();*/

	  $stmt = $pdo->query("CREATE TABLE IF NOT EXISTS `comments`
	  (`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	  `comment` varchar(150) NOT NULL,
	  `image_id` int(11) NOT NULL,
	  `username` varchar(20) NOT NULL
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8");
	  $stmt->execute();

	$stmt = $pdo->query("CREATE TABLE IF NOT EXISTS `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `event` enum('like','comment') NOT NULL,
  `img_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` varchar(255) DEFAULT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8");
	$stmt->execute();

$stmt = $pdo->query("CREATE TABLE IF NOT EXISTS `gallery`(
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `img_id` varchar(100) NOT NULL COMMENT 'datetime + user_id',
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8");
$stmt->execute();

$stmt = $pdo->query("CREATE TABLE IF NOT EXISTS `groups_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(11) NOT NULL,
  `permissions` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8");
$stmt->execute();


$stmt = $pdo->query("CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `image_url` mediumblob NOT NULL,
  `likes` int(11) DEFAULT '0',
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `type` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8");
$stmt->execute();

$stmt = $pdo->query("CREATE TABLE IF NOT EXISTS `likes` (
	`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`image_id` int(11) NOT NULL,
	`username` varchar(20) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8");
  $stmt->execute();

  $stmt = $pdo->query("CREATE TABLE IF NOT EXISTS `user_sessions` (
	`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`user_id` int(11) NOT NULL,
	`hash` varchar(64) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8");
   $stmt->execute();

 $stmt = $pdo->query("CREATE TABLE IF NOT EXISTS `verify` (
	`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`name` varchar(80) NOT NULL,
	`username` varchar(30) NOT NULL,
	`email` varchar(120) NOT NULL,
	`password` text NOT NULL,
	`code` text NOT NULL,
	`verified` tinyint(1) NOT NULL,
	`notification` tinyint(1) DEFAULT '1'
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8");
    $stmt->execute();
}

catch (\PDOException $e)
	{
		die($e->getMessage());
	}
	
?>