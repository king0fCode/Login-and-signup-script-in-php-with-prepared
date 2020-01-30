<?php
session_start();
if (isset($_SESSION['logged_in'])) {
    header("location: home.php");
}
include 'include/signup_c.php';
include 'header.php';
?>
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <?='<h4 class="alert-danger">'.$error.'</h4>';?>
        <form method="POST" action="<?=$_SERVER['PHP_SELF'];?>">
            <div class="form-horizontal">
                <div class="form-group">
                    <label class="control-label">First Name</label>
                    <input type="text" class="form-control" name="fname" placeholder="First Name">
                </div>
                <div class="form-group">
                    <label class="control-label">Last Name</label>
                    <input type="text" class="form-control" name="lname" placeholder="Last Name">
                </div>
                <div class="form-group">
                    <label class="control-label">Email Id</label>
                    <input type="email" class="form-control" name="email" placeholder="Email">
                </div>
                <div class="form-group">
                    <label class="control-label">Username</label>
                    <input type="text" class="form-control" name="username" placeholder="Username">
                </div>
                <div class="form-group">
                    <label class="control-label">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Password">
                </div>
                <div class="form-group">
                    <label class="control-label">Re-type Password</label>
                    <input type="password" class="form-control" name="repassword" placeholder="Password">
                </div>
                <button type="submit" name="signup" class="btn btn-primary">SignUP</button>
            </div>
        </form>
    </div>
</div>
<?php include 'footer.php'; ?>
