<?php

function addPhoto($mysqli, $files, $id)
{
    $count = 0;
    for ($i = 0; $i < sizeof($files); $i++) {
        $mysqli->query("INSERT INTO photo (url, toy_id) 
                            VALUES ('$files[$i]', '$id')");
        $count++;
    }
    $mysqli->close();

    if ($count == sizeof($files)) {
        return true;
    } else {
        return false;
    }
}

function deletePhoto($mysqli, $id)
{
    $result = null;
    $files = [];
    $urlResult = $mysqli->query("SELECT url FROM photo WHERE toy_id = '$id'");

    if($urlResult) {
        while($row = mysqli_fetch_object($urlResult)) {
            $files[] = $row->url;
        }
    }
    foreach ($files as $file) {
        if(@unlink($file)) {
            $result = $mysqli->query("DELETE FROM photo WHERE url = '$file'");
        }
    }

    if($result) {
        return true;
    } else {
        return false;
    }
}
