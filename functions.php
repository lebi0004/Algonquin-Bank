<?php
// Validate Principal Amount
function ValidatePrincipal($amount) {
    if (empty($amount)) {
        return "Principal Amount is required.";
    } elseif (!is_numeric($amount) || $amount <= 0) {
        return "Principal Amount must be numeric and greater than zero.";
    }
    return "";
}

// Validate Number of Years
function ValidateYears($years) {
    if (empty($years)) {
        return "Number of years is required.";
    } elseif (!is_numeric($years) || $years < 1 || $years > 25) {
        return "Years must be a number between 1 and 25.";
    }
    return "";
}

// Validate Name (optional, but keeping for completeness)
function ValidateName($name) {
    if (empty($name)) {
        return "Name is required.";
    }
    return "";
}

// Validate Postal Code
function ValidatePostalCode($postalCode) {
    if (empty($postalCode)) {
        return "Postal Code is required.";
    } elseif (!preg_match("/^[A-Za-z]\d[A-Za-z][ ]?\d[A-Za-z]\d$/", $postalCode)) {
        return "Postal Code is incorrect";
    }
    return "";
}

// Validate Phone Number
function ValidatePhone($phone) {
    if (empty($phone)) {
        return "Phone number is required.";
    } elseif (!preg_match("/^[2-9]\d{2}-[2-9]\d{2}-\d{4}$/", $phone)) {
        return "Phone number is incorrect.";
    }
    return "";
}

// Validate Email Address
function ValidateEmail($email) {
    if (empty($email)) {
        return "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/", $email)) {
        return "Email is incorrect";
    }
    return "";
}


?>
