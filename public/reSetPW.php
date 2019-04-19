
<?php
require '../core/bootstrap.php';
require '../core/db_connect.php';
require '../core/About/src/Validation/Validate.php';

use  About\Validation;

//Validate Declarations
$valid = new About\Validation\Validate();
$message=null;

    $input = filter_input_array(INPUT_POST,[ 
        'email'=>FILTER_SANITIZE_EMAIL,
        'password'=>FILTER_UNSAFE_RAW,
        'confirm_password'=>FILTER_UNSAFE_RAW
    ]);

if (!empty($input)){
    $valid->validation = [
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
        $sql='select id, email from users where email=:email';

        $PWhash = password_hash($input['password'], PASSWORD_DEFAULT);
        
        $stmt=$pdo->prepare($sql);
        $stmt->execute([
            'email'=>$input['email']
        ]);
    
        $row=$stmt->fetch();
        if ( $row){
            $match = password_verify($input['email'], $row['email']);

            $sql='insert into users 
            set 
                hash=:PWhash
            where
                email=:email
        ';

        $stmt=$pdo->prepare($sql);

        try{
            $stmt->execute([
                'PWhash'=>$PWhash
            ]);
                header('LOCATION: /login.php');
        
        } catch(PDOException $e) {
            $message="<div class=\"alert alert-danger\">{$e->errorInfo[2]}</div>";
        }
        }   
    } else {
        $message = "<div class=\"alert alert-danger\">Please update the Fields below. Thank you.</div>";
    }
    $message = "<div class=\"alert \">Please update the Fields below. Thank you.</div>";
}

//$goto=!empty($_GET['goto'])?$_GET['goto']:'/';


$meta=[];
$meta['title']="Password Reset";


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
