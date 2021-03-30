<?php 
    
    include('ulala_function.php')
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Pendaftaran</title>
        <meta charset="utf-8" />
        <meta name="description" content="Register member" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
    </head>
    <body>
        
        <form class="login" action="" method="post">
            
            <?php echo "".display_error(); ?>
            <input type="text" class="login-input" value="<?php echo $username; ?>" name="username" placeholder="Username" />
            <input type="password" class="login-input" name="password_1" placeholder="Password" />
            <input type="password" class="login-input" name="password_2" placeholder="Konfirmasi Password" />
            <input type="submit" name="register_btn" value="Daftar" class="login-button" />
        </form>
    </body>
</html>