<?php
session_start(); // Start the session

include("./common/header.php");
include 'functions.php';

// Initialize variables with session data (or default values)
$preferredTimes = $_SESSION['preferredTimes'] ?? [];
$errors = [];

// If the Back button is clicked, redirect to CustomerInfo.php
if (isset($_POST['back'])) {
    header("Location: CustomerInfo.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $preferredTimes = $_POST['time'] ?? [];

    // Validate selected times
    if (empty($preferredTimes)) {
        $errors['preferredTimes'] = "You must select one or more contact times.";
    }

    // Check for validation errors
    $hasErrors = array_filter($errors);

    if (!$hasErrors) {
        // Store preferred times in session
        $_SESSION['preferredTimes'] = $preferredTimes;

        // Redirect to DepositCalculator.php
        header("Location: DepositCalculator.php");
        exit();
    }
}
?>

<div class="container">
    <div class="row mb-3 align-items-center justify-content-center">
        <div class="col-lg-6 offset-lg-2">
            <h1>Select Contact Times</h1>
            <form method="post" action="ContactTime.php">
                <div class="mb-3">
                    <label class="form-label">Best Time to Contact</label>
                    <?php foreach (['9-10', '10-11', '11-12', '1-2', '2-3', '3-4', '4-5', '5-6'] as $time): ?>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="<?= $time; ?>" name="time[]" value="<?= $time; ?>" <?= in_array($time, $preferredTimes) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="<?= $time; ?>"><?= $time; ?>am</label>
                        </div>
                    <?php endforeach; ?>
                    <div class="text-danger error-message"><?= $errors['preferredTimes'] ?? ''; ?></div>
                </div>

                <button type="submit" name="next" class="btn btn-primary">Next</button>
                <button type="submit" name="back" class="btn btn-secondary">Back</button>
            </form>
        </div>
    </div>
</div>

<?php include("./common/footer.php"); ?>
