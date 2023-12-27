<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cartItems'])) {
    // Extract cart items sent via POST request
    $cartItems = $_POST['cartItems'];

    // Establish database connection (replace with your credentials)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sia1";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        $response = array(
            'success' => false,
            'message' => 'Connection failed: ' . $conn->connect_error,
        );
        echo json_encode($response);
        exit(); // Terminate script if connection fails
    }

    // Loop through cart items and insert into checkout_products table
    foreach ($cartItems as $item) {
        $productName = $item['product_name'];
        $price = $item['price'];

        // Prepare SQL statement to insert into checkout_products table
        $sql = "INSERT INTO checkout_products (product_name, price) VALUES ('$productName', '$price')";

        // Perform the SQL query
        if ($conn->query($sql) !== TRUE) {
            $response = array(
                'success' => false,
                'message' => 'Error: ' . $sql . '<br>' . $conn->error,
            );
            echo json_encode($response);
            $conn->close();
            exit(); // Terminate script if insertion fails
        }
    }

    // Close the database connection
    $conn->close();

    // Return success response
    $response = array(
        'success' => true,
        'message' => 'Checkout successful!',
        // You can include additional data in the response if needed
    );
    echo json_encode($response);
} else {
    // Return failure response if data not received
    $response = array(
        'success' => false,
        'message' => 'Error: No cart items received for checkout.',
    );
    echo json_encode($response);
}
?>
