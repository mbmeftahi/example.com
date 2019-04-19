<?php
include '../../core/db_connect.php';
$args = [
    'id'=>FILTER_SANITIZE_STRING
];
$input = filter_input_array(INPUT_GET, $args);
$stmt = $pdo->prepare('DELETE FROM posts WHERE id = :id');
if($stmt->execute(['id'=>$input['id']])){
    header('LOCATION: /posts');
}
