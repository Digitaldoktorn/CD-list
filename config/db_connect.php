<?php
$conn = mysqli_connect('localhost', 'shaun', 'abc123', 'CD-list');

    if(!$conn) {
        echo 'Connection error: ' . mysqli_connect_error();
    }
?>