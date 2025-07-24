-- Giftcard Receiver Name and Email
INSERT INTO patients (fname, email, status, user_token, created_at, updated_at)
SELECT 
    CASE 
        WHEN recipient_name IS NULL OR recipient_name = '' 
        THEN your_name 
        ELSE recipient_name 
    END AS fname,
    gift_send_to AS email,
    status,
    user_token,
    created_at,
    updated_at
FROM giftsends
WHERE gift_send_to IS NOT NULL AND gift_send_to != ''
ON DUPLICATE KEY UPDATE 
    fname = VALUES(fname),
    status = 1,  -- Fixed incorrect use of VALUES()
    user_token = VALUES(user_token),
    created_at = VALUES(created_at),
    updated_at = VALUES(updated_at);

-- Data Coming from Transaction Table
INSERT INTO patients (fname, lname, city, country, zip_code, phone, address, email, status, user_token, created_at, updated_at)
SELECT 
    t.fname, 
    t.lname, 
    t.city, 
    t.country, 
    t.zip_code, 
    t.phone, 
    t.address, 
    t.email, 
    1 AS status, 
    t.user_token, 
    t.created_at, 
    t.updated_at
FROM transaction_histories t
INNER JOIN (
    SELECT email, MAX(id) AS latest_id
    FROM transaction_histories
    WHERE email IS NOT NULL
    GROUP BY email
) AS latest_emails 
ON t.email = latest_emails.email AND t.id = latest_emails.latest_id
WHERE NOT EXISTS (
    SELECT 1
    FROM patients p
    WHERE p.email = t.email OR p.phone = t.phone
);

-- Remove Duplicate Entries
DELETE FROM patients
WHERE id NOT IN (
    SELECT MIN(id)
    FROM patients
    GROUP BY email
);

-- Identify Duplicate Records
SELECT email, COUNT(*) 
FROM patients 
GROUP BY email 
HAVING COUNT(*) > 1;
-- Adding Comment in giftsends table 
ALTER TABLE `giftsends` CHANGE `your_name` `your_name` VARCHAR(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'Send for other Giftcard Then This fields Sender Name Giftcard Buy For Self Then Receiver This Field Work as Giftcard Receiver Name giftcard buy for self then recipient_name is empty', CHANGE `recipient_name` `recipient_name` VARCHAR(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'Giftcard buy for other then use this fields in this case field is not null', CHANGE `gift_send_to` `gift_send_to` VARCHAR(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'Giftcard Buy For Other and Self ', CHANGE `receipt_email` `receipt_email` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'Giftcard Sender Email_id Giftcard buy for Other ';