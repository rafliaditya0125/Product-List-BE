<?php

class Product {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM products");
        return $stmt->fetchAll();
    }

    public function find($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $stmt = $this->pdo->prepare("INSERT INTO products (name, category, stock, price, image) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['name'], 
            $data['category'], 
            $data['stock'], 
            $data['price'], 
            $data['image']
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->pdo->prepare("UPDATE products SET name = ?, category = ?, stock = ?, price = ?, image = ? WHERE id = ?");
        return $stmt->execute([
            $data['name'], 
            $data['category'], 
            $data['stock'], 
            $data['price'], 
            $data['image'], 
            $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
