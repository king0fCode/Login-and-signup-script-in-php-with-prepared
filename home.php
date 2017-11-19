<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header("location: index.php");
}
if (isset($_POST['logout'])) {
    unset($_SESSION['logged_in']);
    unset($_SESSION['fname']);
    unset($_SESSION['lname']);
    unset($_SESSION['username']);
    unset($_SESSION['email']);
    header("location: index.php");
}
include 'header.php';
?>
<form method="POST" action="<?=$_SERVER['PHP_SELF'];?>">
    <button type="submit" name="logout" class="btn btn-danger">Logout</button>
</form>
<?php include 'footer.php'; ?>
