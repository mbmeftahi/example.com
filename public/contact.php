<?php
// form processing requirement
require '../core/processContactForm.php';
$meta=[];
$meta['title'] = "Contact Me!";
$meta['description'] = "my Contact Page";
$meta['keywords'] = false;

$content = <<<EOT
<main>
<h1>Contact Me - YOUR-NAME</h1>

<form action="contact.php" method="POST">

<input type="hidden" name="subject" value="New submission!">

<div>
  <label for="firstName">Fisrt Name</label>
  <input id="firstName" type="text" name="firstName" value="{$valid->userInput('firstName')}">
  <div class="text-error">{$valid->error('firstName')}</div>
</div>

<div>
  <label for="name">Last Name</label>
  <input id="lastName" type="text" name="lastName" value="{$valid->userInput('lastName')}">
  <div class="text-error">{$valid->error('lastName')}</div>
</div>

<div>
  <label for="email">Email</label>
  <input id="email" type="text" name="email" value="{$valid->userInput('email')}">
  <div class="text-error">{$valid->error('email')}</div>
</div>

<div>
  <label for="message">Message</label>
  <textarea id="message" name="message">{$valid->userInput('message')}</textarea>
  <div class="text-error">{$valid->error('message')}</div>
</div>

<div>
  <input type="submit" value="Send">
</div>

</form>
</main> 
EOT;
require '../core/layout.php';

