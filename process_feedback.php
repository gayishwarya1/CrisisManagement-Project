<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and sanitize input data
    $name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : '';
    $email = isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : '';
    $subject = isset($_POST['subject']) ? htmlspecialchars(trim($_POST['subject'])) : '';
    $message = isset($_POST['message']) ? htmlspecialchars(trim($_POST['message'])) : '';
    $selectedScenario = isset($_POST['selectedScenario']) ? $_POST['selectedScenario'] : '';
    $crisisName = isset($_POST['CrisisName']) ? htmlspecialchars(trim($_POST['CrisisName'])) : '';

    // Check if all required fields are present
    if (empty($name) || empty($email) || empty($subject) || empty($message) || empty($selectedScenario)) {
        header("Location: index.php?error=All fields are required.");
        exit();
    }

    // Check if the data is already submitted (optional, based on your logic)
    $check_stmt = $mysqli->prepare("SELECT id FROM Feedback WHERE name = ? AND email = ? AND subject = ? AND message = ? AND ID_ScenarioC = ? AND CrisisName = ?");
    $check_stmt->bind_param("ssssss", $name, $email, $subject, $message, $selectedScenario, $crisisName);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        // Redirect back to index.php with a message indicating the submission is duplicate
        header("Location: index.php?error=Duplicate submission detected.");
        exit();
    }

    // Prepare and bind parameters
    $stmt = $mysqli->prepare("INSERT INTO Feedback (name, email, subject, message, ID_ScenarioC, CrisisName) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $email, $subject, $message, $selectedScenario, $crisisName);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to index.php with success message
        header("Location: index.php?success=Your message has been sent. Thank you!");
        exit();
    } else {
        // Redirect to index.php with error message
        header("Location: index.php?error=Error occurred. Please try again.");
        exit();
    }

    // Close the statements and connection
    $stmt->close();
    $check_stmt->close();
    $mysqli->close();
} else {
    // Invalid request method
    header("Location: index.php?error=Invalid request method.");
    exit();
}
?>
