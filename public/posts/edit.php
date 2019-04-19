<?php
require '../../core/functions.php';
require '../../config/keys.php';
require '../../core/db_connect.php';
//require '../../core/processContactLocal.php';
require '../../core/About/src/Validation/Validate.php';

//Validate Declarations
$valid = new About\Validation\Validate();

$message=null;

$args = [
    'id'=>FILTER_SANITIZE_STRING, //strips HMTL
    'title'=>FILTER_SANITIZE_STRING, //strips HMTL
    'meta_description'=>FILTER_SANITIZE_STRING, //strips HMTL
    'meta_keywords'=>FILTER_SANITIZE_STRING, //strips HMTL
    'body'=>FILTER_UNSAFE_RAW  //NULL FILTER
];

$input = filter_input_array(INPUT_POST, $args);

if(!empty($input)){
    $valid->validation = [
        'title'=>[[
            'rule'=>'notEmpty',
            'message'=>'Please enter title'
        ]]
    ];

    $valid->check($input);
    if (empty($valid->errors)){
    //Strip white space, begining and end
        $input = array_map('trim', $input);

        //Allow only whitelisted HTML
        $input['body'] = cleanHTML($input['body']);

        //Create the slug
        $slug = slug($input['title']);

        //Sanitiezed insert
        //$sql = 'INSERT INTO posts SET id=uuid(), title=?, slug=?, body=?';
        $sql = 'UPDATE posts SET title=:title, slug=:slug, body=:body, meta_description=:meta_description, meta_keywords=:meta_keywords WHERE id=:id';

        if($pdo->prepare($sql)->execute([
            'id'=>$input['id'],
            'title'=>$input['title'],
            'slug'=>$slug,
            'body'=>$input['body'],
            'meta_description'=>$input['meta_description'],
            'meta_keywords'=>$input['meta_keywords']
        ])){
        header('LOCATION:/posts');
        }else{
            $message = 'Something bad happened';
        }

    } else {
    $message = "<div class=\"alert alert-danger\">Please update the Fields below. Thank you.</div>";
    }
}

/* Preload the page */
$args = [
    'id'=>FILTER_SANITIZE_STRING
];
$getParams = filter_input_array(INPUT_GET, $args);
$sql = 'SELECT * FROM posts WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->execute([
    'id'=>$getParams['id']
]);
$row = $stmt->fetch();
$fields=[];
$fields['id']=$row['id'];
$fields['title']=$row['title'];
$fields['body']=$row['body'];
$fields['meta_description']=$row['meta_description'];
$fields['meta_keywords']=$row['meta_keywords'];
if(!empty($input)){
    $fields['id']=$valid->userInput('id');
    $fields['title']=$valid->userInput('title');
    $fields['body']=$valid->userInput('body');
    $fields['meta_description']=$valid->userInput('meta_description');
    $fields['meta_keywords']=$valid->userInput('meta_keywords');
}
//

$meta=[];
$meta['title']='Edit: ' . $fields['title'];


$content = <<<EOT
<h1>Add a New Post</h1>
{$message}
<form method="post">

<input name="id" type="hidden" value="{$fields['id']}">

<div class="form-group">
    <label for="title">Title</label>
    <input id="title" name="title" type="text" class="form-control" value="{$fields['title']}">
    <div class="text-danger">{$valid->error('title')}</div>
</div>

<div class="form-group">
    <label for="body">Body</label>
    <textarea id="body" name="body" rows="8" class="form-control">{$fields['body']}</textarea>
</div>

<div class="row">
    <div class="form-group col-md-6">
        <label for="meta_description">Description</label>
        <textarea id="meta_description" name="meta_description" rows="2" class="form-control">{$fields['meta_description']}</textarea>
    </div>

    <div class="form-group col-md-6">
        <label for="meta_keywords">Keywords</label>
        <textarea id="meta_keywords" name="meta_keywords" rows="2" class="form-control">{$fields['meta_keywords']}</textarea>
    </div>
</div>

<div class="form-group">
    <input type="submit" value="Submit" class="btn btn-primary">
</div>
</form>

<hr>
<div>
    <a 
        class="btn btn-danger"
        onclick="return confirm('Are you sure?')"
        href="/posts/delete.php?id={$fields['id']}">
        <i class="fa fa-trash" aria-hidden="true"></i>
        Delete
    </a>
</div>
EOT;

include '../../core/layout.php';
