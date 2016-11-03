<?php require_once "bootstrap.php" ?>

    <!-- ***************************** Login checking *****************************-->
<?php

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location:" . DIR . "login.php");
}

?>

<?php include("layouts/frontend/header.php"); ?>
<?php include("layouts/frontend/nav.php"); ?>


    <!-- ***************************** Exchange process *****************************-->
<?php

$result = "";
$errName = "";
$errPhoto = "";

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
        <form method="post" action="<?php echo DIR; ?>newExchange.php" class="form-horizontal"
              enctype="multipart/form-data">
            <fieldset>
                <legend>New toy exchange</legend>
                <div class="form-group">
                    <label for="toy" class="col-lg-2 control-label">Toy Name</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="toy" id="toy" placeholder="Toy Name">
                        <?php echo "<p class='text-danger'>$errName</p>"; ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="description" class="col-lg-2 control-label">Description</label>
                    <div class="col-lg-8">
                        <textarea class="form-control" rows="3" name="description" id="description"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="expectToChange" class="col-lg-2 control-label">Except to Change</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="expectToChange" id="expectToChange"
                               placeholder="Empty if you want to change anything">
                    </div>
                </div>
                <div class="form-group">
                    <label for="description" class="col-lg-2 control-label"></label>
                    <div class="col-lg-8">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">Upload Photos</h3>
                            </div>
                            <div class="panel-body">
                                <input type="file" name="photos" id="file" value="Upload photos">

                            </div>
                        </div>
                        Maximum <strong>3</strong> photos can be uploaded.<br>
                        Maximum size for each photo is <strong>1MB</strong>.<br>
                        Only accept <strong>.jpg</strong> format.<br>
                        <?php echo "<p class='text-danger'>$errPhoto</p>"; ?>
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