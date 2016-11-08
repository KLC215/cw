<?php require_once "bootstrap.php" ?>
<?php include("db.member.php"); ?>
<?php include("layouts/frontend/header.php"); ?>
<?php include("layouts/frontend/nav.php"); ?>

<!-- ***************************** Login process *****************************-->
<?php

$result = "";
$errName = "";
$errPwd = "";

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!$username) {
        $errName = "Please enter username !";
    }
    if (!$password) {
        $errPwd = "Please enter password !";
    }
    if (!$errName && !$errPwd) {
        $result = login($username, md5($password));
        unset($_POST);
    }
}

?>


<!-- ***************************** Login *****************************-->
<div class="container well well-lg">
    <?php echo $result; ?>
    <form method="post" action="<?php echo DIR; ?>login.php" class="form-horizontal">
        <fieldset>
            <legend>Login</legend>
            <div class="form-group">
                <label for="username" class="col-lg-2 control-label">Username</label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" name="username" id="username" placeholder="Username">
                    <?php echo "<p class='text-danger'>$errName</p>"; ?>
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="col-lg-2 control-label">Password</label>
                <div class="col-lg-8">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                    <?php echo "<p class='text-danger'>$errPwd</p>"; ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2">
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-default">Reset</button>
                </div>
            </div>
        </fieldset>
    </form>
</div>


<?php include("layouts/frontend/footer.php"); ?>
