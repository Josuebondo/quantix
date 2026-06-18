ALTER TABLE users
ADD COLUMN warehouse_id BIGINT UNSIGNED NULL,
ADD CONSTRAINT fk_users_warehouse
FOREIGN KEY
(warehouse_id) REFERENCES warehouses
(id)
ON
DELETE
SET NULL;