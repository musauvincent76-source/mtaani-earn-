include 'security.php';
if ($baki = is_blocked()) die("⛔ BLOCKED - Come back after $baki mins");

if ($_FILES) {
    verify_mtaani_submission($_FILES['screenshot']['tmp_name'], $_POST['views'], $_POST['post_time']);
    echo "✅ VERIFIED - ORIGINAL";
}
