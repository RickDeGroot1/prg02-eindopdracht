<?php
if (!isset($_SESSION)) {
    session_start();
}
if(!isset($_SESSION['user']))  {
    header('Location: login.php');
    exit();
}

$result = $_GET['id'];
/** @var mysqli $db */

require_once 'includes/database.php';

$query = "DELETE FROM adventure WHERE adventure_id = $result";
$result = mysqli_query($db, $query)
or die('Error '.mysqli_error($db).' with query '.$query);

if ($result) {
    $success = "Successfully removed from the database! ";
} else {
    $errors['db'] = mysqli_error($db);
}

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
    <?php
    if (isset($errors['db'])) {
        echo $errors['db'];
    } elseif (isset($success)) {
        echo $success;
    }
    ?>
</main>
</body>
</html>
