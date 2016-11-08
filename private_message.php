<?php require_once "bootstrap.php" ?>

    <!-- ***************************** Login checking *****************************-->
<?php

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location:" . DIR . "login.php");
}

?>
<?php include("layouts/frontend/header.php"); ?>
<?php include("layouts/frontend/nav.php"); ?>
<?php include("func.alert.php");?>
<?php include("db.message.php"); ?>

    <!-- ***************************** Private Message process *****************************-->
<?php
$result = "";
$msgs = getMsgFromId($_SESSION['userId']);

if (isset($_GET['id']) && isset($_GET['fb']) && $_GET['id'] != '' && $_GET['fb'] != '') {
    switch ($_GET['fb']) {
        case 'accept':
            if (acceptMsg($_GET['id'])) {
                if ($msgs) {
                    if ($row = mysqli_fetch_object($msgs)) {

                        $from_member = getMemberFromToyMemberId($_SESSION['userId']);
                        $to_member = getMemberFromToyMemberId($row->from_user);

                        $you = mysqli_fetch_object($from_member);
                        $himOrHer = mysqli_fetch_object($to_member);

                        $message = '<b>' . $you->username . '</b> accept the exchange ! <p>His/her mobile number: <strong>' . $himOrHer->mobile_no . '</strong></p>';

                        $from_toy = updateToyStatus($row->from_toy, 8);     // Waiting For Exchange
                        $to_toy = updateToyStatus($row->to_toy, 8);

                        $replyMessage = replyAcceptMsg($row->to_user, $row->from_user, $row->to_toy, $row->from_toy, $message);

                        if ($from_toy && $to_toy && $replyMessage) {
                            header("Refresh:0; url=" . DIR . "private_message.php");
                        }
                    }
                } else {
                    $result = error("Oops...Something goes wrong!");
                }
            } else {
                $result = error("Oops...Something goes wrong!");
            }
            break;
        case 'reject':
            $rejectResult = updateMsgStatus($_GET['id'], 6);    // Reply Reject
            if($rejectResult) {
                header("Refresh:0; url=" . DIR . "private_message.php");
            }
            break;
        case 'complete':
            $completeMsgResult = updateMsgStatus($_GET['id'], 3);   // Exchange Successful
            if($row = mysqli_fetch_object($msgs)) {
                $completeFromToyResult = updateToyStatus($row->from_toy, 3);
                $completeToToyResult = updateToyStatus($row->to_toy, 3);

                if($completeFromToyResult && $completeMsgResult && $completeToToyResult) {
                    header("Refresh:0; url=" . DIR . "private_message.php");
                }
            }
            break;
        case 'del':
            $delResult = deleteMsg($_GET['id']);
            if($delResult) {
                header("Refresh:0; url=" . DIR . "private_message.php");
            }
            break;
    }
}

?>
    <!-- ***************************** Private Message Exchange *****************************-->
    <div class="container well well-lg">
        <?php echo $result;?>
        <form method="post" action=""
              class="form-horizontal">
            <fieldset>
                <legend>Private Messages</legend>
                <div class="form-group">
                    <label for="select" class="col-lg-2 control-label"></label>
                    <div class="col-lg-8">
                        <div class="list-group">
                            <?php
                            if (isset($_SESSION['userId'])) {
                                if ($msgs) {
                                    while ($row = mysqli_fetch_object($msgs)) {
                                        echo '<div class="panel panel-info">
                                                  <div class="panel-heading">
                                                    <h3 class="panel-title">Message</h3>
                                                  </div>
                                                  <div class="panel-body">
                                                    <p class="list-group-item-text">
                                                        ' . $row->content . '
                                                    </p>
                                                    <hr>
                                                    <p class="list-group-item-text pull-right">';
                                        $status = checkMsgStatus($row->id);
                                        if ($row = mysqli_fetch_object($status)) {
                                            switch ($row->status_id) {
                                                case '2':    // Waiting for reply
                                                    echo '<a href="' . DIR . 'private_message.php?id=' . $row->id . '&fb=accept" class="btn btn-success">Accept</a>
                                                                        <a href="' . DIR . 'private_message.php?id=' . $row->id . '&fb=reject" class="btn btn-danger">Reject</a>';
                                                    break;
                                                case '3':
                                                    echo '<p><strong>This exchange is finished !</strong></p>';
                                                    echo '<p><a id="del" href="' . DIR . 'private_message.php?id=' . $row->id . '&fb=del" class="btn btn-danger">Delete this message</a></p>';
                                                    break;
                                                case '5':    // Reply accept
                                                    echo '<p><a href="' . DIR . 'private_message.php?id=' . $row->id . '&fb=complete" class="btn btn-success pull-right">Finish Exchange</a></p>';
                                                    break;
                                                case '6':    // Reply reject
                                                    echo '<p><strong>You reject this exchange!</strong></p>';
                                                    echo '<p><a id="del" href="' . DIR . 'private_message.php?id=' . $row->id . '&fb=del" class="btn btn-danger">Delete this message</a></p>';
                                                    break;
                                            }
                                        }

                                        echo '</p>
                                                  </div>
                                                </div>';
                                    }
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>

<?php include("layouts/frontend/footer.php"); ?>