<?php
require '../../core/bootstrap.php';
include '../../core/db_connect.php';

$meta=[];
$meta['title']="UserView";


$args = [
    'user'=>FILTER_SANITIZE_STRING
];
$input = filter_input_array(INPUT_GET, $args);
$user = preg_replace("/[^a-z0-9-]+/", "", $input['user']);

$content=null;
$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$user]);

$row = $stmt->fetch();


$meta=[];
$meta['title']="UsersView";
$meta['description']=$row['first_name'];
$meta['keywords']=$row['id'];


$content=<<<EOT
<h1>{$row['id']}</h1>
{$row['first_name']} , {$row['last_name']} , {$row['email']} , {$row['id']}
<hr>
<div>
    <a class="btn btn-primary" href="/users/edit.php?user={$row['id']}">
        <i class="fa fa-pencil" aria-hidden="true"></i>
        Edit
    </a>
</div>
EOT;

require '../../core/layout.php';

