<nav class="navbar navbar-expand-lg">
    <div class="ms-auto d-flex mb-3">
    <?php 
        require_once($_SERVER['DOCUMENT_ROOT']."/php/config.php");

        if(isLogged()){
        require(__DIR__.'/navbarH/user.php');
        }
        else{
        require(__DIR__.'/navbarH/login.php');
        }
    ?>
    </div>
</nav>