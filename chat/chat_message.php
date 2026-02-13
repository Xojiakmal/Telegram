<?php
session_start();
include 'texnic/conn.php';

if (isset($_SESSION['my_id']) and !empty($_SESSION['my_id'])) {
    $my_id = $_SESSION['my_id'];
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $_SESSION['whom'] = $_GET['id'];
        $whom_id = $_GET['id'];
        $stmt = $pdo->prepare("SELECT `name` FROM `users` WHERE `id`=?");
        $stmt->execute([$whom_id]);
        $res = $stmt->fetch();

        $writed_select_query = "SELECT `users_id` FROM `users_affinities` WHERE `user_id`=?";

        $writed_to_chek = $pdo->prepare($writed_select_query);
        $writed_to_chek->execute([$whom_id]);
        $writed_to_data = $writed_to_chek->fetch();

        $writed_from_chek = $pdo->prepare($writed_select_query);
        $writed_from_chek->execute([$my_id]);
        $writed_from_data = $writed_from_chek->fetch();

        if (!empty($writed_to_data['users_id'])) {
            $writed_to_data['users_id'] = json_decode($writed_to_data['users_id'], true);

            if (!in_array($my_id, $writed_to_data['users_id'])) {
                $users_count = count($writed_to_data)+1;
                $writed_to_data['users_id'][] = $my_id;
                $writed_to_data['users_id'] = json_encode($writed_to_data['users_id']);

            }
        }
        else {
            $writed_to_data['users_id'][1] = $my_id;
            $writed_to_data['users_id'] = json_encode($writed_to_data['users_id']);
        }

        if (!empty($writed_from_data['users_id'])) {
            $writed_from_data['users_id'] = json_decode($writed_from_data['users_id'], true);
            
            if (!in_array($whom_id, $writed_from_data['users_id'])) {
                $users_count = count($writed_from_data)+1;
                $writed_from_data['users_id'][$users_count] = $whom_id;
                $writed_from_data['users_id'] = json_encode($writed_from_data['users_id']);
            }
        }
        else {
            $writed_from_data['users_id'][1] = $whom_id;
            $writed_from_data['users_id'] = json_encode($writed_from_data['users_id']);
        }
        $change_query = "UPDATE `users_affinities` SET `users_id`=:f WHERE `user_id`=:s";

        $change_from_data = $pdo->prepare($change_query);
        $change_from_data->execute([':f'=>$writed_to_data['users_id'], ':s'=>$whom_id]);

        $change_to_data = $pdo->prepare($change_query);
        $change_to_data->execute([':f'=>$writed_from_data['users_id'], ':s'=>$my_id]);
    }
    elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $whom_id = $_SESSION['whom'];
        if(isset($_POST['textarea']) and !empty($_POST['textarea'])){
            $textarea = $_POST['textarea'];
            header("Location: send_message.php?from=u-$my_id&to=u-$whom_id&text=$textarea");
            exit;
        }
        else {
            header("Location:send_message.php?from=u-$my_id&to=u-$whom_id&file=true");
            exit;
        }
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
    <h1><?=$res['name']?></h1>
    <form action="" method='POST' enctype="multipart/form-data">
        <input type="file" name="file" id="">
        <textarea name="textarea"></textarea required>
        <input type="submit" value="Yuborish">
    </form>
</body>
</html>