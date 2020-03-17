<?php
session_start();

function ErrorSMS()
{
    if (isset($_SESSION["ErrorMessage"])) {
        $zinute = '<div class="alert alert-danger">' . htmlentities($_SESSION["ErrorMessage"]) . '</div>';
        $_SESSION["ErrorMessage"] = null;
        return $zinute;
    }

}

function SuccessSMS()
{
    if (isset($_SESSION["SucessMessage"])) {
        $zinute = '<div class="alert alert-success">' . htmlentities($_SESSION["SucessMessage"]) . '</div>';
        $_SESSION["SucessMessage"] = null;
        return $zinute;
    }
}