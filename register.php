<?php require_once "bootstrap.php" ?>
<?php include("db.member.php"); ?>
<?php include("layouts/frontend/header.php"); ?>
<?php include("layouts/frontend/nav.php"); ?>

<!-- ***************************** Register process *****************************-->
<?php

$user_type = 1;
$result = "";
$errName = "";
$errPwd = "";
$errCPwd = "";
$errEmail = "";
$errMobile = "";

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];

    if (!$username) {
        $errName = "Please enter username !";
    }
    if (!$password) {
        $errPwd = "Please enter password !";
    }
    if (strcmp($password, $cpassword) !== 0 || !$cpassword) {
        $errCPwd = "Password must be the same !";
    }
    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errEmail = "Please enter a valid email address !";
    }

    if(!$mobile){
        $errMobile = "Please enter your mobile number !";
    }

    if(!is_numeric($mobile)) {
        $errMobile = "Please enter a valid mobile number !";
    }

    if (!$errName && !$errPwd && !$errCPwd && !$errEmail && !$errMobile) {
        $result = register($username, $email, $mobile, md5($password), $user_type);
        unset($_POST);
    }
}
?>

<!-- ***************************** Register *****************************-->
<div class="container well well-lg">
    <?php echo $result; ?>
    <form method="post" action="<?php echo DIR; ?>register.php" class="form-horizontal">
        <fieldset>
            <legend>Register</legend>
            <div class="form-group">
                <label for="username" class="col-lg-2 control-label">Username</label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" name="username" id="username" placeholder="Username"
                           maxlength="32" value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>">
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
                <label for="cpassword" class="col-lg-2 control-label">Confirm Password</label>
                <div class="col-lg-8">
                    <input type="password" class="form-control" name="cpassword" id="cpassword"
                           placeholder="Confirm Password">
                    <?php echo "<p class='text-danger'>$errCPwd</p>"; ?>
                </div>
            </div>
            <div class="form-group">
                <label for="cpassword" class="col-lg-2 control-label">Email</label>
                <div class="col-lg-8">
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email"
                           value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>">
                    <?php echo "<p class='text-danger'>$errEmail</p>"; ?>
                </div>
            </div>
            <div class="form-group">
                <label for="mobile" class="col-lg-2 control-label">Mobile</label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Mobile"
                           value="<?php if (isset($_POST['mobile'])) echo $_POST['mobile']; ?>" maxlength="8">
                    <?php echo "<p class='text-danger'>$errMobile</p>"; ?>
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

<script>
    $("#username").keypress(function (event) {
        var ew = event.which;
        if (48 <= ew && ew <= 57)
            return true;
        if (65 <= ew && ew <= 90)
            return true;
        if (97 <= ew && ew <= 122)
            return true;
        return false;
    });

    $("#mobile").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
            // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
            // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

</script>


<?php include("layouts/frontend/footer.php"); ?>
