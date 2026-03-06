<?php
include 'texnic/conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data['name'] = $_POST['name'];
    $data['tel'] = $_POST['tel'];
    $data['yosh'] = $_POST['yosh'];
    $data['millat'] = $_POST['millat'];
    $data['jins'] = $_POST['jins'];
    $other = ['davlat'=>$_POST['davlat'], 'viloyat'=>$_POST['viloyat'], 'tuman'=>$_POST['tuman'], 'mfy'=>$_POST['mfy'], 'kocha'=>$_POST['kocha']];
    $data['other'] = json_encode($other);
    $len = strlen((string)$data['tel']);
    if ($len == 9) {
        $data['tel'] = "+998".$data['tel'];
    }
    elseif ($len == 13) {}
    else {
        die('error');
    }

    print_r($data);
    if (!in_array(null, $data)) {
        $query = "INSERT INTO `users`(`name`, `yosh`, `tel`, `millat`, `jins`, `other`) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$data['name'], $data['yosh'], $data['tel'], $data['millat'], $data['jins'], $data['other']]);
        
        $get_id = $pdo->prepare('SELECT `id` FROM `users` WHERE `tel`=?');
        $get_id->execute([$data['tel']]);
        $id = $get_id->fetch();
        if ($id[0] != null) {
            $add_aff = $pdo->prepare('INSERT INTO `users_affinities`(`user_id`) VALUES (?)');
            $add_aff->execute([$id[0]]);
            $_SESSION['my_id'] = $id[0];
            header("Location: index.php");
            exit;
        }
    }
    else {
        echo "Name is none";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
        <label for="name">User name: <input type="text" id='name' name='name'></label><br>
        <label for="tel">Phone: <input type="tel" name="tel" id="tel"></label><br>
        <label for="yosh">Age: <input type="number" name="yosh" id="yosh"></label><br>
        <label for="male"><input type="radio" id="male" name="jins" value='Erkak'>Erkak</label>
        <label for="female"><input type="radio" id="female" name="jins" value='Ayol'>Ayol</label><br>
        <label for="millat">Millat: </label>
        <select name="millat" id="millat">
            <option value="Uzbek">Uzbek</option>
            <option value="Tojik">Tojik</option>
            <option value="Qozozq">Qozoq</option>
            <option value="Qirgiz">Qirgiz</option>
        </select><br>
        <label for="davlat">Davlat: </label>
        <select name="davlat" id="davlat">
            <option value="Uzbekiston">Uzbekiston</option>
            <option value="Qozogiston">Qozogiston</option>
        </select><br>
        <label for="viloyat">Viloyat: </label>
        <select name="viloyat" id="viloyat">
            <option value="Fargona">Fargona</option>
            <option value="Toshkent">Toshkent</option>
            <option value="Buxoro">Buxoro</option>
            <option value="Namangan">Namangan</option>
        </select><br>
        <label for="tuman">Tuman: </label>
        <select name="tuman" id="tuman">
            <option value="Samarqand">Samarqand</option>
            <option value="Termiz">Termiz</option>
            <option value="Buxoro">Buxoro</option>
            <option value="Yunsobot">Yunsobot</option>
        </select><br>
        <label for="mfy">MFY: </label>
        <select name="mfy" id="mfy">
            <option value="Bahor">Bahor</option>
            <option value="Bogdod">Bogdod</option>
            <option value="Tinchlik">Tinchlik</option>
            <option value="Yoshlik">Yoshlik</option>
        </select><br>        
        <label for="kocha">Kocha: </label>
        <select name="kocha" id="kocha">
            <option value="Navbahor">Navbahor</option>
            <option value="Yangihayot">Yangihayot</option>
            <option value="Mustaqillik">Mustaqillik</option>
            <option value="Gulzor">Gulzor</option>
        </select><br>
        <input type="submit" value="Login">
    </form>
    <a href="login.php">Back</a>
</body>
</html>