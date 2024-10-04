<?php 

session_start(); // Start the session

// Ensure the user has completed all steps before accessing this page
if (!isset($_SESSION['name']) || !isset($_SESSION['contactMethod'])) {
    header("Location: CustomerInfo.php");
    exit();
}
include("./common/header.php"); 
include 'functions.php'; 

// Initialize variables from session or default values
$principalAmount = $_SESSION['principalAmount'] ?? '';
$yearsToDeposit = $_SESSION['yearsToDeposit'] ?? '';
$hasErrors = false;
$errors = [];
$form_submitted = false; // Initialize this variable

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle button clicks
    if (isset($_POST['calculate'])) {
        // Validate Principal Amount
        if (empty($_POST['principal'])) {
            $hasErrors = true;
            $errors['principal'] = 'Principal amount is required.';
        } elseif (!is_numeric($_POST['principal']) || $_POST['principal'] <= 0) {
            $hasErrors = true;
            $errors['principal'] = 'Please enter a valid positive number for the principal amount.';
        } else {
            $principalAmount = $_POST['principal'];
            $_SESSION['principalAmount'] = $principalAmount; // Save to session
        }

        // Validate Years to Deposit
        if (empty($_POST['years'])) {
            $hasErrors = true;
            $errors['years'] = 'Number of years is required.';
        } elseif (!is_numeric($_POST['years']) || $_POST['years'] < 1 || $_POST['years'] > 25) {
            $hasErrors = true;
            $errors['years'] = 'Please select a valid number of years between 1 and 25.';
        } else {
            $yearsToDeposit = $_POST['years'];
            $_SESSION['yearsToDeposit'] = $yearsToDeposit; // Save to session
        }

        // If no errors, process the form
        if (!$hasErrors) {
            $rate = 0.03; // Interest rate
            $principal = floatval($principalAmount);
            $results = [];

            for ($year = 1; $year <= $yearsToDeposit; $year++) {
                $interest = $principal * $rate;
                $results[] = [
                    'year' => $year,
                    'principal' => $principal,
                    'interest' => $interest
                ];
                $principal += $interest;
            }
            $form_submitted = true; // Indicate form has been processed
        }
    } elseif (isset($_POST['previous'])) {
        // Redirect to the previous page based on the contact method stored in session
        $contactMethod = $_SESSION['contactMethod'] ?? 'default'; // Retrieve contact method from session
        if ($contactMethod === 'Phone') {
            header("Location: ContactTime.php"); // Navigate back to ContactTime.php if 'Phone' method was selected
        } elseif ($contactMethod === 'Email') {
            header("Location: CustomerInfo.php"); // Navigate back to CustomerInfo.php if 'Email' method was selected
        } else {
            header("Location: CustomerInfo.php"); // Default fallback to CustomerInfo.php
        }
        exit();
    } elseif (isset($_POST['complete'])) {
        // Redirect to Complete.php
        header("Location: Complete.php"); // Make sure Complete.php exists and is accessible
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deposit Calculator</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">Deposit Calculator</h1>
    <form method="POST" action="">
        <div class="form-group">
            <label for="principal">Amount to Deposit:</label>
            <input type="text" name="principal" class="form-control" value="<?= htmlspecialchars($principalAmount) ?>">
            <?php if (isset($errors['principal'])): ?>
                <small class="text-danger"><?= $errors['principal'] ?></small>
            <?php endif; ?>
        </div>
        <div class="form-group">
            <label for="years">Years to Deposit:</label>
            <select name="years" class="form-control">
                <option value="">Select...</option>
                <?php for ($i = 1; $i <= 25; $i++): ?>
                    <option value="<?= $i ?>" <?= $i == $yearsToDeposit ? 'selected' : '' ?>><?= $i ?></option>
                <?php endfor; ?>
            </select>
            <?php if (isset($errors['years'])): ?>
                <small class="text-danger"><?= $errors['years'] ?></small>
            <?php endif; ?>
        </div>
        <button type="submit" name="calculate" class="btn btn-primary">Calculate</button>
        <button type="submit" name="previous" class="btn btn-secondary">Previous</button>
        <button type="submit" name="complete" class="btn btn-primary">Complete</button>
    </form>

    <?php if (isset($form_submitted) && $form_submitted): ?>
        <h2 class="mt-4 text-center">Results</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Year</th>
                    <th>Principal</th>
                    <th>Interest</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $result): ?>
                    <tr>
                        <td><?= $result['year'] ?></td>
                        <td><?= number_format($result['principal'], 2) ?></td>
                        <td><?= number_format($result['interest'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<?php include("./common/footer.php"); ?>
</body>
</html>
