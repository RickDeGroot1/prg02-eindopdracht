<?php
$result = $_GET['id'];
/** @var mysqli $db */

require_once 'includes/database.php';

$query = "SELECT * FROM adventure WHERE adventure_id = $result";
$result = mysqli_query($db, $query)
or die('Error '.mysqli_error($db).' with query '.$query);

$adventures = [];

$row = mysqli_fetch_assoc($result);
$adventures[] = $row;

mysqli_close($db);

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
<header>
    <?php
    require_once 'includes/nav.php';
    ?>
</header>
<main>
    <?php foreach ($adventures as $index => $adventure) { ?>
    <h2 class="title mt-4"><?= $adventure['adventure_name'] ?> details</h2>
    <section class="content">
        <ul>
            <li>Name: <?= $adventure['adventure_name'] ?> </li>
            <li>Description: <?= $adventure['description'] ?> </li>
            <li>Price: <?= $adventure['price'] ?> </li>
        </ul>
        <?php } ?>
    </section>
</main>
</body>
</html>