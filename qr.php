<?php
$maneno = "MTAANI ORIGINAL | CODE: XT9-2026 | VERIFIED";
file_put_contents('qr_security.txt', $maneno);
$qr = "https://api.qrserver.com/v1/create-qr-code/?size=400x400&data=".urlencode($maneno);
echo "<center style='font-family:sans-serif;padding:20px'><h2>🔐 MTAANI SECURITY QR</h2><img src='$qr' style='border:8px solid gold'><p><b>Maneno ndani:</b> $maneno</p><p>Download hii QR uweke kwa advert yako</p></center>";
?>
