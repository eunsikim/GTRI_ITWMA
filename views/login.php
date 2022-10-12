<?php
    $title = 'Login';
    //  If the user is logged in, redirect to home view
    require_once($_SERVER['DOCUMENT_ROOT']."/php/config.php");

    if(isLogged()){
        header('Location: /');
    }

    //  Header
    require_once('./views/templates/header.php')
?>
<div class="container">
    <h1>Log in</h1>

    <form action="login" method="POST">
        <?php 
            if(isset($_GET['error'])){
                echo '<div class="alert alert-danger" role="alert">';
                if($_GET['error'] == '1'){
                    echo 'Email address or Password empty';
                }
                elseif($_GET['error'] == '2'){
                    echo 'Wrong email or password';
                }
                echo '</div>';
            }
        ?>
        <!-- Email input -->
        <div class="form-outline mb-4">
            <input type="email" id="form2Example1" class="form-control" name="user_email" />
            <label class="form-label" for="form2Example1">Email address</label>
        </div>
        <!-- Password input -->
        <div class="form-outline mb-4">
            <input type="password" id="form2Example2" class="form-control" name="user_password" />
            <label class="form-label" for="form2Example2">Password</label>
        </div>

        <div class="text-center">
            <p>Not a member? <a href="/register">Register</a></p>
        </div>

        <!-- Submit button -->
        <input type="submit" class="btn btn-primary btn-block mb-4" name="login" value="login">
    </form>
    
</div>
<?php require_once('./views/templates/footer.template') ?>