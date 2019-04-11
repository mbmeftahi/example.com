<?php
//Include non-vendor files
require '../core/About/src/Validation/Validate.php';

//Declare Namespaces
use About\Validation;

//Validate Declarations
$valid = new About\Validation\Validate();
$args = [
  'firstName'=>FILTER_SANITIZE_STRING,
  'lastName'=>FILTER_SANITIZE_STRING,
  'subject'=>FILTER_SANITIZE_STRING,
  'message'=>FILTER_SANITIZE_STRING,
  'email'=>FILTER_SANITIZE_EMAIL,
];
$input = filter_input_array(INPUT_POST, $args);


$message = null;
if(!empty($input)){

    $valid->validation = [
       'firstName'=>[[
            'rule'=>'notEmpty',
            'message'=>'Please enter your first name'
        ]],

        'lastName'=>[[
            'rule'=>'notEmpty',
            'message'=>'Please enter your last name'
        ]], 
/*        'name'=>[[
                'rule'=>'notEmpty',
                'message'=>'Please enter your first name'
        ]],
*/        'email'=>[[
                'rule'=>'email',
                'message'=>'Please enter a valid email'
            ],[
                'rule'=>'notEmpty',
                'message'=>'Please enter an email'
        ]],
        'subject'=>[[
            'rule'=>'notEmpty',
            'message'=>'Please enter a subject'
        ]],
        'message'=>[[
            'rule'=>'notEmpty',
            'message'=>'Please add a message'
        ]],
    ];


    $valid->check($input);
}

if(empty($valid->errors) && !empty($input)){
  require '../core/mailgun.php';
    $message = "<div>Success!</div>";
}else{
    $message = "<div>Please update the Fields below. Thank you.</div>";
}
// ternery operator
//{(!empty($message)?$message:null)}
