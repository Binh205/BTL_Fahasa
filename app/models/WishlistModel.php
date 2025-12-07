<?php
class WishlistModel extends DB {
    public function getByUserId($uid) {
        return $this->all("SELECT w.id as wishlist_id, w.product_id, p.name as product_name, p.image as image, p.price as price, p.old_price as original_price, p.author, p.rating, p.sold, w.created_at
            FROM wishlist w JOIN products p ON p.id = w.product_id WHERE w.user_id = :uid ORDER BY w.created_at DESC", ['uid'=>$uid]);
    }

    public function exists($uid,$pid){
        return (bool)$this->single("SELECT id FROM wishlist WHERE user_id=:uid AND product_id=:pid", ['uid'=>$uid, 'pid'=>$pid]);
    }

    public function add($uid,$pid){
        if ($this->exists($uid,$pid)) return false;
        return $this->query("INSERT INTO wishlist (user_id,product_id) VALUES (:uid,:pid)", ['uid'=>$uid,'pid'=>$pid]);
    }

    public function remove($uid,$pid){
        return $this->query("DELETE FROM wishlist WHERE user_id=:uid AND product_id=:pid", ['uid'=>$uid,'pid'=>$pid]);
    }

    public function removeById($id,$uid){
        return $this->query("DELETE FROM wishlist WHERE id=:id AND user_id=:uid", ['id'=>$id,'uid'=>$uid]);
    }
}
