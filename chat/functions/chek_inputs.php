<?php
session_start();
class Chek_inputs {
    public $data;

    public function __construct($data) {
        $this->data = $data;
    }
    public function chek_name($index_name, $err_code=-1) {
        $name = $this->data[$index_name];
        $pattern = "/^[A-Za-z]+$/";
        if (preg_match($pattern, $name)) {
            return $name;
        }
        else {
            if ($err_code == -1) {
                header("Location:".$_SERVER['PHP_SELF']."?err=def");
                exit;
            }
            else {
                header("Location:".$_SERVER['PHP_SELF']."?err=".$err_code);
                exit;
            }
        }
    }
    public function chek_tel($index_name, $err_code=-1) {
        $tel = $this->data[$index_name];
        if (is_string($tel)) {
            $len = strlen($tel);
        }
        else {
            $len = 0;
        }
        $some_op = explode('+', $tel);
        if ($len == 9 && is_numeric($tel)) {
            return "+998".$tel;
        }
        elseif ($len == 13 && $some_op[0] == null && is_numeric($some_op[1])) {
            return $tel;
        }
        else {
            if ($err_code == -1) {
                header("Location:".$_SERVER['PHP_SELF']."?err=def");
                exit;
            }
            else {
                header("Location:".$_SERVER['PHP_SELF']."?err=".$err_code);
                exit;
            }
        }
    }
    public function chek_chosen($index_name, $options, $err_code=-1) {
        $chosen = $this->data[$index_name];
        if (in_array($chosen, $options)) {
            return $chosen;
        }
        else {
            if ($err_code == -1) {
                header("Location:".$_SERVER['PHP_SELF']."?err=def");
                exit;
            }
            else {
                header("Location:".$_SERVER['PHP_SELF']."?err=".$err_code);
                exit;
            }
        }
    }
    public function chek_num_limit($index_name, $max, $min, $err_code=-1) {
        $num = $this->data[$index_name];
        $are_numeric = is_numeric($max) && is_numeric($min) && is_numeric($num);

        if ($are_numeric && ($num > $min && $num < $max)) {
            return $num;
        }
        else {
            if ($err_code == -1) {
                header("Location:".$_SERVER['PHP_SELF']."?err=def");
                exit;
            }
            else {
                header("Location:".$_SERVER['PHP_SELF']."?err=".$err_code);
                exit;
            }
        }
    }
}

// $chek_inputs = new Chek_inputs($arr); 

// $da = explode('+', 'a+00910');
// var_dump('3' > 4);