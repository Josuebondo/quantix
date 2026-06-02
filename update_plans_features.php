<?php

// Bootstrap the application
require 'vendor/autoload.php';

// Create application instance
$app = new \Core\Application();

// Get database connection from container
$pdo = $app->connexion();

// Update Plan 1 - Gratuit
$plan1_features = json_encode([
    'users_limit' => 2,
    'warehouses_limit' => 1,
    'products_limit' => 100,
    'reports' => false,
    'barcode' => false,
    'exports' => false,
    'api_access' => false,
    'multi_warehouse' => false,
    'priority_support' => false,
    'custom_roles' => false,
    'inventory_history' => true,
    'stock_alerts' => true,
    'dashboard_analytics' => false,
    'multi_currency' => false,
    'invoice_management' => true,
    'purchase_management' => true,
    'sales_management' => true
]);

// Update Plan 2 - Standard
$plan2_features = json_encode([
    'users_limit' => 10,
    'warehouses_limit' => 5,
    'products_limit' => 5000,
    'reports' => true,
    'barcode' => true,
    'exports' => true,
    'api_access' => false,
    'multi_warehouse' => true,
    'priority_support' => false,
    'custom_roles' => true,
    'inventory_history' => true,
    'stock_alerts' => true,
    'dashboard_analytics' => true,
    'multi_currency' => true,
    'invoice_management' => true,
    'purchase_management' => true,
    'sales_management' => true
]);

// Update Plan 3 - Business
$plan3_features = json_encode([
    'users_limit' => 50,
    'warehouses_limit' => 20,
    'products_limit' => 50000,
    'reports' => true,
    'barcode' => true,
    'exports' => true,
    'api_access' => true,
    'multi_warehouse' => true,
    'priority_support' => true,
    'custom_roles' => true,
    'inventory_history' => true,
    'stock_alerts' => true,
    'dashboard_analytics' => true,
    'multi_currency' => true,
    'invoice_management' => true,
    'purchase_management' => true,
    'sales_management' => true
]);

try {
    $stmt1 = $pdo->prepare("UPDATE plans SET features = ? WHERE id = 1");
    $stmt1->execute([$plan1_features]);
    echo "✓ Plan 1 (Gratuit) updated\n";

    $stmt2 = $pdo->prepare("UPDATE plans SET features = ? WHERE id = 2");
    $stmt2->execute([$plan2_features]);
    echo "✓ Plan 2 (Standard) updated\n";

    $stmt3 = $pdo->prepare("UPDATE plans SET features = ? WHERE id = 3");
    $stmt3->execute([$plan3_features]);
    echo "✓ Plan 3 (Business) updated\n";

    // Verify updates
    $stmt_verify = $pdo->query("SELECT id, name, features FROM plans ORDER BY id");
    $plans = $stmt_verify->fetchAll(PDO::FETCH_ASSOC);

    echo "\nPlan data:\n";
    foreach ($plans as $plan) {
        echo "ID {$plan['id']}: {$plan['name']}\n";
        echo "  Features: " . substr($plan['features'], 0, 50) . "...\n";
    }
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}
