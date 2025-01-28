<?php

require_once __DIR__ . '/../migrations/create_message_table_migration.php';
require_once __DIR__ . '/../migrations/create_users_table_migration.php';

$action = $argv[1] ?? null;

if ($action === 'up') {
    CreateUsersTableMigration::up();
    CreateMessageTableMigration::up();
} elseif ($action === 'down') {
    CreateUsersTableMigration::down();
    CreateMessageTableMigration::down();
} else {
    echo "Invalid action. Use 'php migrate.php up' to apply migrations or 'php migrate.php down' to rollback.\n";
}
