<?php

class NewsModel extends DB
{
  public function getAllNews()
  {
    $sql = "SELECT n.*, u.fullname as author_name FROM news n JOIN users u ON n.author_id = u.user_id ORDER BY n.created_at DESC";
    $result = $this->query($sql);
    return $result->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getNewsById($id)
  {
    $sql = "SELECT n.*, u.fullname as author_name FROM news n JOIN users u ON n.author_id = u.user_id WHERE n.id = :id";
    $result = $this->query($sql, [':id' => $id]);
    return $result->fetch(PDO::FETCH_ASSOC);
  }

  // Admin methods
  public function createNews($title, $content, $imageUrl, $authorId)
  {
    $sql = "INSERT INTO news (title, content, image_url, author_id) VALUES (:title, :content, :image_url, :author_id)";
    $params = [
      ':title' => $title,
      ':content' => $content,
      ':image_url' => $imageUrl,
      ':author_id' => $authorId
    ];
    return $this->query($sql, $params);
  }

  public function updateNews($id, $title, $content, $imageUrl)
  {
    $sql = "UPDATE news SET title = :title, content = :content, image_url = :image_url WHERE id = :id";
    $params = [
      ':id' => $id,
      ':title' => $title,
      ':content' => $content,
      ':image_url' => $imageUrl
    ];
    return $this->query($sql, $params);
  }

  public function deleteNews($id)
  {
    $sql = "DELETE FROM news WHERE id = :id";
    return $this->query($sql, [':id' => $id]);
  }
}