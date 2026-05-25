<?php

function ensure_settings_table(mysqli $conn): void
{
    $conn->query("CREATE TABLE IF NOT EXISTS `system_settings` (
        `setting_key` varchar(100) NOT NULL,
        `setting_value` text DEFAULT NULL,
        `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (`setting_key`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");
}

function default_settings(): array
{
    return [
        'system_name' => 'Job Portal',
        'language' => 'en-US',
        'timezone' => 'Asia/Kathmandu',
        'logo_path' => 'assets/images/Job.png',
        'ai_sensitivity' => 'balanced',
        'screening_threshold' => '75',
        'llm_model' => 'recruitllm-v4',
        'two_factor_enabled' => '0',
        'email_notifications' => '1',
    ];
}

function get_settings(mysqli $conn): array
{
    ensure_settings_table($conn);
    $settings = default_settings();
    $result = $conn->query('SELECT setting_key, setting_value FROM system_settings');

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
    }

    return $settings;
}

function save_setting(mysqli $conn, string $key, ?string $value): void
{
    ensure_settings_table($conn);
    $stmt = $conn->prepare(
        'INSERT INTO system_settings (setting_key, setting_value) VALUES (?, ?)
         ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)'
    );
    $stmt->bind_param('ss', $key, $value);
    $stmt->execute();
    $stmt->close();
}

function save_settings_bulk(mysqli $conn, array $pairs): void
{
    foreach ($pairs as $key => $value) {
        save_setting($conn, $key, (string) $value);
    }
}
