<?php
// Establish connection to MySQL database
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = "krishna"; // Your MySQL password
$dbname = "test"; // Your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$branch = $_POST['branch'];
$cgpa = $_POST['cgpa'];
$experience = $_POST['experience'];
$yop = $_POST['yop'];
$resume = $_FILES['resume']['name']; // Uploaded resume file name

// Move uploaded resume file to desired directory
$target_dir = "cv/";
$target_file = $target_dir . basename($_FILES["resume"]["name"]);

if (move_uploaded_file($_FILES["resume"]["tmp_name"], $target_file)) {
    echo "The file " . htmlspecialchars(basename($_FILES["resume"]["name"])) . " has been uploaded.";
} else {
    echo "Sorry, there was an error uploading your file.";
}

// Prepare and bind SQL statement
$sql = "INSERT INTO students (name, email, phone, branch, cgpa, experience, yop, resume) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssdsss", $name, $email, $phone, $branch, $cgpa, $experience, $yop, $resume);

// Execute SQL statement
if ($stmt->execute() === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$stmt->close();
$conn->close();
?>
