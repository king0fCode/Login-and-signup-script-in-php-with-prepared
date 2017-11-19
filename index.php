<?php include 'header.php';
session_start();
if (isset($_SESSION['logged_in'])) {
    header("location: home.php");
}
?>
<div class="row">
    <h3 class="col-md-1 col-md-offset-5"><a class="btn btn-primary" href="login_view.php">Login</a></h3>
    <h3><a class="btn btn-success" href="signup_view.php">SignUp</a></h3>
</div>
<?php include 'footer.php'; ?>
