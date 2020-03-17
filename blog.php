<?php require "includes\db.php";?>
<?php require "includes\Functions.php";?>
<?php require "includes\sessions.php";?>

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
                <li class="nav-item active"> <a style="color: white" class="nav-link" href="blog.php?Page=1">Straipsniai
                    </a> </li>
                <li class="nav-item active"> <a style="color: white" class="nav-link" href="#">Apie mus </a> </li>
                <li class="nav-item active"> <a style="color: white" class="nav-link" href="#">Paslaugos </a> </li>
                <li class="nav-item active"> <a style="color: white" class="nav-link" href="#">Kontaktai </a> </li>
                <li class="nav-item active"> <a style="color: white" class="nav-link" href="#">Ypatybes </a> </li>
            </ul>
            <form action="blog.php" class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Paieska" aria-label="Search"
                    name="search">
                <button class="btn btn-outline-success my-2 my-sm-0 " name="SearchButton">Ieskoti</button>
            </form>
        </div>
    </nav>

    <div class="container">
        <div class="blog-header">
            <br>
            <h1>Siandienines aktualijos</h1>
            <br>
            <div class="row">
                <div class="col-sm-8">

                    <?php

global $Conn;

if (isset($_GET["SearchButton"])) {
    $Search = $_GET["search"];

    $postView = "SELECT * FROM admin_panel WHERE dateTime LIKE '%$Search%' OR title LIKE '%$Search%' OR category LIKE '%$Search%' OR post LIKE '%$Search%' ORDER BY dateTime desc";

} elseif (isset($_GET["kategorija"])) {

    $Category = $_GET["kategorija"];
    $postView = "SELECT * FROM admin_panel WHERE category = '$Category' ORDER BY dateTime desc";

} elseif (isset($_GET["Page"])) {
    $Page = $_GET["Page"];

    if ($Page == 0 || $Page < 0) {
        $Show_post = 0;

    } else {
        $Show_post = ($Page * 5) - 5;
    }

    $postView = "SELECT * FROM admin_panel ORDER BY dateTime desc LIMIT $Show_post, 5";
} else {
    $postView = "SELECT * FROM admin_panel ORDER BY dateTime desc LIMIT 0,3";
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
                            <p><?php
if (strlen($Post) > 200) {
        $Post = substr($Post, 0, 200) . '...';
        echo $Post;
    }
    ?></p>

                            <?php
global $Conn;
    $View = "SELECT COUNT(*) FROM comments WHERE admin_panel_id='$PostId' AND status='ON'";
    $Execute_Approved = mysqli_query($Conn, $View);
    $Data_count = mysqli_fetch_array($Execute_Approved);
    $Total_count_approved = array_shift($Data_count);

    ?>
                            <span class="badge badge-pill badge-warning fa-pull-right">Komentarai :
                                <?php echo $Total_count_approved; ?></span>

                        </div>
                        <a href="pilnasStraipsnis.php?id=<?php echo $PostId; ?>"><button
                                class="btn btn-info">Placiau...</button>
                        </a>
                    </div>
                    <?php }?>
                    <br>
                    <nav>
                        <ul class="pagination pagination-lg">

                            <!-- Back mygtuko sukurimas -->

                            <?php if (isset($Page)) {
    if ($Page > 1) {?>
                            <li class="page-item"><a class="page-link" href="Blog.php?Page=<?php echo $Page - 1 ?>">
                                    &laquo; </a> </li>
                            <?php }
}?>
                            <?php
global $Conn;
$Post_numbering = "SELECT COUNT(*) FROM admin_panel";
$Execute_post_numbering = mysqli_query($Conn, $Post_numbering);
$Post_count = mysqli_fetch_array($Execute_post_numbering);
$Total_post = array_shift($Post_count);

$Post_per_page = $Total_post / 5;
$Post_per_page = ceil($Post_per_page);

for ($i = 1; $i <= $Post_per_page; $i++) {

    if (isset($Page)) {
        if ($i == $Page) {
            ?> <li class="active page-item"><a class="page-link" href="blog.php?Page=<?php echo $i ?>">
                                    <?php echo $i ?></a></li>
                            <?php
} else {?>
                            <li class="page-item"><a class="page-link" href="blog.php?Page=<?php echo $i ?>">
                                    <?php echo $i ?></a></li>
                            <?php }
    }
}?>

                            <!-- Forward mygtuko sukurimas -->

                            <?php if (isset($Page)) {
    if ($Page + 1 <= $Post_per_page) {?>
                            <li class="page-item"><a class="page-link" href="Blog.php?Page=<?php echo $Page + 1 ?>">
                                    &raquo; </a> </li>
                            <?php }
}?>

                        </ul>
                    </nav>
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
                        <div class="card-body">
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
                        <div class="card-footer"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div id="footer">
        <p>Sukurta | Andrejus Kruglekovas | kopija: 2019 - 2020 --- Visos teises saugomos.</p>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quod atque modi
            repudiandae consequuntur
            sapiente
            eligendi, tempore molestiae facere quis placeat cum deserunt iusto! Ex ullam repudiandae laudantium ad,
            possimus autem?</p>


    </div>




    <script src="libs\jquery.3.4.1\jquery_3_4_1.js"></script>
    <script src="libs\bootstrap_4_3_1\js\bootstrap.js"></script>
</body>

</html>