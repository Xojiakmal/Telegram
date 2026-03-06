<?php
include 'texnic/conn.php';
include 'functions/writetolog.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data['name'] = $_POST['name'];
    $data['tel'] = $_POST['tel'];
    $len = strlen((string)$data['tel']);
    if ($len == 9) {
        $data['tel'] = "+998".$data['tel'];
    }
    elseif ($len == 13) {}
    else {
        die('error');
    }

    if ($data['name'] != null) {
        $query = "SELECT `id` FROM `users` WHERE `name`=? AND `tel`=?";
        $stmt = $pdo->prepare($query);
        writetolog($stmt, 'set');
        $stmt->execute([$data['name'], $data['tel']]);
        $id = $stmt->fetch();
        writetolog($id, 'get');
        if ($id[0] != null) {
            $_SESSION['my_id'] = $id[0];
            header("Location: index.php");
            exit;
        }
    }
    else {
        echo "Name is none";
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