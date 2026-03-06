<?php
session_start();
include "texnic/conn.php";
include "functions/chek_session.php";
include "functions/writetolog.php";

$my_id = chek_session('my_id', 'index.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $resurse['name'] = $_POST['resurse'];
    $data['name'] = $_POST['name'] ?? 'None';
    $data['type'] = $_POST['type'] ?? 'private';
    if ($data['type'] == 'private' or $_POST['link'] == null) {
        $res = $pdo->prepare("SELECT `name` FROM `users` WHERE `id`=?");
        writetolog($res, 'set');
        $res->execute([$my_id]);
        $my_name = $res->fetch();
        writetolog($my_name, 'get');

        $data['link'] = $my_name[0].$data['name'].rand(100000, 999999).$my_id;
    }
    elseif ($data['type'] == 'public') {
        $data['link'] = $_POST['link'];
    }

    if ($resurse['name'] == 'Group') {
        $data['table'] = 'groups';
        $data['cols'] = 'group_name';
    }
    elseif ($resurse['name'] == 'Channel') {
        $data['table'] = 'channels';
        $data['cols'] = 'channel_name';
    }
    if ($_POST['izoh'] != null) {
        $data['izoh'] = $_POST['izoh'];
    }
    else {
        $data['izoh'] = 'None';
    }
    if ($_FILES['file']['name'] != null) {
        $file = $_FILES['file'];
        $file_path = 'users_files/images/'.$file['name'];
    }
    else {
        $file = null;
        $file_path = null;
    }

    if (!in_array(null, $data)) {
        $chek_row_name = $pdo->prepare("SELECT `id` FROM `".$data['table']."` WHERE `".strtolower($resurse['name'])."_name`=? OR `link`=?");
        writetolog($chek_row_name, 'set');
        $chek_row_name->execute([$data['name'], $data['link']]);
        $chek_name = $chek_row_name->fetchAll();
        writetolog($chek_name, 'get');

        if ($chek_name == []) {
            $add_row_stmt = $pdo->prepare("INSERT INTO `".$data['table']."`(`".$data['cols']."`, `author_id`, `types`, `izoh`, `link`, `file`) VALUES (:name, :auid, :type, :iz, :li, :fi)");
            writetolog($add_row_stmt, 'set');
            if ($add_row_stmt->execute([':name'=>$data['name'], ':auid'=>$my_id, ':type'=>$data['type'], ':iz'=>$data['izoh'], ':li'=>$data['link'], ':fi'=>$file_path])) {
                if ($file_path != null) {
                    file_put_contents($file_path, $file['tmp_name']);
                }
                $get_row_stmt = $pdo->prepare("SELECT `id` FROM `".$data['table']."` WHERE `link`=:a");
                writetolog($get_row_stmt, 'set');
                $get_row_stmt->execute([':a'=>$data['link']]);
                if ($row_id = $get_row_stmt->fetch()) {
                    writetolog($row_id, 'get');
                    if ($resurse['name'] == 'Group') {
                        header("Location: chat_group.php?id=".$row_id['id']);
                        exit;
                    }
                    elseif ($resurse['name'] == 'Channel') {
                        header("Location: chat_channel.php?id=".$row_id['id']);
                        exit;
                    }
                }
                else {
                    echo "Error. Uncougth id";
                }
            }
            else {
                echo "Error. ".$resurse['name']." didn't create";
            }
        }
        else {
            echo "Error. This ".$resurse['name']." created before";
        }
    }
    else {
        echo "Error. Data isn't full";
    }
    
}
elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ($_GET['type'] == 'group') {
        $resurse = ['name'=>'Group'];
        $id = $_SESSION['whom_id'];
    }
    elseif ($_GET['type'] == 'channel') {
        $resurse = ['name'=>'Channel'];
        $id = $_SESSION['whom_id'];
    }
    else {
        header("Location:index.php");
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
    <form action="<?=$_SERVER['PHP_SELF']?>" method="POST"  enctype="multipart/form-data">
        <input type="hidden" name="resurse" value='<?=$resurse['name']?>'>
        <label for="name"><?=$resurse['name']?> name: <input type="text" name='name' id='name' reuqired></label><br>
        Choose <?=$resurse['name']?> type:
        <label for="pub">Public <input type="radio" value='public' name='type' id='pub'></label>
        <label for="pri">Private<input type="radio" value='private' name='type' id='pri'></label><br>
        <label for="link">Link: <input type="text" name='link' id='link'></label><br> 
        <label for="izoh">Izoh: <textarea name="izoh" id="izoh"></textarea></label><br>
        <label for="profile">Profile rasm<input type="file" name="file" id='profile'></label><br>
        <input type="submit" value="Create"><br>
        <?
        if ($resurse['name'] == 'Group') {
            echo "<a href='chat_group.php?id=$id'>Back</a>";
        }
        elseif ($resurse['name'] == 'Channel') {
            echo "<a href='chat_channel.php?id=$id'>Back</a>";
        }
        ?>
    </form>
</body>
</html>