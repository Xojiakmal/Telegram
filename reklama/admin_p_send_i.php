<?php
include 'texnic/conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ads_id = $_POST['ads'];
    $date_time = $_POST['send_time'];

    $res = $pdo->prepare("INSERT INTO `send_data`(`message_id`, `send_time`, `sended`) VALUES (?, ?, ?)");
    $res->execute([$ads_id, $date_time, false]);

    header("Location:".$_SERVER['PHP_SELF']);
    exit;
}
else {
    $res = $pdo->prepare('SELECT * FROM `informations`');
    $res->execute();
    $data = $res->fetchAll(PDO::FETCH_ASSOC);
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
    <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <select name="ads" id="">
            <option value="">...</option>
            <?foreach($data as $v){?>
            <option value="<?=$v['id']?>"><?=$v['id']?>: <?=$v['message']?></option>
            <?}?>
        </select>
        <label for="time"><input type="datetime" name="send_time" id="time"></label>
        <input type="submit" value="Tanlash">
    </form>
</body>
</html>