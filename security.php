<?php
// BLOCK 10 MINS
function is_blocked(){ 
    $f='blocked_ips.txt'; $b=file_exists($f)?json_decode(file_get_contents($f),true):[]; 
    $ip=$_SERVER['REMOTE_ADDR']; 
    if(isset($b[$ip]) && time() < $b[$ip]) return ceil(($b[$ip]-time())/60); 
    return false; 
}
function block_ip($r){ 
    $f='blocked_ips.txt'; $b=file_exists($f)?json_decode(file_get_contents($f),true):[]; 
    $b[$_SERVER['REMOTE_ADDR']]=time()+600; 
    file_put_contents($f,json_encode($b)); 
    die("<h1>⛔ FAKE: $r - BLOCKED 10 MINS</h1>"); 
}

// HII NDIO FUNCTION YAKO INAYOITWA KWENYE PICHA
function verify_mtaani_proof($tmp){
    // 1. QR SECURITY - Maneno ndani ya QR
    $valid_qr = file_exists('qr_security.txt') ? trim(file_get_contents('qr_security.txt')) : "MTAANI ORIGINAL | CODE: XT9-2026 | VERIFIED";
    // Hapa unaweza kuongeza OCR baadaye, kwa sasa tunahifadhi tu
    if(!file_exists('qr_security.txt')){
        file_put_contents('qr_security.txt', $valid_qr);
    }

    // 2. FULL SCREEN CHECK
    list($w,$h)=@getimagesize($tmp); 
    if($h < $w) block_ip("Must be FULL SCREEN");

    // 3. REUSED CHECK
    $hash=sha1_file($tmp); $uf='used_hashes.txt'; 
    $u=file_exists($uf)?json_decode(file_get_contents($uf),true):[]; 
    if(in_array($hash,$u)) block_ip("Screenshot Reused");
    $u[]=$hash; file_put_contents($uf,json_encode($u));

    // 4. TIME CHECK 23HRS
    $post_time = $_POST['post_time'] ?? '';
    if(strtotime($post_time) && time()-strtotime($post_time) > 23*3600) block_ip("Expired 23hrs");

    // 5. VIEWS MAX 53
    $views = (int)($_POST['views'] ?? 0);
    if($views > 53) block_ip("Max 53 views only");
}
?>
