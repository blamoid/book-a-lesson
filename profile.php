<?php
    $pageTitle = 'My Profile';
    require_once ('loader.php');

    if (!isLogged()) {
        header('Location: http://' . $_SERVER['HTTP_HOST'] . '/loginPage.php', true, 303);
    }

    $error = '';
    if (isset($_POST['submit'])) {
        try {
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/profileEdit.php', true, 303);
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
        
        <title>BOOK-A-LESSON - My Profile</title>
    </head>

    <body>
        <div id="container">
    
            <header>
                <h1>
                    <a href="./">BOOK-A-LESSON</a>
                </h1>
            </header>
        
            <h2>My Profile</h2>
            
            <nav>
                <ul>
                    <li><a href="./profile.php">My Profile</a></li>
                    <li><a href="./newLesson.php">New Lesson</a></li>
                    <li><a href="./myLessons.php">My Lessons</a></li>
                    <li><a href="./timetable.php">Timetable</a></li>
                    <li><a href="./logout.php">Log out</a></li>
                </ul>
            </nav>
                  
            <main>
                <?php
                    if (!empty($error)) {
                        echo '<p class="error"><strong>ERROR:</strong> ' . htmlspecialchars($error) . '</p>';
                    }
                    
                    if(!empty($_GET['changed'])) {
                        echo '<p class="message"><strong>Data successfully changed.</strong></p>';
                    }
                ?>
                <table>
                    <?php
                        $result = dibi::query('SELECT * FROM [users] WHERE username=%s', $_SESSION['username']);   
                        foreach ($result as $m => $row) {
                            $username = $row['username'];
                            $name = $row['name'];
                            $surname = $row['surname'];
                            $email = $row['email'];
                            $phoneNumber = $row['phoneNumber'];
                            $studentName = $row['studentName'];
                            $studentSurname = $row['studentSurname'];
                            $studentAge = $row['studentAge'];
                            echo "<tr><td>Username:</td><td>" . $username . "</td></tr>";
                            echo "<tr><td>Name:</td><td>" . $name . "</td></tr>";
                            echo "<tr><td>Surname:</td><td>" . $surname . "</td></tr>";
                            echo "<tr><td>E-mail:</td><td>" . $email . "</td></tr>";
                            echo "<tr><td>Phone Number:</td><td>" . $phoneNumber . "</td></tr>";
                            echo "<tr><td>Student's Name:</td><td>" . $studentName . "</td></tr>";
                            echo "<tr><td>Student's Surname:</td><td>" . $studentSurname . "</td></tr>";
                            echo "<tr><td>Student's Age:</td><td>" . $studentAge . "</td></tr>";
                        } 
                    ?>
                    <tr>
                        <td colspan="2">
                            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                                <input name="submit" class="submit" type="submit" value="Edit Profile">
                            </form>
                        </td>
                    </tr>
                </table>
            </main>
            
            <footer>
                <div id="copyright">
                    <p>Copyright © blamoid, 2014<br />contact: <a href="mailto:blamoid@gmail.com">blamoid@gmail.com</a></p>
                </div>
            </footer>

        </div>
    </body>
</html>
