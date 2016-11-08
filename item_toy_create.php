<?php require_once "bootstrap.php" ?>

    <!-- ***************************** Login checking *****************************-->
<?php

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location:" . DIR . "login.php");
}

?>
<?php include("layouts/frontend/header.php"); ?>
<?php include("layouts/frontend/nav.php"); ?>
<?php include("db.category.php"); ?>
<?php include("db.toy.php"); ?>

    <!-- ***************************** newExchange process *****************************-->
<?php
$result = "";
$errToy = "";
$errCategory = "";

if (isset($_POST['submit'])) {

    $toy = $_POST['toy'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $expectToChange = $_POST['expectToChange'];

    if (!$toy) {
        $errToy = "Please enter the name of the toy !";
    }
    if (!$category || $category == 0) {
        $errCategory = "Please choose a category of the toy !";
    }
    if (!$description) {
        $description = "This guy is so lazy !  XD";
    }
    if (!$expectToChange) {
        $expectToChange = "Any toys";
    }

    if (!$errToy && !$errCategory) {
        include('class.uploader.php');

        $uploader = new Uploader();
        $upload = $uploader->upload($_FILES['photos'], [
            'limit'       => 3,
            'maxSize'     => 8,
            'extensions'  => ["jpg", "png", "jpeg", "PNG", "JPG"],
            'required'    => true,
            'uploadDir'   => 'uploads/',
            'title'       => ['auto', 32],
            'removeFiles' => true,
            'replace'     => true,
            'perms'       => null,
            'onCheck'     => null,
            'onError'     => null,
            'onSuccess'   => null,
            'onUpload'    => null,
            'onComplete'  => null,
            'onRemove'    => null,
        ]);

        if ($upload['isComplete']) {
            $files = [];

            for ($i = 0; $i < sizeof($upload['data']['metas']); $i++) {
                $files[] = $upload['data']['metas'][$i]['file'];
            }
            //var_dump($files);
            $result = addToy($toy, $description, $expectToChange, $category, $files);
            unset($_POST);
        }

        if ($upload['hasErrors']) {
            $errors = $upload['errors'];
            $result = "<div class=\"alert alert-dismissible alert-danger\">
               <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
                " . $error[0][0] . "
            </div>";
        }
    }
}

?>

<?php
function isSelected($id)
{
    if (isset($_POST['category'])) {
        return strcmp($_POST['category'], $id) === 0
            ? 'selected'
            : '';
    }
}

?>
    <!-- ***************************** Login *****************************-->
    <div class="container well well-lg">

        <?php echo $result; ?>
        <form method="post" action="<?php echo DIR; ?>item_toy_create.php" class="form-horizontal"
              enctype="multipart/form-data">
            <fieldset>
                <legend>New toy exchange</legend>
                <div class="form-group">
                    <label for="toy" class="col-lg-2 control-label">Toy Name</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="toy" id="toy"
                               value="<?php if (isset($_POST['toy'])) echo $_POST['toy']; ?>" placeholder="Toy Name">
                        <?php echo "<p class='text-danger'>$errToy</p>"; ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="select" class="col-lg-2 control-label">Category</label>
                    <div class="col-lg-8">
                        <select class="form-control" name="category" id="select">
                            <option value="0">Choose a category of toy</option>
                            <?php
                            $categories = retrieveCategory();
                            while ($row = mysqli_fetch_array($categories)) {
                                echo '<option ' . isSelected($row['id']) . ' value="' . $row['id'] . '">' . $row['name'] . '</option>';
                            }
                            ?>
                        </select>
                        <?php echo "<p class='text-danger'>$errCategory</p>"; ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="description" class="col-lg-2 control-label">Description</label>
                    <div class="col-lg-8">
                        <textarea class="form-control" rows="3" name="description"
                                  id="description"><?php if (isset($_POST['description'])) echo $_POST['description']; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="expectToChange" class="col-lg-2 control-label">Except to Change</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="expectToChange" id="expectToChange"
                               placeholder="Empty if you want to change anything"
                               value="<?php if (isset($_POST['expectToChange'])) echo $_POST['expectToChange']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="description" class="col-lg-2 control-label">Upload Photos</label>
                    <div class="col-lg-8">
                        <input type="file" id="photo" name="photos[]" multiple="multiple">
                        <br>Maximum <strong>3</strong> photos can be uploaded.<br>
                        Maximum size for each photo is <strong>2MB</strong>.<br>
                        Only accept <strong>.jpg & .png</strong> format.<br>
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