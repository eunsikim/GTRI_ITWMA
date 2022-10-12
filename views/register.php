<?php
    $title = 'Register';
    //  If the user is logged in, redirect to home view
    require_once($_SERVER['DOCUMENT_ROOT']."/php/config.php");

    if(isLogged()){
        header('Location: /');
    }

    //  Header
    require_once('./views/templates/header.php')
?>
<div class="container">
    <div class="card-body py-5 px-md-5">
        <?php 
            if(isset($_GET['error']) && $_GET['error'] == 'none'){
                echo '<div class="alert alert-success" role="alert">';
                echo 'Success!';
                echo '</div>';
            }
            else if(isset($_GET['error'])){
                echo '<div class="alert alert-danger" role="alert">';
                if($_GET['error'] == '1'){
                    echo 'Some inputs were empty';
                }
                elseif($_GET['error'] == '2'){
                    echo 'Email already in use';
                }
                elseif($_GET['error'] == '2'){
                    echo 'Statement fail';
                }
                echo '</div>';
            }
        ?>
        <form action="register" method="POST">
            <!-- 2 column grid layout with text inputs for the first and last names -->
            <div class="row">
            <div class="col-md-6 mb-4">
                <div class="form-outline">
                <input name="firstName" type="text" class="form-control" />
                <label class="form-label" for="form3Example1">First name</label>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="form-outline">
                <input name="lastName" type="text" class="form-control" />
                <label class="form-label" for="form3Example2">Last name</label>
                </div>
            </div>
            </div>

            <!-- Email input -->
            <div class="form-outline mb-4">
            <input name="email" type="email" class="form-control" />
            <label class="form-label" for="form3Example3">Email address</label>
            </div>

            <!-- Password input -->
            <div class="form-outline mb-4">
            <input name="password" type="password" class="form-control" />
            <label class="form-label" for="form3Example4">Password</label>
            </div>


            <!-- Submit button -->
            <input name="register" value="register" type="submit" class="btn btn-primary btn-block mb-4">
        </form>
    </div>
</div>
<?php require_once('./views/templates/footer.template') ?>