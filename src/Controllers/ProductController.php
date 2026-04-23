<?php
require_once __DIR__ . '/../Models/Product.php';

class ProductController {
    private $productModel;
    private $baseUrl;

    public function __construct($pdo, $baseUrl) {
        $this->productModel = new Product($pdo);
        $this->baseUrl = $baseUrl;
    }

    public function index() {
        echo json_encode($this->productModel->getAll());
    }

    public function store() {
        $data = [
            'name' => $_POST['name'] ?? '',
            'category' => $_POST['category'] ?? '',
            'stock' => $_POST['stock'] ?? 0,
            'price' => $_POST['price'] ?? 0,
            'image' => $this->handleUpload()
        ];

        if ($this->productModel->create($data)) {
            echo json_encode(['message' => 'Product created', 'image_url' => $data['image']]);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Failed to create product']);
        }
    }

    public function update() {
        $id = $_POST['id'] ?? null;
        $product = $this->productModel->find($id);

        if (!$product) {
            http_response_code(404);
            echo json_encode(['message' => 'Product not found']);
            return;
        }

        $imageUrl = $product['image'];
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $this->deleteFile($imageUrl);
            $imageUrl = $this->handleUpload();
        }

        $data = [
            'name' => $_POST['name'] ?? $product['name'],
            'category' => $_POST['category'] ?? $product['category'],
            'stock' => $_POST['stock'] ?? $product['stock'],
            'price' => $_POST['price'] ?? $product['price'],
            'image' => $imageUrl
        ];

        if ($this->productModel->update($id, $data)) {
            echo json_encode(['message' => 'Product updated', 'image_url' => $imageUrl]);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Update failed']);
        }
    }

    public function delete() {
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'] ?? $_POST['id'] ?? null;
        $product = $this->productModel->find($id);

        if ($product) {
            $this->deleteFile($product['image']);
            $this->productModel->delete($id);
            echo json_encode(['message' => 'Product deleted']);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Product not found']);
        }
    }

    private function handleUpload() {
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $filename = time() . '_' . $_FILES['image']['name'];
            $target = __DIR__ . '/../../storage/uploads/' . $filename;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                return $this->baseUrl . '/storage/' . $filename;
            }
        }
        return '';
    }

    private function deleteFile($url) {
        if ($url) {
            $filename = basename($url);
            $path = __DIR__ . '/../../storage/uploads/' . $filename;
            if (file_exists($path)) unlink($path);
        }
    }
}
