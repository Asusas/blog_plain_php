<?php require "includes\db.php";?>
<?php require "includes\Functions.php";?>
<?php require "includes\sessions.php";?>
<?php prisijungimo_patvirtinimas();?>

<?php

if (isset($_POST['tvirtinti'])) {

    global $Conn;
    $Title = mysqli_real_escape_string($Conn, $_POST['Pavadinimas']);
    $Category = mysqli_real_escape_string($Conn, $_POST['kategorija']);
    $Post = mysqli_real_escape_string($Conn, $_POST['siusti']);

    date_default_timezone_set("Europe/Vilnius");
    $CurrentTime = time();
    $DateTime = strftime("%Y-%m-%d %H:%M:%S", $CurrentTime);

    $Admin = "Andrejus Kruglekovas";
    $Image = $_FILES["Image"]["name"];
    $Img_upload = "img_upload/" . basename($Image);

    if (empty($Title)) {
        $_SESSION["ErrorMessage"] = "Iveskite straipsnio pavadinima !";
        redirect_to("naujasStraipsnis.php");

    } elseif (strlen($Title) < 4) {
        $_SESSION["ErrorMessage"] = "Straipsnio pavadinimas per trumpas !";
        redirect_to("naujasStraipsnis.php");
    } else {
        $PostId_URL = $_GET["Redaguoti"];
        $Query = "UPDATE admin_panel SET dateTime='$DateTime', title='$Title', category='$Category', author='$Admin', image='$Image', post='$Post' WHERE id='$PostId_URL'";
        $Execute = mysqli_query($Conn, $Query);
        move_uploaded_file($_FILES["Image"]["tmp_name"], $Img_upload);
        if ($Execute) {
            $_SESSION["SucessMessage"] = "Straipsnis redaguotas sekmingai !";
            redirect_to("meniu.php");
        } else {
            $_SESSION["ErrorMessage"] = "Straipsnio redagavimas nepavyko !";
            redirect_to("meniu.php");
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

    <title>Redaguoti straipsni</title>
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
                    <li class="nav-item list"> <a class="nav-link" href="#"><i class="fas fa-users-cog"></i>
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
                <h3>Redaguoti straipsni</h3>

                <div>
                    <?php

global $Conn;

$PostId_URL = $_GET["Redaguoti"];
$ViewPost = "SELECT * FROM admin_panel WHERE id='$PostId_URL'";
$Execute = mysqli_query($Conn, $ViewPost);
while ($Data = mysqli_fetch_array($Execute)) {
    $TitleEdit = $Data["title"];
    $CategoryEdit = $Data["category"];
    $ImgEdit = $Data["image"];
    $PostEdit = $Data["post"];
}
?>

                    <form action="redaguoti_straipsni.php?Redaguoti=<?php echo $PostId_URL ?>" method="post"
                        enctype="multipart/form-data">
                        <fieldset>
                            <div class="form-group">
                                <label for="pavadinimas">Pavadinimas: </label>
                                <input value="<?php echo $TitleEdit ?>" class="form-control" type="text"
                                    name="Pavadinimas" id="pavadinimas" placeholder="Pavadinimas">
                            </div>

                            <div class="form-group">

                                <span style="Color: red;"> <strong>Esama kategorijos: </strong> </span>
                                <?php echo $CategoryEdit ?>
                                <br>
                                <br>
                                <label for="kategorijos_parinkimas">Keisti kategorija: </label>
                                <select class="form-control" id="kategorijos_parinkimas" name="kategorija">
                                    <?php
global $Conn;
$Query = "SELECT * FROM category ORDER BY dateTime desc";
$result = mysqli_query($Conn, $Query);

while ($Data = mysqli_fetch_array($result)) {
    $ID = $Data["id"];
    $CategName = $Data["name"];
    ?>
                                    <option> <?php echo $CategName ?> </option>
                                    <?php }?>
                                </select>
                            </div>

                            <div class="form-group">

                                <span style="Color: red;"> <strong>Esamas paveikslelis: </strong> </span>
                                <br>
                                <img style="width: 300px; height: 150px" src="img_upload/<?php echo $ImgEdit ?>" alt="">
                                <br>
                                <label for="paveiksliuko_parinkimas">Pasirinkite paveiksleli: </label>
                                <input type="File" class="form-control" name="Image" id="paveiksliuko_parinkimas">
                            </div>

                            <div class="form-group">

                                <label for="straipsnio_laukas">Straipsnis: </label>
                                <textarea class="form-control" name="siusti" id="straipsnio_laukas">
                                <?php echo $PostEdit ?></textarea>
                            </div>

                            <input class="btn btn-success btn-block" type="Submit" name="tvirtinti"
                                value="Redaguoti straipsni">
                        </fieldset>
                        <br>
                    </form>
                </div>
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