<?php
function show_affinities($pdo, $my_id, $type=null) {
    if ($type == 'users') {
        $resurse = ['query'=>"SELECT `users_id` FROM `users_affinities` WHERE `id`=?", 'select_cols'=>"`id`, `name`, `tel`"];
    }
    elseif ($type == 'groups') {
        $resurse = ['query'=>"SELECT `groups_id` FROM `users_affinities` WHERE `id`=?", 'select_cols'=>"`id`, `group_name`"];
    }
    elseif ($type == 'channels') {
        $resurse = ['query'=>"SELECT `channels_id` FROM `users_affinities` WHERE `id`=?", 'select_cols'=>"`id`, `channel_name`"];
    }
    else {
        $resurse = ['query'=>"SELECT `users_id` FROM `users_affinities` WHERE `id`=?", 'select_cols'=>"`id`, `name`, `tel`"];
    }

    $user_affs = $pdo->prepare($resurse['query']);
    $user_affs->execute([$my_id]);
    
    $user_affs_id = $user_affs->fetch();
    if ($user_affs_id[0] !== null) {
        $user_affs_id = json_decode($user_affs_id[0], true);

        $query = "SELECT ".$resurse['select_cols']." FROM `users` WHERE ";
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
        $user_affs->execute($user_affs_id);
        $result = $user_affs->fetchAll(PDO::FETCH_ASSOC);
        if ($result !== null) {
            return $result;
        }
    }
    else {
        return null;
    }
}