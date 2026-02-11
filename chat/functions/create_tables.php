<?php
function create_tables($conn, $table_name, $cols){
    $query = "CREATE TABLE IF NOT EXISTS `$table_name`(`id` INT PRIMARY KEY AUTO_INCREMENT";
    foreach ($cols as $k => $v) {
        if ($v['type'] == 'int') {
            $query.=", `$k` INT";
            if (isset($v['null'])) {
                $query.=" NOT NULL";
            }
        }
        elseif ($v['type'] == 'str') {
            $query.=", `$k` TEXT";
            if (isset($v['null'])) {
                $query.=" NOT NULL";
            }
        }
        elseif ($v['type'] == 'date_time') {
            $query.=", `$k` DATETIME";
            if (isset($v['null'])) {
                $query.=" NOT NULL";
            }
        }
        elseif ($v['type'] == 'date_stamp') {
            $query.=", `$k` TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
            if (isset($v['null'])) {
                $query.=" NOT NULL";
            }
        }
        elseif ($v['type'] == 'json') {
            $query.=", `$k` JSON";
            if (isset($v['null'])) {
                $query.=" NOT NULL";
            }
        }
        elseif ($v['type'] == 'varchar') {
            if (isset($v['varchar'])) {
                $query.=", `$k` VARCHAR(".$v['varchar'].')';
            }else {
                $query.=", `$k` VARCHAR(255)";
            }
            if (isset($v['null'])) {
                $query.=" NOT NULL";
            }
        }
        elseif ($v['type'] == 'file') {
            $query.=", `$k` TEXT";
            if (isset($v['null'])) {
                $query.=" NOT NULL";
            }
        }
    }
    $query.=")";
    $conn->query($query); 
}