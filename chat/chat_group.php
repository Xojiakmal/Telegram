<?php
session_start();
include 'texnic/conn.php';
include "functions/chek_session.php";
include 'functions/writetolog.php';
include 'functions/add_contacts.php';

$my_id = chek_session('my_id', 'index.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $whom_id = $_SESSION['whom_id'] = $_GET['id'];
    
    $stmt = $pdo->prepare("SELECT `group_name` FROM `groups` WHERE `id`=?");
    writetolog($stmt, 'set');
    $stmt->execute([$whom_id]);
    $res = $stmt->fetch();
    writetolog($res, 'get');
    
    add_contacts($pdo, $my_id, $whom_id, 'group');

    $messages_stmt = $pdo->prepare("SELECT `id`, `text`, `file`, `user_id` FROM `notes` WHERE (`user_id`=:f AND `to_whom`=:s) OR (`user_id`=:a AND `to_whom`=:b)");
    writetolog($messages_stmt, 'set');
    $messages_stmt->execute([':f'=>$my_id, ':s'=>'g-'.$whom_id, ':a'=>$whom_id, ':b'=>'g-'.$my_id]);
    $messages_data = $messages_stmt->fetchAll(PDO::FETCH_ASSOC);
    writetolog($messages_data, 'get');
}
elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = rand(100000, 999999);
    $_SESSION['form_token'] = $token;
    if ($_POST['reply'] !== null) {
        $_SESSION['group_data'] = $_POST['textarea'];
        $_SESSION['reply_id'] = $_POST['reply'];
        header("Location: send_message.php?form_token=$token&text=true&reply=true");
        exit;
    }
    elseif($_POST['textarea'] !== null){
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
    <style>
        .message_field {
            max-height: 300px;
            min-height: 100px;
            border: solid 2px;
            display: inline-block;
            width: 400px;
            padding: 5px;
        }
        .message {
            border: solid 2px;
            display: inline-block;
            padding: 2px;
            width: 45%;
            margin: 2px 0;
        }
    </style>
</head>
<body>
    <h1><?=$res['group_name']?></h1>
    <h2><img src="users_files/images/default.jpg" alt=""></h2>
    <form action="<?=$_SERVER['PHP_SELF']?>" method='POST' enctype="multipart/form-data">
        <div class="message_field">
            <?foreach ($messages_data as $v):
                if ($v['user_id'] == $my_id) {
                    if (!empty($v['text'])) {?>
                        <div class='message' style="margin-left: 50%"><input type="radio" name="reply" value='<?=$v['id']?>'><?=$v['text']?></div><br>
                    <?}
                    else {?>
                        <div class='message' style="margin-left: 50%"><input type="radio" name="reply" value='<?=$v['id']?>'><?=$v['file']?></div><br>
                    <?}
                }
                else {
                    if (!empty($v['text'])) {?>
                        <div class='message'><input type="radio" name="reply" value='<?=$v['id']?>'><?=$v['text']?></div><br>
                    <?}
                    else {?>
                        <div class='message'><input type="radio" name="reply" value='<?=$v['id']?>'><?=$v['file']?></div><br>
                    <?}
                }
                ?>
            <?endforeach;?>
        </div><br>
        <input type="file" name="file" <?if($assent == true):?>disabled<?endif;?>>
        <textarea name="textarea"></textarea>
        <input type="submit" value="Yuborish"><br>
        <a href="show_users.php?where=groups">Back</a>
    </form>
</body>
</html>