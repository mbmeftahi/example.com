<?php
require '../../bootstrap.php';
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
    'first_name'=>FILTER_SANITIZE_STRING, //strips HMTL
    'last_name'=>FILTER_SANITIZE_STRING, //strips HMTL
    'email'=>FILTER_SANITIZE_EMAIL, //strips HMTL
];

$input = filter_input_array(INPUT_POST, $args);

if(!empty($input)){
    $valid->validation = [
            'first_name'=>[[
                'rule'=>'notEmpty',
                'message'=>'Please enter your First Name'
            ]],
            'last_name'=>[[
                'rule'=>'notEmpty',
                'message'=>'Please enter your Last Name'
            ]],
            'email'=>[[
                'rule'=>'email',
                'message'=>'Please enter a valid email'
            ],[
                'rule'=>'notEmpty',
                'message'=>'Please enter an email'
        ]]
    ];

    $valid->check($input);
    if (empty($valid->errors)){
    //Strip white space, begining and end
        $input = array_map('trim', $input);

        //Allow only whitelisted HTML
        $input['first_name'] = cleanHTML($input['first_name']);
        $input['last_name'] = cleanHTML($input['last_name']);

        //Create the slug
        //$slug = slug($input['title']);

        //Sanitiezed insert
        //$sql = 'INSERT INTO posts SET id=uuid(), title=?, slug=?, body=?';
        $sql = 'UPDATE users SET first_name=:first_name, last_name=:last_name, email=:email WHERE id=:id';

        if($pdo->prepare($sql)->execute([
            'id'=>$input['id'],
            'first_name'=>$input['first_name'],
            'last_name'=>$input['last_name'],
            'email'=>$input['email']
        ])){
        header('LOCATION:/users');
        }else{
            $message = 'Something bad happened';
        }

    } else {
    $message = "<div class=\"alert alert-danger\">Please update the Fields below. Thank you.</div>";
    }
}

/* Preload the page */
$args = [
    'user'=>FILTER_SANITIZE_STRING
];
$getParams = filter_input_array(INPUT_GET, $args);
$sql = 'SELECT * FROM users WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->execute([
    'id'=>$getParams['user']
]);
$row = $stmt->fetch();
$fields=[];
$fields['id']=$row['id'];
$fields['first_name']=$row['first_name'];
$fields['last_name']=$row['last_name'];
$fields['email']=$row['email'];

if(!empty($input)){
    //$fields['id']=row('id');
    $fields['first_name']=$row['first_name'];
    $fields['last_name']=$row['last_name'];
    $fields['email']=$row['email'];
}
//

$meta=[];
$meta['title']='Edit: ' . $fields['last_name'];


$content = <<<EOT
<h1>Add a New Post</h1>
{$message}
<form method="post">

<input name="id" type="hidden" value="{$fields['id']}">

<div class="form-group">
    <label for="first_name">Fisrt Name</label>
    <input class="form-control" id="first_name" type="text" name="first_name" value="{$fields['first_name']}">
    <div class="text-danger">{$valid->error('first_name')}</div>
</div>

<div class="form-group">
    <label for="lastName">Last Name</label>
    <input class="form-control" id="lastName" type="text" name="last_name" value="{$fields['last_name']}">
    <div class="text-danger">{$valid->error('last_name')}</div>
</div>

<div class="form-group">
  <label for="email">Email</label>
  <input class="form-control" id="email" type="text" name="email" value="{$fields['email']}">
  <div class="text-danger">{$valid->error('email')}</div>
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
        href="/users/delete.php?id={$fields['id']}">
        <i class="fa fa-trash" aria-hidden="true"></i>
        Delete
    </a>
</div>
EOT;

include '../../core/layout.php';
