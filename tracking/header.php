<?php session_start(); ?>
<nav>
   <a href="tracking_form.php">Home</a>
   <?php if (isset($_SESSION['user_id'])): ?>
       <a href="logout.php">Logout</a>
       <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
   <?php else: ?>
       <a href="login_form.php">Login</a>
       <a href="registration_form.php">Register</a>
   <?php endif; ?>
</nav>
