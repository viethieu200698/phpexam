<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $phone_number = trim($_POST["phone_number"]);
    
    if (!empty($name) && !empty($phone_number)) {
        $stmt = $conn->prepare("INSERT INTO contacts (name, phone_number) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $phone_number);
        $stmt->execute();
        $stmt->close();
    }
}

$result = $conn->query("SELECT * FROM contacts");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Phone Book</title>
</head>
<body>
    <h1>Phone Book Contacts</h1>
    
    <form method="POST" action="">
        <label>Name:</label>
        <input type="text" name="name" required>
        <label>Phone Number:</label>
        <input type="text" name="phone_number" required>
        <button type="submit">Add</button>
    </form>
    
    <h2>Contacts List</h2>
    <table border="1">
        <tr>
            <th>Name</th>
            <th>Phone Number</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['phone_number']); ?></td>
            <td>
                <a href="edit_contact.php?id=<?php echo $row['id']; ?>">Edit</a>
                <a href="delete_contact.php?id=<?php echo $row['id']; ?>">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
