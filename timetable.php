<?php
    $pageTitle = 'Timetable';
    require_once ('loader.php');

    if (!isLogged()) {
        header('Location: http://' . $_SERVER['HTTP_HOST'] . '/loginPage.php', true, 303);
    }

    $error = '';
    if (isset($_POST['submit'])) {
        try {
            $string = $_POST['submit'];
            $date = substr($string, 0, 10);
            $hour = substr($string, 10);
            $firstHourBefore = sprintf("%02d", $hour);
            $firstHourAfter = sprintf("%02d", $hour+1);
            $url = 'http://' . $_SERVER['HTTP_HOST'] . '/newLesson.php';
            $fields = array(
                'date' => $date,
                'timeStart' => $firstHourBefore . ':00',
                'timeEnd' => $firstHourAfter . ':00',
                'note' => ''
            );
            $postvars = http_build_query($fields);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, count($fields));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
            curl_setopt ($ch,CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
            $result = curl_exec($ch);
            curl_close($ch);
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

        <title>BOOK-A-LESSON - Timetable</title>
    </head>

    <body>
        <div id="container">

            <header>
                <h1>
                    <a href="./">BOOK-A-LESSON</a>
                </h1>
            </header>

            <h2>Timetable</h2>
        
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
                    
                    if(!empty($_GET['addUser'])) {
                        echo '<p class="message"><strong>Registration was successful, now you can book a lesson.</strong></p>';
                    }
                ?>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                    <table class="timetable">  
                        <tr>
                            <td></td>
                            <td>07:00 - 08:00</td>
                            <td>08:00 - 09:00</td>
                            <td>09:00 - 10:00</td>
                            <td>10:00 - 11:00</td>
                            <td>11:00 - 12:00</td>
                            <td>12:00 - 13:00</td>
                            <td>13:00 - 14:00</td>
                            <td>14:00 - 15:00</td>
                            <td>15:00 - 16:00</td>
                            <td>16:00 - 17:00</td>
                            <td>17:00 - 18:00</td>
                            <td>18:00 - 19:00</td>
                            <td>19:00 - 20:00</td>
                            <td>20:00 - 21:00</td>
                            <td>21:00 - 22:00</td>
                            <td>22:00 - 23:00</td>
                            <td>23:00 - 24:00</td>
                        </tr>
                        <?php
                            for($i=0; $i < 14; $i++) {
                                $dayOfWeek = date('w') ;
                                $todaysDate = date('Y-m-d', strtotime('-'.($dayOfWeek - 1 - $i).' days')) ;
                                $result = dibi::query('SELECT timeStart, timeEnd FROM [lessons] WHERE date=%d', $todaysDate);
                                for ($j = 7; $j < 24; $j++) {
                                    $time[$j] = true;
                                }
                                foreach ($result as $m => $row) {
                                    $timeStartFor = date_format( date_create( $row['timeStart'] ), 'H' );
                                    $timeEndFor = date_format( date_create( $row['timeEnd'] ), 'H' );
                                    for ($j = $timeStartFor; $j < $timeEndFor; $j++) {
                                        for ($k = 7; $k < 24; $k++) {
                                            if ( ($j == $k) || ($timeStartFor == $k) || ($timeEndFor == $k) ) {
                                                $time[$k] = false;
                                            }
                                        }
                                    }
                                }
                                if ($i == 0) echo '<tr><td colspan="18">This week</td></tr>';
                                if ($i == 0) echo '<tr><td>Monday<br>' . $todaysDate . '</td>';
                                if ($i == 1) echo '<tr><td>Tuesday<br>' . $todaysDate . '</td>';
                                if ($i == 2) echo '<tr><td>Wednesday<br>' . $todaysDate . '</td>';
                                if ($i == 3) echo '<tr><td>Thursday<br>' . $todaysDate . '</td>';
                                if ($i == 4) echo '<tr><td>Friday<br>' . $todaysDate . '</td>';
                                if ($i == 5) echo '<tr><td>Saturday<br>' . $todaysDate . '</td>';
                                if ($i == 6) echo '<tr><td>Sunday<br>' . $todaysDate . '</td>';
                                if ($i == 7) echo '<tr><td colspan="18">Next week</td></tr>';
                                if ($i == 7) echo '<tr><td>Monday<br>' . $todaysDate . '</td>';
                                if ($i == 8) echo '<tr><td>Tuesday<br>' . $todaysDate . '</td>';
                                if ($i == 9) echo '<tr><td>Wednesday<br>' . $todaysDate . '</td>';
                                if ($i == 10) echo '<tr><td>Thursday<br>' . $todaysDate . '</td>';
                                if ($i == 11) echo '<tr><td>Friday<br>' . $todaysDate . '</td>';
                                if ($i == 12) echo '<tr><td>Saturday<br>' . $todaysDate . '</td>';
                                if ($i == 13) echo '<tr><td>Sunday<br>' . $todaysDate . '</td>';
                                for ($j = 7; $j < 24; $j++) {
                                    if ( $todaysDate < date('Y-m-d') ) {
                                        echo '<td><button type="submit" name="submit"  value="' . $todaysDate . $j . '" class="past" disabled></button></td>';
                                    }
                                    else if ( ( $todaysDate == date('Y-m-d') ) && $j <= date('H') ) {
                                        echo '<td><button type="submit" name="submit"  value="' . $todaysDate . $j . '" class="past" disabled></button></td>';
                                    }
                                    else if ($time[$j] == true) {
                                        echo '<td><button type="submit" name="submit"  value="' . $todaysDate . $j . '" class="free"></button></td>';
                                    } else {
                                        echo '<td><button type="submit" name="delete"  value="' . $todaysDate . $j . '" class="full" disabled></button></td>';
                                    }
                                }
                                echo '</tr>';
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
