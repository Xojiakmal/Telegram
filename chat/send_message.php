<?php
include "texnic/conn.php";

if ((isset($_GET['from']) and !empty($_GET['from'])) and (isset($_GET['to']) and !empty($_GET['to']))) {
    $from_data = explode('-', $_GET['from']);
    $to_data = explode('-', $_GET['to']);
    if ($from_data[0] == 'u' and $to_data[0] == 'u') {
        if (isset($_GET['text'])) {
            $text = $_GET['text'];
            $from_id = $from_data[1];
            $to_id = $to_data[1];

            $query = "INSERT INTO `notes`(`text`, `user_id`, `to_whom`) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$text, $from_id, $to_id]);
            header("Location: chat_message.php?id=".$to_id);
        }
        elseif (isset($_GET['file'])) {
            
        }
    }


}