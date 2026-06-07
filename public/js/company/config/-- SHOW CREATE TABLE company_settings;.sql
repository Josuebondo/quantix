INSERT INTO permissions (name, code, module, created_at) VALUES

-- =====================
-- PRODUCTS
-- =====================
('View Product', 'product.view', 'products', NOW()),
('List Products', 'product.list', 'products', NOW()),
('Create Product', 'product.create', 'products', NOW()),
('Update Product', 'product.update', 'products', NOW()),
('Delete Product', 'product.delete', 'products', NOW()),
('Export Products', 'product.export', 'products', NOW()),

-- =====================
-- STOCKS
-- =====================
('View Stock', 'stock.view', 'stocks', NOW()),
('List Stock', 'stock.list', 'stocks', NOW()),
('Create Stock', 'stock.create', 'stocks', NOW()),
('Update Stock', 'stock.update', 'stocks', NOW()),
('Delete Stock', 'stock.delete', 'stocks', NOW()),
('Adjust Stock', 'stock.adjust', 'stocks', NOW()),
('Stock History', 'stock.history', 'stocks', NOW()),
('Export Stock', 'stock.export', 'stocks', NOW()),

-- =====================
-- SALES
-- =====================
('View Sales', 'sale.view', 'sales', NOW()),
('List Sales', 'sale.list', 'sales', NOW()),
('Create Sale', 'sale.create', 'sales', NOW()),
('Update Sale', 'sale.update', 'sales', NOW()),
('Delete Sale', 'sale.delete', 'sales', NOW()),
('Refund Sale', 'sale.refund', 'sales', NOW()),
('Export Sales', 'sale.export', 'sales', NOW()),

-- =====================
-- USERS
-- =====================
('Create User', 'user.create', 'users', NOW()),
('View User', 'user.view', 'users', NOW()),
('List Users', 'user.list', 'users', NOW()),
('Update User', 'user.update', 'users', NOW()),
('Delete User', 'user.delete', 'users', NOW()),
('Manage Users', 'user.manage', 'users', NOW()),
('Assign Role', 'user.assign_role', 'users', NOW()),

-- =====================
-- ROLES
-- =====================
('Create Role', 'role.create', 'roles', NOW()),
('View Role', 'role.view', 'roles', NOW()),
('List Roles', 'role.list', 'roles', NOW()),
('Update Role', 'role.update', 'roles', NOW()),
('Delete Role', 'role.delete', 'roles', NOW()),
('Manage Roles', 'role.manage', 'roles', NOW()),
('Assign Permission', 'role.assign_permission', 'roles', NOW()),

-- =====================
-- AUTH
-- =====================
('Login', 'auth.login', 'auth', NOW()),
('Logout', 'auth.logout', 'auth', NOW()),
('Refresh Token', 'auth.refresh', 'auth', NOW()),
('View Sessions', 'auth.sessions', 'auth', NOW()),
('Impersonate User', 'auth.impersonate', 'auth', NOW());