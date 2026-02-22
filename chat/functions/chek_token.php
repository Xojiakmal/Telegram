<?php
function chek_token($token) {
    $token_count = strlen((string)$token);
    if ($token == $_SESSION['form_token']) {
        if ($token_count == 5) {
            $data['whom_type'] = 'user';
            $data['my_id'] = $_SESSION['my_id'];
            $data['whom_id'] = $_SESSION['whom_id'];
            $data['data'] = $_SESSION['user_data'];
            $_SESSION['user_data'] = null;
            $_SESSION['form_token'] = null;
        }
        elseif ($token_count == 6) {
            $data['whom_type'] = 'group';
            $data['my_id'] = $_SESSION['my_id'];
            $data['whom_id'] = $_SESSION['whom_id'];
            $data['data'] = $_SESSION['group_data'];
            $_SESSION['group_data'] = null;
            $_SESSION['form_token'] = null;
        }
        elseif ($token_count == 7) {
            $data['whom_type'] = 'channel';
            $data['my_id'] = $_SESSION['my_id'];
            $data['whom_id'] = $_SESSION['whom_id'];
            $data['data'] = $_SESSION['channel_data'];
            $_SESSION['channel_data'] = null;
            $_SESSION['form_token'] = null;
        }
        else {
            header("Location: index.php");
            exit;
        }
    }
    else {
        header("Location: index.php");
        exit;
    }
    
    return $data;
    
}