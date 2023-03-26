<?php 
// session_unset();
// session_destroy();
    require_once("C:/xampp/htdocs/jbeleave/private/initialize.php");
    $page_title = "Log in";
    include(SHARED_PATH . "/header.php");


    if(isset($_SESSION["username"])){
        if(isset($_SESSION['employeetype']) && $_SESSION['employeetype'] == 'user')
        {
            header("location: user/");
            exit();
        }
    }

    if(isset($_SESSION["username"])){
        if(isset($_SESSION['employeetype']) && $_SESSION['employeetype'] == 'supervisor')
        {
            header("location: supervisor/");
            exit();
        }
    }

    if(isset($_SESSION["username"])){
        if(isset($_SESSION['employeetype']) && $_SESSION['employeetype'] == 'hr')
        {
            header("location: hr/");
            exit();
        }
    }

    if(isset($_SESSION["username"])){
        if(isset($_SESSION['employeetype']) && $_SESSION['employeetype'] == 'management')
        {
            header("location: management/");
            exit();
        }
    }

    if(isset($_SESSION["username"])){
        if(isset($_SESSION['employeetype']) && $_SESSION['employeetype'] == 'admin')
        {
            header("location: admin/");
            exit();
        }
    }
?>
    <section class="jbe__container-fluid">
        <div class="jbe__container jbe__login-form">
            <form class="jbe__login" id="jbe__login" action="" autocomplete="off">
                <div class="jbe__error-msg" id="jbe__error-msg">This is an error message</div>
                <div class="form-group">
                    <label for="username" id="label-username">Username <span class="required error" id="login-username-info"></span></label>
                    <input type="text" class="form-control" name="username" id="username" aria-describedby="usernameHelp" placeholder="Enter Username">
                </div>
                <div class="form-group">
                    <label for="password" id="label-password">Password <span class="required error" id="login-password-info"></label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password">
                    <i class="fas fa-eye"></i>
                </div>
                <!-- <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="remember-me">
                    <label class="form-check-label" for="remember-me">Remember Me!</label>
                </div> -->
                <button type="submit" class="jbe__submit">Log In</button>
            </form>
        </div>
    </section>


<?php 
//   echo '<pre>';
//   var_dump($_SESSION);
//   echo '</pre>';
    include(SHARED_PATH . "/footer.php")
?>
