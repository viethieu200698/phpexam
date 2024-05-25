<?php
require 'db.php';

$id = intval($_GET['id']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $phone_number = trim($_POST["phone_number"]);
    
    if (!empty($name) && !empty($phone_number)) {
        $stmt = $conn->prepare("UPDATE contacts SET name = ?, phone_number = ? WHERE id = ?");
        $stmt->bind_param("ssi", $name, $phone_number, $id);
        $stmt->execute();
        $stmt->close();
        header("Location: index.php");
        exit();
    }
}

$stmt = $conn->prepare("SELECT * FROM contacts WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$contact = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Contact</title>
</head>
<body>
    <h1>Edit Contact</h1>
    <form method="POST" action="">
        <label>Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($contact['name']); ?>" required>
        <label>Phone Number:</label>
        <input type="text" name="phone_number" value="<?php echo htmlspecialchars($contact['phone_number']); ?>" required>
        <button type="submit">Save</button>
    </form>
</body>
</html>

<?php
$conn->close();
?>
