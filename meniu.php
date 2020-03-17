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
                            <?php

global $Conn;
$View = "SELECT COUNT(*) FROM comments WHERE status='OFF'";
$Execute_Total = mysqli_query($Conn, $View);
$Data_count = mysqli_fetch_array($Execute_Total);
$Total_count_total = array_shift($Data_count);
?>
                            Komentarai
                            <?php if ($Total_count_total > 0) {?>
                            <span class="btn btn-warning float-right" style="padding: 0em 1em">
                                <?php echo $Total_count_total; ?></span>
                            <?php }?>
                        </a> </li>
                    <li class="nav-item list"> <a class="nav-link" href="blog.php?Page=1" target="_blank"><i
                                class="far fa-eye"></i>
                            Sekimas</a> </li>
                    <li class="nav-item list"> <a class="nav-link" href="atsijungimas.php"><i
                                class="fas fa-sign-out-alt"></i>
                            Atsijungti</a> </li>
                </ul>
            </div>
            <div class="col-sm-9">
                <h4>Monitoringas</h4>
                <div> <?php echo ErrorSMS(); ?> </div>
                <div> <?php echo SuccessSMS(); ?> </div>

                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Nr.</th>
                                <th>Straipsnio pavadinimas</th>
                                <th>Sukurimo laikas</th>
                                <th>Autorius</th>
                                <th>Kategorija</th>
                                <th>Banner'is</th>
                                <th>Komentarai</th>
                                <th>Veiksmai</th>
                                <th> Smulkmenos</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
global $Conn;
$View = "SELECT * FROM admin_panel ORDER BY dateTime desc";
$Execute = mysqli_query($Conn, $View);
$Nr = 0;
while ($Data = mysqli_fetch_array($Execute)) {
    $PostId = $Data["id"];
    $DateTime = $Data["dateTime"];
    $Title = $Data["title"];
    $Category = $Data["category"];
    $Admin = $Data["author"];
    $Img = $Data["image"];
    $Post = $Data["post"];
    $Nr++;
    ?>
                            <tr>
                                <td><?php echo $Nr ?> </td>
                                <td> <?php
if (strlen($Title) > 10) {
        $Title = substr($Title, 0, 10) . '...';
    }
    echo $Title?></td>
                                <td> <?php
if (strlen($DateTime) > 10) {
        $DateTime = substr($DateTime, 0, 10) . '...';
    }

    echo $DateTime?></td>
                                <td><?php
if (strlen($Admin) > 10) {
        $Admin = substr($Admin, 0, 10) . '...';
    }

    echo $Admin?> </td>
                                <td><?php echo $Category ?> </td>
                                <td><img style="width: 150px; height: 100px" src="img_upload/<?php echo $Img ?>" alt="">
                                </td>
                                <td>
                                    <?php
global $Conn;
    $View = "SELECT COUNT(*) FROM comments WHERE admin_panel_id='$PostId' AND status='ON'";
    $Execute_Disapproved = mysqli_query($Conn, $View);
    $Data_count = mysqli_fetch_array($Execute_Disapproved);
    $Total_count_dissapproved = array_shift($Data_count);

    ?>
                                    <?php
global $Conn;
    $View = "SELECT COUNT(*) FROM comments WHERE admin_panel_id='$PostId' AND status='OFF'";
    $Execute_Approved = mysqli_query($Conn, $View);
    $Data_count = mysqli_fetch_array($Execute_Approved);
    $Total_count_approved = array_shift($Data_count);

    ?>
                                    <span
                                        class="btn btn-success fa-pull-right"><?php echo $Total_count_dissapproved; ?></span>
                                    <span
                                        class="btn btn-danger fa-pull-left"><?php echo $Total_count_approved; ?></span>
                                </td>
                                <td>
                                    <a href="redaguoti_straipsni.php?Redaguoti=<?php echo $PostId ?>"> <span
                                            class="btn btn-primary">Redaguoti</span> </a>
                                    <a href="trinti_straipsni.php?Trinti=<?php echo $PostId ?>"><span
                                            class="btn btn-danger">Trinti</span></a>
                                </td>
                                <td> <a href="pilnasStraipsnis.php?id=<?php echo $PostId ?>" target="_blank"> <span
                                            class="btn btn-info">Placiau</span></a> </td>
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