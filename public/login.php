<?php
require '../bootstrap.php';
require '../core/db_connect.php';

$message=null;

$input = filter_input_array(INPUT_POST,[
        'password'=>FILTER_UNSAFE_RAW,
        'email'=>FILTER_SANITIZE_EMAIL
]);

if (!empty($input)){

    $input = array_map('trim', $input);
    $sql='select id, hash from users where email=:email';

    $stmt=$pdo->prepare($sql);
    $stmt->execute([
        'email'=>$input['email']
    ]);

    $row=$stmt->fetch();
    
    if ( $row){
        $match = password_verify($input['password'], $row['hash']);
        
        if ($match){
            $_SESSION['user']= [];
            $_SESSION['user']['id']=$row['id'];
            header('LOCATION: ' . $_POST['goto']);
            
        } else {
            // Do Nothing  Since it is login page. 
            // var_dump ("Bad User Name or Password.!");
        }
    } else {
        // $message="<div class=\"alert alert-danger\">{$e->errorInfo[2]}</div>";
        
        $message = "<div class=\"alert alert-danger\">\"Bad User Name or Password.!?\"</div>";
        header("LOCATION:  {$_SERVER['PHP_SELF']}");

    }
}


$goto=!empty($_GET['goto'])?$_GET['goto']:'/';

$meta=[];
$meta['title']="login";

$content=<<<EOT
<h1>{$meta['title']}</h1>
$message
<form method="post" autocomplete="off">
    <div>
    <label for="email">Email</label>
        <input class="form-control"
        id="email"
        name="email"
        type="email"
        >
    </div>
    <div>
    <label for="password">Password</label>
        <input class="form-control"
        id="password"
        name="password"
        type="password"
        >
    </div>
    <input name="goto" value="{$goto}">
    <input type="submit" class="btn btn-primary">
    <span> <a id="pwReset" href="reSetPW.php" > Reset Your Password</a></span>
</form>
EOT;

require '../core/layout.php';
