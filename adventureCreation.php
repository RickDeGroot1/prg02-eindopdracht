<?php

session_start();

if(!isset($_SESSION['user']))  {
    header('Location: index.php');
    exit();
}

if(isset($_POST['submit'])) {
    // Get form data
    /** @var $db */
    require_once 'includes/database.php';
    $adventureName = mysqli_real_escape_string($db, $_POST['adventureName']);
    $adventureDescription = mysqli_real_escape_string($db, $_POST['adventureDescription']);
    $adventurePrice = mysqli_real_escape_string($db, $_POST['adventurePrice']);

    // Server-side validation
    $errors = [];
    if($adventureName == '') {
        $errors['adventureName'] = 'Please fill in the adventure name.';
    }
    if($adventureDescription == '') {
        $errors['adventureDescription'] = 'Please give a description.';
    }
    if($adventurePrice == '') {
        $errors['adventurePrice'] = 'Please add a price.';
    }

    if (empty($errors)) {
        //INSERT in DB

        $query = "INSERT INTO adventure (`adventure_name`, `description`, `price`)
                    VALUES('$adventureName', '$adventureDescription', '$adventurePrice')";
        $result = mysqli_query($db, $query);

        if ($result) {
            $success = 'Successfully added ' . htmlentities($_POST['adventureName']) . ' to the database!';
        } else {
            $errors['db'] = mysqli_error($db);
        }
        mysqli_close($db);
    }
}

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
<header>
    <?php
    require_once 'includes/nav.php';
    ?>
</header>
<body>
<main>
    <?php
    if (isset($errors['db'])) {
        echo $errors['db'];
    } elseif (isset($success)) {
        echo $success;
    }
    ?>
    <form id="addAdventureForm" action="" method="post">
        <label for="adventureName">Adventure Name:</label>
        <input type="text" id="adventureName" name="adventureName">
        <p><?= $errors['adventureName'] ?? '' ?></p>


        <label for="adventureDescription">Adventure Description:</label>
        <textarea id="adventureDescription" name="adventureDescription" rows="4"></textarea>
        <p><?= $errors['adventureDescription'] ?? '' ?></p>

        <label for="adventurePrice">Price:</label>
        <input type="number" id="adventurePrice" name="adventurePrice" step="0.01">
        <p><?= $errors['adventurePrice'] ?? '' ?></p>

        <input type="submit" name="submit" value="submit"></input>
    </form>
</main>
</body>
</html>
