<?php
// Test upload path
session_start();
define('PROJECT_ROOT', dirname(__DIR__));

$targetDir = PROJECT_ROOT . "/uploads/avatars/";

echo "PROJECT_ROOT: " . PROJECT_ROOT . "<br>";
echo "targetDir: " . $targetDir . "<br>";
echo "Folder exists: " . (is_dir($targetDir) ? 'YES' : 'NO') . "<br>";
echo "Folder writable: " . (is_writable($targetDir) ? 'YES' : 'NO') . "<br>";

// Test tạo folder
if (!is_dir($targetDir)) {
    echo "Creating folder...<br>";
    if (mkdir($targetDir, 0777, true)) {
        echo "Folder created successfully<br>";
    } else {
        echo "ERROR: Could not create folder<br>";
    }
}

// Test write file
$testFile = $targetDir . 'test.txt';
if (file_put_contents($testFile, 'test')) {
    echo "Can write files: YES<br>";
    unlink($testFile);
} else {
    echo "Can write files: NO<br>";
}

// Hiển thị file permissions 
if (is_dir($targetDir)) {
    $perms = substr(sprintf('%o', fileperms($targetDir)), -4);
    echo "Folder permissions: " . $perms . "<br>";
}
?>
