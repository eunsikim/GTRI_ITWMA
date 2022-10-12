<?php
    $title = 'Home';
    // If the user is not logged in, redirect to login view
    require_once('./php/config.php');

    if(!isLogged()){
        header('Location: login');
    }

    //  Header
    require_once('./views/templates/header.php')
?>
<div class="container">
    <h1>Welcome <?php echo $_SESSION['user']  ?> </h1>
</div>
<?php require_once('./views/templates/footer.template') ?>