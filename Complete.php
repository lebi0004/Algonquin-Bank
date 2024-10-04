<?php 
session_start(); // Start the session

// Ensure the user has completed all steps before accessing this page
if (!isset($_SESSION['name']) || !isset($_SESSION['contactMethod'])) {
    header("Location: CustomerInfo.php");
    exit();
}


include("./common/header.php"); 

// Retrieve session data
$name = $_SESSION['name'] ?? '';
$contactMethod = $_SESSION['contactMethod'] ?? '';
$phoneNumber = $_SESSION['phoneNumber'] ?? '';
$emailAddress = $_SESSION['emailAddress'] ?? '';
$preferredTimes = $_SESSION['preferredTimes'] ?? [];

// Format preferred times if the contact method is phone
$timeMessage = '';
if ($contactMethod === 'Phone' && !empty($preferredTimes)) {
    if (count($preferredTimes) > 1) {
        $lastTimeSlot = array_pop($preferredTimes);
        $formattedOutput = implode(', ', $preferredTimes) . ' or ' . $lastTimeSlot;
    } else {
        $formattedOutput = $preferredTimes[0];
    }
}

// Display the page content
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete</title>
    <link rel="stylesheet" href="style.css" type="text/css"/>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="text-center">
    <h1 class="display-4">Thank You, <?= htmlspecialchars($name); ?>!</h1>
    <p>
        Thank you for using our deposit calculation tool.
        <?php if ($contactMethod === 'Phone'): ?>
            <p>We will call you tomorrow at <?= htmlspecialchars($formattedOutput); ?> to discuss your inquiry, <?= htmlspecialchars($phoneNumber); ?>.</p>
        <?php elseif ($contactMethod === 'Email'): ?>
            <p>You will receive an email shortly at <?= htmlspecialchars($emailAddress); ?>.</p>
        <?php endif; ?>
    </p>
</div>

<?php include("./common/footer.php"); ?>

</body>
</html>

<?php
// Clear all session data after displaying the page
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session completely

// Optionally, you can redirect the user to the home page or a confirmation page
 //header("Location: Index.php");
// exit();
?>
