<?php require "includes\Functions.php";?>
<?php require "includes\sessions.php";?>

<?php $_SESSION["User_Id"] = null;
session_destroy();
redirect_to("registracija.php")
?>