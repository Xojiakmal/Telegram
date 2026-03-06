<?php
session_start();
include "texnic/conn.php";
include "functions/chek_session.php";
include 'functions/writetolog.php';

$my_id = chek_session('my_id');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['my_id'] = $_POST['user'];
}
elseif ($my_id == 'bor') {
    $res = $pdo->prepare("SELECT `id`, `name` FROM `users`");
    writetolog($res, 'set');
    $res->execute();
    $data = $res->fetchAll(PDO::FETCH_ASSOC);
    writetolog($data, 'get');
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
    <?if ($data !== null){?>
    <form action="" method='POST'>
        <select name='user'>
            <?foreach ($data as $v):?>
            <option value="<?=$v['id']?>"><?=$v['name']?></option>
            <?endforeach;?>
            <input type="submit" value="Tanlash">
        </select>
    </form>
    <?} else {?>
        <ul>
            <li><a href='edit_group_channel.php?id=<?=$my_id?>-u'>Edit profile</a></li>
            <li><a href='show_users.php?where=users'>Contacts</a></li>
            <li><a href='show_users.php?where=groups'>Groups</a></li>
            <li><a href='show_users.php?where=channels'>Channels</a></li>
        </ul>
    <?}?>
    <a href="login.php">Log in</a>
</body>
</html>