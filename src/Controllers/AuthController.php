<?php
require_once __DIR__ . '/../Models/User.php';

class AuthController {
    private $userModel;

    public function __construct($pdo) {
        $this->userModel = new User($pdo);
    }

    public function login() {
        $data = json_decode(file_get_contents('php://input'), true);
        $user = $this->userModel->findByUsername($data['username'] ?? '');

        if ($user && password_verify($data['password'] ?? '', $user['password'])) {
            echo json_encode(['message' => 'Login successful', 'user' => ['username' => $user['username']]]);
        } else {
            http_response_code(401);
            echo json_encode(['message' => 'Invalid credentials']);
        }
    }

    public function register() {
        $data = json_decode(file_get_contents('php://input'), true);
        if ($this->userModel->create($data['username'] ?? '', $data['password'] ?? '')) {
            echo json_encode(['message' => 'User registered']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Registration failed']);
        }
    }
}
