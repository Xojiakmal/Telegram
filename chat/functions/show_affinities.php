<?php
function show_affinities($pdo, $my_id, $type=null) {
    if ($type == 'users') {
        $resurse = ['query'=>"SELECT `users_id` FROM `users_affinities` WHERE `user_id`=?", 'select_cols'=>"`id`, `name`, `tel`", 'table'=>'users'];
    }
    elseif ($type == 'groups') {
        $resurse = ['query'=>"SELECT `groups_id` FROM `users_affinities` WHERE `user_id`=?", 'select_cols'=>"`id`, `group_name`, link", 'table'=>'groups', 'type'=>'public'];
    }
    elseif ($type == 'channels') {
        $resurse = ['query'=>"SELECT `channels_id` FROM `users_affinities` WHERE `user_id`=?", 'select_cols'=>"`id`, `channel_name`, link", 'table'=>'channels', 'type'=>'public'];
    }
    else {
        $resurse = ['query'=>"SELECT `users_id` FROM `users_affinities` WHERE `user_id`=?", 'select_cols'=>"`id`, `name`, `tel`", 'table'=>'users'];
    }

    $user_affs = $pdo->prepare($resurse['query']);
    writetolog($user_affs, 'set');
    $user_affs->execute([$my_id]);
    
    $user_affs_id = $user_affs->fetch();
    writetolog($user_affs_id, 'get');
    // print_r($user_affs);
    if ($user_affs_id[0] !== null) {
        $user_affs_id = json_decode($user_affs_id[0], true);
        
        $query = "SELECT ".$resurse['select_cols']." FROM `".$resurse['table']."` WHERE ";
        $son = true;
        foreach ($user_affs_id as $v) {
            if ($son) {
                $query.="`id`=? ";
                $son = false;
            }
            else {
                $query.="OR `id`=?";
            }
        }
        $user_affs = $pdo->prepare($query);
        writetolog($user_affs, 'set');

        $user_affs->execute($user_affs_id);
        $result = $user_affs->fetchAll(PDO::FETCH_ASSOC);
        writetolog($result, 'get');

        if ($result !== null) {
            return $result;
        }
    }
    else {
        return null;
    }
}