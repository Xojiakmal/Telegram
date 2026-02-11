<?php
function col_type($pdo, $type) {
    $desc_table_stmt = $pdo->prepare("DESC `users`");
    $desc_table_stmt->execute();
    $desc = $desc_table_stmt->fetchAll(PDO::FETCH_ASSOC);
    // print_r($desc); 
    foreach ($desc as $k => $v) {
        if ($v['Type'] == $type) {
            $ret[] = $v['Field'];
        }
    }
    return $ret;
}

function filter_data($data, $need) {
    $needs_key = array_keys($need);

    // Country filter
    if (in_array('country', $needs_key)) {
        foreach ($data as $v) {
            foreach ($v as $sk => $sv) {
                if (is_array($sv)) {
                    foreach ($sv as $thk => $thv) {
                        if ($need['country'] == $thv) {
                            $row[] = $v;
                        }
                    }
                }
                else {
                    if ($need['country'] == $sv) {
                        $row[] = $v;
                    }
                }
            }
        }
        if (!empty($row)) {
            $data = $row;
            $row = [];
        }
    }
    // Gender filter
    if (in_array('gender', $needs_key)) {
        foreach ($data as $v) {
            foreach ($v as $sk => $sv) {
                if (is_array($sv)) {
                    foreach ($sv as $thk => $thv) {
                        if ($need['gender'] == $thv) {
                            $row[] = $v;
                        }
                    }
                }
                else {
                    if ($need['gender'] == $sv) {
                        $row[] = $v;
                    }
                }
            }
        }
        if (!empty($row)) {
            $data = $row;
            $row = [];
        }
    }
    // District filter
    if (in_array('district', $needs_key)) {
        foreach ($data as $v) {
            foreach ($v as $sk => $sv) {
                if (is_array($sv)) {
                    foreach ($sv as $thk => $thv) {
                        if ($need['district'] == $thv) {
                            $row[] = $v;
                        }
                    }
                }
                else {
                    if ($need['district'] == $sv) {
                        $row[] = $v;
                    }
                }
            }
        }
        if (!empty($row)) {
            $data = $row;
            $row = [];
        }
    }
    // Age filter
    if (in_array('age', $needs_key)) {
        $age = explode('-', $need['age']);
        foreach ($data as $v) {
            foreach ($v as $sk => $sv) {
                if ($sk == 'yosh') {
                    if ((int)$age[0] <= (int)$sv and (int)$age[1] >= (int)$sv) {
                        $row[] = $v;
                    }
                }
            }
        }
        if (!empty($row)) {
            $data = $row;
            $row = [];
        }
    }
    
    return $data;
}

function get_ids($data) {
    $s = 0;
    foreach ($data as $v) {
        $id[$s] = $v['id'];
        $s++;
    }
    return $id;
}

function json_to_arr($data, $col_type) {
    foreach ($data as $v) {
        foreach ($v as $sk => $sv) {
            if (in_array($sk, $col_type)) {
                $v[$sk] = json_decode($sv, true);
            }
        }
        $filtered_data[] = $v;
    }
    return $filtered_data;
}

function insert_ads($pdo, $ads, $data, $file_name) {
    $ids = json_encode(get_ids($data));

    $res = $pdo->prepare("INSERT INTO `informations`(`message`, `users_id`, `file`) VALUES (?, ?, ?)");
    if (empty($ids)) {
        return 'ids';
    }
    elseif (empty($ads)) {
        return 'Ads yoq';
    }
    elseif (!$res->execute([$ads, $ids, $file_name])) {
        return "Joylanmadi";
    }
    else {
        return "Joylandi";
    }
    
}

function chek_arr_data($data) {
    foreach ($data as $v) {
        if (!empty($v) and !is_array($v)) {
            $ans[] = true;
        }
        else {
            $ans[] = false;
        }
    }
    if (in_array(false, $ans)) {
        return false;
    }
    else {
        return true;
    }
}
function chek_file($file) {
    if (!empty($file)) {
        $name = basename($_FILES['rek_file']['name']);
        $target_dir = 'resources/'.$name;
        move_uploaded_file($_FILES['rek_file']['tmp_name'], $target_dir);
        return $_SERVER['PHP_SELF'].'../resouces/'.$name;
    }
}

function reklama_tarqatish($pdo, $need, $ads) {
    if (chek_arr_data($need)) {
        $data_stmt = $pdo->prepare("SELECT * FROM `users`");
        $data_stmt->execute();
        $data = $data_stmt->fetchAll(PDO::FETCH_ASSOC);

        $data = json_to_arr($data, col_type($pdo, 'json'));

        $data = filter_data($data, $need);

        $path = chek_file($_FILES);

        echo insert_ads($pdo, $ads, $data, $path);
        
    }
}
// reklama_tarqatish($pdo, $need);