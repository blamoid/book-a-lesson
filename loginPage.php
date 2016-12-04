<?php
    $pageTitle = 'Login Page';
    require_once ('loader.php');

    if (isLogged()) {
        header('Location: http://' . $_SERVER['HTTP_HOST'] . '/timetable.php', true, 303);
    }

    $error = '';
    if (!empty($_POST)) {
        try {
            login($_POST['username'], $_POST['password']);
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/timetable.php', true, 303);
            exit;
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        
        <meta name="author" content="blamoid">
        <meta name="keywords" content="tutoring, tutor, education, school, lesson booking, lesson reservation">
        <meta name="description" content="Web application for booking lessons.">
        <meta name="robots" content="all">
        
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        
        <link rel="stylesheet" type="text/css" href="css/main.css" title="preferred"> 
        
        <title>BOOK-A-LESSON - Login Page</title>
    </head>

    <body>
        <div id="container">

            <header>
                <h1>
                    <a href="./">BOOK-A-LESSON</a>
                </h1>
            </header>
    
            <h2>Login Page</h2>
        
            <nav>
                <ul>
                    <li><a href="/signUpPage.php">Sign Up</a></li>
                </ul>
            </nav>

            <main>
                <?php
                  if (!empty($error)) {
                      echo '<p class="error"><strong>ERROR:</strong> ' . htmlspecialchars($error) . '</p>';
                  }
                ?>
                <form name="loginForm" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method='post' accept-charset='UTF-8'>
                    <fieldset>
                        <legend>Login</legend>
                        <input class = "items" type='hidden' name='submitted' id='submitted' value='1'/>
                        <label for='username'>Username:</label>
                        <input class = "items" type='text' name='username' id='username'  maxlength="30" required/>
                        <label for='password' >Password:</label>
                        <input class = "items" type='password' name='password' id='password' maxlength="64" required/>
                        <input class = "submit" type='submit' name='submit' value='Login' />
                    </fieldset>
                </form>
            </main>
        
            <footer>
                <div id="copyright">
                    <p>Copyright © blamoid, 2014<br />contact: <a href="mailto:blamoid@gmail.com">blamoid@gmail.com</a></p>
                </div>
            </footer>

        </div>
    </body>
</html>
