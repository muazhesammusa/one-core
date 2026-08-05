<?php

declare(strict_types=1);

$root = dirname(__DIR__);
$failures = [];

$bridgePath = $root . '/inc/class-entitlement-bridge.php';
if (!is_file($bridgePath)) {
    $failures[] = 'One Core entitlement bridge is missing.';
}

$bridge = is_file($bridgePath) ? (file_get_contents($bridgePath) ?: '') : '';
foreach (['tophive_one_license_status', 'tophive_one_has_entitlement', 'tophive_one_license_features', 'apply_filters'] as $required) {
    if (strpos($bridge, $required) === false) {
        $failures[] = "One Core bridge contract is missing: {$required}";
    }
}
foreach (['License_Api_Client', 'Entitlement_Verifier', '/v1/licenses/', 'purchase_code', 'update_option'] as $forbidden) {
    if (strpos($bridge, $forbidden) !== false) {
        $failures[] = "One Core bridge owns forbidden license runtime: {$forbidden}";
    }
}

$bootstrap = file_get_contents($root . '/one-core.php') ?: '';
if (strpos($bootstrap, "require_once('inc/class-entitlement-bridge.php')") === false) {
    $failures[] = 'One Core does not load the read-only entitlement bridge.';
}

$demo = file_get_contents($root . '/inc/admin/demo-import.php') ?: '';
foreach (["EntitlementBridge::has('demo_import')", "check_ajax_referer( 'bp_demo_import_step', '_wpnonce' )", 'one_license_required', 'themes.php?page=one&tab=license'] as $required) {
    if (strpos($demo, $required) === false) {
        $failures[] = "Protected demo importer contract is missing: {$required}";
    }
}
if (strpos($demo, "if ( isset( \$_POST['_wpnonce'] ) )") !== false) {
    $failures[] = 'Demo importer nonce remains optional.';
}

$demoJs = file_get_contents($root . '/inc/admin/demo-import.js') ?: '';
if (strpos($demoJs, '_wpnonce: BPDemoSteps.nonce') === false) {
    $failures[] = 'Demo importer JavaScript does not send the required nonce.';
}

$plan = file_get_contents($root . '/.ai/ONE_LICENSE_MIGRATION_PLAN.md') ?: '';
foreach (['Phase 4: Defensive Entitlement Bridge Consumer [complete]', 'Phase 7: Licensed and Unlicensed Compatibility QA [complete]'] as $status) {
    if (strpos($plan, $status) === false) {
        $failures[] = "One Core migration plan status is missing: {$status}";
    }
}


if (file_exists($root . '/t/modules/custom-fonts/custom-fonts.php@@ -310,13 +310,7 @@')) {
    $failures[] = 'A stale diff-artifact PHP file remains in One Core.';
}

$distignore = file_get_contents($root . '/.distignore') ?: '';
if (strpos($distignore, 'tests/') === false) {
    $failures[] = 'One Core release rules do not exclude tests.';
}
if (strpos($distignore, 'SOURCE-HANDOFF.json') === false) {
    $failures[] = 'One Core release rules do not exclude source handoff metadata.';
}

if ($failures !== []) {
    fwrite(STDERR, "One Core entitlement bridge contract failed:\n- " . implode("\n- ", $failures) . "\n");
    exit(1);
}

echo "One Core entitlement bridge contract: PASS\n";
