<?php

include "db.php";
include "db.photo.php";
include "func.alert.php";

function addToy($name, $description, $expectToChange, $category, $files)
{

    $mysqli = connectDB();

    $userId = $_SESSION['userId'];
    $result = $mysqli->query("INSERT INTO toy (toy, description, expect_to_change, member_id, category_id, status_id) 
                            VALUES ('$name', '$description' , '$expectToChange' , '$userId', '$category', 1)");

    $toyId = $mysqli->insert_id;

    if ($result) {
        if (addPhoto($mysqli, $files, $toyId)) {
            return success("New toy exchange has been created !");
        } else {
            return error("Sorry! Database goes wrong!");
        }
    } else {
        return error("Sorry! Database goes wrong!");
    }
}

function retrieveToy($startNumber, $pageSize)
{
    $mysqli = connectDB();

    $result = $mysqli->query("SELECT
                              toy.*,
                              member.username,
                              photo.url, status.name
                            FROM toy, photo, member, status
                            WHERE toy.member_id = member.id AND
                                  photo.url = (select url FROM photo WHERE toy_id = toy.id LIMIT 1) AND
                                  toy.status_id = status.id AND toy.status_id = 1
                            ORDER BY toy.id DESC LIMIT $startNumber, $pageSize");

    if ($result) {
        $mysqli->close();

        return $result;
    }
}

function searchToy($column, $where, $startNumber, $pageSize)
{
    $mysqli = connectDB();

    $result = $mysqli->query("SELECT
                              toy.*,
                              member.username,
                              photo.url, status.name
                            FROM toy, photo, member, status
                            WHERE toy.member_id = member.id AND
                                  photo.url = (select url FROM photo WHERE toy_id = toy.id LIMIT 1) AND
                                  toy.status_id = status.id AND toy.status_id = 1 AND {$column} LIKE '%$where%'
                            ORDER BY toy.id DESC LIMIT $startNumber, $pageSize");

    if ($result) {
        $mysqli->close();

        return $result;
    }
}

function getToy($id)
{
    $mysqli = connectDB();

    $result = $mysqli->query("SELECT toy.*, photo.url, member.username, status.name 
                                    FROM toy, photo, member, status 
                                    WHERE toy.id = '$id' AND 
                                          photo.toy_id = '$id' AND
                                          member.id = toy.member_id AND
                                          status.id = 1");

    if ($result) {
        $mysqli->close();

        return $result;
    }

}

function getExchangeToy($id)
{
    $mysqli = connectDB();

    $result = $mysqli->query("SELECT toy.*, photo.url, member.username, status.name 
                                    FROM toy, photo, member, status 
                                    WHERE toy.id = '$id' AND 
                                          photo.url = (select url FROM photo WHERE toy_id = '$id' LIMIT 1) AND
                                          member.id = toy.member_id AND
                                          status.id = 1");

    if ($result) {
        $mysqli->close();

        return $result;
    }
}

function getUserToy($id)
{
    $mysqli = connectDB();

    $result = $mysqli->query("SELECT * FROM toy WHERE member_id = '$id'");

    if ($result) {
        $mysqli->close();

        return $result;
    }
}

function getSelectedToy($id)
{
    $mysqli = connectDB();

    $result = $mysqli->query("SELECT * FROM toy WHERE id = '$id'");

    if ($result) {
        $mysqli->close();

        return $result;
    }
}

function updateToy($id, $name, $category, $description, $expectToChange)
{
    $mysqli = connectDB();

    $result = $mysqli->query("UPDATE toy SET toy = '$name', 
                                              category_id = '$category', 
                                              description = '$description',
                                              expect_to_change = '$expectToChange'
                                         WHERE id = '$id'");

    if ($result) {
        $mysqli->close();

        return success("Update successfully !");
    } else {
        return error("Oops...Something goes wrong !");
    }
}

function addClickRate($id)
{
    $mysqli = connectDB();

    $result = $mysqli->query("UPDATE toy SET click_rate = click_rate + 1
                                  WHERE id = '$id'");

    if ($result) {
        $mysqli->close();

        return $result;
    }
}

function countToysOwner($column = null, $where = null)
{
    $mysqli = connectDB();

    $result = null;
    $memberId = null;

    if ($column && $where) {
        $result = getMemberId($mysqli, $where);
        if ($result) {
            $memberId = mysqli_fetch_assoc($result)['id'];
        }
        if ($memberId) {
            $result = $mysqli->query("select count(*) from toy WHERE {$column} = '$memberId'");
        }
    }

    if ($result) {
        $mysqli->close();

        return $result;
    }
}

function getMemberId($mysqli, $username)
{
    $result = $mysqli->query("SELECT id FROM member WHERE username = '$username'");

    if ($result) {
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

function countToys($toy = null, $id = null)
{
    $mysqli = connectDB();

    $result = null;

    if ($toy) {
        $result = $mysqli->query("select count(*) from toy WHERE toy LIKE '%$toy%'");
    } else {
        $result = $mysqli->query("select count(*) from toy");
    }

    if ($id) {
        $result = $mysqli->query("select count(*) from toy WHERE member_id = '$id'");
    }

    if ($result) {
        $mysqli->close();

        return $result;
    }
}

function countToyCategory($id)
{
    $mysqli = connectDB();

    $result = $mysqli->query("select count(*) from toy WHERE category_id = '$id'");

    if ($result) {
        $mysqli->close();

        return $result;
    }
}

function deleteToy($id)
{
    $mysqli = connectDB();

    $id = base64_decode(urldecode($_GET['id']));

    $result = $mysqli->query("DELETE FROM toy WHERE id = '$id'");

    if ($result) {
        $result = deletePhoto($mysqli, $id);
        if ($result) {
            $mysqli->close();

            return $result;
        }
    }
}

function searchMyExchange($id, $startNumber, $pageSize)
{
    $mysqli = connectDB();

    $result = $mysqli->query("SELECT
                              toy.*,
                              member.username,
                              photo.url, status.name
                            FROM toy, photo, member, status
                            WHERE toy.member_id = '$id' AND toy.member_id = member.id AND
                                  photo.url = (select url FROM photo WHERE toy_id = toy.id LIMIT 1) AND
                                  toy.status_id = status.id
                            ORDER BY toy.id DESC LIMIT $startNumber, $pageSize");

    if ($result) {
        $mysqli->close();

        return $result;
    }
}

function addMessage($from_user, $to_user, $from_toy, $to_toy, $content)
{
    $mysqli = connectDB();

    $result = $mysqli->query("INSERT INTO message (from_user, to_user, from_toy, to_toy, content, viewed, accepted, status_id)
                                  VALUES ('$from_user', '$to_user', '$from_toy', '$to_toy', '$content', 0, 0, 2)");

    if ($result) {
        $mysqli->close();

        return $result;
    }
}