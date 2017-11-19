<?php
$error = "";
if (isset($_POST['signup'])) {
    include 'dbconnect.php';
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $repassword = mysqli_real_escape_string($conn, $_POST['repassword']);
// check for any empty fields
    if (empty($fname) || empty($lname) || empty($email) || empty($username) || empty($password) || empty($repassword)) {
        $error = 'Some fields are empty';
    } else {
//check for maximum and minimum size of fields
        if ((strlen($fname) > 32) || (strlen($lname) > 32) || (strlen($username) > 32) || (strlen($password) < 6)) {
            $error = 'Only 32 characters are allowed.<br>Password should be minimum 6 characters long.';
        } else {
//check that only characters are entered at firstname and lastname field
            if (!preg_match("/^[a-zA-Z]*$/", $fname) || !preg_match("/^[a-zA-Z]*$/", $lname)) {
                $error = 'First name or Last name must contains only Alphabets';
            } else {
//check that only alphanumeric characters are entered in username
                if (!preg_match("/^[a-zA-Z0-9_.]*$/", $username)) {
                    $error = 'Username must only contain Alphanumeric characters.';
                } else {
// verify that e-mail address is valid
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $error = 'Email is not valid.';
                    } else {
//check that password and confirmation passwords are safe
                        if ($password != $repassword) {
                            $error = 'Password does not match.';
                        } else {
// select records of user from database to check if the entered username is already alloted or not
// if not assigned then new user can be created otherwise prompt to enter other username
                            $query = "SELECT * FROM user WHERE uname=?";
                            $stmt = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($stmt, $query)) {
                                $error = "Internal Error.";
                            } else {
                                mysqli_stmt_bind_param($stmt, "s", $username);
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);
// with selected username, if any records found in database, that means username is already taken
                                if (mysqli_num_rows($result) > 0) {
                                    $error = 'Username already taken.';
                                } else {
//hashed password is used to store password in database for more security
                                    $hashPass = password_hash($password, PASSWORD_DEFAULT);
                                    $query = "INSERT INTO user(fname, lname, email, uname, pass)";
                                    $query .= "VALUES (?, ?, ?, ?, ?)";
                                    $stmt2 = mysqli_stmt_init($conn);
                                    if (!mysqli_stmt_prepare($stmt2, $query)) {
                                        $error = "Internal Error.";
                                    } else {
                                        mysqli_stmt_bind_param($stmt2, "sssss", $fname, $lname, $email, $username, $hashPass);
//if data can not be written in database then throw errors otherwise start new session and and redirect to members page
                                        if (mysqli_stmt_execute($stmt2)) {
                                            $_SESSION['username'] = $username;
                                            $_SESSION['email'] = $email;
                                            $_SESSION['fname'] = $fname;
                                            $_SESSION['lname'] = $lname;
                                            $_SESSION['logged_in'] = true;
                                            header("location: home.php");
                                        } else {
                                            $error = 'Internal errors, please try after some time.';
                                        }
                                    } // 2nd prepare stmt else closed
                                } // existance of username check else closed
                            } // 1st prepare stmt else closed
                        } // both password match else closed
                    } // email validation else closed
                } // character verification for username else closed
            } // character in fname and lname check else closed
        } // string length else closed
    } // empty else closed
} // submit if closed
