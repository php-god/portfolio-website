<?php

$response;

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    require_once("conn.php");

    $name = pg_escape_string($conn, validate($_POST["name"]));
    $email = pg_escape_string($conn, validate($_POST["email"]));
    $message = pg_escape_string($conn, validate($_POST["message"]));

    if (!empty($name) && strlen($name) < 150)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($email) < 150)
        {
            if (!empty($message))
            {
                $sql = "INSERT INTO contact (name, email, message) VALUES ('$name', '$email', '$message')";
                if (pg_query($conn, $sql))
                {
                    $response = array("success", "Your Response Was Submitted!");
                    echo json_encode($response);
                }
                else
                {
                    $response = array("error", "Error!");
                    echo json_encode($response);
                }
            }
            else
            {
                $response = array("error", "Message Is Required!");
                echo json_encode($response);
            }
        }
        else
        {
            $response = array("error", "Email Is Required And Please Make Sure That The Email You Entered Is Valid And Is No More Longer Than 150 Characters.");
            echo json_encode($response);
        }
    }
    else
    {
        $response = array("error", "Name Is Required And Cannot Contain More Than 150 Characters.");
        echo json_encode($response);
    }
}

function validate($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}

?>