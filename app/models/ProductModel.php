<?php

class ProductModel extends DB
{
  /**
   * Lấy sản phẩm có kèm filter, phân trang và join các bảng liên quan
   */
  public function getFilteredProducts($options = [])
  {
    // Default options
    $search = $options['search'] ?? '';
    $category_id = $options['category_id'] ?? null;
    $limit = $options['limit'] ?? 12;
    $offset = $options['offset'] ?? 0;

    $sql = "SELECT 
                p.*, 
                pi.image_url, 
                aop.author_name as author
            FROM product p
            LEFT JOIN (
                SELECT product_id, image_url 
                FROM product_image 
                GROUP BY product_id
            ) AS pi ON p.product_id = pi.product_id
            LEFT JOIN author_of_product aop ON p.product_id = aop.product_id
            LEFT JOIN category_product cp ON p.product_id = cp.product_id";

    $params = [];
    $whereClauses = [];

    if (!empty($search)) {
      $whereClauses[] = "(p.title LIKE :search OR aop.author_name LIKE :search)";
      $params[':search'] = '%' . $search . '%';
    }

    if (!empty($category_id) && is_numeric($category_id)) {
      $whereClauses[] = "cp.category_id = :category_id";
      $params[':category_id'] = $category_id;
    }
    
    if (count($whereClauses) > 0) {
      $sql .= " WHERE " . implode(' AND ', $whereClauses);
    }
    
    $sql .= " GROUP BY p.product_id";
    $sql .= " LIMIT :limit OFFSET :offset";
    $params[':limit'] = $limit;
    $params[':offset'] = $offset;

    $result = $this->query($sql, $params);
    return $result->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Đếm tổng số sản phẩm dựa trên filter (để phân trang)
   */
  public function countFilteredProducts($options = [])
  {
    $search = $options['search'] ?? '';
    $category_id = $options['category_id'] ?? null;

    // A simplified query to count distinct products
    $sql = "SELECT COUNT(DISTINCT p.product_id) as total
            FROM product p
            LEFT JOIN author_of_product aop ON p.product_id = aop.product_id
            LEFT JOIN category_product cp ON p.product_id = cp.product_id";
    
    $params = [];
    $whereClauses = [];

    if (!empty($search)) {
      $whereClauses[] = "(p.title LIKE :search OR aop.author_name LIKE :search)";
      $params[':search'] = '%' . $search . '%';
    }

    if (!empty($category_id) && is_numeric($category_id)) {
      $whereClauses[] = "cp.category_id = :category_id";
      $params[':category_id'] = $category_id;
    }

    if (count($whereClauses) > 0) {
      $sql .= " WHERE " . implode(' AND ', $whereClauses);
    }

    $result = $this->query($sql, $params);
    return $result->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
  }


  /**
   * Lấy thông tin chi tiết của một sản phẩm
   */
  public function getProductDetailsById($id)
  {
    $sql = "SELECT 
                p.*, 
                pi.image_url, 
                aop.author_name as author,
                cp.category_id
            FROM product p
            LEFT JOIN (
                SELECT product_id, image_url 
                FROM product_image 
                GROUP BY product_id
            ) AS pi ON p.product_id = pi.product_id
            LEFT JOIN author_of_product aop ON p.product_id = aop.product_id
            LEFT JOIN category_product cp ON p.product_id = cp.product_id
            WHERE p.product_id = :id
            GROUP BY p.product_id";

    $result = $this->query($sql, [':id' => $id]);
    return $result->fetch(PDO::FETCH_ASSOC);
  }

  /**
   * Lấy các sản phẩm liên quan (cùng danh mục)
   */
  public function getRelatedProducts($categoryId, $currentProductId, $limit = 4)
  {
    $sql = "SELECT
                p.*,
                pi.image_url,
                aop.author_name as author
            FROM product p
            JOIN category_product cp ON p.product_id = cp.product_id
            LEFT JOIN (
                SELECT product_id, image_url 
                FROM product_image 
                GROUP BY product_id
            ) AS pi ON p.product_id = pi.product_id
            LEFT JOIN author_of_product aop ON p.product_id = aop.product_id
            WHERE cp.category_id = :category_id AND p.product_id != :current_product_id
            GROUP BY p.product_id
            LIMIT :limit";
    
    $params = [
        ':category_id' => $categoryId,
        ':current_product_id' => $currentProductId,
        ':limit' => $limit
    ];

    $result = $this->query($sql, $params);
    return $result->fetchAll(PDO::FETCH_ASSOC);
  }
}