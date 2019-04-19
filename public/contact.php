<?php
require '../core/bootstrap.php';


// form processing requirement
require '../core/processContactForm.php';
$meta=[];
$meta['title'] = "Contact Me!";
$meta['description'] = "my Contact Page";
$meta['keywords'] = false;

$content = <<<EOT
<main>
<h1>Contact Me - YOUR-NAME</h1>
{$message}
<form action="contact.php" method="POST">

<input type="hidden" name="subject" value="New submission!">

<div class="form-group">
  <label for="firstName">Fisrt Name</label>
  <input class="form-control" id="firstName" type="text" name="firstName" value="{$valid->userInput('firstName')}">
  <div class="text-danger">{$valid->error('firstName')}</div>
</div>

<div class="form-group">
  <label for="name">Last Name</label>
  <input class="form-control" id="lastName" type="text" name="lastName" value="{$valid->userInput('lastName')}">
  <div class="text-danger">{$valid->error('lastName')}</div>
</div>

<div class="form-group">
  <label for="email">Email</label>
  <input class="form-control" id="email" type="text" name="email" value="{$valid->userInput('email')}">
  <div class="text-danger">{$valid->error('email')}</div>
</div>

<div class="form-group">
  <label for="message">Message</label>
  <textarea class="form-control" id="message" name="message">{$valid->userInput('message')}</textarea>
  <div class="text-danger">{$valid->error('message')}</div>
</div>

<div class="form-group">
  <input class="btn btn-primary" type="submit" value="Send">
</div>

</form>
</main> 
EOT;
require '../core/layout.php';

