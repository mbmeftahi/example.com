<?php
// add meta tags
$meta=[];
$meta['title'] = "MBMeftahi";


$content =<<<EOT
    <main>
      <h1>Hello, My name is Mohammad Meftahi</h1>
      <img  class="avitar" src="https://www.gravatar.com/avatar/4678a33bf44c38e54a58745033b4d5c6?d=mm&s=64" alt="MBMeftahi">
      <p> I am system engineer; curently attending full stack training at Microtrain  to extend my coding capability. I would like to be able to develop websites and api's  and websites to comunicate with user community and created utilities and tools to automate back end activities of system admins.</p>
    </main>
    <section>
      <a href="https://localhost/apod-vanilla/index.html" >Vanilla NASA </a>
      <iframe src="https://localhost/apod-vanilla/index.html" width="1080" height="660"></iframe>
    </section>
EOT;
require '../core/layout.php';


