<?php

function connectDB()
{
    try {
        return new mysqli("localhost", "root", "", "toys_exchange");
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}
