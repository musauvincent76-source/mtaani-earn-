<?php
session_start();

// HAPA NDIPO UNABADILISHA SECURITY KILA SIKU - Badilisha maneno hapa peke yake
$security_ndani = "MTAANI-ORIGINAL-2026-GOLD-A1"; // LEO HII
// Kesho badilisha kuwa B2, kesho kutwa C3, etc.

$secret_code = sha1($security_ndani . "SALT YA MTAANI");
file_put_contents('qr_words.txt', $security_ndani);
file_put_contents('qr_security.txt', $secret_code);

// QR API inatengeneza QR yenye maneno yako mapya
$qr_data = urlencode($security_ndani);
$qr_image = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=$qr_data&bgcolor=255-255-255";

echo "
<div style='text-align:center;font-family:sans-serif;padding:20px'>
<h2>🔐 GOLD QR - SECURITY NDANI</h2>
<p>Maneno ya leo ndani: <b style='background:gold;padding:5px'>$security_ndani</b></p>
<img src='$qr_image' style='border:8px solid gold;border-radius:20px;width:300px'>
<p>Hii ndio QR utaweka kwa advert. Picha ya gold inabaki ile ile,<br>lakini maneno ndani ndio yamebadilika.</p>
<p><small>Code: $secret_code</small></p>
</div>
";
?>
