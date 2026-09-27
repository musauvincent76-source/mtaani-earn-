<?php
include 'security.php';

if ($b = is_blocked()) {
    die("<h1>⛔ YOU ARE BLOCKED</h1><p>Come back after $b minute(s). Fake attempt detected.</p>");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_FILES['proof_file']) || !isset($_POST['views']) || !isset($_POST['post_time'])) {
        die("Missing fields");
    }
    verify_mtaani_proof($_FILES['proof_file']['tmp_name'], $_POST['views'], $_POST['post_time']);
    echo "<h1>✅ VERIFIED ORIGINAL</h1><p>Proof accepted. It passed all 5 security layers.</p>";
    exit;
}
?>
<!DOCTYPE html>
<html><body style="font-family:sans-serif;max-width:400px;margin:auto;padding:20px">
<h3>Mtaani Earn - WhatsApp Status Submission</h3>
<form method="POST" enctype="multipart/form-data">
  <label>File *</label><br>
  <input type="file" name="proof_file" required><br><br>
  <label>Date & Time when posted *</label><br>
  <input type="datetime-local" name="post_time" required><br><br>
  <label>No. of Views *</label><br>
  <input type="number" name="views" placeholder="e.g 42" required><br><br>
  <button type="submit" style="background:green;color:white;padding:10px;width:100%">Submit Proof</button>
</form>
</body></html>
