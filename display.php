<?php
/*error_reporting(E_ALL);
ini_set('display_errors', 1);*/
    include_once 'core/init.php';
    header('Content-Type: text/html');
    if(Session::exists('home')) {
        echo '<p>' .Session::flash('home') . '<p>';
    }
    $user = new User();
   // <!-- stop php code -->
  //  <p>Hello <a href="#"><?php echo escape($user->data()->username)
?>
<!DOCTYPE html>


<head id="header">

    <title>Display mySQL images</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./js/likes.js"></script>
</head>
<body>
<div id="container">
<!--    Trying out a new header-->
<?php require_once("./includes/navbar.inc.php") ?>
    <!--    Trying out a new header-->
<?php
    $disabled = "";
    if ($_SESSION["user_name"] != "guest")
        echo "Public Gallery";
    else
    {
        $disabled = "disabled";
        echo '<p> You need to <a href="login.php">log in</a> or <a href="register.php">register</a></p>';
    }
?>
</div>
<div id="photos">
<?php

$Dbo = DB::getInstance();
$pdo = $Dbo->getConnection();

$stmt = $pdo->query("SELECT * FROM `images`");
$stmt->execute();

$sql = "SELECT * FROM `event` WHERE `img_id`=:id AND `event`='like'";


while($data = $stmt->fetch(PDO::FETCH_ASSOC)){
    $stmt_inter = $pdo->prepare($sql);
    $stmt_inter->bindParam(":id", $data["id"]);
    $stmt_inter->execute();
    $stmt_inter->fetch(PDO::FETCH_ASSOC);
    $comment = "<textarea class='comment_section' readonly>";
    $stmt_comm = $pdo->prepare("SELECT * FROM `event` WHERE img_id=:id AND `event`='comment'");
    $stmt_comm->bindParam(":id", $data["id"]);
    $stmt_comm->execute();
    while ($comm_data = $stmt_comm->fetch(PDO::FETCH_ASSOC))
    {
        $comment .= $comm_data["message"].PHP_EOL;
    }
    $comment.="</textarea>";

    $form = "<form action='#' method='' class='comment-form-submit'>
    <input type='text' name='comm_message' ".$disabled."/>
    <button type='submit' ".$disabled.">Make Comment</button>
    </form>";
    echo "<div>";
	$img = "<img src='data:image/png;base64,".$data["image_url"]."' />";
    echo $img;
    echo $comment;
    //if ($_SESSION["user_name"] != "guest"){
        echo '<button id="bt_'.$data["id"].'"name="like_button"  data-postedby="'.$data["user_id"].'" class="btn-like" '.$disabled.'> like '.$stmt_inter->rowCount().'       
        </button>';//}
    echo $form;
    echo "</div>";
	//echo $data["image_url"];
	//printr($stmt);
}

?>
</div>
<!--</div> -->
<footer class="footer">
    © 2018 tbenedic Benedict Builds
</footer>
</body>
</html>