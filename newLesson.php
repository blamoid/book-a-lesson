<?php
    $pageTitle = 'New Lesson';
    require_once ('loader.php');

    if (!isLogged()) {
        header('Location: http://' . $_SERVER['HTTP_HOST'] . '/loginPage.php', true, 303);
    }

    $error = '';
    if (!empty($_POST)) {
        if ( isset( $_POST['submit'] ) ) {
            try {
                $date = $_POST['date'];
                $timeStart = $_POST['timeStart'];
                $timeEnd = $_POST['timeEnd'];
                $note = $_POST['note'];
                addLesson($_SESSION['username'], $_POST['date'], $_POST['timeStart'], $_POST['timeEnd'], $_POST['note']);
                header('Location: http://' . $_SERVER['HTTP_HOST'] . '/myLessons.php?addLesson=true', true, 303);
                exit;
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
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

        <meta http-equiv="X-UA-Compatible" content="IE=edge">    <!-- pro spravne zobrazovani v IE9 -->

        <link rel="stylesheet" type="text/css" href="css/main.css" title="preferred">  

        <title>BOOK-A-LESSON - New Lesson</title>
    </head>

    <body>
        <div id="container">
    
            <header>
                <h1>
                    <a href="./">BOOK-A-LESSON</a>
                </h1>
            </header>
      
            <h2>New Lesson</h2>
          
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
                ?>
                <p class="label">To create a Lesson, you must fill in all fields marked with *. In case of not filling mandatory data or inaccurate data information system will notify you of errors and you can fix it.</p>
                <form name ="createLesson" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                    <fieldset>
                        <legend>Zápis lekce</legend>
                        <label for="date" >*&nbsp;Date:</label>
                        <span class="instructions">Fill in the date of the Lesson in format "RRRR-M-D".</span>
                        <input class="items" name="date" id="date" type="date" value="<?php echo isset($_POST['date']) ? htmlspecialchars($_POST['date']) : date('Y-m-d'); ?>" required>
                        <label for="timeStart">*&nbsp;Start At:</label>
                        <span class="instructions">Fill in the start time of the Lesson in format "h:m".</span>
                        <input class="items" name="timeStart" id="timeStart" type="time" value="<?php echo isset($_POST['timeStart']) ? htmlspecialchars($_POST['timeStart']) : '12:00' ?>" required>
                        <label for="timeEnd">*&nbsp;End At:</label>
                        <span class="instructions">Fill in the end time of the Lesson in format "h:m".</span>
                        <input class="items" name="timeEnd" id="timeEnd" type="time" value="<?php echo isset($_POST['timeEnd']) ? htmlspecialchars($_POST['timeEnd']) : '13:00'; ?>" required>
                        <label for="note">Note:</label>  
                        <textarea class="items" name="note" id="note"><?php echo isset($_POST['timeEnd']) ? htmlspecialchars($_POST['note']) : ''; ?></textarea> 
                        <input name="submit" class="submit" type="submit" value="Create Lesson">
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
