<?php include("db.category.php"); ?>
<!-- ***************************** Side bar *****************************-->
<div class="col-md-3">
    <p class="lead"><a href="<?php echo DIR; ?>">All categories</a></p>
    <div class="list-group">
        <?php
        $category = retrieveCategory();
        while ($row = mysqli_fetch_object($category)) {
            echo '<a href="' . DIR . '?search_param=category&x=' . $row->id . '" class="list-group-item">' . $row->name . '</a>';
        }
        ?>
    </div>
</div>