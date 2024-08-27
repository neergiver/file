<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login_form.php");
    exit();
}
include 'config.php';
include 'functions.php';

// Fetch roles for form
$roles = $pdo->query("SELECT * FROM roles")->fetchAll(PDO::FETCH_ASSOC);

// Fetch users
$searchTerm = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';
$stmt = $pdo->prepare("SELECT u.*, r.role_name FROM users u LEFT JOIN roles r ON u.role_id = r.id WHERE username LIKE :search");
$stmt->execute(['search' => "%$searchTerm%"]);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Add new user
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role_id = htmlspecialchars($_POST['role_id']);

    $stmt = $pdo->prepare("INSERT INTO users (username, password, role_id) VALUES (:username, :password, :role_id)");
    $stmt->execute(['username' => $username, 'password' => $password, 'role_id' => $role_id]);

    log_activity($_SESSION['admin_id'], "Created user $username");

    header("Location: manage_users.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <link rel="stylesheet" type="text/css" href="assets/style.css">
</head>
<body>
    <h2>Manage Users</h2>
    <form method="get" action="manage_users.php">
        <input type="text" name="search" placeholder="Search users..." value="<?php echo $searchTerm; ?>">
        <button type="submit">Search</button>
    </form>
    <form method="post" action="manage_users.php">
        <h3>Add New User</h3>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <label for="role">Role:</label>
        <select id="role" name="role_id">
            <?php foreach ($roles as $role): ?>
                <option value="<?php echo $role['id']; ?>"><?php echo htmlspecialchars($role['role_name']); ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Add User</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Role</th>
                <th>Email Verified</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['role_name']); ?></td>
                    <td><?php echo $user['email_verified'] ? 'Yes' : 'No'; ?></td>
                    <td>
                        <a href="edit_user.php?id=<?php echo $user['id']; ?>">Edit</a>
                        <a href="delete_user.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
