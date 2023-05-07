<?php

$conn = pg_connect("host=127.0.0.1 port=5432 dbname=yourdb user=postgres password=pass123");

if (!$conn)
{
    die("Error!");
}

?>