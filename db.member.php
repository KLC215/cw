<?php

include "db.php";
include "func.alert.php";


function login($username, $password)
{
    $mysqli = connectDB();
    $result = $mysqli->query("SELECT * from member 
                  WHERE username = '$username' AND password = '$password'");

    if ($result->num_rows == 1) {
        $_SESSION['login'] = true;
        $_SESSION['userId'] = mysqli_fetch_array($result)['id'];
        $_SESSION['username'] = $username;

        $mysqli->close();

        return success("You successfully login !" . header("Location:" . DIR . ""));
    } else {
        return error("Wrong username or password !");
    }
}

function register($username, $email, $mobile, $password, $type)
{
    $mysqli = connectDB();
    if (hasUser($username, $email, $mobile)) {
        $result = $mysqli->query("INSERT INTO member (username, email, mobile_no, password, user_type) 
                            VALUES ('$username', '$email' , '$mobile', '$password' , '$type')");
        $userId = $mysqli->insert_id;
        $mysqli->close();

        if ($result) {
            $_SESSION['login'] = true;
            $_SESSION['userId'] = $userId;
            $_SESSION['username'] = $username;

            return success("You successfully register!" . header("refresh:1;url=" . DIR . "?act=" . urlencode(base64_encode("reg"))));
        } else {
            return error("Sorry! Database goes wrong!");
        }
    } else {
        return error("Sorry! Username or Email has been used !");
    }

}

function hasUser($username, $email, $mobile)
{
    $mysqli = connectDB();

    $result = $mysqli->query("SELECT * FROM member WHERE username = '$username' OR email = '$email' OR mobile_no = '$mobile'");

    $mysqli->close();

    if ($result->num_rows) {
        return false;
    } else {
        return true;
    }
}

function getUser($id)
{
    $mysqli = connectDB();

    $result = $mysqli->query("SELECT * FROM member WHERE id = '$id'");

    $mysqli->close();

    if ($result) {
        return $result;
    }
}

function updateMember($id, $column, $where)
{
    $mysqli = connectDB();

    $result = $mysqli->query("UPDATE member SET {$column} = '$where' WHERE id = '$id'");

    $mysqli->close();

    if ($result) {
        return success("Update successful !");
    } else {
        return error("Oops...Something goes wrong !");
    }
}

function confirmPassword($id, $password) {
    $mysqli = connectDB();

    $result = $mysqli->query("SELECT * FROM member WHERE id='$id' AND password = '$password'");

    $mysqli->close();

    if ($result->num_rows) {
        return true;
    } else {
        return false;
    }
}