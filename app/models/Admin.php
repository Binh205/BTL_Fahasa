<?php
class Admin extends DB {

    // ================= TASK 1: QUẢN LÝ CẤU HÌNH (SETTINGS) =================
    
    public function getSettings() {
        $result = $this->all("SELECT * FROM settings");
        $settings = [];
        if ($result) {
            foreach ($result as $row) {
                $settings[$row['key_name']] = $row['value'];
            }
        }
        return $settings;
    }

    public function updateSetting($key, $value) {
        return $this->query("UPDATE settings SET value = :value WHERE key_name = :key", 
            ['value' => $value, 'key' => $key]
        );
    }

    // ================= TASK 1: QUẢN LÝ LIÊN HỆ (CONTACTS) =================

    public function getAllContacts() {
        return $this->all("SELECT * FROM contacts ORDER BY created_at DESC");
    }

    public function deleteContact($id) {
        return $this->query("DELETE FROM contacts WHERE id = :id", ['id' => $id]);
    }

    // ================= TASK 2: QUẢN LÝ TRANG (PAGES) =================

    public function getPageContent($pageName) {
        $result = $this->single("SELECT content FROM pages WHERE page_name = :page", ['page' => $pageName]);
        return $result ? $result['content'] : '';
    }

    public function updatePageContent($pageName, $content) {
        $check = $this->getPageContent($pageName);
        
        if ($check !== '') {
            $sql = "UPDATE pages SET content = :content, updated_at = NOW() WHERE page_name = :page";
        } else {
            $sql = "INSERT INTO pages (page_name, content, created_at) VALUES (:page, :content, NOW())";
        }
        return $this->query($sql, ['page' => $pageName, 'content' => $content]);
    }

    // ================= TASK 2: QUẢN LÝ HỎI ĐÁP (QA) =================

    public function getAllQA() {
        return $this->all("SELECT * FROM qa ORDER BY id DESC");
    }

    public function createQA($question, $answer, $category) {
        $sql = "INSERT INTO qa (question, answer, category) VALUES (:q, :a, :c)";
        return $this->query($sql, ['q' => $question, 'a' => $answer, 'c' => $category]);
    }

    public function deleteQA($id) {
        return $this->query("DELETE FROM qa WHERE id = :id", ['id' => $id]);
    }



// ================= QUẢN LÝ TIN TỨC (NEWS) =================
    public function getAllArticles() {
        return $this->all("SELECT * FROM news ORDER BY created_at DESC");
    }

    public function getArticleById($id) {
        return $this->single("SELECT * FROM news WHERE id = :id", ['id' => $id]);
    }

    public function addArticle($data) {
        $sql = "INSERT INTO news (title, content, image_url, author_id)
                VALUES (:title, :content, :image_url, :author_id)";
        return $this->query($sql, $data);
    }

    public function updateArticle($id, $data) {
        // Nếu có ảnh mới thì update cả ảnh, không thì giữ nguyên
        if (!empty($data['image_url'])) {
            $sql = "UPDATE news SET title=:title, content=:content, image_url=:image_url WHERE id=:id";
        } else {
            $sql = "UPDATE news SET title=:title, content=:content WHERE id=:id";
            unset($data['image_url']); // Bỏ key image_url khỏi mảng data
        }
        $data['id'] = $id; // Thêm id vào mảng tham số
        return $this->query($sql, $data);
    }

    public function deleteArticle($id) {
        return $this->query("DELETE FROM news WHERE id = :id", ['id' => $id]);
    }

    // ================= QUẢN LÝ SẢN PHẨM (PRODUCTS) =================
    public function getAllProducts() {
        return $this->all("SELECT * FROM product ORDER BY product_id DESC");
    }

    public function getProductById($id) {
        return $this->single("SELECT * FROM product WHERE product_id = :id", ['id' => $id]);
    }

    public function addProduct($data) {
        $sql = "INSERT INTO product (title, price, old_price, description, stock_quantity, publisher)
                VALUES (:title, :price, :old_price, :description, :stock_quantity, :publisher)";
        return $this->query($sql, $data);
    }

    public function updateProduct($id, $data) {
        $sql = "UPDATE product SET title=:title, price=:price, old_price=:old_price,
                description=:description, stock_quantity=:stock_quantity, publisher=:publisher
                WHERE product_id=:id";
        $data['id'] = $id;
        return $this->query($sql, $data);
    }

    public function deleteProduct($id) {
        return $this->query("DELETE FROM product WHERE product_id = :id", ['id' => $id]);
    }

    // ================= QUẢN LÝ ĐƠN HÀNG (ORDERS) =================

    public function getAllOrders() {
        $sql = "SELECT
                    o.order_id,
                    o.created_date,
                    o.status,
                    o.total,
                    o.shipping_fee,
                    o.note,
                    o.point_used,
                    o.point_earned,
                    p.payment_method,
                    p.customer_id,
                    u.name as customer_name,
                    u.email as customer_email,
                    u.phone as customer_phone
                FROM orders o
                LEFT JOIN payment p ON o.payment_id = p.payment_id
                LEFT JOIN users u ON p.customer_id = u.user_id
                ORDER BY o.created_date DESC, o.order_id DESC";
        return $this->all($sql);
    }

    public function getOrderById($orderId) {
        $sql = "SELECT
                    o.order_id,
                    o.created_date,
                    o.status,
                    o.total,
                    o.shipping_fee,
                    o.note,
                    o.point_used,
                    o.point_earned,
                    p.payment_method,
                    p.customer_id,
                    u.name as customer_name,
                    u.email as customer_email,
                    u.phone as customer_phone,
                    u.address as customer_address
                FROM orders o
                LEFT JOIN payment p ON o.payment_id = p.payment_id
                LEFT JOIN users u ON p.customer_id = u.user_id
                WHERE o.order_id = :order_id";
        return $this->single($sql, ['order_id' => $orderId]);
    }

    public function getOrderItems($orderId) {
        $sql = "SELECT
                    ci.product_id,
                    ci.quantity,
                    p.title,
                    p.price,
                    (ci.quantity * p.price) as subtotal,
                    pi.image_url
                FROM cart_items ci
                JOIN product p ON ci.product_id = p.product_id
                LEFT JOIN product_image pi ON p.product_id = pi.product_id
                WHERE ci.user_id = (
                    SELECT customer_id FROM payment
                    WHERE payment_id = (SELECT payment_id FROM orders WHERE order_id = :order_id)
                )
                GROUP BY ci.product_id";
        return $this->all($sql, ['order_id' => $orderId]);
    }

    public function updateOrderStatus($orderId, $status) {
        $sql = "UPDATE orders SET status = :status WHERE order_id = :order_id";
        return $this->query($sql, ['status' => $status, 'order_id' => $orderId]);
    }

    public function deleteOrder($orderId) {
        return $this->query("DELETE FROM orders WHERE order_id = :order_id", ['order_id' => $orderId]);
    }

    public function getOrderStats() {
        $sql = "SELECT
                    COUNT(*) as total_orders,
                    SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending_orders,
                    SUM(CASE WHEN status = 'processing' THEN 1 ELSE 0 END) as processing_orders,
                    SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed_orders,
                    SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) as cancelled_orders,
                    SUM(total) as total_revenue
                FROM orders";
        return $this->single($sql);
    }
}