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

	  $stmt = $pdo->query("INSERT INTO `users` (`id`, `email`, `verified`, `bio`, `propic`, `username`, `password`, `salt`, `joined`, `group_type`, `activation_key`, `forgot_key`) VALUES
	  (22, 'camagru@mailinator.com', 1, NULL, NULL, 'tester', '', '1', '2018-12-04 01:27:25', 1, 0xc744aa635a801ee41c49, 0x30),
	  (23, 'camagrutest@mailinator.com', 1, NULL, NULL, 'mailtester', '', '1', '2018-12-04 06:01:39', 1, 0x02c77f195874015f583c, NULL),
	  (24, 'noellemostert@gmail.com', 0, NULL, NULL, 'nmostert', '', '1', '2018-12-16 08:56:47', 1, 0xfbf5894c790c86e39121, NULL)");
	  $stmt->execute();
	}
	catch (\PDOException $e)
	{
		die($e->getMessage());
	}


/*require_once './database.php';
	
	$pdo = DB::getConnection();
	try
	{
		$stmt = $pdo->query("CREATE DATABASE IF NOT EXISTS db_camagru");
		$stmt->execute();
		
		$stmt = $pdo->query("CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL  AUTO_INCREMENT PRIMARY KEY,
  `user_name` varchar(15) NOT NULL UNIQUE,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `email` text NOT NULL,
  `hash` text NOT NULL,
  `avatar` mediumblob,
  `type` text,
  `em_subs` tinyint(1) NOT NULL DEFAULT '1',
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `verification_key` varbinary(10) DEFAULT NULL,
  `forgot_key` varbinary(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8");
		$stmt->execute();
		
		
		$stmt = $pdo->query("CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11)  NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(11) NOT NULL,
  `src` mediumblob NOT NULL,
  `creation_date` datetime NOT NULL,
  `type` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8");
		$stmt->execute();
		
		
		$stmt = $pdo->query("CREATE TABLE IF NOT EXISTS`events` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `type` enum('comment','like') NOT NULL,
  `img_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8");
		$stmt->execute();
	$stmt = $pdo->query("ALTER TABLE `events` ADD CONSTRAINT `img_id` FOREIGN KEY (`img_id`) REFERENCES `images`(`id`) ON DELETE CASCADE ON UPDATE CASCADE; ALTER TABLE `events` ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;");
		$stmt->execute();
		
		$stmt = $pdo->query("INSERT INTO `users` (`user_name`, `first_name`, `last_name`, `email`, `hash`, `avatar`, `type`, `em_subs`, `verified`, `verification_key`, `forgot_key`) VALUES
( 'Fred-Dee', 'Fred', 'Dilapisho', 'fred.dilapisho@mailinator.com', '', NULL, NULL, 1, 1, NULL, 0x2c07a9a73044d40527f1),
('Tester', 'Fred', 'Dilapisho', 'fred.dilapisho@mailinator.com', '', NULL, NULL, 0, 1, NULL, NULL),
('KGart', 'Kyle', 'Gartland', 'fred.dilapisho@gmail.com', '', NULL, NULL, 1, 1, 0x8918b41d6891917ae328, NULL),
('JDee', 'Jonathan', 'Dilapisho', 'fred.dilapisho@mailinator.com', '', NULL, NULL, 1, 1, 0x5aa4b6e590b04dc6e54b, 0xeb50ffa56a00d842b8f7),
('tmarking2', 'Thato', 'Marking', 'tmarking@mailinator.com', '', NULL, NULL, 1, 1, 0x09ceeb4e4d9c4db09f17, 0x3b600d5424b33b3ba7a7)");
		$stmt->execute();
		
	}
	
	catch (\PDOException $e)
	{
		die($e->getMessage());
	}*/
	
?>