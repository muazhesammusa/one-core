<?php

declare(strict_types=1);

$root = dirname(__DIR__);
$failures = [];

$forbiddenPaths = [
    'inc/licensing',
    'updater',
];

foreach ($forbiddenPaths as $relativePath) {
    if (file_exists($root . '/' . $relativePath)) {
        $failures[] = "One Core must not own license runtime path: {$relativePath}";
    }
}

$forbiddenSignatures = [
    '/v1/licenses/activate',
    '/v1/licenses/refresh',
    '/v1/licenses/deactivate',
    '/v1/products/update',
    'purchase_code',
    'License_Api_Client',
    'Entitlement_Verifier',
    'pre_set_site_transient_update_themes',
    'wp_ajax_one_license_activate',
    'wp_ajax_one_license_refresh',
    'wp_ajax_one_license_deactivate',
    'one_license_admin',
];

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS)
);

foreach ($iterator as $file) {
    if (!$file->isFile() || !in_array($file->getExtension(), ['php', 'js'], true)) {
        continue;
    }

    $relativePath = ltrim(str_replace($root, '', $file->getPathname()), '/');
    foreach (['tests/', 'release/', 'temp/', 'node_modules/', '.git/'] as $excludedPrefix) {
        if (str_starts_with($relativePath, $excludedPrefix)) {
            continue 2;
        }
    }

    $contents = file_get_contents($file->getPathname());
    if ($contents === false) {
        $failures[] = "Unable to read {$relativePath}";
        continue;
    }

    foreach ($forbiddenSignatures as $signature) {
        if (strpos($contents, $signature) !== false) {
            $failures[] = "Theme-owned license signature '{$signature}' found in {$relativePath}";
        }
    }
}

if ($failures !== []) {
    fwrite(STDERR, "One Core license boundary contract failed:\n- " . implode("\n- ", $failures) . "\n");
    exit(1);
}

echo "One Core license boundary contract: PASS\n";
