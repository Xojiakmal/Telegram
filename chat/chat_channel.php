<?php
session_start();
include 'texnic/conn.php';
include "functions/chek_session.php";
include 'functions/add_contacts.php';

$my_id = chek_session('my_id', 'index.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $whom_id = $_SESSION['whom_id'] = $_GET['id'];
    
    $stmt = $pdo->prepare("SELECT `channel_name` FROM `channels` WHERE `id`=?");
    $stmt->execute([$whom_id]);
    $res = $stmt->fetch();
    
    add_contacts($pdo, $my_id, $whom_id, 'channel');

}
elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = rand(1000000, 9999999);
    $_SESSION['form_token'] = $token;
    if($_POST['textarea'] != null and $_FILES['file'] == null){
        $_SESSION['group_data'] = $_POST['textarea'];
        header("Location: send_message.php?form_token=$token&text=true");
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
    <h1><?=$res['channel_name']?></h1>
    <form action="<?=$_SERVER['PHP_SELF']?>" method='POST' enctype="multipart/form-data">
        <input type="file" name="file" id="">
        <textarea name="textarea"></textarea>
        <input type="submit" value="Yuborish"><br>
        <a href="show_users.php?where=channels">Back</a>
    </form>
</body>
</html>