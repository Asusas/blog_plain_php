<?php

function redirect_to($location)
{
    header("Location:" . $location);
    exit;
}

function meginimas_jungtis($Username, $Password)
{
    global $Conn;
    $Query = "SELECT * FROM registration WHERE username='$Username' AND password='$Password'";
    $Execute = mysqli_query($Conn, $Query);
    if ($Admin = mysqli_fetch_assoc($Execute)) {
        return $Admin;
    } else {
        return null;
    }
}

function prisijungimas()
{

    if (isset($_SESSION["User_Id"])) {
        return true;
    }
}

function prisijungimo_patvirtinimas()
{

    if (!prisijungimas()) {
        $_SESSION["ErrorMessage"] = "Butinas prisijungimas !";
        redirect_to("registracija.php");

    }
}