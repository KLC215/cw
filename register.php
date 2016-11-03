<?php require_once "bootstrap.php"?>
<?php include("layouts/frontend/header.php"); ?>
<?php include("layouts/frontend/nav.php"); ?>

<div class="container">
    <form class="form-horizontal">
        <fieldset>
            <legend>Register</legend>
            <div class="form-group">
                <label for="username" class="col-lg-2 control-label">Username</label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" id="username" placeholder="Username">
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="col-lg-2 control-label">Password</label>
                <div class="col-lg-8">
                    <input type="password" class="form-control" id="password" placeholder="Password">
                </div>
            </div>
            <div class="form-group">
                <label for="cpassword" class="col-lg-2 control-label">Confirm Password</label>
                <div class="col-lg-8">
                    <input type="password" class="form-control" id="cpassword" placeholder="Confirm Password">
                </div>
            </div>
            <div class="form-group">
                <label for="cpassword" class="col-lg-2 control-label">Email</label>
                <div class="col-lg-8">
                    <input type="email" class="form-control" id="email" placeholder="Email">
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-default">Cancel</button>
                </div>
            </div>
        </fieldset>
    </form>
</div>


<?php include("layouts/frontend/footer.php"); ?>
