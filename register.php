<?php
if(isset($_POST['submit'])) {
    // Get form data
    /** @var $db */
    require_once 'includes/database.php';
    $firstName = mysqli_real_escape_string($db, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($db, $_POST['lastName']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $phone = mysqli_real_escape_string($db, $_POST['phone']);
    $dob = mysqli_real_escape_string($db, $_POST['dob']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    // Server-side validation
    $errors = [];
    if($firstName == '') {
        $errors['firstName'] = 'Enter your first name.';
    }
    if($lastName == '') {
        $errors['lastName'] = 'Enter your last name.';
    }
    if($email == '') {
        $errors['email'] = 'Enter your email.';
    }
    if($phone == '') {
        $errors['phone'] = 'Enter your phone number .';
    }
    if($dob == '') {
        $errors['dob'] = 'Fill in your date of birth.';
    }
    if($password == '') {
        $errors['wachtwoord'] = 'Enter a password.';
    }

    $query = "SELECT * FROM user WHERE email = '$email'";
    $result = mysqli_query($db, $query);
    $user = mysqli_fetch_assoc($result);
    if($user) {
        $errors['email'] = 'Email already in use.';
    }

    if (empty($errors)) {
        //INSERT in DB
        $password = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO user (`first_name`, `last_name`, `email`, `password`, `phone`, `date_of_birth`)
                    VALUES('$firstName', '$lastName', '$email', '$password', '$phone', '$dob')";
        $result = mysqli_query($db, $query);

        if ($result) {
            $success = 'User ' . htmlentities($_POST['firstName']) . 'Registered successfully!';
        } else {
            $errors['db'] = mysqli_error($db);
        }
    }
    mysqli_close($db);
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
<header>
    <?php
    include_once 'includes/nav.php';
    ?>
</header>
<main class="registratieMain">
    <section>
            <form id="emailPasswordForm" action="" method="post">
                <?php
                if (isset($errors['db'])) {
                    echo $errors['db'];
                } elseif (isset($success)) {
                    echo $success;
                }
                ?>
                <h1>Registreer</h1>
                <label for="firstName">First Name:</label>
                <input type="text" id="firstName" name="firstName">
                <p><?= $errors['firstName'] ?? '' ?></p>

                <label for="lastName">Last Name:</label>
                <input type="text" id="lastName" name="lastName">
                <p><?= $errors['lastName'] ?? '' ?></p>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email">
                <p><?= $errors['email'] ?? '' ?></p>

                <label for="phone">Phone Number:</label>
                <input type="text" id="phone" name="phone">
                <p><?= $errors['phone'] ?? '' ?></p>

                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob">
                <p><?= $errors['dob'] ?? '' ?></p>

                <label for="password">Password:</label>
                <input type="text" id="password" name="password">
                <p><?= $errors['password'] ?? '' ?></p>

                <input type="submit" name="submit" value="submit">
            </form>
    </section>
</main>
</body>
</html>
