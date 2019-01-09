<?php
if(!isset($_SESSION))
	session_start();

require_once 'core/init.php';


$Dbo = DB::getInstance();
$pdo = $Dbo->getConnection();


if(isset($_POST["images"]))
{
	$all = json_decode($_POST["images"]);
	$full_thing = imagecreatetruecolor(500, 375);
	imagealphablending($full_thing, true);
	imagesavealpha($full_thing,true);
	
	$full_h = imagesx($full_thing);
	$full_w = imagesy($full_thing);
	$original = $full_w/$full_h;
	$fail = false;
	
	foreach($all as $key => $value)
	{
	
		$data = explode(",", $value, 2);
		$new = base64_decode($data[1]);
		$img = imagecreatefromstring($new);
		if ($img !== false)
		{
			
			imagealphablending($img, true);
			imagesavealpha($img, true);
			$h = imagesx($img);
			$w = imagesy($img);
			if($w/$h > $original)
				$w = $h*$original;
			else
				$h = $w/$original;
			$img = imagescale($img, $full_w, -1);
			imagecopy($full_thing, $img, 0, 0, 0, 0, $w, imagesy($img));
		}
		else
			$fail = true;
	}
	try{
		if($fail == false)
		{
			$imgdir = "./gallery/trial" . $_SESSION["user_id"] . ".png";
			imagepng($full_thing, $imgdir);
			$final = base64_encode(file_get_contents($imgdir));

			if(isset($_GET))
			{
				if($GET["type"] == "propic"){
					$stmt = $pdo->prepare("UPDATE users SET `propic`=:img, `type`='png' WHERE id=:uid");
					$stmt->bindParam(":img", $final, PDO::PARAM_STR);
					$stmt->bindParam(":uid", $_SESSION["user_id"]);
					$stmt->execute();
				}
				else{
					$stmt = $pdo->prepare("INSERT INTO `images` (`user_id`, `image_url`, `creation_date`) VALUES (:why, :image_url, NOW())");
					$stmt->bindParam(":why", $_SESSION["user_id"], PDO::PARAM_INT);
					$stmt->bindParam(":image_url", $final, PDO::PARAM_STR);
					$stmt->execute();

				}
				//imagedestroy($full_thing);
				//unlink($imgdir);
				echo "Success";
				exit();
			}
		}
		echo "failure";
	}
	catch(\PDOException $e){
		echo $e->getMessage;
	}

}
else{
	echo "Failure: Invalid method or file";
}
?>