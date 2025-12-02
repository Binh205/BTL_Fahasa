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
}