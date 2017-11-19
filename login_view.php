<?php
session_start();
if (isset($_SESSION['logged_in'])) {
    header("location: home.php");
}
include 'include/login_c.php';
include 'header.php';
?>
<div class="row">
    <div class="col col-md-2 col-md-offset-5">
        <?=$error;?>
        <form method="POST" action="<?=$_SERVER['PHP_SELF'];?>">
            <div class="form-horizontal">
                <div class="form-group">
                    <label class="control-label">Username</label>
                    <div class="form-group">
                        <input type="text" name="username" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label">Password</label>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <input type="submit" name="login" class="btn btn-primary" value="Login">
                </div>
            </div>
        </form>
    </div>
</div>
<?php include 'footer.php'; ?>
