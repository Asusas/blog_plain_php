<?php require "includes\db.php";?>
<?php require "includes\Functions.php";?>
<?php require "includes\sessions.php";?>
<?php prisijungimo_patvirtinimas();?>

<?php

if (isset($_POST['tvirtinti'])) {
    global $Conn;
    // mysqli_real_escape_string - metodas kuris leidzia i duomenu baze siusti String tipo duomenis su kabutemis
    //pvz: Username: Andriu's
    $Category = mysqli_real_escape_string($Conn, $_POST['kategorija']);
    // Paspaudimo metu aktyvuojama funkcija kuri nustato ESAMA kategorijos sukurimo laika
    date_default_timezone_set("Europe/Vilnius");
    $CurrentTime = time();
    $DateTime = strftime("%Y-%m-%d %H:%M:%S", $CurrentTime);

    $Admin = $_SESSION["Username"];

    if (empty($Category)) {
        $_SESSION["ErrorMessage"] = "Ivedimo laukas privalo buti uzpildytas !";
        redirect_to("kategorijos.php");

    } elseif (strlen($Category) > 30) {
        $_SESSION["ErrorMessage"] = "Kategorijos pavadinimas per ilgas !";
        redirect_to("kategorijos.php");
    } else {
        $Query = "INSERT INTO category(dateTime, name, creatorName) VALUES ('$DateTime','$Category','$Admin')";
        $Execute = mysqli_query($Conn, $Query);
        if ($Execute) {
            $_SESSION["SucessMessage"] = "Kategorija sukurta sekmingai !";
            redirect_to("kategorijos.php");
        } else {
            $_SESSION["ErrorMessage"] = "Kategorijos sukurti nepavyko !";
            redirect_to("kategorijos.php");
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

    <title>Kurti nauja kategorija</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-dark">
        <a class="navbar-brand" href="blog.php"><img style="width:160px; height:70px" src="img\idea_2x.jpg" alt=""></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02"
            aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon "></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active"> <a style="color: white;" class="nav-link" href="blog.php">Pagrindinis </a>
                </li>
                <li class="nav-item active"> <a style="color: white" class="nav-link" href="#">Straipsniai </a> </li>
                <li class="nav-item active"> <a style="color: white" class="nav-link" href="#">Apie mus </a> </li>
                <li class="nav-item active"> <a style="color: white" class="nav-link" href="#">Paslaugos </a> </li>
                <li class="nav-item active"> <a style="color: white" class="nav-link" href="#">Kontaktai </a> </li>
                <li class="nav-item active"> <a style="color: white" class="nav-link" href="#">Ypatybes </a> </li>
            </ul>
            <form action="pilnasStraipsnis.php" class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Paieska" aria-label="Search"
                    name="search">
                <button class="btn btn-outline-success my-2 my-sm-0 " name="SearchButton">Ieskoti</button>
            </form>
        </div>
    </nav>
    <br>
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-3">
                <h3>Valdymo panelė</h3>
                <ul id="side_menu" class="nav nav-pills">
                    <li class="nav-item list"> <a class="nav-link" href="meniu.php"><i class="fas fa-th"></i>
                            Meniu</a>
                    </li>
                    <li class="nav-item list"> <a class="nav-link" href="naujasStraipsnis.php"><i
                                class="far fa-newspaper"></i>
                            Kurti
                            nauja straipsni</a></li>
                    <li class="nav-item list"> <a class="nav-link" href="kategorijos.php"><i class="fas fa-cubes"></i>
                            Kategorijos</a> </li>
                    <li class="nav-item list"> <a class="nav-link" href="administratoriai.php"><i
                                class="fas fa-users-cog"></i>
                            Tvarkyti adminu'us</a> </li>
                    <li class="nav-item list"> <a class="nav-link" href="komentarai.php"><i class="fas fa-comments"></i>
                            Komentarai</a> </li>
                    <li class="nav-item list"> <a class="nav-link" href="blog.php?Page=1" target="_blank"><i
                                class="far fa-eye"></i>
                            Sekimas</a> </li>
                    <li class="nav-item list"> <a class="nav-link" href="atsijungimas.php"><i
                                class="fas fa-sign-out-alt"></i>
                            Atsijungti</a> </li>
                </ul>
            </div>

            <div class="col-sm-9">
                <h3>Kurti kategorija</h3>
                <div> <?php echo ErrorSMS(); ?> </div>
                <div> <?php echo SuccessSMS(); ?> </div>
                <div>
                    <form action="kategorijos.php" method="post">
                        <fieldset>
                            <div class="form-group">
                                <label for="kategorijos_pav">Kategorija: </label>
                                <input class="form-control" type="text" name="kategorija" id="kategorijos_pav"
                                    placeholder="Pavadinimas">
                            </div>
                            <input class="btn btn-success btn-block" type="Submit" name="tvirtinti"
                                value="Sukurti nauja kategorija">
                        </fieldset>
                        <br>
                    </form>
                </div>

                <div>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Nr. </th>
                                <th>Sukurimo data</th>
                                <th>Kategorijos pavadinimas</th>
                                <th>Autorius</th>
                                <th>Veiksmai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
global $Conn;
$Query = "SELECT * FROM category ORDER BY dateTime desc";
$result = mysqli_query($Conn, $Query);

$Id_Nr = 0;

while ($Data = mysqli_fetch_array($result)) {
    $ID = $Data["id"];
    $DateTime = $Data["dateTime"];
    $CategName = $Data["name"];
    $Author = $Data["creatorName"];
    $Id_Nr++;

    ?>
                            <tr>
                                <td><?php echo $Id_Nr ?></td>
                                <td><?php echo $DateTime ?></td>
                                <td><?php echo $CategName ?></td>
                                <td><?php echo $Author ?></td>
                                <td><a href="trinti_kategorija.php?id=<?php echo $ID; ?>"> <span class="btn btn-danger">
                                            Trinti</span> </a></td>


                            </tr>
                            <?php }?>

                        </tbody>


                    </table>
                </div>

            </div>

        </div>
    </div>
    <div id="footer">
        <p>Sukurta | Andrejus Kruglekovas | kopija: 2019 - 2020 --- Visos teises saugomos.</p>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quod atque modi repudiandae consequuntur sapiente
            eligendi, tempore molestiae facere quis placeat cum deserunt iusto! Ex ullam repudiandae laudantium ad,
            possimus autem?</p>
    </div>


    <script src="libs\jquery.3.4.1\jquery_3_4_1.js"></script>
    <script src="libs\bootstrap_4_3_1\js\bootstrap.js"></script>

</body>

</html>