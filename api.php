<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

$dataFile = 'data.json';

// قراءة البيانات
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (file_exists($dataFile)) {
        echo file_get_contents($dataFile);
    } else {
        echo json_encode(['products' => [], 'settings' => [], 'custom_css' => '']);
    }
    exit;
}

// حفظ البيانات (للمستخدمين المصرح لهم فقط)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_GET['pass'] ?? '';
    if ($password !== '6767') {
        http_response_code(403);
        echo json_encode(['error' => 'كلمة المرور غير صحيحة']);
        exit;
    }
    
    $input = json_decode(file_get_contents('php://input'), true);
    if ($input) {
        file_put_contents($dataFile, json_encode($input, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'بيانات غير صالحة']);
    }
    exit;
}
?>
