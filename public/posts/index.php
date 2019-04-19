<?php

require '../../core/db_connect.php';
$stmt = $pdo->query("SELECT * FROM posts");
$meta=[];
$meta['title']="My Blog";

$items=null;

//$content="<h1>My Blog</h1>";
while ($row = $stmt->fetch())
{
   // var_dump($row);
   // $content .= "<a href=\"view.php?slug={$row['slug']}\">{$row['title']}</a><br>";
    $items.="<a href=\"view.php?slug={$row['slug']}\" class=\"list-group-item\">".
    "{$row['title']} - {$row['meta_keywords']} <br> Description: <br> Message: {$row['body']} </a>";
};
//echo $content;

$content=<<<EOT
<h1>My Blog</h1>
<div class=\"list-group\">{$items}</div>{$row['body']}
<hr>
<div>
    <a class="btn btn-primary" href="/posts/add.php">
        <i class="fa fa-plus" aria-hidden="true"></i>
        Add
    </a>
</div>
EOT;



require '../../core/layout.php';
