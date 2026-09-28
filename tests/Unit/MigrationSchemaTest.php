<?php

test('users migration does not assign a default value to the items_provided json column', function () {
    $migrationPath = dirname(__DIR__, 2) . '/database/migrations/2025_12_11_065049_add_validity_and_items_to_users_table.php';
    $migration = file_get_contents($migrationPath);

    expect($migration)->toContain("\$table->json('items_provided')");
    expect($migration)->not->toContain('default(json_encode(["Router", "Cable", "Adapter"]))');
});

test('sql dump does not assign an invalid default value to the items_provided column', function () {
    $possiblePaths = [
        dirname(__DIR__, 2) . '/gba (2).sql',
        dirname(__DIR__, 2) . '/../../Downloads/gba (2).sql',
        getenv('USERPROFILE') . '/Downloads/gba (2).sql',
        'C:/Users/SATHVIKA/Downloads/gba (2).sql',
    ];

    $sqlPath = null;
    foreach ($possiblePaths as $path) {
        if (is_file($path)) {
            $sqlPath = $path;
            break;
        }
    }

    expect($sqlPath)->not->toBeNull();

    $sql = file_get_contents($sqlPath);

    expect($sql)->toBeString();
    $this->assertStringContainsString('`items_provided`', $sql);
    $this->assertStringNotContainsString("DEFAULT '[\"Router\",\"Cable\",\"Adapter\"]'", $sql);
});
