<?php
$nc = true == false ?? 'no';
var_dump($nc); // false

$nc = null ?? 'yes';
var_dump($nc); // yes

$username = null == false ?? 'no';
var_dump($username); // true

$nc = $_GET['something'] ?? 'default';
var_dump($nc); // default

$nc = !isset($_GET['something']) ?? 'wtf';
var_dump($nc); // true

$nc = isset($_GET['something']) ?? 'wtf';
var_dump($nc); // false

$_POST['second'] = 'chain';
$nc = $_GET['first'] ?? $_POST['second'] ?? $_REQUEST['third'] ?? 'wtf';
var_dump($nc); // chain

echo '<hr>';

// Here is something useful for OR ( or any other ) bitwise comparison: 
    $a = 0;
    $b = 1;   
    printf('$a = %1$04b | $b = %2$04b ...  PROCESSED is: %3$s ( %3$04b )', $a, $b, ($a | $b));

?>
