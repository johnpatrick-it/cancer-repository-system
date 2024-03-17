<?php
$plaintextPassword = 'admin123';
$hashedPassword = password_hash($plaintextPassword, PASSWORD_BCRYPT);
echo htmlspecialchars($hashedPassword);
?>
