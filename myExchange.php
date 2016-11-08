<?php require_once "bootstrap.php" ?>

    <!-- ***************************** My Exchange checking *****************************-->
<?php

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location:" . DIR . "login.php");
}

?>
<?php include("layouts/frontend/header.php"); ?>
<?php include("layouts/frontend/nav.php"); ?>
<?php include("db.toy.php"); ?>

    <!-- ***************************** My Exchange process *****************************-->
<?php
$error = "";
$pageSize = 5;
$result = countToys(null, $_SESSION['userId']);
$toyCount = mysqli_fetch_row($result)[0];
$pageCount = ceil($toyCount / $pageSize);

$pageNumber = isset($_GET['page']) ? $_GET['page'] : 1;

if ($pageNumber <= 1) {
    $pageNumber = 1;
}
if ($pageNumber >= $pageCount) {
    $pageNumber = $pageCount;
}

$startNumber = ($pageNumber - 1) * $pageSize;

function isActive($pageNumber, $selectedPage)
{
    return strcmp($pageNumber, $selectedPage) === 0
        ? 'active'
        : '';
}

?>
    <!-- ***************************** My Exchange *****************************-->
    <div class="container well well-lg">
        <fieldset>
        <legend>My Exchange</legend>
        <div class="list-group">
            <?php
            $toys = searchMyExchange($_SESSION['userId'], $startNumber, $pageSize);
            if ($toys) {
                while ($row = mysqli_fetch_object($toys)) {
                    if ($row->status_id != 1) {
                        echo '<div class="list-group-item">
                            <div class="media pull-left">
                                <img class="media-object"
                                     src="' . DIR . $row->url . '"
                                     alt="amazing" height="100" width="100">
                            </div>
                            
                            <div class="media-body">
                                <h4 class="media-heading">&nbsp;' . $row->toy . '</h4>
                                <p class="list-group-item-text">&nbsp;&nbsp;Owner: <b>' . $row->username . '</b>&nbsp;</p>
                                <p class="list-group-item-text">&nbsp;&nbsp;Want: <b>' . $row->expect_to_change . '</b>&nbsp;</p>
                                <p class="list-group-item-text">&nbsp;&nbsp;Upload time: <b>' . $row->created_at . '</b>&nbsp;</p>
                                <p class="list-group-item-text">&nbsp;&nbsp;Status: <b><span class="label label-success">' . $row->name . '</b></span>&nbsp;</p>
                                <p class="list-group-item-text pull-right"><a id="del" href="' . DIR . 'item_toy_view.php?id=' . urlencode(base64_encode($row->id)) . '&del=1" class="btn btn-danger">Delete</a></p>
                            </div>
                        </div>';
                    } else {
                        echo '<a href="' . DIR . 'item_toy_view?id=' . urlencode(base64_encode($row->id)) . '" class="list-group-item">
                            <div class="media pull-left">
                                <img class="media-object"
                                     src="' . DIR . $row->url . '"
                                     alt="amazing" height="100" width="100">
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">&nbsp;' . $row->toy . '</h4>
                                <p class="list-group-item-text">&nbsp;&nbsp;Owner: <b>' . $row->username . '</b>&nbsp;</p>
                                <p class="list-group-item-text">&nbsp;&nbsp;Want: <b>' . $row->expect_to_change . '</b>&nbsp;</p>
                                <p class="list-group-item-text">&nbsp;&nbsp;Upload time: <b>' . $row->created_at . '</b>&nbsp;</p>
                                <p class="list-group-item-text">&nbsp;&nbsp;Status: <b><span class="label label-success">' . $row->name . '</b></span>&nbsp;</p>
                                <p class="list-group-item-text pull-right"><b>' . $row->click_rate . '</b>&nbsp;Reviews</p>
                                <p></p>
                            </div>
                        </a>';
                    }
                }
                echo '<ul class="pagination pull-right">';
                for ($i = 1; $i <= $pageCount; $i++) {
                    echo '<li class="' . isActive($pageNumber, $i) . '">
                                            <a href="?page=' . $i . '">' . $i . '</a></li>';
                }
                echo '</ul>';

            }
            ?>
        </div>
        </fieldset>
    </div>

<?php include("layouts/frontend/footer.php"); ?>