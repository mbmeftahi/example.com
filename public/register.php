
<?php
require '../core/bootstrap.php';
require '../core/db_connect.php';
require '../core/About/src/Validation/Validate.php';

use  About\Validation;

//Validate Declarations
$valid = new About\Validation\Validate();
$message=null;

    $args=[
        'password'=>FILTER_UNSAFE_RAW,
        'confirm_password'=>FILTER_UNSAFE_RAW,
        'email'=>FILTER_SANITIZE_EMAIL,
        'first_name'=>FILTER_SANITIZE_STRING,
        'last_name'=>FILTER_SANITIZE_STRING
    ];

    $input = filter_input_array(INPUT_POST, $args);

if (!empty($input)){
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
            'message'=>'Please enter a email'
        ]],
        'password'=>[[
            'rule'=>'notEmpty',
            'message'=>'Please enter a password'
        ],[
            'rule'=>'strength',
            'message'=>'Must contain \WA-Za-z0-9'
        ]],
        'confirm_password'=>[[
            'rule'=>'notEmpty',
            'message'=>'Please enter a password'
        ],[
            'rule'=>'matchPassword',
            'message'=>'Passwords DO NOT match'
        ]]
    ];

    $valid->check($input);
    if (empty($valid->errors)){
    //Strip white space, begining and end
        $input = array_map('trim', $input);
        $PWhash = password_hash($input['password'], PASSWORD_DEFAULT);

            $sql='insert into users 
                set 
                    id=UUID(),
                    email=:email,
                    first_name=:first_name,
                    last_name=:last_name,
                    hash=:PWhash
            ';

            $stmt=$pdo->prepare($sql);
        try{
            $stmt->execute([
                'email'=>$input['email'],
                'first_name'=>$input['first_name'],
                'last_name'=>$input['last_name'],
                'PWhash'=>$PWhash
            ]);
                header('LOCATION: /login.php');
        
        } catch(PDOException $e) {
            $message="<div class=\"alert alert-danger\">{$e->errorInfo[2]}</div>";
        }
    } else {
        $message = "<div class=\"alert alert-danger\">Please update the Fields below. Thank you.</div>";
    }
}

//$goto=!empty($_GET['goto'])?$_GET['goto']:'/';


$meta=[];
$meta['title']="Register";


$content=<<<EOT
<h1>{$meta['title']}</h1>
{$message}
<form method="post" autocomplete="off">
    <div>
    <label for="email">Email</label>
        <input class="form-control"
        id="email"
        name="email"
        type="email"
        value="{$valid->userInput('email')}";
        >
        <div class="text text-danger">{$valid->error('email')}</div>
    </div>
    <div>
    <label for="first_name">First Name</label>
        <input class="form-control"
        id="first_name"
        name="first_name"
        type="first_name"
        value="{$valid->userInput('first_name')}";
        >
        <div class="text text-danger">{$valid->error('first_name')}</div>
    </div>
    <div>
    <label for="last_name">Last Name</label>
        <input class="form-control"
        id="last_name"
        name="last_name"
        type="last_name"
        value="{$valid->userInput('last_name')}";
        >
        <div class="text text-danger">{$valid->error('last_name')}</div>
    </div>
    <div>
    <label for="password">Password</label>
        <input class="form-control"
        id="password"
        name="password"
        type="password"
        value="{$valid->userInput('password')}";
        >
        <div class="text text-danger">{$valid->error('password')}</div>
    </div>
    <div>
    <label for="confirm_password">Confirm Password</label>
    <input class="form-control"
    id="confirm_password"
    name="confirm_password"
    type="password"
    value="{$valid->userInput('confirm_password')}";
    >
    <div class="text text-danger">{$valid->error('confirm_password')}</div>
    </div>

    <br><div>
    <input type="submit" class="btn btn-primary">
    </div>
</form>
EOT;

require '../core/layout.php';
/*
    <label for="loginid">Email OR UserName</label>
        <input class="form-control"
        id="loginid"
        name="loginid"
        type="password"
        >
*/
