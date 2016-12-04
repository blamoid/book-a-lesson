<?php
    $pageTitle = 'My Lessons';
    require_once ('loader.php');

    if (!isLogged()) {
        header('Location: http://' . $_SERVER['HTTP_HOST'] . '/loginPage.php', true, 303);
    }

    $error = '';
    if (isset($_POST['submit'])) {
        try {
            deleteLesson($_POST['submit']);
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
        
        <title>BOOK-A-LESSON - My Lessons</title>
    </head>

    <body>
        <div id="container">

            <header>
                <h1>
                    <a href="./">BOOK-A-LESSON</a>
                </h1>
            </header>

            <h2>My Lessons</h2>

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
                        echo '<p class="error"><strong>ERROR:</strong>' . htmlspecialchars($error) . '</p>';
                    }
                    if(!empty($_GET['addLesson'])) {
                        echo '<p class="message"><strong>Lesson created successfully.</strong></p>';
                    }
                ?>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" onsubmit="return confirm('Are you sure you want to delete this lesson?')">
                    <table>  
                        <tr>
                            <td>Date</td>
                            <td>Start At</td>
                            <td>End At</td>
                            <td>Note</td>
                            <td>Delete</td>
                        </tr>
                        <?php  
                            echo '';
                            $result = dibi::query('SELECT * FROM [lessons] WHERE username=%s', $_SESSION['username']);  
                            foreach ($result as $m => $row) {
                                $timeStart = date_format( date_create( $row['timeStart'] ), 'H:i' );
                                $timeEnd = date_format( date_create( $row['timeEnd'] ), 'H:i' );
                                $date = substr($row['date'], 0, 10);
                                echo '<tr><td>' . $date . '</td>' . '<td>' . $timeStart . '</td>' . '<td>' . $timeEnd . '</td>' . '<td>' . $row['note'] . '</td>' . '<td>  <button type="submit" name="submit" class="delete" value="' . $row['lessonId'] . '"></button></td>' . '</tr>';
                            }
                        ?>
                    </table>
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
