<?php

include "bootstrap.php";
session_unset();
session_destroy();

header("Location:" . DIR . "?act=". urlencode(base64_encode("logout")));
