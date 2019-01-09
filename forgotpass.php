
<?php
require_once 'core/init.php';

// $Dbo = DB::getInstance();
// $pdo = $Dbo->getConnection();

// $email = Input::get('email');

// $stmt = $pdo->prepare("SELECT * FROM users WHERE email='$email'");
// var_dump($stmt);


// $sql = "SELECT * FROM users WHERE email='$email'";
//         // $params = array (0 => $email);
//          $dbo->query($sql);


if (Token::check(Input::get('token'))) {

try {

function random_alphanumeric($length) {
    $key = '';
    $keys = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }
    return $key;
}
$len = 8;
$rand_bytes = random_alphanumeric($len);

$to = Input::get('email');
$subject = "Forgot Email Address";
$message = "Hi There!  <br />  <br /> This is your your new password: <b>".$rand_bytes. "</b> <br /> Please login and change your password immeadiately";
$headers = "FROM: noreply@innuendo.com";
if(!mail($to, $subject, $message, $headers)) {
echo "Mail error.";
exit();
}
Session::flash('home', 'Please check your email');

Redirect::to('index.php');
} catch (Exception $e) {
die($e->getMessage());
}
}
?>


<!DOCTYPE html>
<html>
<body>
<div id="container">
    <div id="header">

        <title>InnuendO</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

    </div>
    <form action ="" method="post">
        <div class="field">
            <label for="email">Email</label>
            <input type="email" name="email" id="email"  autocomplete="off">
        </div>


        <input type="hidden" name="token" value="<?php echo Token::generate();?>">
        <input type="submit" value="Mail me">
    </form>

    <div class="footer">
        © 2018 tbenedic Benedict Builds
    </div>
</div>
</body>
</html>