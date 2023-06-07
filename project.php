<!DOCTYPE html>
<html>
<head>
    <title>VIN Search</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        h2, p {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>VIN Search Tool</h1>
    <form action="project.php" method="POST">
        <label for="vin">VIN:</label>
        <input type="text" id="vin" name="vin" required>
        <input type="submit" value="Search">
    </form>

    <?php
    // Check if VIN was provided in the form submission
    if (isset($_POST['vin'])) {
        $vin = $_POST['vin'];

        // Connect to the MySQL database
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "vindata";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check the database connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Query the vehicle_listings table for the provided VIN
        $sql = "SELECT * FROM vindata WHERE VIN = '$vin' LIMIT 1";
        $result = $conn->query($sql);

        // Check if any matching results were found
        if ($result->num_rows > 0) {
            // Display the results in a table
            echo "<h2>Vehicle Information</h2>";
            echo "<table>";
            $row = $result->fetch_assoc();
            foreach ($row as $field => $value) {
                echo "<tr>";
                echo "<th>" . ucfirst(str_replace('_', ' ', $field)) . "</th>";
                echo "<td>" . $value . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No matching results found.</p>";
        }
        
        // Close the database connection
        $conn->close();
    }
    ?>
</body>
</html>
