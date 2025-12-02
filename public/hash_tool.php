<?php
// Mật khẩu chung của Customer cũ
$user_password = 'pass123';
$user_hash = password_hash($user_password, PASSWORD_DEFAULT);
echo "1. Mật khẩu mã hóa cho 'pass123' là: " . $user_hash . "<br>";

// Mật khẩu chung của Staff cũ
$staff_password = 'staffpass';
$staff_hash = password_hash($staff_password, PASSWORD_DEFAULT);
echo "2. Mật khẩu mã hóa cho 'staffpass' là: " . $staff_hash . "<br>";

// Mật khẩu Admin (chỉ để kiểm tra lại)
$admin_password = 'admin';
$admin_hash = password_hash($admin_password, PASSWORD_DEFAULT);
echo "3. Mật khẩu mã hóa cho 'admin' là: " . $admin_hash . "<br>";
?>