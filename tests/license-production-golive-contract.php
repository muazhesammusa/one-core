<?php

declare(strict_types=1);

$root = dirname(__DIR__);
$failures = [];

foreach (['.gitignore', '.distignore'] as $file) {
    $contents = file_get_contents($root . '/' . $file) ?: '';
    foreach (['release/', 'temp/'] as $entry) {
        if (strpos($contents, $entry) === false) {
            $failures[] = "{$file} is missing {$entry}";
        }
    }
}

$release = file_get_contents($root . '/scripts/release.mjs') ?: '';
foreach (["'temp'", "'temp/'"] as $entry) {
    if (strpos($release, $entry) === false) {
        $failures[] = "Core release builder does not exclude {$entry}";
    }
}

$plan = file_get_contents($root . '/.ai/ONE_LICENSE_MIGRATION_PLAN.md') ?: '';
if (strpos($plan, 'Phase 8: Production License Go-Live Integration / no Core ownership [complete]') === false) {
    $failures[] = 'Main plan is missing the Phase 8 [complete] tag.';
}

$runtime = '';
foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root . '/inc', FilesystemIterator::SKIP_DOTS)) as $file) {
    if ($file->isFile() && strtolower($file->getExtension()) === 'php') {
        $runtime .= file_get_contents($file->getPathname()) ?: '';
    }
}
foreach (['ONE_LICENSE_PUBLIC_KEYS', 'purchase_code', '/v1/licenses/activate', 'License_Api_Client', 'sodium_crypto_sign_verify_detached'] as $forbidden) {
    if (strpos($runtime, $forbidden) !== false) {
        $failures[] = "One Core crossed the production license ownership boundary: {$forbidden}";
    }
}

if ($failures !== []) {
    fwrite(STDERR, "One Core production go-live contract failed:\n- " . implode("\n- ", $failures) . "\n");
    exit(1);
}

echo "One Core production go-live contract: PASS\n";
