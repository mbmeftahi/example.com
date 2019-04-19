<?php
require '../../core/bootstrap.php';
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
        // $user = slug($input['email']);

        //Sanitiezed insert
        $sql = 'INSERT INTO users SET id=uuid(), first_name=?, last_name=?, email=?;

        if($pdo->prepare($sql)->execute([
            $input['first_name'],
            $input['last_name'],
            $input['email']
        ])){
        header('LOCATION:/users');
        }else{
            $message = 'Something bad happened';
        }

    } else {
    $message = "<div class=\"alert alert-danger\">Please update the Fields below. Thank you.</div>";
    }
}


$meta=[];
$meta['title']="Contact";

$content = <<<EOT
<h1>Add a New Post</h1>
{$message}
<form method="post">

<div class="form-group">
    <label for="first_name">Fisrt Name</label>
    <input class="form-control" id="firstName" type="text" name="first_name" value="{$valid->userInput('first_name')}">
    <div class="text-danger">{$valid->error('first_name')}</div>
</div>
<div class="form-group">
    <label for="last_name">Last Name</label>
    <input class="form-control" id="lastName" type="text" name="last_name" value="{$valid->userInput('last_name')}">
    <div class="text-danger">{$valid->error('last_name')}</div>
</div>

<div class="form-group">
  <label for="email">Email</label>
  <input class="form-control" id="email" type="text" name="email" value="{$valid->userInput('email')}">
  <div class="text-danger">{$valid->error('email')}</div>
</div>

<div class="form-group">
    <input type="submit" value="Submit" class="btn btn-primary">
</div>
</form>
EOT;

include '../../core/layout.php';
