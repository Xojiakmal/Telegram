<?php
session_start();
include 'texnic/conn.php';
include 'functions/chek_session.php';
include 'functions/show_affinities.php';
include 'functions/writetolog.php';

$my_id = chek_session('my_id', 'index.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET' and isset($_GET['id'])) {
    $edit_id = explode('-', $_GET['id']);
    if ($edit_id[1] == 'g') {
        $resurse['type'] = 'Group';
        $resurse['col_name'] = 'group_name';
        $input_data_stmt = $pdo->prepare("SELECT * FROM `groups` WHERE `id`=?");
        $input_data_stmt->execute([$edit_id[0]]);
        $input_data = $input_data_stmt->fetch(PDO::FETCH_ASSOC);
        if ($input_data['admins'] != null) {
            $input_data['admins'] = json_decode($input_data['admins'], true);
        }
        $users_data = show_affinities($pdo, $my_id, 'users');
    }
    elseif ($edit_id[1] == 'c') {
        $resurse['type'] = 'Channel';
        $resurse['col_name'] = 'channel_name';
        $input_data_stmt = $pdo->prepare("SELECT * FROM `channels` WHERE `id`=?");
        $input_data_stmt->execute([$edit_id[0]]);
        $input_data = $input_data_stmt->fetch(PDO::FETCH_ASSOC);
        if ($input_data['admins'] != null) {
            $input_data['admins'] = json_decode($input_data['admins'], true);
        }
        $users_data = show_affinities($pdo, $my_id, 'users');
    }
    elseif ($edit_id[1] == 'u') {
        $resurse['type'] = 'User';
        $resurse['col_name'] = 'name';
        $input_data_stmt = $pdo->prepare("SELECT * FROM `users` WHERE `id`=?");
        $input_data_stmt->execute([$my_id]);
        $input_data = $input_data_stmt->fetch(PDO::FETCH_ASSOC);
    }
}
elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // $data['name'] = filter_input('post', $name, )
    $edit_id = $_POST['edit_id'];
    $resurse = $_POST['resurse'];
    $data['name'] = $_POST['name'];
    if ($resurse['type'] != 'User') {
        $data['izoh'] = $_POST['izoh'];
        if ($_FILES['file']['name'] != null) {
            $file = $_FILES['file'];
            $file_path = "users_files/imyoshs/".$file['name'];
        }
        else {
            $file = null;
            $file_path = null;
        }
        if ($_POST['admins'] != null) {
            $data['admins'] = $_POST['admins'];
            $data['admins'] = json_encode($data['admins']);
        }
        else {
            $data['admins'] = null;
        }

        $query = "SELECT `id` FROM `".strtolower($resurse['type'])."s` WHERE `".strtolower($resurse['type'])."_name`=?";
        $chek_name = $pdo->prepare($query);
        $chek_name->execute([$data['name']]);
        $chek_name_data = $chek_name->fetch();

        if ($data['name'] != null && ($chek_name_data[0] == null || $edit_id[0] == $chek_name_data[0])) {
            $query = "UPDATE `".strtolower($resurse['type'])."s` SET ".strtolower($resurse['type'])."_name=?, `izoh`=?, `file`=?, `admins`=? WHERE `id`=?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$data['name'], $data['izoh'], $file_path, $data['admins'], $edit_id[0]]);
            if ($file != null) {
                file_put_contents('users_files/imyoshs/'.$file['name'], $file['tmp_name']);
            }
        }
        else {
            echo "Error. Name is none or used before";
        }
    }
    else {
        $data['yosh'] = $_POST['yosh'];
        $data['jins'] = $_POST['jins'];
        $data['millat'] = $_POST['millat'];
        
        if ($data['name'] != null) {
            $query = "UPDATE `".strtolower($resurse['type'])."s` SET `name`=?, `yosh`=?, `jins`=?, `millat`=? WHERE `id`=?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$data['name'], $data['yosh'], $data['jins'], $data['millat'], $my_id]);
            // print_r($my_id);
        }
    }

    header('Location:'.$_SERVER['PHP_SELF']."?id=".$edit_id[0].'-'.$edit_id[1]);
    exit;
}
else {
    header('Location:index.php');
    exit;
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
    <form action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data" method="POST">
        <input type="hidden" name="resurse[type]" value='<?=$resurse['type']?>'>
        <input type="hidden" name="resurse[col_name]" value='<?=$resurse['col_name']?>'>
        <input type="hidden" name="edit_id[]" value='<?=$edit_id[0]?>'>
        <input type="hidden" name="edit_id[]" value='<?=$edit_id[1]?>'>
        <label for="name"><?=$resurse['type']?> name: <input type="text" name='name' id='name' value='<?=$input_data[$resurse['col_name']]?>'></label><br>
        <?if ($resurse['type'] != 'User'){?>
        <label for="izoh">Izoh: <input type="text" name='izoh' id='izoh' value='<?=$input_data['izoh']?>'></label><br>
        <label for="profile"><input type="file" name="file" id="profile"></label><br>
        <?if($users_data != null):?><ul>
            <?foreach ($users_data as $v):?>
            <li><input type="checkbox" name='admins[]' value='<?=$v['id']?>' <?if($input_data['admins'] != null && in_array($v['id'], $input_data['admins'])):?>checked<?endif;?> name="admins"> <?=$v['name']?></li>
            <?endforeach;?>
        </ul><?endif;?>
        <input type="submit" value="Confirm"><br>
        <a href="show_users.php?where=<?=strtolower($resurse['type'])?>s">Back</a>
        <?} else {?>
        <label for="yosh"><?=$resurse['type']?> Yosh: <input type="number" name='yosh' id='yosh' value='<?=$input_data['yosh']?>'></label><br>
        <label for="male"><input type="radio" name="jins" <?if($input_data['jins'] == 'Erkak'):?>checked<?endif;?> id="male" value='Erkak'>Erkak</label>
        <label for="female"><input type="radio" name="jins" <?if($input_data['jins'] == 'Ayol'):?>checked<?endif;?> id="female" value='Ayol'>Ayol</label><br>
        <label for="millat">Millat: </label>
        <select name="millat" id="millat">
            <option value="Uzbek" <?if($input_data['millat'] == 'Uzbek'):?>selected<?endif;?>>Uzbek</option>
            <option value="Tojik" <?if($input_data['millat'] == 'Tojik'):?>selected<?endif;?>>Tojik</option>
            <option value="Qozozq" <?if($input_data['millat'] == 'Qoqoz'):?>selected<?endif;?>>Qozoq</option>
            <option value="Qirgiz" <?if($input_data['millat'] == 'Qirgiz'):?>selected<?endif;?>>Qirgiz</option>
        </select><br>
        
        <input type="submit" value="Confirm"><br>
        <a href="index.php">Back</a>
        <?}?>
    </form>
    <!-- groups -->
    <!-- Nomi, admin, izoh, file -->
    <!-- user -->
    <!-- other to tel -->
</body>
</html>