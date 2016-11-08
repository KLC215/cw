<?php require_once "bootstrap.php" ?>
<?php include("layouts/frontend/header.php"); ?>
<?php include("layouts/frontend/nav.php"); ?>
<?php include("db.toy.php"); ?>
<?php
if (isset($_GET['id'])) {
    $itemId = base64_decode(urldecode($_GET['id']));
    addClickRate($itemId);

    if (isset($_GET['del']) && $_GET['del'] == 1) {
        $result = deleteToy($_GET['id']);
        if ($result) {
            header("Location:" . DIR . "?act=" . urlencode(base64_encode("delete")));
        }
    }
}
?>

<?php
$item = getToy(base64_decode(urldecode($_GET['id'])));
$toy = [];
?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <?php include("layouts/frontend/sidebar.php"); ?>

        <!-- ***************************** Item *****************************-->
        <div class="col-md-9">
            <?php
            while ($row = mysqli_fetch_array($item)) {
                $toy[] = $row;
            }
            ?>
            <div class="row">
                <div class="media pull-right">
                    <?php
                    for ($i = 0; $i < sizeof($toy); $i++) {
                        echo '<a href="' . $toy[$i]['url'] . '" data-lightbox="toy"><img class="media-object"
                             src="' . $toy[$i]['url'] . '"
                             height="100" width="100"></a>';
                    }
                    ?>
                </div>
                <div class="media-body">
                    <h4><strong><?php echo $toy[0]['toy']; ?></strong></h4>
                    <table class="table table-striped table-hover ">
                        <tr>
                            <td><strong>Owner:</strong></td>
                            <td><?php echo $toy[0]['username']; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Description:</strong></td>
                            <td><?php echo $toy[0]['description']; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Want:</strong></td>
                            <td><?php echo $toy[0]['expect_to_change']; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Upload at:</strong></td>
                            <td><?php echo $toy[0]['created_at']; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td><span class="label label-success"><?php echo $toy[0]['name']; ?></span></td>
                        </tr>
                    </table>
                    <hr>
                    <?php
                    if (isset($_SESSION['userId']) && ($_SESSION['userId'] != $toy[0]['member_id'])) {
                        echo '<p class="text-primary"><a href="' . DIR . 'request_exchange.php?id=' . $_GET['id'] . '" class="btn btn-warning">I want to exchange !</a></strong></p>';
                    }
                    ?>
                    <?php
                    if (isset($_SESSION['userId']) && $toy[0]['member_id']) {
                        if ($toy[0]['member_id'] == $_SESSION['userId']) {
                            echo '<p class="text-primary pull-right"><strong><a id="del" href="' . DIR . 'item_toy_view.php?id=' . $_GET['id'] . '&del=1" class="btn btn-danger">Delete</a></strong></p>
                                   <p class="text-primary pull-right"><a href="' . DIR . 'item_toy_edit.php?id=' . $_GET['id'] . '" class="btn btn-info">Edit</a></strong></p>';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("layouts/frontend/footer.php"); ?>
