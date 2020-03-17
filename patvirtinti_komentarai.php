<?php require "includes\db.php";?>
<?php require "includes\Functions.php";?>
<?php require "includes\sessions.php";?>

<?php

if (isset($_GET["id"])) {
    $Url_Id = $_GET["id"];
    global $Conn;
    $Admin = $_SESSION["Username"];
    $Query = "UPDATE comments SET status='ON', approvedby='$Admin' WHERE id='$Url_Id' ";
    $Execute = mysqli_query($Conn, $Query);
    if ($Execute) {
        $_SESSION["SucessMessage"] = "Komentaras patvirtintas sekmingai !";
        redirect_to("komentarai.php");
    } else {

        $_SESSION["ErrorMessage"] = "Komentaro patvirtinti nepavyko  !";
        redirect_to("komentarai.php");
    }

}

?>