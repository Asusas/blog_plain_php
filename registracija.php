<?php require "includes\db.php";?>
<?php require "includes\Functions.php";?>
<?php require "includes\sessions.php";?>

<?php

if (isset($_POST['tvirtinti'])) {
    global $Conn;

    $Username = mysqli_real_escape_string($Conn, $_POST['vartotojas']);
    $Password = mysqli_real_escape_string($Conn, $_POST['slaptazodis']);

    $hashFormat = "$2y$10$";
    $salt = "ksdfhlsdkKJKSDBFLSKDBkbjdgfbkg5543131";
    $hash_and_salt = $hashFormat . $salt;

    $Password = crypt($Password, $hash_and_salt);

    if (empty($Username) || empty($Password)) {
        $_SESSION["ErrorMessage"] = "Visi laukai privalo buti uzpildyti !";
        redirect_to("registracija.php");

    } else {
        $Find_account = meginimas_jungtis($Username, $Password);
        $_SESSION["User_Id"] = $Find_account["id"];
        $_SESSION["Username"] = $Find_account["username"];
        if ($Find_account) {
            $_SESSION["SucessMessage"] = "Sveiki prisijunge, {$Find_account["username"]} !";
            redirect_to("meniu.php");
        } else {
            $_SESSION["ErrorMessage"] = "Prisijungti nepavyko ! Blogai ivesti duomenys";
            redirect_to("registracija.php");
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="libs\bootstrap_4_3_1\css\bootstrap.css">
    <link rel="stylesheet" href="libs\fontawesome_icons\css\all.css">
    <link rel="stylesheet" href="css\styles.css">

    <title>Redaguoti administratorius</title>
</head>

<body style="background: white">
    <nav class="navbar navbar-expand-lg navbar-light bg-dark">
        <a class="navbar-brand" href="blog.php"><img style="width:160px; height:70px" src="img\idea_2x.jpg" alt=""></a>
    </nav>
    <br>
    <div class="container-fluid">

        <div class="row">
            <div class="offset-sm-4 col-sm-4">
                <div> <?php echo ErrorSMS(); ?> </div>
                <div> <?php echo SuccessSMS(); ?> </div>
                <br>
                <br>
                <br>
                <br>
                <h3>Prasome prisijungti</h3>

                <div>
                    <form action="registracija.php" method="post">
                        <fieldset>
                            <div class="form-group">
                                <label for="vartotojo_var">Vartotojas: </label>
                                <input class="form-control" type="text" name="vartotojas" id="vartotojas"
                                    placeholder="Vardas">
                            </div>
                            <div class="form-group">
                                <label for="slaptazodzio_pav">Slaptazodis: </label>
                                <input class="form-control" type="password" name="slaptazodis" id="slaptazodis"
                                    placeholder="Jusu slaptazodis">
                            </div>
                            <input class="btn btn-warning btn-block" type="Submit" name="tvirtinti" value="Prisijungti">
                        </fieldset>
                        <br>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="libs\jquery.3.4.1\jquery_3_4_1.js"></script>
    <script src="libs\bootstrap_4_3_1\js\bootstrap.js"></script>

</body>

</html>