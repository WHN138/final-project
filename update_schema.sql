-- Update structure for meal_logs table
-- Run this in your database SQL tab

-- 0. Ensure ID and user_id column exists
ALTER TABLE meal_logs ADD COLUMN id INT AUTO_INCREMENT PRIMARY KEY FIRST;
ALTER TABLE meal_logs ADD COLUMN user_id INT NOT NULL AFTER id;

-- 1. Add columns for manual nutrition entry
ALTER TABLE meal_logs
ADD COLUMN waktu_makan VARCHAR(50) NOT NULL AFTER tanggal,
ADD COLUMN food_name VARCHAR(255) NULL AFTER waktu_makan,
ADD COLUMN calories FLOAT DEFAULT 0 AFTER food_name,
ADD COLUMN protein FLOAT DEFAULT 0 AFTER calories,
ADD COLUMN fat FLOAT DEFAULT 0 AFTER protein,
ADD COLUMN carbs FLOAT DEFAULT 0 AFTER fat;

-- 2. Make food_id nullable (since manual entries won't have a food_id)
    ALTER TABLE meal_logs MODIFY COLUMN food_id INT NULL;
