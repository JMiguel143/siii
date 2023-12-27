<?php
// Establish database connection (replace with your credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sia1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch products from the database
$sql = "SELECT product_name, product_code, price FROM products";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $products = array();
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    echo json_encode(array("success" => true, "products" => $products));
} else {
    echo json_encode(array("success" => false, "message" => "No products found"));
}
$conn->close();
?>
