<div class="d-flex p-2">
    <ul class="navbar-nav">
        <li class="nav-item me-3">
            <?php
                if(isset($_SESSION['user'])){
                    echo '<h1>'.$_SESSION['user'].'</h1>';
                }
            ?>
        </li>

        <li class="nav-item me-3">
            <h1><i class="bi bi-file-person-fill"></i></h1>
        </li>

        <li class="nav-item dropdown-center me-3">
            <!-- <span class="navbar-toggler-icon" style="font-size:2em;"></span> -->
            <a class="btn dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="navbar-toggler-icon" style="font-size:1.5em;"></span>
            </a>

            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <form action="logout" method="POST">
                        <input type="submit" class="btn" name="logout" value="logout">
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</div>

