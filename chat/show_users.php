<?php
session_start();
include "texnic/conn.php";
include "functions/chek_session.php";
include "functions/show_affinities.php";

$my_id = chek_session('my_id', 'index.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $_SESSION['whom'] = null;
    $resurse['name'] = $_GET['where'];
    
    if ($_GET['where'] == 'users') {
        $result = show_affinities($pdo, $my_id, 'users');
    }
    elseif ($_GET['where'] == 'groups') {
        $result = show_affinities($pdo, $my_id, 'groups');
        $create_to = ['info'=>'group', 'name'=>'Create group'];
    }
    elseif ($_GET['where'] == 'channels') {
        $result = show_affinities($pdo, $my_id, 'channels');
        $create_to = ['info'=>'channel', 'name'=>'Create channel'];
    }
    else {
        $result = show_affinities($pdo, $my_id);
    }
}
elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $text = trim($_POST['text']);
    $resurse['name'] = $_POST['resurse'];

    if ($resurse['name'] == 'users') {
        $resurse['cols'] = '`id`, `name`, `tel`';
        $resurse['like'] = 'tel';
    }
    elseif ($resurse['name'] == 'groups') {
        $resurse['cols'] = '`id`, `group_name`, `link`';
        $resurse['like'] = 'link';
    }
    elseif ($resurse['name'] == 'channels') {
        $resurse['cols'] = '`id`, `channel_name`, `link`';
        $resurse['like'] = 'link';
    }

    $stmt = $pdo->prepare("SELECT ".$resurse['cols']." FROM `".$resurse['name']."` WHERE `".$resurse['like']."` LIKE '%' :t ");
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
    <form action="" method="POST">
        <input type="hidden" name="resurse" value='<?=$resurse['name']?>'>
        <input type="text" name='text' placeholder="Qidiring">
        <input type="submit" value="Qidirish">
    </form><br>
    <a href="index.php">Back</a><br>
    <?if ($create_to !== null):?><a href="create_group_channel.php?type=<?=$create_to['info']?>"><?=$create_to['name']?></a><?endif;?>
    <div>
        <?if ($result !== null):?>
        <ul>
            <?foreach ($result as $v):
                if ($resurse['name'] == 'users') {
                    $first = $v['name'];
                    $second = $v['tel'];
                    $file = 'message';
                }
                elseif ($resurse['name'] == 'groups') {
                    $first = $v['group_name'];
                    $second = $v['link'];
                    $file = 'group';
                }
                elseif ($resurse['name'] == 'channels') {
                    $first = $v['channel_name'];
                    $second = $v['link'];
                    $file = 'channel';
                }
                ?>
            <li><a href="chat_<?=$file?>.php?id=<?=$v['id']?>"><?=$first?> - <?=$second?></a></li>
            <?endforeach;?>
        </ul>
        <?endif;?>
    </div>
</body>
</html>