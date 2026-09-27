<?php
include 'security.php';
if ($b = is_blocked()) {
    die("<h1 style='text-align:center'>⛔ YOU ARE BLOCKED<br>Come back after $b mins</h1><p style='text-align:center'>Reason: QR Security Failed / Fake Screenshot</p>");
}

// Soma maneno ya leo ya Gold QR
$valid_qr_word = file_exists('qr_words.txt') ? file_get_contents('qr_words.txt') : 'NOT SET';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_all(); // Ita-check views 53, full screen, reused, 23hrs + QR
    echo "
    <div style='font-family:sans-serif;text-align:center;padding:30px'>
    <h1>✅ ORIGINAL VERIFIED</h1>
    <p><b>Gold QR Word:</b> $valid_qr_word</p>
    <p>GateHub imesoma maneno ndani ya QR, ni ORIGINAL!</p>
    <img src='mtaani_seal.png' width='200' style='border:5px solid gold;border-radius:50%'><br><br>
    <a href='qr.php'>Generate New Gold QR for Next Advert</a>
    </div>";
    exit;
}
?>
<!DOCTYPE html>
<html>
<body style="font-family:sans-serif;max-width:400px;margin:auto;padding:20px;text-align:center">
<h3>🔐 MTAANI EARN - Submit Proof</h3>
<p><small>Security Word leo: <b><?php echo $valid_qr_word; ?></b></small></p>
<img src="mtaani_seal.png" width="150" style="border:4px solid gold;border-radius:50%"><br><br>
<form method="POST" enctype="multipart/form-data" action="wait.html">
  <input type="file" name="proof_file" required><br><br>
  <input type="datetime-local" name="post_time" required><br><br>
  <input type="number" name="views" placeholder="Views (Max 53)" required><br><br>
  <button type="submit" style="background:gold;color:black;padding:12px;width:100%;font-weight:bold;border-radius:10px">VERIFY GOLD QR + SUBMIT</button>
</form>
</body>
</html>
