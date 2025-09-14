<?php
// create_hash.php
$passwordToHash = 'adminpass';
$hashedPassword = password_hash($passwordToHash, PASSWORD_DEFAULT);

echo '<h3>Password Hash Generated Successfully</h3>';
echo 'Your new password hash for "adminpass" is:';
echo '<br><br>';
echo '<textarea rows="3" cols="80" readonly>' . $hashedPassword . '</textarea>';
echo '<br><br>';
echo 'Copy the text from the box above and follow the next step.';
?>