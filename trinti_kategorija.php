<?php require "includes\db.php";?>
<?php require "includes\Functions.php";?>
<?php require "includes\sessions.php";?>

<?php

if (isset($_GET["id"])) {
    $Url_Id = $_GET["id"];
    global $Conn;
    $Query = "DELETE FROM category WHERE id='$Url_Id' ";
    $Execute = mysqli_query($Conn, $Query);
    if ($Execute) {
        $_SESSION["SucessMessage"] = "Kategorija istrinta sekmingai !";
        redirect_to("kategorijos.php");
    } else {

        $_SESSION["ErrorMessage"] = "Kategorijos istrinti nepavyko  !";
        redirect_to("kategorijos.php");
    }

}

?>