<?php
    $pageTitle = 'Profile editing';
    require_once ('loader.php');

    if (!isLogged()) {
        header('Location: http://' . $_SERVER['HTTP_HOST'] . '/loginPage.php', true, 303);
    }

    $error = '';
    if (isset($_POST['back'])) {
        try {
          header('Location: http://' . $_SERVER['HTTP_HOST'] . '/profile.php', true, 303);
          exit;
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }

    if (isset($_POST['change'])) {
        try {
          $_POST['name'] = trim($_POST['name']);
          $_POST['surname'] = trim($_POST['surname']);  
          $_POST['email'] = trim($_POST['email']);
          $_POST['phoneNumber'] = trim($_POST['phoneNumber']);
          $_POST['studentName'] = trim($_POST['studentName']); 
          $_POST['studentSurname'] = trim($_POST['studentSurname']);
          $_POST['studentAge'] = trim($_POST['studentAge']);
          if (get_magic_quotes_gpc()) {
              $_POST['name'] = stripslashes($_POST['name']);
              $_POST['surname'] = stripslashes($_POST['surname']);
              $_POST['email'] = stripslashes($_POST['email']);
              $_POST['phoneNumber'] = stripslashes($_POST['phoneNumber']);
              $_POST['studentName'] = stripslashes($_POST['studentName']); 
              $_POST['studentSurname'] = stripslashes($_POST['studentSurname']);
              $_POST['studentAge'] = stripslashes($_POST['studentAge']);
          }
          changeData($_POST['name'], $_POST['surname'], $_SESSION['username'], $_POST['email'], $_POST['phoneNumber'], $_POST['studentName'], $_POST['studentSurname'], $_POST['studentAge']);
          header('Location: http://' . $_SERVER['HTTP_HOST'] . '/profile.php?changed=true', true, 303); 
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
          
          <title>BOOK-A-LESSON - Profile Edit</title>
      </head>

      <body>
          <div id="container">
      
          <header>
              <h1>
                  <a href="./">BOOK-A-LESSON</a>
              </h1>
          </header>
      
          <h2>Profile Edit</h2>
          
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
                  }
              ?>
              <form name ="profileEdit" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                  <fieldset>
                      <legend>Profile edit</legend>
                      <label for="name">Name:</label>
                      <input class="items" name="name" id="name" type="text" maxlength="30" value="<?php echo $name; ?>" required>
                      <label for="surname">Surname:</label>
                      <input class="items" name="surname" id="surname" type="text" maxlength="30" value="<?php echo $surname; ?>" required>
                      <label for="email">E-mail:</label>
                      <input class="items" name="email" id="email" type="text" maxlength="64" value="<?php echo $email; ?>" required>
                      <label for="phoneNumber">Phone Number:</label>
                      <input class="items" name="phoneNumber" id="phoneNumber" type="text" maxlength="13" value="<?php echo $phoneNumber; ?>">      
                      <label for="studentName">Student's name:</label>
                      <input class="items" name="studentName" id="studentName" type="text" maxlength="30" vvalue="<?php echo $studentName; ?>">
                      <label for="studentSurname">Student's surname:</label>
                      <input class="items" name="studentSurname" id="studentSurname" type="text" maxlength="30" value="<?php echo $studentSurname; ?>">
                      <label for="studentAge">Student's age:</label>
                      <input class="items" name="studentAge" id="studentAge" type="text" value="<?php echo $studentAge; ?>">
                      <input class="submit" type="submit" name="change" value="Change">
                      <input class="submit" type="submit" name="back" value="Back">
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
