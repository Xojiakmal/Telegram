<?php
function create_tables($conn, $table_name, $cols){
    $query = "CREATE TABLE IF NOT EXISTS `$table_name`(`id` INT PRIMARY KEY AUTO_INCREMENT";
    foreach ($cols as $k => $v) {
        if ($v['type'] == 'int') {
            $query.=", `$k` INT";
            if ($v['null'] != true) {
                $query.=" NOT NULL";
            }
        }
        elseif ($v['type'] == 'str') {
            $query.=", `$k` TEXT";
            if ($v['null'] != true) {
                $query.=" NOT NULL";
            }
        }
        elseif ($v['type'] == 'date_time') {
            $query.=", `$k` DATETIME";
            if ($v['null'] != true) {
                $query.=" NOT NULL";
            }
        }
        elseif ($v['type'] == 'date_stamp') {
            $query.=", `$k` TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
            if ($v['null'] != true) {
                $query.=" NOT NULL";
            }
        }
        elseif ($v['type'] == 'json') {
            $query.=", `$k` JSON";
            if ($v['null'] != true) {
                $query.=" NOT NULL";
            }
        }
        elseif ($v['type'] == 'varchar') {
            if (isset($v['varchar'])) {
                $query.=", `$k` VARCHAR(".$v['varchar'].')';
            }else {
                $query.=", `$k` VARCHAR(255)";
            }
            if ($v['null'] != true) {
                $query.=" NOT NULL";
            }
        }
        elseif ($v['type'] == 'file') {
            $query.=", `$k` TEXT";
            if ($v['null'] != true) {
                $query.=" NOT NULL";
            }
        }
    }
    $query.=")";
    $conn->query($query); 
}
$tables_type_data = [
    'informations'=>['message'=>['type'=>'text'], 'users_id'=>['type'='json'], 'file'=>['type'=>'file', 'null'=>true]],
    'notes'=>['text'=>['type'=>'text', 'null'=>true], 'file'=>['type'=>'file', 'null'=>true], 'user_id'=>['type'=>'int'], 'to_whom'=>['type'=>'int'], 'reply'=>['type'=>'json', 'null'=>true], 'create_at'=>['type'=>'date_stamp'], 'update_at'=>['type'=>'date_time']],
    'send_data'=>['message_id'=>['type'=>'int'], 'send_time'=>['type'=>'date_time'], 'sended'=>['type'=>'int']],
    'users'=>['name'=>['type'=>'varchar', 'varchar'=>70], 'yosh'=>['type'=>'int'], 'tel'=>['type'=>'varchar', 'varchar'=>14], 'millat'=>['type'=>'text'], 'jins'=>['type'=>'varchar', 'varchar'=>6], 'other'=>['type'=>'json']],
    'users_affinities'=>['user_id'=>['type'=>'int'], 'groups_id'=>['type'=>'json', 'null'=>true], 'users_id'=>['type'=>'json', 'null'=>true], 'channels_id'=>['type'=>'json', 'null'=>true]],
    'groups'=>['group_name'=>['type'=>'varchar', 'varchar'=10], 'author_id'=>['type'=>'int'], 'admins'=>['type'=>'json'], 'type'=>['type'=>'varchar', 'varchar'=>255], 'izoh'=>['type'=>'text'], 'link'=>['type'=>'text']]
];