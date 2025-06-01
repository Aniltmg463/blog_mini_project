 <?php
    // session_start();
    require_once 'config/Database.php';
    require_once 'models/post_model.php';
    require_once 'views/partials/alert.php';

    $db = new Database();
    $conn = $db->connect();
    $postModel = new post_model($conn);
    ?>
 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Document</title>
 </head>

 <body>
     <div class="alert alert-primary text-center">
         <?= $_SESSION['message'] = "Welcome"; ?>
     </div>

     <?php
        echo "<h1>Welcome, " . htmlspecialchars($_SESSION['message']) . "</h1>";
        ?>

 </body>

 </html>