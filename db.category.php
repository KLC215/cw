<?php

function retrieveCategory()
{
    $mysqli = connectDB();

    $result = $mysqli->query("SELECT * FROM category;");

    $mysqli->close();

    return $result;

}