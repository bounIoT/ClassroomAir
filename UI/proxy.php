<?php
    // Gets data from url and prints it. Provides data to javascript codeblocks.

    $url = $_GET['url'];
    $response = file_get_contents($url);
    echo $response;

?>
