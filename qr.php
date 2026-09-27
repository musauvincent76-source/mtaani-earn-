<?php
$security_ndani = "MTAANI-ORIGINAL-GOLD-A1"; // HAPA NDIO UNABADILISHA MANENO YA SIRI
file_put_contents('qr_words.txt', $security_ndani);
$qr = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=".urlencode($security_ndani);
echo "<center><h2>GOLD QR LEO: $security_ndani</h2><img src='$qr' style='border:8px solid gold'><br><br><img src='mtaani_seal.png' width='200'></center>";
?>
