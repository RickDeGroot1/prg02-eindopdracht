<?php
if (!isset($_SESSION)) {
    session_start();
}
if(!isset($_SESSION['user']))  {
    header('Location: login.php');
    exit();
}

/** @var $db */
require_once 'includes/database.php';

$query = "SELECT * FROM adventure";
$result = mysqli_query($db, $query);
$adventures = mysqli_fetch_all($result, MYSQLI_ASSOC);

if(isset($_POST['submit'])) {
    // Get form data
    $adventure = mysqli_real_escape_string($db, $_POST['adventure']);
    $date = mysqli_real_escape_string($db, $_POST['date']);
    $id = $_SESSION['user']['id'];

    // Server-side validation
    $errors = [];
    if($adventure == '') {
        $errors['adventure'] = 'Please select an adventure.';
    }
    if($date == '') {
        $errors['date'] = 'Please select a date.';
    }
    if (empty($errors)) {
        //INSERT in DB
        $query = "INSERT INTO reservations (`date`, `adventure_id`, `user_id`)
                    VALUES('$date', '$adventure', '$id')";
        $result = mysqli_query($db, $query);

        if ($result) {
            $success = 'Reservation successful!';
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
    <form id="addAdventureForm" action="" method="post">
        <?php
        if (isset($errors['db'])) {
            echo $errors['db'];
        } elseif (isset($success)) {
            echo $success;
        }
        ?>
        <label for="adventure">Choose an adventure:</label>
        <select id="adventure" name="adventure">
            <option value="" selected="">Please select</option>
            <?php foreach($adventures as $adventure): ?>
                <option value="<?php echo $adventure['adventure_id']?>">
                    <?php echo $adventure['adventure_name']?>
                </option>
            <?php endforeach; ?>
        </select>
        <p><?= $errors['adventure'] ?? '' ?></p>
        <label for="date">Adventure Date</label>
        <input type="date" id="date" name="date">
        <p><?= $errors['date'] ?? '' ?></p>
        <input type="submit" name="submit" value="submit">
    </form>
</main>
</body>
</html>
