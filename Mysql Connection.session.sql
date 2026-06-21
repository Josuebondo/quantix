ALTER TABLE invitations
ADD COLUMN `name` Varchar
(100) DEFAULT NULL AFTER `role_id`