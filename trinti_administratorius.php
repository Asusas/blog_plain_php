<?php require "includes\db.php";?>
<?php require "includes\Functions.php";?>
<?php require "includes\sessions.php";?>

<?php

if (isset($_GET["id"])) {
    $Url_Id = $_GET["id"];
    global $Conn;
    $Query = "DELETE FROM registration WHERE id='$Url_Id' ";
    $Execute = mysqli_query($Conn, $Query);
    if ($Execute) {
        $_SESSION["SucessMessage"] = "Administratorius istrinta sekmingai !";
        redirect_to("administratoriai.php");
    } else {

        $_SESSION["ErrorMessage"] = "Administratoriaus istrinti nepavyko  !";
        redirect_to("administratoriai.php");
    }

}

?>