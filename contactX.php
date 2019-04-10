<?php
//Create a RegEx pattern to determine the validity of the use submitted email
// - allow up to two strings with dot concatenation any letter, any case any number with _- before the @
// - require @
// - allow up to two strings with dot concatenation any letter, any case any number with - after the at
// - require at least 2 letters and only letters for the domain
$validEmail = "/^[_A-Z_a-z0-9-]+(\.[_A-Z_a-z0-9-]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9-]+)*(\.[a-z]{2,})$/";

//Extract $_POST to a data array
$data = $_POST;

//Create an empty array to hold any error we detect
$errors = [];

foreach($data as $key => $value){
  echo "{$key} = {$value}<br>";

  //Use a switch statement to change your behavior based upon the form field
  switch($key){
      case 'email':
        if(preg_match($validEmail, $value)!==1){
            $errors[$key] = "Invalid email";
        }

      break;

      default:
        if(empty($value)){
            $errors[$key] = "Invalid {$key}";
        }
      break;
  }

}

var_dump($errors);
echo "<br>";
var_dump($data);
?>


<!DOCTYPE html>
<html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>MBMeftahi</title>
      <link rel="shortcut icon"  href="https://www.gravatar.com/avatar/4678a33bf44c38e54a58745033b4d5c6?d=mm&s=64">
      <!-- <link rel="stylesheet" type="text/css" href="./dist/css/main.css"> -->
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  </head>
  <body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="#">LOGO</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
          
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                  <a class="nav-link" href="index.html">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="resume.html">Resume</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">ContactUS</a>
                </li>
              </ul>
              <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
              </form>
            </div>
          </nav>

      <main>
          
      <p></p>
      <div class="container">
          <p>Please Provide your contact Information below and we will contact you. Thank you.</p>
          <form action="contact.php" method="POST">
          <input type="hidden" name="subject" value="new submission!" > 
            <label for="fname">First Name</label>
            <input type="text" id="fname" name="firstname" placeholder="Your name..">
            <br>
            <label for="lname">Last Name</label>
            <input type="text" id="lname" name="lastname" placeholder="Your last name..">
            <br>
            <label for="country">Email</label>
            <input id="email" type="text" name="email" placeholder="Your Email.." >
            <br>      
            <label for="message">Message</label>
            <textarea id="message" name="message" placeholder="Write something.." style="height:200px"></textarea>
            <br>
            <input type="submit" value="Submit">
          </form>
      </div>

        
    </main>
<script>
    var toggleMenu = document.getElementById('toggleMenu');
    var nav = document.querySelector('nav');
    toggleMenu.addEventListener(
      'click',
      function(){
        if(nav.style.display=='block'){
          nav.style.display='none';
        }else{
          nav.style.display='block';
        }
      }
    );
</script>

    </body>
</html>