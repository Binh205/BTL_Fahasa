<?php
class User extends DB {

    /**
     * Tìm user theo Email hoặc SĐT
     * Hàm này sửa lỗi "Call to undefined method User::findUserByEmail()"
     */
    public function findUserByEmailOrPhone($emailOrPhone) {
        // SỬA: Dùng 2 placeholder khác nhau (:email và :phone)
        $sql = "SELECT * FROM users WHERE email = :email OR phone = :phone LIMIT 1";
        
        // SỬA: Truyền mảng tham số map với 2 key trên
        return $this->single($sql, [
            'email' => $emailOrPhone,
            'phone' => $emailOrPhone
        ]);
    }

    /**
     * Tạo tài khoản mới (Dùng cho chức năng Đăng ký)
     */
    public function create($data) {
        // $data nhận vào mảng gồm: fullname, email_or_phone, password
        
        // 1. Mã hóa mật khẩu
        $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);

        // 2. Tách Email hoặc Phone (Logic đơn giản)
        $email = null;
        $phone = null;
        
        if (strpos($data['email_or_phone'], '@') !== false) {
            $email = $data['email_or_phone'];
        } else {
            $phone = $data['email_or_phone'];
        }

        // 3. Câu SQL Insert
        $sql = "INSERT INTO users (fullname, email, phone, password, created_date) 
                VALUES (:fullname, :email, :phone, :password, NOW())";

        // 4. Thực thi
        return $this->query($sql, [
            'fullname' => $data['fullname'],
            'email'    => $email,
            'phone'    => $phone,
            'password' => $passwordHash
        ]);
    }
}