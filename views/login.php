<?php

session_start();

require_once '../app/helpers/Database.php';

$db = new Database();

if ($db->isUserLogged()){
    header("Location: main.php");die;
}

$errorMessage = null;
if (!empty($_POST)) {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = filter_input(INPUT_POST, 'pass');
    $pwdHash = password_hash($password, PASSWORD_DEFAULT);



    $user = $db->authUser($email, $password);

    if(!$user){
       $errorMessage = "Incorrect user or password";
    }else {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_auth'] = sha1($user['password']);
        header("Location: main.php");
        exit();
    }

}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/login.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
<section>
    <form action="login.php" method="post">
        <div class="container">
            <div class="row form-interface-container">
                <div class="col form-data-container">
                    <?php if($errorMessage): ?>
                    <b style="color:red"><?= $errorMessage ?> </b>
                        <?php endif; ?>
                    <p class="registration-title">Log in</p>
                    <label> User email </label>
                    <input type="email" id="email" name="email"/>
                    <label> Password </label>
                    <input type="Password" id="pass" name="pass">
                    <button class="reg-submit-btn btn-success">Login</button>
                    <p>Dont have an account?</p>
                    <a  href="register.php">Register</a>
                </div>
            </div>
        </div>
    </form>
</section>
</body>
</html>
