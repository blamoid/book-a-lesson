<?php

    define('TIMEOUT', 3600);

    function register($name, $surname, $username, $email, $phoneNumber, $password1, $password2, $studentName, $studentSurname, $age, $subject) {
        logout();
        inputCheck($name, $surname, $username, $email, $phoneNumber, $studentName, $studentSurname, $age);
        passwordCheck($password1, $password2);
        setData($name, $surname, $username, $email, $phoneNumber, $password1, $password2, $studentName, $studentSurname, $age, $subject);
        $_SESSION['username'] = $username;
        $_SESSION['time'] = time();
    }

    function addLesson($user, $date, $timeStart, $timeEnd, $note) {
        if (empty($date)) {
            throw new Exception('Date is a required field.');
        }
        if (strlen($date) > 10) {
            throw new Exception('Date may have a maximum of 10 characters.');
        }
        if (!preg_match('/[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}/', $date)) {
            throw new Exception('Invalid date format! The correct format is "YYYY-M-D".');
        }
        if (empty($timeStart)) {
        throw new Exception('Time is a required field.');
        }
        if (strlen($timeStart) > 8) {
            throw new Exception('Times may have a maximum of 8 characters.');
        }
        if ( !($timeStartTime = strtotime($timeStart)) ) {
            throw new Exception('Wrong time format');
        }
        if (empty($timeEnd)) {
        throw new Exception('Time is a required field.');
        }
        if (strlen($timeEnd) > 8) {
            throw new Exception('Times may have a maximum of 8 characters.');
        }
        if ( !($timeEndTime = strtotime($timeEnd)) ) {
            throw new Exception('Wrong time format');
        }
        if ( !($timeStartTime = strtotime($timeStart)) ) {
            throw new Exception('Wrong time format');
        }
        if ( date('H', $timeEndTime) == date('H', $timeStartTime)) {
            throw new Exception('Lesson must be at least 60 minutes long.');
        }
        if ( $date < date("Y-m-d") ) {
            throw new Exception('The beginning of the lesson must not be earlier than today.');
        }
        if ( ($date == date("Y-m-d")) && ($timeStart < date('H:i:s')) ) {
        throw new Exception('The beginning of the lesson must not be earlier than now.');
        }
        if ($timeStart > $timeEnd) {
        throw new Exception('Beginning of the lesson must be before the end of the lesson.');
        }
        if ($timeStart == $timeEnd) {
        throw new Exception('Lesson must be at least 60 minutes long.');
        }
        if ($date < date("Y-m-d")) {
        throw new Exception('Date of new lesson cannot be earlier than today.');
        }
        $result = dibi::query('SELECT timeStart, timeEnd FROM [lessons] WHERE date=%d', $date);
        $freeTime = TRUE;
        foreach ($result as $m => $row) {
            $timeStartFormatted = date_format(date_create($row['timeStart']), 'H:i' );
            $timeEndFormatted = date_format(date_create($row['timeEnd']), 'H:i');
            if (crossingIntervals($timeStart, $timeEnd, $timeStartFormatted, $timeEndFormatted)) {
                $freeTime = FALSE;
            }
        }
        if ($freeTime) {
            $arr = array(
                'username' => $user,
                'date' => $date,
                'timeStart'  => $timeStart,
                'timeEnd'  => $timeEnd,
                'note'  => $note,
            );
            dibi::query('INSERT INTO [lessons]', $arr);
        } else {
        throw new Exception('The specified time is not available.');
        }
    }

    function crossingIntervals($a, $b, $c, $d) {
        return ( ($a <= $c && $c<=$b && $b <= $d) ||
                ($c <= $a && $a<=$d && $d <= $b) ||
                ($a <= $c && $d <= $b) ||
                ($c <= $a && $b <= $d)    );
    }

    function login($username, $password) {
        $username = trim($username);
        $password = trim(hash_hmac('sha256', $password, $username));
        logout();
        $result = dibi::query('SELECT username FROM [users] WHERE username=%s AND password=%s', $username, $password);
        $rows = count($result);
        if ($rows == 0) {
            throw new Exception('Entered Username or Password is not valid.');
        }
        $_SESSION['username'] = $username;
        $_SESSION['time'] = time();
    }

    function isLogged() {
        return !empty($_SESSION['username']);
    }

    function authenticate() {
        if (isLogged()) {
            if ($_SESSION['time'] < (time() - TIMEOUT)) {
                logout();
            } else {
                $_SESSION['time'] = time();
            }
        }
    }

    function logout() {
        unset($_SESSION['username']);
        unset($_SESSION['time']);
        session_regenerate_id(TRUE);
    }

    function deleteLesson($lessonId) {
        $result = dibi::query('DELETE FROM [lessons] WHERE lessonId=%i', $lessonId);
        if (!$result) {
            throw new Exception('The lesson could not be deleted.');
        }
    }

    function inputCheck($name, $surname, $username, $email, $phoneNumber, $studentName, $studentSurname, $age) {
        if (strlen($name) > 30) {
            throw new Exception('Name may have a maximum of 30 characters.');
        }
        if (strlen($surname) > 30) {
            throw new Exception('Surname may have a maximum of 30 characters.');
        }
        if (empty($email)) {
            throw new Exception('E-mail is a required field.');
        }
        if (strlen($email) > 30) {
            throw new Exception('E-mail may have a maximum of 30 characters.');
        }
        if (!preg_match('/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/', $email)) {
            throw new Exception('Invalid E-mail format.');
        }
        if (strlen($phoneNumber) != 0) {
        if (strlen($phoneNumber) > 13) {
            throw new Exception('Phone Number may have a maximum of 13 characters.');
        }
        if (!preg_match('/[+]?[0-9]{9,12}/', $phoneNumber)) {
            throw new Exception('Invalid Phone Number format.');
        }
        }
        if (strlen($username) > 30) {
            throw new Exception('Username may have a maximum of 30 characters.');
        }
        if (empty($username)) {
            throw new Exception('Username is a required field.');
        }
        if (!preg_match('/[0-9]*/', $age)) {
            throw new Exception('Age must be an integer value.');
        }
    }

    function passwordCheck($password1, $password2) {
        if ($password1 != $password2) {
            throw new Exception('Passwords do not match!');
        }
        if (strlen($password1) > 64) {
            throw new Exception('Password may have a maximum of 64 characters.');
        }
        if (strlen($password1) < 5) {
            throw new Exception('Password has to be at least 5 characters long.');
        }
        if (empty($password1)) {
            throw new Exception('Password is a required field.');
        }
    }

    function setData($name, $surname, $username, $email, $phoneNumber, $password1, $password2, $studentName, $studentSurname, $age, $subject) {
        if (!isUsernameTaken($username)) {
            $password = hash_hmac('sha256', $password1, $username);
            $arr = array(
                'name' => $name,
                'surname' => $surname,
                'email' => $email,
                'phoneNumber' => $phoneNumber,
                'username' => $username,
                'password'  => $password,
                'studentName'  => $studentName,
                'studentSurname'  => $studentSurname,
                'studentAge'  => $age
            );
            $insert = dibi::query('INSERT INTO [users]', $arr);
            if (!$insert) {
                throw new Exception('Failed to save the user to the database.');
            }
            for($i=0; $i < count($subject); $i++) {
                if ($subject[$i] != "") {
                    $arr = array(
                        'username' => $username,
                        'code' => $subject[$i]
                    );
                    $insert = dibi::query('INSERT INTO [student_subjects]', $arr);
                    if (!$insert) {
                        throw new Exception('Failed to save selected subject to the database.');
                    }
                }
            }
        } else {
            throw new Exception('A user with that username already exists, choose another one.');
        }
    }

    function changeData($name, $surname, $username, $email, $phoneNumber, $studentName, $studentSurname, $age) {
        inputCheck($name, $surname, $username, $email, $phoneNumber, $studentName, $studentSurname, $age);
        if (isUsernameTaken($username)) {
            $arr = array(
                'name' => $name,
                'surname' => $surname,
                'email' => $email,
                'phoneNumber' => $phoneNumber,
                'studentName'  => $studentName,
                'studentSurname'  => $studentSurname,
                'studentAge'  => $age
            );
            $change = dibi::query('UPDATE [users] SET ', $arr, 'WHERE username=%s', $username);
            if (!$change) {
                throw new Exception('Failed to change user data.');
            }
        } else {
            throw new Exception("A user with that username doesn't exist.");
        }
    }

    function isUsernameTaken($username) {
        $result = dibi::query('SELECT username FROM [users] WHERE username=%s', $username);
        $rows = count($result);
        if ($rows == 0) {
            return false;
        } else {
            return true;
        }
    }

?>
