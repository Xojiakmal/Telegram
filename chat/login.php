<?php
session_start();
include 'texnic/conn.php';
include 'functions/writetolog.php';
include 'functions/chek_inputs.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $chek_inputs = new Chek_inputs($_POST);

    $data['name'] = $chek_inputs->chek_name('name', 1);
    $data['tel'] = $chek_inputs->chek_tel('tel', 3);

    $stmt = $pdo->prepare("SELECT `id` FROM `users` WHERE `name`=:na AND `tel`=:te");
    writetolog($stmt, 'set');
    $stmt->execute([':na'=>$data['name'], ':te'=>$data['tel']]);
    $id = $stmt->fetch(PDO::FETCH_ASSOC);
    writetolog($id, 'get');
    if ($id['id'] != null) {
        $_SESSION['my_id'] = $id['id'];
        header("Location: index.php");
        exit;
    }
    else {
        header("Location: login.php?err=2");
        exit;
    }
}
elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ($_GET['err'] != null) {
        $err = $_GET['err'];
        if ($err == 1) {
            echo "Name is none";
        }
        elseif ($err == 2) {
            echo 'Name is not in base or other';
        }
        elseif ($err == 3) {
            echo 'Error in tel input';
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
        <label for="name">User name: <input type="text" id='name' name='name'></label><br>  
        <label for="tel">Phone: <input type="tel" name="tel" id="tel"></label><br>  
        <input type="submit" value="Login">
    </form>
    <a href="index.php">Back</a><br>
    <a href="register.php">Register</a>
</body>
</html>