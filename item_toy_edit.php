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


    $id = base64_decode(urldecode($_GET['id']));
    $toy = $_POST['toy'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $expectToChange = $_POST['expectToChange'];

    if (!$id) {
        $result = "Oops...Something goes wrong !";
    }
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
        $result = updateToy($id, $toy, $category, $description, $expectToChange);
    } else {
        $result = "Oops...Something goes wrong !";
    }

}

?>

<?php

$toy = [];

if (isset($_GET['id'])) {
    $item = getToy(base64_decode(urldecode($_GET['id'])));
    while ($row = mysqli_fetch_array($item)) {
        $toy[] = $row;
    }
}

function isSelected($id, $newId)
{
    if (isset($_POST['category'])) {
        return strcmp($_POST['category'], $id) === 0
            ? 'selected'
            : '';
    } else {
        return strcmp($newId, $id) === 0
            ? 'selected'
            : '';
    }
}
?>
    <!-- ***************************** Login *****************************-->
    <div class="container well well-lg">

        <?php echo $result; ?>
        <form method="post" action="<?php echo DIR; ?>item_toy_edit.php?id=<?php echo $_GET['id'] ?>"
              class="form-horizontal"
              enctype="multipart/form-data">
            <fieldset>
                <legend>Edit page</legend>
                <div class="form-group">
                    <label for="toy" class="col-lg-2 control-label">Toy Name</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="toy" id="toy"
                               value="<?php if (isset($toy[0]['toy'])) echo $toy[0]['toy']; ?>" placeholder="Toy Name">
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
                                echo '<option ' . isSelected($row['id'], $toy[0]['category_id']) . ' value="' . $row['id'] . '">' . $row['name'] . '</option>';
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
                                  id="description"><?php if (isset($toy[0]['description'])) echo $toy[0]['description']; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="expectToChange" class="col-lg-2 control-label">Except to Change</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="expectToChange" id="expectToChange"
                               placeholder="Empty if you want to change anything"
                               value="<?php if (isset($toy[0]['expect_to_change'])) echo $toy[0]['expect_to_change']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>

<?php include("layouts/frontend/footer.php"); ?>