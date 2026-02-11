<?php
include "texnic/conn.php";
include "ads_function.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // $need = ['country'=>"Uzbekiston", 'district'=>'Nukus', 'peoples'=>5, 'gender'=>'Erkak', 'age'=>'17-20'];
    // ( [country] => Uzbekiston [district] => Nukus [age] => 16-20 [gender] => Erkak [people] => 5 [ads] => llll ) 
    
    $post_keys = array_keys($_POST);
    foreach ($post_keys as $k) {
        if (!empty($_POST[$k])) {
            $need[$k] = $_POST[$k];
        }
    }
    $ads = $_POST['ads'];
    reklama_tarqatish($pdo, $need, $ads);
    // header("Location:".$_SERVER['PHP_SELF']);
    // exit;
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
    <form action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
        Davlat: <select name="country">
            <option value="">...</option>
            <option value="Uzbekiston">O'zbekiston</option>
            <option value="USA">AQSH</option>
            <option value="Istabbul">Istanbul</option>
        </select> Majbury<br>
        Tuman: <select name="district">
            <option value="">...</option>
            <option value="Nukus">Nukus</option>
            <option value="Fargona">Fargona</option>
            <option value="Buxoro">Buxoro</option>
        </select> Ixtiyoriy<br>
        Yosh oralig'i: <select name="age">
            <option value="">...</option>
            <option value="0-10">10 yoshdan kichik</option>
            <option value="10-15">10 va 15 orasida</option>
            <option value="16-20">16 va 20 orasida</option>
            <option value="21-50">21 va 50 orasida</option>
            <option value="51-200">50 yoshdan katta</option>
        </select> Majbury<br>
        Jins: <select name="gender">
            <option value="">...</option>
            <option value="Erkak">Erkak</option>
            <option value="Ayol">Ayol</option>
        </select> Majbury<br>
        <label for="peoples">Nechta odamga tarqatish: <input type="number" name="peoples" id="peoples"></label><br>
        <label for="ads">Reklamangiz: <input type="text" name="ads" id="ads"></label><br>
        <label for="file"><input type="file" name="rek_file" id="file"></label><br>
        <input type="submit" value="Yuborish">
    </form>
</body>
</html>