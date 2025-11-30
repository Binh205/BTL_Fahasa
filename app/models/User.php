<?php
// models/User.php

class User
{
    protected $pdo;

    public function __construct()
    {
        // Thay đổi nếu core/DB.php có API khác
        // Giả sử DB::getConnection() trả về PDO
        if (class_exists('DB') && method_exists('DB', 'getConnection')) {
            $this->pdo = DB::getConnection();
        } else {
            // fallback: tạo PDO từ config (thay theo config.php của bạn)
            $cfg = require_once CONFIGROOT . '/config.php'; // optional
            $dsn = $cfg['db_dsn'] ?? null;
            if (!$dsn) {
                throw new Exception('Không thể kết nối DB - cập nhật DB::getConnection hoặc config.php');
            }
            $this->pdo = new PDO($dsn, $cfg['db_user'] ?? null, $cfg['db_pass'] ?? null, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        }
    }

    public function findByEmailOrPhone(string $emailOrPhone)
    {
        $sql = "SELECT * FROM users WHERE email = :e OR phone = :e LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':e' => $emailOrPhone]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(array $data)
    {
        // $data keys: fullname, email_or_phone, password
        $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);
        // Ghi vào cột email/phone tùy DB schema: mình dùng email và phone cột riêng,
        // nhưng để đơn giản mình ghi vào email cột nếu có ký tự '@' иначе phone.
        $email = null;
        $phone = null;
        if (strpos($data['email_or_phone'], '@') !== false) $email = $data['email_or_phone'];
        else $phone = $data['email_or_phone'];

        $sql = "INSERT INTO users (fullname, email, phone, password, created_at) VALUES (:fullname, :email, :phone, :password, NOW())";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':fullname' => $data['fullname'],
            ':email' => $email,
            ':phone' => $phone,
            ':password' => $passwordHash,
        ]);
    }
}
