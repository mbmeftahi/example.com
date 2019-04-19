<?php
//Include non-vendor files
require '/var/www/example.com/core/About/src/Validation/Validate.php';

//Declare Namespaces
use About\Validation;

//Validate Declarations
$valid = new About\Validation\Validate();

$args = [
  'title'=>FILTER_SANITIZE_STRING, //strips HMTL
  'meta_description'=>FILTER_SANITIZE_STRING, //strips HMTL
  'meta_keywords'=>FILTER_SANITIZE_STRING, //strips HMTL
  'body'=>FILTER_UNSAFE_RAW  //NULL FILTER
];
$input = filter_input_array(INPUT_POST, $args);


$message = null;
if(!empty($input)){

    $valid->validation = [
        'title'=>[[
            'rule'=>'notEmpty',
            'message'=>'Please enter title'
        ]],
        'meta_description'=>[[
            'rule'=>'notEmpty',
            'message'=>'Please provide description'
        ]], 
       'meta_keywords'=>[[
                'rule'=>'notEmpty',
                'message'=>'Please provide keywords'
        ]],
        'body'=>[[
                'rule'=>'email',
                'message'=>'Please enter details'
        ]]
    ];

    $valid->check($input);
}
/*
//if(empty($valid->errors) && !empty($input)){
if(empty($valid->errors) && !empty($input)){
  require '../core/mailgun.php';
    $message = "<div class=\"alert alert-success\">Success! Your form is submited.</div>";
}else if (!empty($valid->errors)){
    $message = "<div class=\"alert alert-danger\">Please update the Fields below. Thank you.</div>";
}
// ternery operator
//{(!empty($message)?$message:null)}
*/