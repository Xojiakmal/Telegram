<?php
session_start();
include 'texnic/conn.php';
include "functions/chek_session.php";
include 'functions/add_contacts.php';

$my_id = chek_session('my_id', 'index.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $whom_id = $_SESSION['whom_id'] = $_GET['id'];
    
    $stmt = $pdo->prepare("SELECT `group_name` FROM `groups` WHERE `id`=?");
    $stmt->execute([$whom_id]);
    $res = $stmt->fetch();
    
    add_contacts($pdo, $my_id, $whom_id, 'group');

}
elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = rand(100000, 999999);
    $_SESSION['form_token'] = $token;
    $whom_id = $_SESSION['whom_id'];
    if($_POST['textarea'] !== null){
        $textarea = $_POST['textarea'];
        header("Location: send_message.php?form_token=$token&text=$textarea");
        exit;
    }
    else {
        $_SESSION['file'] = $_FILES['file'];
        header("Location:send_message.php?form_token=$token&file=true");
        exit;
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
    <h1><?=$res['group_name']?></h1>
    <form action="<?=$_SERVER['PHP_SELF']?>" method='POST' enctype="multipart/form-data">
        <input type="file" name="file" id="">
        <textarea name="textarea"></textarea>
        <input type="submit" value="Yuborish"><br>
        <a href="show_users.php?where=groups">Back</a>
    </form>
</body>
</html>