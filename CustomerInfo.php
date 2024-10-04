<?php 
session_start(); // Start the session

// Check if the user has accepted the disclaimer. If not, redirect them.
if (!isset($_SESSION['acceptedDisclaimer'])) {
    header("Location: Disclaimer.php");
    exit();
}

include("./common/header.php"); 
include 'functions.php'; 

// Initialize variables with session data (or default empty values)
$name = $_SESSION['name'] ?? '';
$postalCode = $_SESSION['postalCode'] ?? '';
$phoneNumber = $_SESSION['phoneNumber'] ?? '';
$emailAddress = $_SESSION['emailAddress'] ?? '';
$contactMethod = $_SESSION['contactMethod'] ?? '';
$errors = [];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['Name'] ?? '';
    $postalCode = $_POST['PostalCode'] ?? '';
    $phoneNumber = $_POST['PhoneNumber'] ?? '';
    $emailAddress = $_POST['EmailAddress'] ?? '';
    $contactMethod = $_POST['contactMethod'] ?? '';

    // Validate input using functions from functions.php
    $errors['name'] = ValidateName($name);
    $errors['postalCode'] = ValidatePostalCode($postalCode);
    $errors['phoneNumber'] = ValidatePhone($phoneNumber);
    $errors['emailAddress'] = ValidateEmail($emailAddress);
    $errors['contactMethod'] = empty($contactMethod) ? "You must select a contact method." : '';

    // Check for validation errors
    $hasErrors = array_filter($errors);

    if (!$hasErrors) {
        // Store the submitted data into the session
        $_SESSION['name'] = $name;
        $_SESSION['postalCode'] = $postalCode;
        $_SESSION['phoneNumber'] = $phoneNumber;
        $_SESSION['emailAddress'] = $emailAddress;
        $_SESSION['contactMethod'] = $contactMethod;

        // Redirect based on the contact method
        if ($contactMethod === "Email") {
            header("Location: DepositCalculator.php");
            exit();
        } elseif ($contactMethod === "Phone") {
            header("Location: ContactTime.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deposit Calculator - Customer Info</title>
    <link rel="stylesheet" href="style.css" type="text/css"/>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</head>
<body>
<div class="text-center">
    <h1 class="display-4">Customer Information</h1>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <form id="depositForm" method="post" action="CustomerInfo.php">
                <!-- Name Field -->
                <div class="row mb-3">
                    <label for="Name" class="col-4 text-end col-form-label">Name</label>
                    <div class="col-4">
                        <input type="text" id="Name" name="Name" class="form-control" value="<?= htmlspecialchars($name); ?>">
                    </div>
                    <div class="col-4 text-danger error-message"><?= $errors['name'] ?? ''; ?></div>
                </div>

                <!-- Postal Code Field -->
                <div class="row mb-3">
                    <label for="PostalCode" class="col-4 text-end col-form-label">Postal Code</label>
                    <div class="col-4">
                        <input type="text" id="PostalCode" name="PostalCode" class="form-control" value="<?= htmlspecialchars($postalCode); ?>">
                    </div>
                    <div class="col-4 text-danger error-message"><?= $errors['postalCode'] ?? ''; ?></div>
                </div>

                <!-- Phone Number Field -->
                <div class="row mb-3">
                    <label for="PhoneNumber" class="col-4 text-end col-form-label">Phone Number</label>
                    <div class="col-4">
                        <input type="text" id="PhoneNumber" name="PhoneNumber" class="form-control" value="<?= htmlspecialchars($phoneNumber); ?>">
                    </div>
                    <div class="col-4 text-danger error-message"><?= $errors['phoneNumber'] ?? ''; ?></div>
                </div>

                <!-- Email Address Field -->
                <div class="row mb-3">
                    <label for="EmailAddress" class="col-4 text-end col-form-label">Email Address</label>
                    <div class="col-4">
                        <input type="email" id="EmailAddress" name="EmailAddress" class="form-control" value="<?= htmlspecialchars($emailAddress); ?>">
                    </div>
                    <div class="col-4 text-danger error-message"><?= $errors['emailAddress'] ?? ''; ?></div>
                </div>

                <!-- Contact Method Field -->
                <div class="row mb-3">
                    <label class="col-4 text-end col-form-label">Preferred Contact Method</label>
                    <div class="col-4">
                        <div class="form-check">
                            <input type="radio" id="contactPhone" name="contactMethod" class="form-check-input" value="Phone" <?= $contactMethod === 'Phone' ? 'checked' : ''; ?>>
                            <label for="contactPhone" class="form-check-label">Phone</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" id="contactEmail" name="contactMethod" class="form-check-input" value="Email" <?= $contactMethod === 'Email' ? 'checked' : ''; ?>>
                            <label for="contactEmail" class="form-check-label">Email</label>
                        </div>
                    </div>
                    <div class="col-4 text-danger error-message"><?= $errors['contactMethod'] ?? ''; ?></div>
                </div>

                <!-- Submit Button -->
                <div class="row">
                    <div class="col-8 offset-4">
                        <button type="submit" class="btn btn-primary">Next</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function clearForm() {
        document.getElementById('depositForm').reset();
    }
</script>

<?php include("./common/footer.php"); ?>
</body>
</html>
