<?php
//if there is no session
    //start session

//if user does not exist in session
    //send to login page
    //exit code

//make var db
//connect to database using include

//get id from get

//build query to select all from adventure
//get result
//save result into associative array

//if form is submitted
    //get adventure id from post
    //get date from post

    //make empty errors array
        //if adventure is empty
            //add adventure id into array with message to select and adventure
        //if date is empty
            //add date to errors array with message to fill in the date

    //if errors array is empty
        //set up query to update in reservations, the adventure id and date where the id of the reservation is equal to id in get
        //get result from query and save in variable

        //if result has something in it
            //make success array with success message
        //else
            //add database error to error array

    //close connection with database

if (!isset($_SESSION)) {
    session_start();
}
if(!isset($_SESSION['user']))  {
    header('Location: login.php');
    exit();
}

/** @var $db */
require_once 'includes/database.php';

$id = $_GET['id'];

$query = "SELECT * FROM adventure";
$result = mysqli_query($db, $query);
$adventures = mysqli_fetch_all($result, MYSQLI_ASSOC);

if(isset($_POST['submit'])) {
    // Get form data
    $adventure = mysqli_real_escape_string($db, $_POST['adventure']);
    $date = mysqli_real_escape_string($db, $_POST['date']);

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
        $query = "UPDATE reservations 
                    SET adventure_id = '$adventure', date = '$date'
                    WHERE reservation_id = $id";
        $result = mysqli_query($db, $query);

        if ($result) {
            $success = "Successfully edited!";
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
