<?php require_once "bootstrap.php"?>
<?php include("layouts/frontend/header.php"); ?>
<?php include("layouts/frontend/nav.php"); ?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- ***************************** Side bar *****************************-->
        <div class="col-md-3">
            <p class="lead">Toys categories</p>
            <div class="list-group">
                <a href="#" class="list-group-item">Category 1</a>
                <a href="#" class="list-group-item">Category 2</a>
                <a href="#" class="list-group-item">Category 3</a>
            </div>
        </div>

        <!-- ***************************** Tool bar *****************************-->
        <div class="col-md-9">
            <div class="row">
                <form class="navbar-form" role="search">
                    <div class="input-group">
                        <div class=" dropdown input-group-btn search-panel ">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                <span id="search_concept">Filter by</span> <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#contains">Contains</a></li>
                                <li><a href="#its_equal">It's equal</a></li>
                                <li><a href="#greather_than">Greather than ></a></li>
                                <li><a href="#less_than">Less than < </a></li>
                                <li class="divider"></li>
                                <li><a href="#all">Anything</a></li>
                            </ul>
                        </div>
                        <input type="hidden" name="search_param" value="all" id="search_param">
                        <input type="text" class="form-control" name="x" placeholder="Search term...">
                    </div>
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </button>

                    <div class=" dropdown pull-right">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            <span id="search_concept">Sort by</span> <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#contains">Contains</a></li>
                            <li><a href="#its_equal">It's equal</a></li>
                            <li><a href="#greather_than">Greather than ></a></li>
                            <li><a href="#less_than">Less than < </a></li>
                            <li class="divider"></li>
                            <li><a href="#all">Anything</a></li>
                        </ul>
                    </div>
                </form>
            </div>
            <div class="list-group">
                <a href="#" class="list-group-item">
                    <div class="media pull-left">
                        <img class="media-object"
                             src="http://www.javabeat.net/wp-content/uploads/2014/03/amazing-300x214.jpg"
                             alt="amazing" height="100" width="100">
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading">&nbsp;Media Heading</h4>
                        <p class="list-group-item-text">&nbsp;&nbsp;Owner: &nbsp;</p>
                        <p class="list-group-item-text">&nbsp;&nbsp;Want: &nbsp;</p>
                        <p class="list-group-item-text">&nbsp;&nbsp;Upload time: &nbsp;</p>
                        <p class="list-group-item-text pull-right">Reviews</p>
                        <p></p>
                    </div>
                </a>
                <ul class="pagination pull-right">
                    <li class="disabled"><a href="#">&laquo;</a></li>
                    <li class="active"><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li><a href="#">&raquo;</a></li>
                </ul>
            </div>
        </div>

    </div>
</div>

<?php include("layouts/frontend/footer.php"); ?>
