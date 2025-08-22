<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize inputs
    $name    = trim($_POST["name"]);
    $email   = trim($_POST["email"]);
    $message = trim($_POST["message"]);

    $errors = [];

    // Validate Name
    if (empty($name)) {
        $errors[] = "Name is required.";
    } elseif (strlen($name) < 2) {
        $errors[] = "Name must be at least 2 characters.";
    }

    // Validate Email
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // Validate Message
    if (empty($message)) {
        $errors[] = "Message is required.";
    } elseif (strlen($message) < 10) {
        $errors[] = "Message must be at least 10 characters.";
    }

    // If no errors → send email
    if (empty($errors)) {
        $to      = "ucack@hotmail.com";  // change to your email
        $subject = "New Contact Form Message from " . htmlspecialchars($name);
        $body    = "Name: " . htmlspecialchars($name) . "\n"
                 . "Email: " . htmlspecialchars($email) . "\n\n"
                 . "Message:\n" . htmlspecialchars($message);

        $headers = "From: " . $email . "\r\n" .
                   "Reply-To: " . $email . "\r\n" .
                   "X-Mailer: PHP/" . phpversion();

        if (mail($to, $subject, $body, $headers)) {
            echo "<h2>Thank you, your message has been sent successfully.</h2>";
        } else {
            echo "<h2>Sorry, there was a problem sending your message. Try again later.</h2>";
        }
    } else {
        // Show validation errors
        echo "<h2>Please fix the following errors:</h2><ul>";
        foreach ($errors as $error) {
            echo "<li>" . htmlspecialchars($error) . "</li>";
        }
        echo "</ul><a href='contact.html'>Go back</a>";
    }
} else {
    // If accessed directly, redirect back
    header("Location: contact.html");
    exit;
}
?>