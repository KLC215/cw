<?php require_once "bootstrap.php" ?>

    <!-- ***************************** Login checking *****************************-->
<?php

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location:" . DIR . "login.php");
}

?>
<?php include("layouts/frontend/header.php"); ?>
<?php include("layouts/frontend/nav.php"); ?>
<?php include("db.toy.php"); ?>

    <!-- ***************************** Request Exchange process *****************************-->
<?php
$result = "";
$errYourToy = "";

if (isset($_POST['submit'])) {
    $yourToy = $_POST['yourToy'];

    if (!$yourToy || $yourToy == 0) {
        $errYourToy = "You must choose 1 toy to do exchange!";
    }

    if (!$errYourToy && isset($_GET['id'])) {
        $selectedYourToy = getSelectedToy($yourToy);
        $selectedExchangeToy = getSelectedToy(base64_decode(urldecode($_GET['id'])));

        $selectedYourToyRow = mysqli_fetch_object($selectedYourToy);
        $selectedExchangeToyRow = mysqli_fetch_object($selectedExchangeToy);

        if ($selectedYourToyRow && $selectedExchangeToyRow && $_SESSION['userId']) {
            $member = getMemberFromToyMemberId($_SESSION['userId']);
            $exChangeMember = getMemberFromToyMemberId($selectedExchangeToyRow->member_id);

            $you = mysqli_fetch_object($member);
            $himOrHer = mysqli_fetch_object($exChangeMember);

            $context = '<b>' . $you->username . '</b> wants to exchange your <a href="' . DIR . 'item_toy_view?id=' . urlencode(base64_encode($selectedExchangeToyRow->id)) . '">' . $selectedExchangeToyRow->toy . '</a> by his/her <a href="' . DIR . 'item_toy_view?id=' . urlencode(base64_encode($selectedYourToyRow->id)) . '">' . $selectedYourToyRow->toy . '</a><p>His/her mobile number: <strong>' . $you->mobile_no . '</strong></p>';

            $insert = addMessage($_SESSION['userId'], $himOrHer->id, $selectedYourToyRow->id, $selectedExchangeToyRow->id, $context);

            if ($insert) {
                $result = success("Your request is sent !");
                header("Refresh: 1;url=" . DIR);
            } else {
                $result = error("Oops...Something goes wrong !");
            }
        }


    }
}

?>
    <!-- ***************************** Request Exchange *****************************-->
    <div class="container well well-lg">
        <?php echo $result; ?>
        <form method="post" action="<?php echo DIR; ?>request_exchange.php?&id=<?php echo $_GET['id'] ?>"
              class="form-horizontal">
            <fieldset>
                <legend>Request Exchange</legend>
                <div class="form-group">
                    <label for="select" class="col-lg-2 control-label">Your toy</label>
                    <div class="col-lg-8">
                        <select class="form-control" name="yourToy" id="select">
                            <option value="0">Choose your toy</option>
                            <?php
                            $toys = getUserToy($_SESSION['userId']);
                            while ($row = mysqli_fetch_array($toys)) {
                                echo '<option  value="' . $row['id'] . '">' . $row['toy'] . '</option>';
                            }
                            ?>
                        </select>
                        <?php echo "<p class='text-danger'>$errYourToy</p>"; ?>
                    </div>
                </div>
                <div class="well well-lg text-center">
                    <strong>↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓ CHANGE ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓<strong>
                </div>
                <div class="form-group">
                    <label for="select" class="col-lg-2 control-label"></label>
                    <div class="col-lg-8">
                        <div class="list-group">
                            <?php
                            if (isset($_GET['id'])) {
                                $toy = getExchangeToy(base64_decode(urldecode($_GET['id'])));
                                if ($toy) {
                                    while ($row = mysqli_fetch_object($toy)) {
                                        echo '<div class="media pull-left">
                                                <img class="media-object"
                                                     src="' . DIR . $row->url . '"
                                                     alt="amazing" height="100" width="100">
                                               </div>
                                                <div class="media-body">
                                                    <h4 class="media-heading">&nbsp;' . $row->toy . '</h4>
                                                    <p class="list-group-item-text">&nbsp;&nbsp;Owner: <b>' . $row->username . '</b>&nbsp;</p>
                                                    <p class="list-group-item-text">&nbsp;&nbsp;Want: <b>' . $row->expect_to_change . '</b>&nbsp;</p>
                                                    <p class="list-group-item-text">&nbsp;&nbsp;Upload time: <b>' . $row->created_at . '</b>&nbsp;</p>
                                                    <p></p>
                                                </div>';
                                    }
                                }
                            }
                            ?>
                        </div>
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