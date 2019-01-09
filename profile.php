<?php
    include_once 'core/init.php';
    header('Content-Type: text/html');
    if(Session::exists('home')) {
        echo '<p>' .Session::flash('home') . '<p>';
    }
    $user = new User();
   // <!-- stop php code -->
  //  <p>Hello <a href="#"><?php echo escape($user->data()->username)
?>
<!DOCTYPE html><html>
<body>
<div id="container">
<div id="header">

    <title>Profile</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</div>
<?php require_once("./includes/navbar.inc.php") ?>
    <!--    Trying out a new header-->
<?php
    if ($_SESSION["user_name"] != "guest")
        echo "Profile Gallery";
    else
        echo '<p> You need to <a href="login.php">log in</a> or <a href="register.php">register</a></p>';
?>
<div id="photos">
<?php

$Dbo = DB::getInstance();
$pdo = $Dbo->getConnection();

$stmt = $pdo->query("SELECT image_url FROM images WHERE user_id =".$_SESSION["user_id"] );
// $stmt = $pdo->query("SELECT image_url FROM images WHERE user_id =:_1");

/*
        $stm = $db->prepare("DELETE FROM images WHERE pic_num=:_1 ");
        $stm->execute(array(
            '_1' => $_POST["pic_num"],
        ));
*/

$stmt->execute();


while($data = $stmt->fetch(PDO::FETCH_ASSOC)){
	$img = "<img src='data:image/png;base64,".$data["image_url"]."' />";
    echo $img;
	//echo $data["image_url"];
	//printr($stmt);
}

?>
</div>
<!--</div> -->
<div class="footer">
    © 2018 tbenedic Benedict Builds
</div>
</body>
</html>