<?php
$plaintextPassword = 'M@nyakisako';
$hashedPassword = password_hash($plaintextPassword, PASSWORD_BCRYPT);
echo htmlspecialchars($hashedPassword);
?>
