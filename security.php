<?php
// security.php - TIGHT MTAANI EARN SECURITY - 10 MIN BLOCK

function is_blocked() {
    $ip = $_SERVER['REMOTE_ADDR'];
    $file = __DIR__ . '/blocked_ips.txt';
    if (!file_exists($file)) return false;
    $blocked = json_decode(file_get_contents($file), true) ?? [];
    if (isset($blocked[$ip]) && time() < $blocked[$ip]) {
        return ceil(($blocked[$ip] - time()) / 60);
    }
    return false;
}

function block_ip($reason) {
    $ip = $_SERVER['REMOTE_ADDR'];
    $file = __DIR__ . '/blocked_ips.txt';
    $blocked = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
    $blocked[$ip] = time() + 600; // 10 MINUTES ONLY
    file_put_contents($file, json_encode($blocked));
    die("<h1>⛔ FAKE DETECTED: $reason</h1><p>YOU ARE BLOCKED FOR 10 MINUTES. Come back later.</p>");
}

function verify_mtaani_submission($file_path, $typed_views, $post_time) {
    // LAYER 1: Check Full Screen - Must be tall image, not cropped
    list($width, $height) = getimagesize($file_path);
    if ($height < $width) {
        block_ip("Cropped Screenshot - Must be FULL SCREEN");
    }

    // LAYER 2: Check No Reuse - Same file hash
    $hash = sha1_file($file_path);
    $used_hashes_file = __DIR__ . '/used_hashes.txt';
    $used = file_exists($used_hashes_file) ? json_decode(file_get_contents($used_hashes_file), true) : [];
    if (in_array($hash, $used)) {
        block_ip("Same Screenshot Reused - Not Allowed");
    }

    // LAYER 3: Check Photoshop/Edit - Check EXIF for Canva/PicsArt
    $exif = @exif_read_data($file_path);
    if ($exif && isset($exif['Software']) && preg_match('/Photoshop|Canva|PicsArt/i', $exif['Software'])) {
        block_ip("Edited Screenshot Detected - " . $exif['Software']);
    }

    // LAYER 4: Check Max Views - Max 53 (from your OFFICIAL RULES)
    if ((int)$typed_views > 53) {
        block_ip("Max Limit Exceeded - 53 views ONLY");
    }
    
    // LAYER 5: Check Expiry - Must submit within 23 hours
    if (time() - strtotime($post_time) > 23*3600) {
        block_ip("WhatsApp Status Expired - Submit within 23 hours");
    }

    // If all layers PASS, save hash
    $used[] = $hash;
    file_put_contents($used_hashes_file, json_encode($used));
    return true;
}
?>
