<?php
class Food
{
    private $db;

    public function __construct()
    {
        if (!class_exists('Database')) {
            include "../healty-app/app/config/database.php";
        }
        $this->db = (new Database())->connect();
    }

    public function search($keyword)
    {
        $keyword = "%$keyword%";
        $stmt = $this->db->prepare("SELECT * FROM foods WHERE nama_makanan LIKE ? LIMIT 10");
        $stmt->execute([$keyword]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM foods WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
