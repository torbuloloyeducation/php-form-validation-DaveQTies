<?php
$name = $email = $gender = $website = $phone = $password = $confirmPassword = "";
$nameErr = $emailErr = $genderErr = $websiteErr = $phoneErr = $passwordErr = $confirmErr = $termsErr = "";
$submitCount = 0;

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $submitCount = isset($_POST["submit_count"]) ? (int)$_POST["submit_count"] + 1 : 1;

    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = test_input($_POST["name"]);
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    if (empty($_POST["gender"])) {
        $genderErr = "Gender is required";
    } else {
        $gender = test_input($_POST["gender"]);
    }

    if (!empty($_POST["website"])) {
        $website = test_input($_POST["website"]);
        if (!filter_var($website, FILTER_VALIDATE_URL)) {
            $websiteErr = "Invalid URL format";
        }
    }

    if (empty($_POST["phone"])) {
        $phoneErr = "Phone number is required";
    } else {
        $phone = test_input($_POST["phone"]);
        if (!preg_match('/^[+]?[0-9 \-]{7,15}$/', $phone)) {
            $phoneErr = "Invalid phone format";
        }
    }

    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = $_POST["password"];
        if (strlen($password) < 8) {
            $passwordErr = "Password must be at least 8 characters";
        }
    }

    if (empty($_POST["confirm_password"])) {
        $confirmErr = "Please confirm your password";
    } else {
        $confirmPassword = $_POST["confirm_password"];
        if ($confirmPassword !== $password) {
            $confirmErr = "Passwords do not match";
        }
    }

    if (!isset($_POST["terms"])) {
        $termsErr = "You must agree to the terms and conditions";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>PHP Form Validation</title>
    <style>
        .error { color: red; font-size: 13px; }
        body { font-family: Arial; margin: 30px; }
        input, select { margin-bottom: 5px; }
        label { display: inline-block; width: 150px; }
    </style>
</head>
<body>

<h2>PHP Form Validation</h2>

<p>Submission attempt: <?= $submitCount ?></p>

<form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>">

    <input type="hidden" name="submit_count" value="<?= $submitCount ?>">

    <label>Name:</label>
    <input type="text" name="name" value="<?= $name ?>">
    <span class="error"><?= $nameErr ?></span><br>

    <label>Email:</label>
    <input type="text" name="email" value="<?= $email ?>">
    <span class="error"><?= $emailErr ?></span><br>

    <label>Gender:</label>
    <input type="radio" name="gender" value="Male" <?= ($gender == "Male") ? "checked" : "" ?>> Male
    <input type="radio" name="gender" value="Female" <?= ($gender == "Female") ? "checked" : "" ?>> Female
    <span class="error"><?= $genderErr ?></span><br>

    <label>Website:</label>
    <input type="text" name="website" value="<?= $website ?>">
    <span class="error"><?= $websiteErr ?></span><br>

    <label>Phone:</label>
    <input type="text" name="phone" value="<?= $phone ?>">
    <span class="error"><?= $phoneErr ?></span><br>

    <label>Password:</label>
    <input type="password" name="password">
    <span class="error"><?= $passwordErr ?></span><br>

    <label>Confirm Password:</label>
    <input type="password" name="confirm_password">
    <span class="error"><?= $confirmErr ?></span><br>

    <label>Terms:</label>
    <input type="checkbox" name="terms"> I agree to the terms and conditions
    <span class="error"><?= $termsErr ?></span><br><br>

    <input type="submit" value="Submit">

</form>

<?php
$noErrors = empty($nameErr) && empty($emailErr) && empty($genderErr) &&
            empty($websiteErr) && empty($phoneErr) && empty($passwordErr) &&
            empty($confirmErr) && empty($termsErr);

if ($_SERVER["REQUEST_METHOD"] == "POST" && $noErrors):
?>
<h3>Form Submitted Successfully!</h3>
<p><b>Name:</b> <?= $name ?></p>
<p><b>Email:</b> <?= $email ?></p>
<p><b>Gender:</b> <?= $gender ?></p>
<p><b>Website:</b> <?= $website ?></p>
<p><b>Phone:</b> <?= $phone ?></p>
<?php endif; ?>

</body>
</html>