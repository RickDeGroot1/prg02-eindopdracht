<?php

/** @var mysqli $db */
require_once 'includes/database.php';

$query = "SELECT * FROM adventure";
$result = mysqli_query($db, $query)
or die('Error '.mysqli_error($db).' with query '.$query);

$adventures = [];
while($row = mysqli_fetch_assoc($result))
    $adventures[] = $row;

// Close the connection
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
<main class="adventuresMain">
    <table>
        <thead>
        <tr>
            <th>#</th>
            <th>Adventure</th>
            <th>Description</th>
            <th>Price</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($adventures as $index => $adventure) { ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= $adventure['adventure_name'] ?></td>
                <td><?= $adventure['description'] ?></td>
                <td><?= $adventure['price'] ?></td>
                <td><a href="details.php?id=<?= $adventure['adventure_id'] ?>">Details</a></td>
                <td><a href="delete.php?id=<?= $adventure['adventure_id'] ?>">Delete</td>
                <td><a href="update.php?id=<?= $adventure['adventure_id'] ?>">Update</a> </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</main>
</body>
</html>
