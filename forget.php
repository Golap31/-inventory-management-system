<?php
$conn = new mysqli("localhost", "root", "", "inventorymanagementsystem");
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        $message = "<div class='alert alert-info'>A password reset link has been sent to your email (demo).</div>";
    } else {
        $message = "<div class='alert alert-danger'>Email not found!</div>";
    }
}
?>

<?php include 'header.php'; ?>
<h2 class="mb-4">Forgot Password</h2>
<?= $message ?>
<form method="POST" class="card p-4 shadow-sm bg-white">
  <div class="mb-3">
    <label class="form-label">Enter your email</label>
    <input type="email" name="email" class="form-control" required>
  </div>
  <button type="submit" class="btn btn-warning">Send Reset Link</button>
</form>
<a href="login.php" class="d-block mt-3">Back to Login</a>
<?php include 'footer.php'; ?>
