<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	//echo $_SERVER["DOCUMENT_ROOT"].'/Camagru/core/init.php'.PHP_EOL;
	require $_SERVER["DOCUMENT_ROOT"].'/Camagru/core/init.php';
	
	//echo "it works?";
	$Dbo = DB::getInstance();
	$pdo = $Dbo->getConnection();
	
	//var_dump($_POST);
	$respone_array = array("status" => "", "action" => "", "message" => "");
	if(isset($_POST["img"]))
	{
	
		$img_id =  htmlspecialchars($_POST["img"]);
		$uid = htmlspecialchars($_SESSION["user_id"]);
		$message = htmlspecialchars($_POST["comm_message"]);
		$Dbo = DB::getInstance();
		$pdo = $Dbo->getConnection();

		try
		{
			$sql = "INSERT INTO `event` (`event`, `img_id`, `user_id`, `message`) VALUES (:type, :iid, :uid, :msg)";
			$type = "comment";
			$stmt = $pdo->prepare($sql);
			$stmt->bindParam(":uid", $_SESSION["user_id"], PDO::PARAM_INT, 11);
			$stmt->bindParam(":iid", $img_id, PDO::PARAM_INT, 11);
			$stmt->bindParam(":type", $type, PDO::PARAM_STR);
			$stmt->bindParam(":msg", $message, PDO::PARAM_STR, 255);
			$stmt->execute();
			$respone_array["status"] = "success";
			$respone_array["action"] = "comment";
			$respone_array["message"] = $message."\n";
			//send e-mail
			echo json_encode($respone_array);
			exit();
		}
		catch (\PDOException $e)
		{
			throw new \PDOException($e->getMessage(), (int)$e->getCode());
			exit();
		}
	}
?>