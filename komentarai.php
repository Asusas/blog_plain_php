<?php require "includes\db.php";?>
<?php require "includes\Functions.php";?>
<?php require "includes\sessions.php";?>
<?php prisijungimo_patvirtinimas();?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="libs\bootstrap_4_3_1\css\bootstrap.css">
    <link rel="stylesheet" href="libs\fontawesome_icons\css\all.css">
    <link rel="stylesheet" href="css\styles.css">

    <title>Meniu</title>
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
                                class="far fa-newspaper"></i> Kurti nauja straipsni</a></li>
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
                <h4>Nepatvirtinti komentarai</h4>
                <div> <?php echo ErrorSMS(); ?> </div>
                <div>
                    <table class="table table-responsive table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Nr.</th>
                                <th>Vartotojas</th>
                                <th>Data</th>
                                <th>Komentaras</th>
                                <th>Patvirtinti</th>
                                <th>Istrinti</th>
                                <th>Placiau</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
global $Conn;
$View = "SELECT * FROM comments WHERE status='OFF' ORDER by dateTime desc";
$Execute = mysqli_query($Conn, $View);
$Nr = 0;

while ($Data = mysqli_fetch_array($Execute)) {
    $CommentId = $Data["id"];
    $DateTime = $Data["dateTime"];
    $User_name = $Data["name"];
    $Comment = $Data["comment"];
    $Comment_Id = $Data["admin_panel_id"];
    $Nr++;

    // if (strlen($Comment) > 100) {
    //     $Comment = substr($Comment, 0, 100) . '...';
    // }

    if (strlen($DateTime) > 10) {
        $DateTime = substr($DateTime, 0, 10) . '...';
    }

    ?>

                            <tr>
                                <td><?php echo $Nr ?></td>
                                <td><?php echo $User_name ?></td>
                                <td><?php echo $DateTime ?></td>
                                <td><?php echo $Comment ?></td>
                                <td> <span class="btn btn-success"> <a style="text-decoration: none; color: white"
                                            href="patvirtinti_komentarai.php?id=<?php echo $CommentId; ?>">Patvirtinti</a>
                                    </span></td>
                                <td> <span class="btn btn-danger"> <a style="text-decoration: none; color: white"
                                            href="istrinti_Komentara.php?id=<?php echo $CommentId; ?>">Istrinti</a>
                                    </span></td>
                                <td> <span class="btn btn-info"> <a style="text-decoration: none; color: white"
                                            href="pilnasStraipsnis.php?id=<?php echo $Comment_Id; ?>"
                                            target="_blank">Placiau</a>
                                    </span>
                                </td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </div>
                <h4>Patvirtinti komentarai</h4>
                <div> <?php echo SuccessSMS(); ?> </div>
                <div>
                    <table class="table table-responsive table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Nr.</th>
                                <th>Vartotojas</th>
                                <th>Data</th>
                                <th>Komentaras</th>
                                <th>Kas patvirtino</th>
                                <th>Atsaukti</th>
                                <th>Istrinti</th>
                                <th>Placiau</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

global $Conn;
$View = "SELECT * FROM comments WHERE status='ON' ORDER by dateTime desc";
$Execute = mysqli_query($Conn, $View);
$Nr = 0;

while ($Data = mysqli_fetch_array($Execute)) {
    $CommentId = $Data["id"];
    $DateTime = $Data["dateTime"];
    $User_name = $Data["name"];
    $Comment = $Data["comment"];
    $ApprovedBy = $Data["approvedby"];
    $Comment_Id = $Data["admin_panel_id"];
    $Nr++;

    // if (strlen($Comment) > 100) {
    //     $Comment = substr($Comment, 0, 100) . '...';
    // }

    if (strlen($DateTime) > 10) {
        $DateTime = substr($DateTime, 0, 10) . '...';
    }

    ?>

                            <tr>
                                <td><?php echo $Nr ?></td>
                                <td><?php echo $User_name ?></td>
                                <td><?php echo $DateTime ?></td>
                                <td><?php echo $Comment ?></td>
                                <td><?php echo $ApprovedBy ?></td>
                                <td> <span class="btn btn-secondary"> <a style="text-decoration: none; color: white"
                                            href="atsaukti_Komentarai.php?id=<?php echo $CommentId; ?>">Atsaukti</a>
                                    </span></td>
                                <td> <span class="btn btn-danger"> <a style="text-decoration: none; color: white"
                                            href="istrinti_Komentara.php?id=<?php echo $CommentId; ?>">Istrinti</a>
                                    </span></td>
                                <td> <span class="btn btn-info"> <a style="text-decoration: none; color: white"
                                            href="pilnasStraipsnis.php?id=<?php echo $Comment_Id; ?>"
                                            target="_blank">Placiau</a>
                                    </span>
                                </td>

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