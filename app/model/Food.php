<?php
class Food
{
    private $db;

    public function __construct()
    {
        if (!class_exists('Database')) {
            include __DIR__ . "/../config/database.php";
        }
        $this->db = (new Database())->connect();
    }

    public function search($keyword)
    {
        $keyword = "%$keyword%";
        // Updated to use 'makanan' table
        $stmt = $this->db->prepare("SELECT * FROM makanan WHERE nama_makanan LIKE ? LIMIT 10");
        $stmt->execute([$keyword]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        // Updated to use 'makanan' table
        $stmt = $this->db->prepare("SELECT * FROM makanan WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllFoodsCount()
    {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM makanan");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function getAllFoods()
    {
        $stmt = $this->db->query("SELECT * FROM makanan ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addFood($nama, $kalori, $protein, $lemak, $karbo)
    {
        $stmt = $this->db->prepare("INSERT INTO makanan (nama_makanan, kalori, protein, lemak, karbo) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$nama, $kalori, $protein, $lemak, $karbo]);
    }

    public function updateFood($id, $nama, $kalori, $protein, $lemak, $karbo)
    {
        $stmt = $this->db->prepare("UPDATE makanan SET nama_makanan=?, kalori=?, protein=?, lemak=?, karbo=? WHERE id=?");
        return $stmt->execute([$nama, $kalori, $protein, $lemak, $karbo, $id]);
    }

    public function deleteFood($id)
    {
        $stmt = $this->db->prepare("DELETE FROM makanan WHERE id=?");
        return $stmt->execute([$id]);
    }
}
