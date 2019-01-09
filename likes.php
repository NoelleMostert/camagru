<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
//echo $_SERVER["DOCUMENT_ROOT"].'/Camagru/core/init.php'.PHP_EOL;
require $_SERVER["DOCUMENT_ROOT"].'/Camagru/core/init.php';

//echo "it works?";
$Dbo = DB::getInstance();
$pdo = $Dbo->getConnection();

//var_dump($_POST);
$respone_array = array("status" => "", "action" => "");
if(isset($_POST["img"]))
{

    $img_id =  htmlspecialchars($_POST["img"]);
    $uid = htmlspecialchars($_SESSION["user_id"]);
    $Dbo = DB::getInstance();
    $pdo = $Dbo->getConnection();
    
    $stmt = $pdo->prepare("SELECT * FROM `event` WHERE `event`='like' AND `user_id`=:uid AND `img_id` =:iid");
    $stmt->bindParam(":uid", $uid, PDO::PARAM_INT, 11);
    $stmt->bindParam(":iid", $img_id, PDO::PARAM_INT, 11);
    $stmt->execute();
  
    $sql;
    if($stmt->rowCount() == 0)
    {
        $sql = "INSERT INTO `event` (`event`, `img_id`, `user_id`) VALUES (:type, :iid, :uid)";
        $respone_array["action"] = "like";
    }
    else
    {
        $sql = "DELETE FROM `event` WHERE `event`=:type AND user_id=:uid AND img_id=:iid";
        $respone_array["action"] = "unlike";
    }
    try
    {
        $type = "like";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":uid", $_SESSION["user_id"], PDO::PARAM_INT, 11);
        $stmt->bindParam(":iid", $img_id, PDO::PARAM_INT, 11);
        $stmt->bindParam(":type", $type, PDO::PARAM_STR);
        $stmt->execute();
        $respone_array["status"] = "success";
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

