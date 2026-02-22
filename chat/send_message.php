<?php
session_start();
include "texnic/conn.php";
include "functions/chek_session.php";
include "functions/chek_token.php";

chek_session('my_id', 'index.php');

if ((isset($_GET['form_token']))) {
    $token = $_GET['form_token'];
    $data = chek_token($token);


    if ($data['whom_type'] == 'user') {
        if (isset($_GET['text'])) {
            $text = $_GET['text'];
            $from_id = $data['my_id'];
            $to_id = $data['whom_id'];

            $query = "INSERT INTO notes(text, user_id, to_whom) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$text, $from_id, $to_id]);
        }
        elseif (isset($_GET['file'])) {
            $image_type = ['jpg', 'jpeg', 'png','web','gif'];
            $video_type = ['MP4','MKV','MOV'];
            $musiq_typy = ['audio', 'mp3'];

            $from_id = $data['my_id'];
            $to_id = $data['whom_id'];
            $file = $_SESSION['file'];
            $file_type = explode('/', $file['type']);
            if (in_array($file_type[1], $image_type)) {
                file_put_contents('users_files/images/'.$file['name'], $file['tmp_name']);
                $file_path = 'users_files/images/'.$file['name'];
                
            }
            elseif (in_array($file_type[1], $video_type)) {
                file_put_contents('users_files/videos/'.$file['name'], $file['tmp_name']);
                $file_path = 'users_files/images/'.$file['name'];
                
            }
            elseif (in_array($file_type[1], $musiq_typy)) {
                file_put_contents('users_files/musics/'.$file['name'], $file['tmp_name']);
                $file_path = 'users_files/images/'.$file['name'];
                
            }
            else {
                file_put_contents('users_files/others/'.$file['name'], $file['tmp_name']);
                $file_path = 'users_files/images/'.$file['name'];
                
            }

            var_dump($file_path);
            if(!empty($file_path)){
                $sql = "INSERT INTO notes(file ,user_id, to_whom) VALUES(?, ?, ?)";
                $file_insert = $pdo->prepare($sql);
                if($file_insert->execute([$file_path, $data['whom_type'].$from_id, $data['whom_type'].$to_id])){
                    echo "File yuklandi";
                }
            }
        }
        header("Location: chat_message.php?id=".$to_id);
    }
}