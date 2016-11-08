<?php require_once "bootstrap.php" ?>

    <!-- ***************************** Login checking *****************************-->
<?php

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location:" . DIR . "login.php");
}

?>
<?php include("layouts/frontend/header.php"); ?>
<?php include("layouts/frontend/nav.php"); ?>
<?php include("db.member.php"); ?>

    <!-- ***************************** Profile process *****************************-->
<?php
$user;
$result = "";
$errPwd = "";
$errCPwd = "";
$errCNewPwd = "";
$errOldPwd = "";
$errNewPwd = "";
$errEmail = "";

if (isset($_SESSION['userId'])) {
    $data = getUser($_SESSION['userId']);
    if ($data) {
        while ($row = mysqli_fetch_object($data)) {
            $user = $row;
        }
    }
}

if (isset($_POST['submit'])) {

    switch (base64_decode(urldecode($_GET['a']))) {
        case 'email':
            $newEmail = $_POST['newEmail'];
            $cpasswordForEmail = $_POST['cpasswordForEmail'];

            if (!$newEmail || !filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
                $errEmail = "Please enter a valid email address !";
            }
            if(!$cpasswordForEmail) {
                $errCPwd = "You need to enter password to update the email !";
            }
            if (confirmPassword($_SESSION['userId'], md5($cpasswordForEmail))) {
                $result = updateMember($_SESSION['userId'], 'email', $newEmail);
            } else {
                $errCPwd = "The password is not correct !";
            }
            break;
        case 'password':
            $oldPassword = $_POST['oldPassword'];
            $newPassword = $_POST['newPassword'];
            $cpasswordForPwd = $_POST['cpasswordForPwd'];

            if(!$oldPassword && !$newPassword && !$cpasswordForPwd) {
                $errOldPwd = 'You need to enter old password to change the password !';
                $errNewPwd = 'You need to enter new password to change the password !';
                $errCNewPwd = 'You need to confirm new password to change the password !';
            }
            if(strcmp($newPassword, $cpasswordForPwd) !== 0) {
                $errCNewPwd = 'New password must be the same !';
            }
            if(confirmPassword($_SESSION['userId'], md5($oldPassword))) {
                $result = updateMember($_SESSION['userId'], 'password', md5($newPassword));
            } else {
                $errOldPwd = 'You need to enter old password to change the password !';
            }
            break;
    }
}
?>

    <!-- ***************************** Register *****************************-->
    <div class="container well well-lg">
        <?php echo $result; ?>
        <form method="post" action="" class="form-horizontal">
            <fieldset>
                <legend>Profile</legend>
                <div class="form-group">
                    <label for="username" class="col-lg-2 control-label">Username</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="username" id="username" disabled
                               maxlength="32" value="<?php echo $user->username; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="col-lg-2 control-label">Created At</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="username" id="username" disabled
                               maxlength="32" value="<?php echo $user->created_at; ?>">
                    </div>
                </div>
                <hr>
                <div class="form-group text-center">
                    <a href="<?php echo DIR; ?>profile.php?a=<?php echo urlencode(base64_encode('email')); ?>"
                       class="btn btn-info">Update Email Address</a>
                    <a href="<?php echo DIR; ?>profile.php?a=<?php echo urlencode(base64_encode('password')); ?>"
                       class="btn btn-info">Change password</a>
                </div>
        </form>
        <hr>
        <?php if (isset($_GET['a']) && 'email' == base64_decode(urldecode($_GET['a']))) { ?>
            <form method="post"
                  action="<?php echo DIR; ?>profile.php?a=<?php echo urlencode(base64_encode('email')); ?>"
                  class="form-horizontal">
                <div class="form-group">
                    <label for="cpassword" class="col-lg-2 control-label">Old Email</label>
                    <div class="col-lg-8">
                        <input type="email" class="form-control" name="oldEmail" id="email" placeholder="Email"
                               disabled
                               value="<?php echo $user->email ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="cpassword" class="col-lg-2 control-label">New Email</label>
                    <div class="col-lg-8">
                        <input type="email" class="form-control" name="newEmail" id="email" placeholder="Email">
                        <?php echo "<p class='text-danger'>$errEmail</p>"; ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="cpassword" class="col-lg-2 control-label">Confirm Password</label>
                    <div class="col-lg-8">
                        <input type="password" class="form-control" name="cpasswordForEmail" id="cpassword"
                               placeholder="Confirm Password">
                        <?php echo "<p class='text-danger'>$errCPwd</p>"; ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        <button type="submit" name="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        <?php } ?>
        <?php if (isset($_GET['a']) && 'password' == base64_decode(urldecode($_GET['a']))) { ?>
            <form method="post"
                  action="<?php echo DIR; ?>profile.php?a=<?php echo urlencode(base64_encode('password')); ?>"
                  class="form-horizontal">
                <div class="form-group">
                    <label for="password" class="col-lg-2 control-label">Old Password</label>
                    <div class="col-lg-8">
                        <input type="password" class="form-control" name="oldPassword" id="password"
                               placeholder="Password">
                        <?php echo "<p class='text-danger'>$errOldPwd</p>"; ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-lg-2 control-label">New Password</label>
                    <div class="col-lg-8">
                        <input type="password" class="form-control" name="newPassword" id="password"
                               placeholder="Password">
                        <?php echo "<p class='text-danger'>$errNewPwd</p>"; ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="cpassword" class="col-lg-2 control-label">Confirm New Password</label>
                    <div class="col-lg-8">
                        <input type="password" class="form-control" name="cpasswordForPwd" id="cpassword"
                               placeholder="Confirm Password">
                        <?php echo "<p class='text-danger'>$errCNewPwd</p>"; ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        <button type="submit" name="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        <?php } ?>

        </fieldset>
        </form>
    </div>

<?php include("layouts/frontend/footer.php"); ?>