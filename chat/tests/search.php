<?php
include "texnic/conn.php";

// $text = '234';
// $query = "SELECT `id`, `tel` FROM `users` WHERE `tel` LIKE '%".$text."%'";

// $stmt = $pdo->prepare($query);
// $stmt->execute();
// $result = $stmt->fetchALL(PDO::FETCH_ASSOC);


// // print_r(get_class_methods($stmt));
// // print_r($result);
// // print_r($stmt->rowCount());
// foreach ($result as $v) {
//     $long[$v['id']] = levenshtein($text, $v['tel']);
// }
// asort($long);
// print_r($long);
// foreach (array_keys($long) as $k) {
//     print_r($result[$k]);
//     echo "<br>";
// }

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     $word = strtolower($_POST['text']);
    
//     $stmt = $pdo->prepare("SELECT `name` FROM `users`");
//     $stmt->execute();
//     $result = $stmt->fetchALL(PDO::FETCH_ASSOC);
//     // print_r($result);
//     $old_sim = 1000;
//     foreach ($result as $v) {
//         $new_sim = levenshtein($v['name'], $word);
//         if ($new_sim < $old_sim) {
//             $old_sim = $new_sim;
//             $nk = $k;
//         }
//     }
//     $uzun = strlen($word);
//     if ($old_sim < $uzun) {
//         $final = $result[$nk]['name'];
//     }
//     else {
//         $final = $word;
//         $alert = true;
//         // echo "<script>alert('ksjdncskjdfkj')</script>";
//     }
//     // echo $final;
//     print_r($new_sim);
// }
?>