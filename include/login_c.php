<?php
$error = "";
require("dbconnect.php");
if (isset($_POST['login'])) {
    $username = mysqli_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
// check for any empty fields
    if (empty($username) || empty($password)) {
        $error = "Please provide Username and Password.";
    } else {
//check that only alphanumeric characters are entered in username for better security
        if (!preg_match("/^[a-zA-Z0-9_.]*$/", $username)) {
            $error = 'Username must only contain Alphanumeric characters.';
        } else {
// query to get data of entered username as usernam or email
            $query = "SELECT * from user WHERE uname = ? OR email = ? limit 0,1";
            $stmtlog = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmtlog, $query)) {
                $error = "Internal Errors.";
            } else {
                mysqli_stmt_bind_param($stmtlog, "ss", $username, $username);
                mysqli_stmt_execute($stmtlog);
                $result = mysqli_stmt_get_result($stmtlog);
// check that data exist in database, if not then throw error
                if (mysqli_num_rows($result) < 1) {
                    $error = "Please fill correct Username";
                } else {
                    if ($row = mysqli_fetch_assoc($result)) {
// verify password and store result
                        $passCheck = password_verify($password, $row['pass']);
// if password check failed show errors otherwise add data in session and redirect to member home page
                        if ($passCheck) {
                            $_SESSION['username'] = $username;
                            $_SESSION['email'] = $row['email'];
                            $_SESSION['fname'] = $row['fname'];
                            $_SESSION['lname'] = $row['lname'];
                            $_SESSION['logged_in'] = true;
                            header("location: home.php");
                        } else {
                            $error = "Please fill correct Password";
                        }
                    } else {
                        $error = "Internal Errors";
                    }
                } // username check else closed
            } // prepare stmt else closed
        } // character check for username else closed
    } // empty else closed
} // submit check else closed
