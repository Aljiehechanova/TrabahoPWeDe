<?php
session_start();
include '../config/db_connection.php';
include '../controllers/UserController.php';

$userController = new UserController($conn);

// Validate required session data
if (!isset($_SESSION['email']) || !filter_var($_SESSION['email'], FILTER_VALIDATE_EMAIL)) {
    die("Invalid or missing email. Please go back and complete registration.");
}

// Handle resume upload
$resumePath = "";
if (isset($_FILES['resume']) && $_FILES['resume']['error'] == 0) {
    $resumeDir = "../uploads/resumes/";
    if (!is_dir($resumeDir)) {
        mkdir($resumeDir, 0777, true);
    }

    $originalName = basename($_FILES['resume']['name']);
    $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
    $safeName = uniqid('resume_') . '.' . $ext;
    $resumePath = $resumeDir . $safeName;

    $allowed = ['pdf', 'doc', 'docx'];
    $maxSize = 5 * 1024 * 1024;

    if (!in_array($ext, $allowed)) {
        die("Unsupported file type. Only PDF, DOC, and DOCX allowed.");
    }

    if ($_FILES['resume']['size'] > $maxSize) {
        die("File size exceeds the 5MB limit.");
    }

    move_uploaded_file($_FILES['resume']['tmp_name'], $resumePath);
}

// Build full name
$fullname = $_SESSION['firstname'] . " " . ($_SESSION['initial'] ?? '') . " " . $_SESSION['lastname'];
if (!empty($_SESSION['suffix'])) {
    $fullname .= " " . $_SESSION['suffix'];
}

// Optional fields
$preferred_work = $_SESSION['preferred_work'] ?? '';
$skills = $_SESSION['skills'] ?? '';

// Register the user in database
$result = $userController->registerJobSeeker(
    "job_seeker",
    $fullname,
    $_SESSION['email'],
    $_SESSION['password'],
    $_SESSION['disability'],
    $_SESSION['birthday'],
    $_SESSION['address'],
    $_SESSION['phone'],
    $preferred_work,
    $skills,
    $resumePath
);

// ✅ If successful, generate verification token and send email
if ($result === true) {
    $token = bin2hex(random_bytes(32));
    $email = $_SESSION['email'];

    // Save token to users table
    $stmt = $conn->prepare("UPDATE users SET verification_token = :token, is_verified = 0 WHERE email = :email");
    $stmt->bindParam(':token', $token);
    $stmt->bindParam(':email', $email);
    $stmt->execute();


    // Create verification link
    $verifyLink = "http://localhost/Revised/views/verify.php?token=$token";

    // Email content
    $subject = "Verify Your Email – Trabaho PWeDe";
    $message = "
    <html>
    <body style='font-family: Arial, sans-serif;'>
        <h2>Welcome to Trabaho PWeDe!</h2>
        <p>Please verify your email by clicking the button below:</p>
        <p>
            <a href='$verifyLink' style='
                display: inline-block;
                padding: 10px 20px;
                background-color: #28a745;
                color: white;
                text-decoration: none;
                border-radius: 5px;
                font-weight: bold;
            '>✅ Verify My Email</a>
        </p>
        <p>If you did not register, please ignore this email.</p>
    </body>
    </html>
    ";

    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8\r\n";
    $headers .= "From: no-reply@trabahopwede.com\r\n";

    mail($email, $subject, $message, $headers);

    // Destroy session
    session_destroy();

    echo "<h3>✅ Registration complete!</h3><p>Please check your email to verify your account before logging in.</p>";
    exit();
} else {
    // Make sure $result is a string (not a closure/object)
    echo "❌ Error: " . (is_string($result) ? $result : "Unknown error.");
}
?>
