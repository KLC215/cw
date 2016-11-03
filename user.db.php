<?php

include "db.php";
include "alert.func.php";


function login($username, $password)
{
    $mysqli = connectDB();
    $result = $mysqli->query("SELECT * from user 
                  WHERE username = '$username' AND password = '$password'");

    if ($result->num_rows == 1) {
        $_SESSION['login'] = true;
        $_SESSION['username'] = $username;

        return success("You successfully login !" . header("Location:" . DIR . ""));
    } else {
        return error("Wrong username or password !");
    }
}

function register($username, $email, $password, $type)
{
    $mysqli = connectDB();
    if (hasUser($username, $email)) {
        $result = $mysqli->query("INSERT INTO USER (username, email, password, user_type) 
                            VALUES ('$username', '$email' , '$password' , '$type')");

        $mysqli->close();

        if ($result) {
            $_SESSION['login'] = true;
            $_SESSION['username'] = $username;

            return success("You successfully register!" . header("refresh:1;url=" . DIR . ""));
        } else {
            return error("Sorry! Database goes wrong!");
        }
    } else {
        return error("Sorry! Username or Email has been used !");
    }

}

function hasUser($username, $email)
{
    $mysqli = connectDB();

    $result = $mysqli->query("SELECT * FROM user WHERE username = '$username' OR email = '$email'");

    $mysqli->close();

    if ($result->num_rows) {
        return false;
    } else {
        return true;
    }
}