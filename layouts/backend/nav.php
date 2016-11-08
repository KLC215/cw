<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toys Exchange Admin Panel</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo DIR ?>">Toys Exchange Admin Panel</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <?php if (isset($_SESSION['login']) && isset($_SESSION['username'])) { ?>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="<?php echo DIR; ?>logout.php">
                            <i class="fa fa-sign-out" aria-hidden="true"></i>
                            Logout
                        </a>
                    </li>
                </ul>
                <!--<ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="<?php /*echo DIR; */ ?>">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <?php /*echo $_SESSION['username']; */ ?>
                        </a>
                    </li>
                </ul>-->
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <?php echo $_SESSION['username']; ?>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu panel">
                            <li class="list-group-item">
                                <a href="<?php echo DIR; ?>profile.php"><i class="fa fa-address-card" aria-hidden="true"></i>&nbsp;My
                                    Profile</a>
                                <a href="<?php echo DIR; ?>myExchange.php"><i class="fa fa-exchange" aria-hidden="true"></i>&nbsp;My Exchange</a>
                                <a href="<?php echo DIR; ?>private_message.php"><i class="fa fa-commenting" aria-hidden="true"></i>&nbsp;Private Message</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            <?php } else { ?>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="<?php echo DIR; ?>login.php">
                            <i class="fa fa-sign-in" aria-hidden="true"></i>
                            Login
                        </a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="<?php echo DIR; ?>register.php">
                            <i class="fa fa-registered" aria-hidden="true"></i>
                            Register
                        </a>
                    </li>
                </ul>
            <?php } ?>
        </div>
    </div>
</nav>
