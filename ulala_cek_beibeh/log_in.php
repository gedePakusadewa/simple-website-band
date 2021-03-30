<?php 
    include('ulala_function.php');
    unset($_GET['logout']);
?>

<!DOCTYPE html>

<html>
<!-- https://codewithawa.com/posts/admin-and-user-login-in-php-and-mysql-database-->
    <head>
        <title>Log In</title>
        <meta charset="utf-8" />
        <meta name="description" content="halaman log in website roti roti ku" />
        <meta name="keywords" content="roti, jualan, dagang, enak, website, online" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" type="text/css" href="../css/style.css" />    
    </head>
    <body>

        <form class = "login" action="" method="post">
            <h1 class = "login-title">Log In</h1>
            <?php echo display_error(); ?>
            <input type="text" class="login-input" name="username" placeholder="Username" autofocus />
            <input type="password" class="login-input" name="password" placeholder="Password" />
            <input type="submit" value="Masuk" name="login_btn" class="login-button" /><br /><br />
        </form>


        <div style="width:10%;" ><a href="../index.php"><button class="login-button" >Beli Tiket</button></a></div>

    </body>
</html>

