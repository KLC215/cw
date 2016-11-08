<?php require_once "bootstrap.php" ?>
<?php include("layouts/frontend/header.php"); ?>
<?php include("layouts/frontend/nav.php"); ?>
<?php include("db.toy.php"); ?>

<?php
if (isset($_GET['act'])) {
    switch (base64_decode(urldecode($_GET['act']))) {
        case "logout":
            echo "<script>swal('Bye!', 'Logout successful!', 'success');</script>";
            unset($_GET);
            break;
        case "delete":
            echo '<script>swal("Deleted!", "The toy has been deleted.", "success");</script>';
            unset($_GET);
            break;
    }
}

?>

<?php
$error = "";
$pageSize = 5;
$result = countToys();
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

$searchResult = null;
$sortResult = null;

if (isset($_GET['search_param']) && isset($_GET['x'])) {
    if ($_GET['x'] == '') {
        $error = "Please enter keyword of the filter!";
    } else {
        switch ($_GET['search_param']) {
            case "owners":
                $result = countToysOwner('member_id', $_GET['x']);
                $toyCount = mysqli_fetch_row($result)[0];
                $pageCount = ceil($toyCount / $pageSize);
                $searchResult = searchToy('member.username', $_GET['x'], $startNumber, $pageSize);
                break;
            case "toy":
                $result = countToys($_GET['x']);
                $toyCount = mysqli_fetch_row($result)[0];
                $pageCount = ceil($toyCount / $pageSize);
                $searchResult = searchToy('toy.toy', $_GET['x'], $startNumber, $pageSize);
                break;
            case "category":
                $result = countToyCategory($_GET['x']);
                $toyCount = mysqli_fetch_row($result)[0];
                $pageCount = ceil($toyCount / $pageSize);
                $searchResult = searchToy('toy.category_id', $_GET['x'], $startNumber, $pageSize);
                break;
        }
    }
}
?>
<?php
function isActive($pageNumber, $selectedPage)
{
    return strcmp($pageNumber, $selectedPage) === 0
        ? 'active'
        : '';
}

?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <?php include("layouts/frontend/sidebar.php"); ?>

        <!-- ***************************** Tool bar *****************************-->
        <div class="col-md-9">
            <div class="row">
                <div class=" dropdown pull-right">
                    <a href="<?php echo DIR; ?>item_toy_create.php">
                        <button class="btn btn-success pull-right">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            New Exchange
                        </button>
                    </a>
                </div>
                <p class="text-danger"><?php echo $error; ?></p>
                <form class="navbar-form" role="search">
                    <div class="input-group">
                        <div class=" dropdown input-group-btn search-panel ">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                <span id="search_concept">Filter by</span> <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="#owners">
                                        <i class="fa fa-users" aria-hidden="true"></i>&nbsp;Owner
                                    </a>
                                </li>
                                <li>
                                    <a href="#toy">
                                        <i class="fa fa-product-hunt" aria-hidden="true"></i>&nbsp;Toy
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <input type="hidden" name="search_param" value="all" id="search_param">
                        <input type="text" class="form-control" name="x" placeholder="Search term...">
                    </div>
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                </form>
            </div>
            <div class="list-group">
                <?php
                if (isset($_GET['search_param']) && isset($_GET['x'])) {
                    if ($searchResult) {
                        while ($row = mysqli_fetch_object($searchResult)) {
                            echo '<a href="' . DIR . 'item_toy_view.php?id=' . urlencode(base64_encode($row->id)) . '" class="list-group-item">
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
                        echo '<ul class="pagination pull-right">';
                        for ($i = 1; $i <= $pageCount; $i++) {
                            echo '<li class="' . isActive($pageNumber, $i) . '">
                                            <a href="?search_param=' . $_GET['search_param'] . '&x=' . $_GET['x'] . '&page=' . $i . '">' . $i . '</a></li>';
                        }
                        echo '</ul>';
                    }
                } else {
                    $toys = retrieveToy($startNumber, $pageSize);
                    if ($toys) {
                        while ($row = mysqli_fetch_object($toys)) {
                            echo '<a href="' . DIR . 'item_toy_view.php?id=' . urlencode(base64_encode($row->id)) . '" class="list-group-item">
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
                        echo '<ul class="pagination pull-right">';
                        for ($i = 1; $i <= $pageCount; $i++) {
                            echo '<li class="' . isActive($pageNumber, $i) . '">
                                            <a href="?page=' . $i . '">' . $i . '</a></li>';
                        }
                        echo '</ul>';
                    }
                }
                ?>
            </div>
        </div>

    </div>
</div>

<?php include("layouts/frontend/footer.php"); ?>
