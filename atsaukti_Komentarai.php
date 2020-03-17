<?php require "includes\db.php";?>
<?php require "includes\Functions.php";?>
<?php require "includes\sessions.php";?>

<?php

if (isset($_GET["id"])) {
    $Url_Id = $_GET["id"];
    global $Conn;
    $Query = "UPDATE comments SET status='OFF' WHERE id='$Url_Id' ";
    $Execute = mysqli_query($Conn, $Query);
    if ($Execute) {
        $_SESSION["SucessMessage"] = "Komentaras atsauktas sekmingai !";
        redirect_to("komentarai.php");
    } else {

        $_SESSION["ErrorMessage"] = "Komentaro atsaukti nepavyko  !";
        redirect_to("komentarai.php");
    }

}

?>