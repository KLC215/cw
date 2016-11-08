<?php
include "db.php";

function getMsgFromId($id)
{
    $mysqli = connectDB();

    $result = $mysqli->query("SELECT * FROM message WHERE to_user = '$id'");

    if ($result) {
        $mysqli->close();

        return $result;
    }
}

function getMemberFromMemberId($id)
{
    $mysqli = connectDB();

    $result = $mysqli->query("SELECT * FROM member WHERE id = '$id'");

    if ($result) {
        $mysqli->close();

        return $result;
    }
}

function acceptMsg($msgId)
{
    $mysqli = connectDB();

    $result = $mysqli->query("UPDATE message SET viewed = 1, accepted = 1, status_id = 5 WHERE id = '$msgId'");

    if ($result) {
        $mysqli->close();

        return $result;
    }
}

function rejectMsg()
{

}

function getFromTo($msgId)
{
    $mysqli = connectDB();

    $result = $mysqli->query("SELECT from_user, to_user FROM message WHERE id = '$msgId'");

    if ($result) {
        $mysqli->close();

        return $result;
    }
}


function checkMsgStatus($msgId)
{
    $mysqli = connectDB();

    $result = $mysqli->query("SELECT id, status_id FROM message WHERE id = '$msgId'");

    if ($result) {
        $mysqli->close();

        return $result;
    }
}

function updateToyStatus($toyId, $statusId)
{
    $mysqli = connectDB();

    $result = $mysqli->query("UPDATE toy SET status_id = '$statusId' WHERE id = '$toyId'");

    if ($result) {
        $mysqli->close();

        return $result;
    }
}

function replyAcceptMsg($from_user, $to_user, $from_toy, $to_toy, $content)
{
    $mysqli = connectDB();

    $result = $mysqli->query("INSERT INTO message (from_user, to_user, from_toy, to_toy, content, viewed, accepted, status_id)
                                  VALUES ('$from_user', '$to_user', '$from_toy', '$to_toy', '$content', 0, 1, 5)");

    if ($result) {
        $mysqli->close();

        return $result;
    }
}

function getMemberFromToyMemberId($id)
{
    $mysqli = connectDB();

    $result = $mysqli->query("SELECT * FROM member WHERE id = '$id'");

    if ($result) {
        $mysqli->close();

        return $result;
    }
}

function deleteMsg($msgId)
{
    $mysqli = connectDB();

    $result = $mysqli->query("DELETE FROM message WHERE id = '$msgId'");

    if ($result) {
        $mysqli->close();

        return $result;
    }
}

function updateMsgStatus($msgId, $statusId) {
    $mysqli = connectDB();

    $result = $mysqli->query("UPDATE message SET status_id = '$statusId' WHERE id = '$msgId'");

    if ($result) {
        $mysqli->close();

        return $result;
    }
}