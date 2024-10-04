<?php 
include("./common/header.php"); 
session_start(); // Start the session to track user's agreement

// Initialize an error message
$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['termsCheckbox'])) {
        $errorMessage = 'You must agree to the terms and conditions!';
    } else {
        // Set a session variable to indicate the user has agreed to the terms
        $_SESSION['acceptedDisclaimer'] = true;
        header('Location: CustomerInfo.php'); // Redirect to the next page
        exit();
    }
}
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.6/dist/css/bootstrap.min.css">

<div class="container">
    <div class="row mb-3 align-items-center justify-content-center" style="height: 600vh;">
        <div class="col-lg-6 offset-lg-2">
            <h1>Terms and Conditions</h1>
        </div>
        <div class="col-lg-8 offset-lg-2">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td>I agree to abide by the Bank's Terms and Conditions and rules in force and the changes thereto in Terms and Conditions from time to time relating to my account as communicated and made available on the Bank's website.</td>
                    </tr>
                    <tr>
                        <td>I agree that the bank before opening any deposit account, will carry out a due diligence as required under Know Your Customer guidelines of the bank. I would be required to submit necessary documents or proofs, such as identity, address, photograph and any such information. I agree to submit the above documents again at periodic intervals, as may be required by the Bank.</td>
                    </tr>
                    <tr>
                        <td>I agree that the Bank can at its sole discretion, amend any of the services/facilities given in my account either wholly or partially at any time by giving me at least 30 days notice and/or provide an option to me to switch to other services/facilities.</td>
                    </tr>
                </tbody>
            </table>

            <form method="post" action="">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="termsCheckbox" name="termsCheckbox">
                    <label class="form-check-label" for="termsCheckbox">
                        I have read and agree with the terms and conditions
                    </label>
                </div>
                <?php if (!empty($errorMessage)): ?>
                    <p style="color: red;"><?php echo $errorMessage; ?></p>
                <?php endif; ?>
                <button type="submit" class="btn btn-primary">Start</button>
            </form>
        </div>
    </div>
</div>

<?php include('./common/footer.php'); ?>
