<?php
    $pageTitle = 'Sign Up Page';
    require_once ('loader.php');

    if (isLogged()) {
        header('Location: http://' . $_SERVER['HTTP_HOST'] . '/timetable.php', true, 303);
    }

    $error = '';
    if (!empty($_POST)) {
        try {
            $_POST['name'] = trim($_POST['name']);
            $_POST['surname'] = trim($_POST['surname']);   
            $_POST['username'] = trim($_POST['username']); 
            $_POST['email'] = trim($_POST['email']);
            $_POST['phoneNumber'] = trim($_POST['phoneNumber']);
            $_POST['password1'] = trim($_POST['password1']);
            $_POST['password2'] = trim($_POST['password2']);
            $_POST['studentName'] = trim($_POST['studentName']); 
            $_POST['studentSurname'] = trim($_POST['studentSurname']);
            $_POST['studentAge'] = trim($_POST['studentAge']);
            if (get_magic_quotes_gpc()) {
                $_POST['name'] = stripslashes($_POST['name']);
                $_POST['surname'] = stripslashes($_POST['surname']);
                $_POST['username'] = stripslashes($_POST['username']);
                $_POST['email'] = stripslashes($_POST['email']);
                $_POST['phoneNumber'] = stripslashes($_POST['phoneNumber']);
                $_POST['password1'] = stripslashes($_POST['password1']);
                $_POST['password2'] = stripslashes($_POST['password2']);
                $_POST['studentName'] = stripslashes($_POST['studentName']); 
                $_POST['studentSurname'] = stripslashes($_POST['studentSurname']);
                $_POST['studentAge'] = stripslashes($_POST['studentAge']);
            }
            register($_POST['name'], $_POST['surname'], $_POST['username'], $_POST['email'], $_POST['phoneNumber'], $_POST['password1'], $_POST['password2'], $_POST['studentName'], $_POST['studentSurname'], $_POST['studentAge'], $_POST['subjects']);
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/timetable.php?addUser=true', true, 303);
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
        
        <title>BOOK-A-LESSON - Registration</title>
    </head>

    <body>
        <div id="container">
  
            <header>
                <h1>
                    <a href="./">BOOK-A-LESSON</a>
                </h1>
            </header>
  
            <h2>Sign Up Page</h2>
      
            <nav>
                <ul>
                    <li><a href="./loginPage.php">Login Page</a></li>
                </ul>
            </nav>

            <main>
                <?php
                    if (!empty($error)) {
                        echo '<p class="error"><strong>ERROR:</strong> ' . htmlspecialchars($error) . '</p>';
                    }
                ?>
            
                <p class="label">To register, you must fill in all fields marked with *. In case of not filling mandatory data or inaccurate data information system will notify you of errors and you can fix it.</p>
        
                <form name ="signUp" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                    <fieldset>
                        <legend>Booking</legend>
                        <label for="name"><span class="required">*&nbsp;</span>Name:</label>
                        <input class="items" name="name" id="name" type="text" maxlength="30" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required>
                        <label for="surname"><span class="required">*&nbsp;</span>Surname:</label>
                        <input class="items" name="surname" id="surname" type="text" maxlength="30" value="<?php echo isset($_POST['surname']) ? htmlspecialchars($_POST['surname']) : ''; ?>" required>
                        <label for="username"><span class="required">*&nbsp;</span>Username:</label>
                        <input class="items" name="username" id="username" type="text" maxlength="30" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required>
                        <label for="email"><span class="required">*&nbsp;</span>E-mail:</label>
                        <span class="instructions">Enter your e-mail in the proper format.</span>
                        <input class="items" name="email" id="email" type="text" maxlength="64" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                        <label for="phoneNumber">Phone number:</label>
                        <span class="instructions">Enter your phone number.</span>
                        <input class="items" name="phoneNumber" id="phoneNumber" type="text" maxlength="13" value="<?php echo isset($_POST['phoneNumber']) ? htmlspecialchars($_POST['phoneNumber']) : ''; ?>">       
                        <label for="password1"><span class="required">*&nbsp;</span>Password:</label>
                        <span class="instructions">Password has to be at least 5 characters long.</span>
                        <input class="items" name="password1" id="password1" type="password" pattern=".{5,}" value="" required>
                        <label for="password2"><span class="required">*&nbsp;</span>Password again:</label>
                        <input class="items" name="password2" id="password2" type="password" pattern=".{5,}" value="" required>
                        <p class="label">If you create an account for someone else, please provide more information about the student.</p>
                        <label for="studentName">Student's Name:</label>
                        <input class="items" name="studentName" id="studentName" type="text" maxlength="30" value="<?php echo isset($_POST['studentName']) ? htmlspecialchars($_POST['studentName']) : ''; ?>">
                        <label for="studentSurname">Student's Surname</label>
                        <input class="items" name="studentSurname" id="studentSurname" type="text" maxlength="30" value="<?php echo isset($_POST['studentSurname']) ? htmlspecialchars($_POST['studentSurname']) : ''; ?>">
                        <label for="studentAge">Student's Age:</label>
                        <input class="items" name="studentAge" id="studentAge" type="text" value="<?php echo isset($_POST['studentAge']) ? htmlspecialchars($_POST['studentAge']) : ''; ?>">
                        <p class="label">Subjects:</p>
                        <input class="checkbox" type="checkbox" name="subjects[]" value="MES" >Elementary School Math<br>
                        <input class="checkbox" type="checkbox" name="subjects[]" value="MHS" >High School Math<br>
                        <input class="checkbox" type="checkbox" name="subjects[]" value="EES" >Elementary School English<br>
                        <input class="checkbox" type="checkbox" name="subjects[]" value="EHS" >High School English<br>
                        <input type="hidden" name="subjects[]" value="">
                        <input class="submit" type="submit" value="Submit">
                        <span class="instructions">*&nbsp;Data marked with an asterisk must be filled.</span>
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
