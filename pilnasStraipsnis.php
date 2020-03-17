<?php require "includes\db.php";?>
<?php require "includes\Functions.php";?>
<?php require "includes\sessions.php";?>

<?php

if (isset($_POST['tvirtinti'])) {

    global $Conn;
    $Name = mysqli_real_escape_string($Conn, $_POST['vardas']);
    $Email = mysqli_real_escape_string($Conn, $_POST['el_pastas']);
    $Comment = mysqli_real_escape_string($Conn, $_POST['komentaras']);

    date_default_timezone_set("Europe/Vilnius");
    $CurrentTime = time();
    $DateTime = strftime("%Y-%m-%d %H:%M:%S", $CurrentTime);
    $PostId_URL = $_GET["id"];

    if (empty($Name) || empty($Email) || empty($Comment)) {
        $_SESSION["ErrorMessage"] = "Iveskite reikiamus laukus !";

    } elseif (strlen($Comment) > 400) {
        $_SESSION["ErrorMessage"] = "Maksimalus komentaro simboliu skacius yra 400 !";

    } else {
        $PostId_from_comments = $_GET['id'];
        $Query = "INSERT into comments (dateTime, name, email, comment, approvedby, status, admin_panel_id) VALUES ('$DateTime','$Name','$Email','$Comment', 'Pending', 'OFF', '$PostId_from_comments')";
        $Execute = mysqli_query($Conn, $Query);

        if ($Execute) {
            $_SESSION["SucessMessage"] = "Komentaras sukurtas sekmingai ! Laukite administratoriaus patvirtinimo.";
            redirect_to("pilnasStraipsnis.php?id=$PostId_URL");
        } else {
            $_SESSION["ErrorMessage"] = "Komentaro sukurti nepavyko !";
            redirect_to("pilnasStraipsnis.php?id=$PostId_URL>");
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

    <div class="container">
        <div class="blog-header">
            <h1>Antraste</h1>
            <p class="lead">Straipsnis</p>
            <div class="row">
                <div class="col-sm-8">

                    <?php

global $Conn;

if (isset($_GET["SearchButton"])) {
    $Search = $_GET["search"];
    $postView = "SELECT * FROM admin_panel WHERE dateTime LIKE '%$Search%' OR title LIKE '%$Search%' OR category LIKE '%$Search%' OR post LIKE '%$Search%'";
} else {

    $PostId_URL = $_GET["id"];
    $postView = "SELECT * FROM admin_panel WHERE id='$PostId_URL' ORDER BY dateTime desc";
}

$Execute = mysqli_query($Conn, $postView);
while ($Data = mysqli_fetch_array($Execute)) {
    $PostId = $Data["id"];
    $DateTime = $Data["dateTime"];
    $Title = $Data["title"];
    $Category = $Data["category"];
    $Admin = $Data["author"];
    $Img = $Data["image"];
    $Post = $Data["post"];

    ?>
                    <div class="img-thumbnail">
                        <img class="img-fluid rounded" src="img_upload/<?php echo $Img ?>">
                        <div class="figure-caption">
                            <h1><?php echo $Title ?></h1>
                            <p>Kategorija: <?php echo $Category ?> </p>
                            <p>Paskelbta: <?php echo $DateTime ?></p>

                            <!-- nl2br - funkcija, kuri leidzia kuriant nauja straipsni rasyti teksta is naujos eilutes (naudojant shift + enter klavisu kombinacija) -->

                            <p><?php echo nl2br($Post) ?></p>
                        </div>
                    </div>
                    <?php }?>

                    <br>
                    <span><b>Komentarai:</b></span>
                    <?php

global $Conn;
$Comment_Id = $_GET["id"];
$Comment_extract = "SELECT * FROM comments WHERE admin_panel_id='$Comment_Id' AND status='ON'";
$Execute = mysqli_query($Conn, $Comment_extract);

while ($Data = mysqli_fetch_array($Execute)) {
    $DateTime = $Data["dateTime"];
    $User_name = $Data["name"];
    $Comment = $Data["comment"];

    ?>

                    <br>
                    <br>
                    <div>
                        <img class="fa-pull-left" src="img/user-4.png" style="widht: 60px; height: 60px">
                        <p style="margin-left: 100px"> Vartotojas: <?php echo $User_name ?></p>
                        <p style="margin-left: 100px"> Komentaro data: <?php echo $DateTime ?></p>

                        <!-- nl2br - funkcija, kuri leidzia kuriant nauja straipsni rasyti teksta is naujos eilutes (naudojant shift + enter klavisu kombinacija) -->

                        <p> Komentaras: <?php echo nl2br($Comment) ?></p>
                    </div>
                    <hr>
                    <?php }?>
                    <br>
                    <strong style="font-size: 2em; Color: red">Pasidalinkite savo mintimis</strong>
                    <div>
                        <div> <?php echo ErrorSMS(); ?> </div>
                        <div> <?php echo SuccessSMS(); ?> </div>
                        <form action="pilnasStraipsnis.php?id=<?php echo $PostId_URL ?>" method="post"
                            enctype="multipart/form-data">
                            <fieldset>

                                <div class="form-group">
                                    <label for="Vardas"> <strong>Lankytojo vardas:</strong> </label>
                                    <input class="form-control" type="text" name="vardas" id="vardas"
                                        placeholder="Vardas">
                                </div>

                                <div class="form-group">
                                    <label for="pastas"> <strong>El. pastas:</strong> </label>
                                    <input class="form-control" type="email" name="el_pastas" id="pastas"
                                        placeholder="Elektroninis pastas">
                                </div>

                                <div class="form-group">
                                    <label for="komentaro_laukas"> <strong>Komentaras:</strong> </label>
                                    <textarea class="form-control" name="komentaras" id="komentaro_laukas"></textarea>
                                </div>

                                <input class="btn btn-primary btn-block" type="Submit" name="tvirtinti"
                                    value="Siusti komentara!">
                            </fieldset>

                            <br>
                        </form>
                    </div>
                </div>
                <div class="offset-sm-1 col-sm-3">
                    <h2>Apie mus</h2>
                    <img class="img-fluid" src="img/code.jpeg" alt="">
                    <p style="text-align: justify">Lorem Ipsum is simply dummy text of the printing and typesetting
                        industry. Lorem Ipsum has been
                        the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley
                        of type and scrambled it to make a type specimen book. It has survived not only five centuries,
                        but also the leap into electronic typesetting, remaining essentially unchanged. It was
                    </p>
                    <div class="card text-white bg-info mb-3">
                        <div class="card-header">
                            <h2 class="card-title">Kategorijos</h2>
                        </div>
                        <div class="card-body" style="background-color:">
                            <ol>
                                <?php
global $Conn;
$ViewQuery = "SELECT * FROM category ORDER BY dateTime";
$Execute = mysqli_query($Conn, $ViewQuery);

while ($Data = mysqli_fetch_array($Execute)) {
    $Id = $Data['id'];
    $Category = $Data['name'];
    ?>
                                <a style="color:white" href="blog.php?kategorija=<?php echo $Category ?>">
                                    <li><?php echo $Category ?></li>
                                </a>
                                <?php }?>
                            </ol>
                        </div>
                        <div class="card-footer">
                        </div>
                    </div>
                    <div class="card text-white bg-info mb-3">
                        <div class="card-header">
                            <h2 class="card-title">Naujausias straipsnis</h2>
                        </div>
                        <div class="card-body">

                            <?php
global $Conn;
$ViewQuery = "SELECT * FROM admin_panel ORDER BY dateTime desc LIMIT 0,3 ";
$Execute = mysqli_query($Conn, $ViewQuery);
while ($Data = mysqli_fetch_array($Execute)) {
    $Id = $Data['id'];
    $Title = $Data['title'];
    $DateTime = $Data['dateTime'];
    $Image = $Data['image'];

    if (strlen($DateTime) > 10) {
        $DateTime = substr($DateTime, 0, 10);
    }
    ?>
                            <div>
                                <img class="img-fluid fa-pull-left" src="img_upload/<?php echo $Image ?>" alt="">
                                <a style="color: white" href="pilnasStraipsnis.php?id=<?php echo $Id ?>">
                                    <p class="fa-pull-left"><?php echo $Title ?></p>
                                </a>

                                <p class="fa-pull-right"><?php echo $DateTime ?></p>
                            </div>
                            <br>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="footer">
            <p>Sukurta | Andrejus Kruglekovas | kopija: 2019 - 2020 --- Visos teises saugomos.</p>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quod atque modi repudiandae consequuntur
                sapiente
                eligendi, tempore molestiae facere quis placeat cum deserunt iusto! Ex ullam repudiandae laudantium ad,
                possimus autem?</p>

        </div>

        <script src="libs\jquery.3.4.1\jquery_3_4_1.js"></script>
        <script src="libs\bootstrap_4_3_1\js\bootstrap.js"></script>
</body>

</html>