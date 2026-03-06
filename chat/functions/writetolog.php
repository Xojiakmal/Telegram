<?php
function writetolog($log_data, $type) {
    // print_r($log);
    if ($type == 'set') {
        $log = date("Y-m-d H:i:s")." - ".$log_data->queryString." | {SET} |"."\n";
        file_put_contents('logs.log', $log, FILE_APPEND | LOCK_EX);
    }
    elseif ($type == 'get') {
        $log = date("Y-m-d H:i:s")." - ".json_encode($log_data)." | {GET} |"."\n";
        file_put_contents('logs.log', $log, FILE_APPEND | LOCK_EX);
    }
}
// writetolog('salom');