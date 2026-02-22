<?php
function chek_session($key, $to=null) {
    if ($_SESSION[$key] === null and $to === null) {
        return 'bor';
    }
    elseif ($_SESSION[$key] === null) {
        header("Location:".$to);
        exit;
    }
    else {
        return $_SESSION[$key];
    }
}