<?php
session_start();
include "texnic/conn.php";

$_SESSION['my_id'] = "4";
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $text = trim($_GET['text']);

    $query = "SELECT `id`, `name`, `tel` FROM `users` WHERE `tel` LIKE '%' :t ";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':t' => $text]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <form action="" method="get">
        <input type="text" name='text' placeholder="Qidiring">
        <input type="submit" value="Qidirish">
    </form>
    <div>
        <ul>
            <?foreach ($result as $v):?>
            <li><a href="chat_message.php?id=<?=$v['id']?>"><?=$v['name']?> - <?=$v['tel']?></a></li>
            <?endforeach;?>
        </ul>
    </div>
</body>
</html>