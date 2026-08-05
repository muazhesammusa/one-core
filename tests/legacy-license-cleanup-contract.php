<?php

declare(strict_types=1);

$root = dirname(__DIR__);
$failures = [];

$deletedPaths = [
    'updater/theme-updater.php',
    'updater/assets/js/script.js',
    'inc/admin/One_Imports_Controllers.php',
    'CAPTCHA_HANDLING.md',
];

foreach ($deletedPaths as $relativePath) {
    if (file_exists($root . '/' . $relativePath)) {
        $failures[] = "Deleted legacy file exists: {$relativePath}";
    }
}

$bootstrapPath = $root . '/one-core.php';
$bootstrap = file_get_contents($bootstrapPath);
if ($bootstrap === false) {
    $failures[] = 'Unable to read one-core.php.';
    $bootstrap = '';
}

$forbidden = [
    "require_once('updater/theme-updater.php')",
    'OneThemeUpdater',
    'fo_activation_key',
    'one_activation_key',
    '_tophive_license',
    '_tophive_product_id',
    'site_transient_update_themes',
    'tophive_core_dynamic_update',
    'type=theme_data',
    'wp-json/v1/license',
];

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS)
);

foreach ($iterator as $file) {
    if (!$file->isFile() || !in_array($file->getExtension(), ['php', 'js'], true)) {
        continue;
    }

    $relativePath = ltrim(str_replace($root, '', $file->getPathname()), '/');
    $excludedPrefixes = [
        'tests/',
        'release/',
        'temp/',
        'node_modules/',
        '.git/',
    ];

    foreach ($excludedPrefixes as $excludedPrefix) {
        if (str_starts_with($relativePath, $excludedPrefix)) {
            continue 2;
        }
    }

    $contents = file_get_contents($file->getPathname());
    if ($contents === false) {
        $failures[] = "Unable to read {$relativePath}";
        continue;
    }

    foreach ($forbidden as $signature) {
        if (strpos($contents, $signature) !== false) {
            $failures[] = "Legacy signature '{$signature}' found in {$relativePath}";
        }
    }
}

foreach (["require_once('inc/admin/demo-import.php');", "require_once('inc/admin/one-extension-export.php');"] as $requiredBootstrap) {
    if (strpos($bootstrap, $requiredBootstrap) === false) {
        $failures[] = "Required Core bootstrap was removed: {$requiredBootstrap}";
    }
}

if ($failures !== []) {
    fwrite(STDERR, "One Core legacy license cleanup contract failed:\n- " . implode("\n- ", $failures) . "\n");
    exit(1);
}

echo "One Core legacy license cleanup contract: PASS\n";
