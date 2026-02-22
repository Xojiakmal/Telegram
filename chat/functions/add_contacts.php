<?php
function add_contacts($pdo, $my_id, $whom_id, $type=null) {
    if ($type == 'user') {
        $resurse['colum'] = 'users_id';
        // $resurse['type'] = 'u';
    }
    elseif ($type == 'group') {
        $resurse['colum'] = 'groups_id';
        // $resurse['type'] = 'g';
    }
    elseif ($type == 'channel') {
        $resurse['colum'] = 'channels_id';
        // $resurse['type'] = 'c';
    }
    else {
        $resurse['colum'] = 'users_id';
        // $resurse['type'] = 'u';
    }

    $writed_select_query = "SELECT `".$resurse['colum']."` FROM `users_affinities` WHERE `user_id`=?";
    if ($type == 'user') {
        
        $writed_to_chek = $pdo->prepare($writed_select_query);
        $writed_to_chek->execute([$whom_id]);
        $writed_to_data = $writed_to_chek->fetch();
        
        $writed_from_chek = $pdo->prepare($writed_select_query);
        $writed_from_chek->execute([$my_id]);
        $writed_from_data = $writed_from_chek->fetch();

        if (!empty($writed_to_data[$resurse['colum']])) {
            $writed_to_data[$resurse['colum']] = json_decode($writed_to_data[$resurse['colum']], true);
            
            if (!in_array($my_id, $writed_to_data[$resurse['colum']])) {
                $writed_to_data[$resurse['colum']][] = $my_id;
                $writed_to_data[$resurse['colum']] = json_encode($writed_to_data[$resurse['colum']]);
            }
        }
        else {
            $writed_to_data[$resurse['colum']][] = $my_id;
            $writed_to_data[$resurse['colum']] = json_encode($writed_to_data[$resurse['colum']]);
        }

        if (!empty($writed_from_data[$resurse['colum']])) {
            $writed_from_data[$resurse['colum']] = json_decode($writed_from_data[$resurse['colum']], true);
            
            if (!in_array($whom_id, $writed_from_data[$resurse['colum']])) {
                $writed_from_data[$resurse['colum']][] = $whom_id;
                $writed_from_data[$resurse['colum']] = json_encode($writed_from_data[$resurse['colum']]);
            }
        }
        else {
            $writed_from_data[$resurse['colum']][] = $whom_id;
            $writed_from_data[$resurse['colum']] = json_encode($writed_from_data[$resurse['colum']]);
        }
        $change_query = "UPDATE `users_affinities` SET `".$resurse['colum']."`=:f WHERE `user_id`=:s";

        $change_from_data = $pdo->prepare($change_query);
        $change_from_data->execute([':f'=>$writed_to_data[$resurse['colum']], ':s'=>$whom_id]);
        
        $change_to_data = $pdo->prepare($change_query);
        $change_to_data->execute([':f'=>$writed_from_data[$resurse['colum']], ':s'=>$my_id]);
    }
    else {
        $writed_from_chek = $pdo->prepare($writed_select_query);
        $writed_from_chek->execute([$my_id]);
        $writed_from_data = $writed_from_chek->fetch();

        if (!empty($writed_from_data[$resurse['colum']])) {
            $writed_from_data[$resurse['colum']] = json_decode($writed_from_data[$resurse['colum']], true);
            
            if (!in_array($whom_id, $writed_from_data[$resurse['colum']])) {
                $writed_from_data[$resurse['colum']][] = $whom_id;
                $writed_from_data[$resurse['colum']] = json_encode($writed_from_data[$resurse['colum']]);
            }
        }
        else {
            $writed_from_data[$resurse['colum']][] = $whom_id;
            $writed_from_data[$resurse['colum']] = json_encode($writed_from_data[$resurse['colum']]);
        }

        $change_query = "UPDATE `users_affinities` SET `".$resurse['colum']."`=:f WHERE `user_id`=:s";

        print_r($writed_from_data[$resurse['colum']]);
        $change_from_data = $pdo->prepare($change_query);
        $change_from_data->execute([':f'=>$writed_from_data[$resurse['colum']], ':s'=>$my_id]);
    }
}