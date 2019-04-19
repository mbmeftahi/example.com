<?php
require '../../core/bootstrap.php';
require '../../core/db_connect.php';

checkSession();

$stmt = $pdo->query("SELECT * FROM users");
$meta=[];
$meta['title']="My Blog";

$items=null;

//$content="<h1>My Blog</h1>";
while ($row = $stmt->fetch())
{
   // var_dump($row);
   // $content .= "<a href=\"view.php?slug={$row['slug']}\">{$row['title']}</a><br>";
    $items.="<a href=\"view.php?user={$row['id']}\" class=\"list-group-item\">".
    "{$row['first_name']} &ensp;{$row['last_name']} &emsp; {$row['email']} </a>";
};
//echo $content;

$content=<<<EOT
<h1>My Users</h1>
<div class=\"list-group\">{$items}</div>
<hr>
<div>
    <a class="btn btn-primary" href="/users/add.php">
        <i class="fa fa-plus" aria-hidden="true"></i>
        Add
    </a>
</div>
EOT;



require '../../core/layout.php';
