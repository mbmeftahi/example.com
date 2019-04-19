<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <title><?php echo $meta['title']; ?>MBMeftahi</title>
    <?php if (!empty($meta['description'])): ?>
      <meta name="description" content="<?php echo $meta['description']; ?> ">
    <?php endif; ?>
    <?php if (!empty($meta['keyword'])): ?>
      <meta name="keyword" content="<? echo $meta['keyword']; ?> ">
    <?php endif; ?>
    <style> 
    body{
      padding-top:60px;
    }
    </style>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="shortcut icon"  href="https://www.gravatar.com/avatar/4678a33bf44c38e54a58745033b4d5c6?d=mm&s=64">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    </head>

  <body>
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <a class="navbar-brand" href="index.php">
    <i class="fas fa-dove"></i></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="/">Home</a>
        </li>
          <li class="nav-item">
            <a class="nav-link" href="/resume.php">AboutMe</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="/contact.php">ContactUS</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="/thanks.php">ThankYou</a>
          </li>

          <li class="nav-item">
              <a class="nav-link" href="/posts">Blog</a>
          </li>

          <?php if (!empty($_SESSION['user']['id'])): ?>

          <li class="nav-item">
              <a class="nav-link" href="/users">users</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="/logout.php">Logout</a>
          </li>

          <?php else: ?>

          <li class="nav-item">
              <a class="nav-link" href="/login.php">Login</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="/register.php">Register</a>
          </li>
          
          <?php endif; ?>

      </ul>
    </div>
  </nav>
   
    <main class="container"><?php echo $content; ?>
    </main>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>        
  </body>
</html>