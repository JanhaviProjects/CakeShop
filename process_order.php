<?php
echo '<pre>';
print_r($_POST);
echo '</pre>';

$servername = "localhost"; 
$username = "root";
$password = "";
$dbname = "bakery";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $date = $_POST['order_date'];
    $time = $_POST['order_time'];
    $cakeFlavour = $_POST['cake_flavour'];
    $kg = $_POST['kg'];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO orders (name, email, address, phone, order_date, order_time, cake_flavour, kg) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssd", $name, $email, $address, $phone, $date, $time, $cakeFlavour, $kg);

    if ($stmt->execute()) {
        echo "Order placed successfully";
        header("Location: thank_you_page.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
        // Handle errors as needed
    }
    
    $stmt->close();
}

$conn->close();

?>
