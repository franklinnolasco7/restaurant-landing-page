<?php
$full_name = $_POST['full_name'];
$email = $_POST['email'];
$message = $_POST['message'];

// Database Connection
$conn = new mysqli('localhost', 'id20904233_franklin07', '0123456789@Fdn', 'id20904233_contactdb');
if ($conn->connect_error) {
    echo "$conn->connect_error";
    die("Connection Failed: " . $conn->connect_error);
} else {
    $createTableQuery = "CREATE TABLE IF NOT EXISTS messages (
        id INT AUTO_INCREMENT PRIMARY KEY,
        full_name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        message TEXT
    )";
    $conn->query($createTableQuery);
    
    $result = $conn->query("SHOW TABLES LIKE 'messages'");
    if ($result->num_rows == 0) {
        die("Error: Table 'messages' does not exist.");
    }

    $stmt = $conn->prepare("INSERT INTO messages (full_name, email, message) VALUES (?, ?, ?)");
    if ($stmt === false) {
        die("Error: " . $conn->error);
    }

    $stmt->bind_param("sss", $full_name, $email, $message);
    $execval = $stmt->execute();
    if ($execval === false) {
        die("Error: " . $stmt->error);
    }

    echo "Registration successful...";
    $stmt->close();
    $conn->close();
}
?>
