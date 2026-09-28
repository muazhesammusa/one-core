<?php

declare(strict_types=1);

$root = dirname(__DIR__);
$failures = [];

foreach ([
    'inc/class-entitlement-bridge.php',
    'docs/SHARED_WORDPRESS_SDK_BOUNDARY.md',
] as $relativePath) {
    if (file_exists($root . '/' . $relativePath)) {
        $failures[] = "Old licensing artifact still exists: {$relativePath}";
    }
}

$bootstrap = file_get_contents($root . '/one-core.php') ?: '';
$modules = file_get_contents($root . '/t/class-tophive-modules.php') ?: '';
$importer = file_get_contents($root . '/inc/admin/demo-import.php') ?: '';
$package = json_decode((string) file_get_contents($root . '/package.json'), true);

foreach ([
    'class-entitlement-bridge.php',
    'init_entitled_runtime',
    'EntitlementBridge',
    'tophive_one_has_entitlement',
    'tophive_one_license_status',
    'Tophive_Licence',
    'one_license_required',
] as $signature) {
    if (str_contains($bootstrap . $modules . $importer, $signature)) {
        $failures[] = "One Core still carries old licensing signature: {$signature}";
    }
}

foreach ([
    "check_ajax_referer( 'bp_demo_import_step', '_wpnonce' )",
    "current_user_can( 'manage_options' )",
    "case 'install_plugins':",
    "case 'import_pages':",
] as $required) {
    if (!str_contains($importer, $required)) {
        $failures[] = "Demo importer lost a required non-license safety/runtime contract: {$required}";
    }
}

if (!str_contains($bootstrap, "add_action('after_setup_theme', array(self::getInstance(), 'init_runtime'), 21);")) {
    $failures[] = 'One Core runtime bootstrap was not preserved after licensing cleanup.';
}
if (!isset($package['scripts']['test']) || !str_contains($package['scripts']['test'], 'license-clean-baseline-contract.php')) {
    $failures[] = 'One Core test command does not include the clean license baseline regression gate.';
}

if ($failures !== []) {
    fwrite(STDERR, "One Core clean license baseline contract failed:\n- " . implode("\n- ", $failures) . "\n");
    exit(1);
}

echo "One Core clean license baseline contract: PASS\n";
