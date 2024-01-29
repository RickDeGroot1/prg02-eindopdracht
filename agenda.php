<?php
if (!isset($_SESSION)) {
session_start();
}
if (!isset($_SESSION['user'])) {
header("Location: login.php");
exit;
}
/** @var $db */
require_once 'includes/database.php';

$userid = $_SESSION['user']['id'];

$query = "SELECT adventure.adventure_name, reservations.date, adventure.price, reservations.reservation_id
        FROM adventure
        INNER JOIN reservations
        ON adventure.adventure_id=reservations.adventure_id
        WHERE reservations.user_id=$userid";

$result = mysqli_query($db, $query)
or die('Error '.mysqli_error($db).' with query '.$query);

$reservations = [];
while($row = mysqli_fetch_assoc($result))
    $reservations[] = $row;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Agenda</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
<header>
    <?php
    include_once 'includes/nav.php'
    ?>
</header>
<main class="agendaMain">
    <h1>Your reservations</h1>
    <?php if(!empty($reservations)): ?>
        <table>
            <thead>
            <tr>
                <th>Adventure name</th>
                <th>Price</th>
                <th>Date</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($reservations as $index => $reservation) { ?>
                <tr>
                    <td><?= $reservation['adventure_name'] ?></td>
                    <td><?= $reservation['price'] ?></td>
                    <td><?= $reservation['date'] ?></td>
                    <td><a href="updateReservations.php?id=<?= $reservation['reservation_id'] ?>">Update</a> </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    <?php else: ?>
            <h1>Your reservations</h1>
            <div>
                <p>No reservations found...</p>
            </div>
    <?php endif; ?>
</main>
</body>
</html>

