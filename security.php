<?php
// security.php - MTAANI EARN TIGHT SECURITY - 10 MINS BLOCK - ENGLISH

function is_blocked() {
    $ip = $_SERVER['REMOTE_ADDR'];
    $file = __DIR__ . '/blocked_ips.txt';
    if (!file_exists($file)) return false;
    $blocked = json_decode(file_get_contents($file), true) ?? [];
    if (isset($blocked[$ip])) {
        if (time() < $blocked[$ip]) {
            return ceil(($blocked[$ip] - time()) / 60);
        } else {
            unset($blocked[$ip]);
            file_put_contents($file, json_encode($blocked));
        }
    }
    return false;
}

function block_ip($reason) {
    $ip = $_SERVER['REMOTE_ADDR'];
    $file = __DIR__ . '/blocked_ips.txt';
    $blocked = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
    $blocked[$ip] = time() + 600; // 10 MINUTES ONLY
    file_put_contents($file, json_encode($blocked));
    die("<div style='font-family:sans-serif;text-align:center;padding:40px'><h1>⛔ FAKE DETECTED</h1><p><b>Reason:</b> $reason</p><p><b>YOU ARE BLOCKED FOR 10 MINUTES</b></p><p>Come back later.</p></div>");
}

function verify_mtaani_proof($tmp_path, $typed_views, $posted_datetime) {
    // LAYER 1: MAX 53 VIEWS (From your Official Rules)
    if ((int)$typed_views > 53) {
        block_ip("Max Limit Exceeded - Official Rule is 53 views ONLY, you entered $typed_views");
    }

    // LAYER 2: FULL SCREEN CHECK - Must not be cropped
    list($w, $h) = @getimagesize($tmp_path);
    if (!$w || $h < $w) {
        block_ip("Cropped Screenshot - Must be FULL SCREEN showing time at top");
    }

    // LAYER 3: NO REUSE - Same screenshot cannot be used twice
    $hash = sha1_file($tmp_path);
    $used_file = __DIR__ . '/used_hashes.txt';
    $used = file_exists($used_file) ? json_decode(file_get_contents($used_file), true) : [];
    if (in_array($hash, $used)) {
        block_ip("Same Screenshot Reused - Not Allowed");
    }

    // LAYER 4: NO EDITED SCREENSHOT - Detect Photoshop/Canva/PicsArt
    $exif = @exif_read_data($tmp_path);
    if ($exif && isset($exif['Software']) && preg_match('/photoshop|canva|picsart|light
