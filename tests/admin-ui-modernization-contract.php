<?php

declare(strict_types=1);

$root = dirname(__DIR__);
$importPhp = file_get_contents($root . '/inc/admin/demo-import.php');
$importCss = file_get_contents($root . '/inc/admin/demo-import.css');
$package = json_decode((string) file_get_contents($root . '/package.json'), true);

$assertions = [
    'demo import source readable' => is_string($importPhp),
    'demo import stylesheet readable' => is_string($importCss),
    'demo assets scoped to importer page' => str_contains($importPhp, "'one' !== \$page || 'importer' !== \$tab"),
    'demo card uses modern shell' => str_contains($importPhp, 'one-core-demo-banner__icon') && str_contains($importPhp, 'one-core-demo-banner__copy'),
    'demo modal has structured heading' => str_contains($importPhp, 'bp-demo-modal-heading'),
    'demo modal close has no positional inline style' => str_contains($importPhp, 'class="bp-demo-modal-close"') && !str_contains($importPhp, 'style="position:absolute;right:12px;top:12px;"'),
    'license-required state uses shared action primitive' => str_contains($importPhp, 'one-admin-button one-admin-button--primary'),
    'canonical One admin URL used' => str_contains($importPhp, "themes.php?page=one&tab=license") && str_contains($importPhp, "themes.php?page=one&tab=importer"),
    'required import options default on' => str_contains($importPhp, "'customizer' => true")
        && str_contains($importPhp, "'menus' => true")
        && str_contains($importPhp, "'buddypress' => true"),
    'optional import options default off' => str_contains($importPhp, "'courses' => false")
        && str_contains($importPhp, "'directory' => false")
        && str_contains($importPhp, "'events' => false")
        && str_contains($importPhp, "'woocommerce' => false")
        && str_contains($importPhp, "'job_manager' => false")
        && str_contains($importPhp, "'forums' => false")
        && str_contains($importPhp, "'pmp' => false")
        && str_contains($importPhp, "'media_pages' => false"),
    'modal css has modern overlay' => str_contains($importCss, 'backdrop-filter: blur(6px)') && str_contains($importCss, 'box-shadow: 0 36px 100px'),
    'demo card css is responsive' => str_contains($importCss, '@media (max-width: 782px)') && str_contains($importCss, '.one-core-demo-banner'),
    'test command includes contract' => isset($package['scripts']['test']) && str_contains($package['scripts']['test'], 'admin-ui-modernization-contract.php'),
];

$failed = [];
foreach ($assertions as $label => $passed) {
    if (!$passed) {
        $failed[] = $label;
    }
}

if ($failed !== []) {
    fwrite(STDERR, "One Core admin UI modernization contract failed:\n- " . implode("\n- ", $failed) . "\n");
    exit(1);
}

echo "One Core admin UI modernization contract: PASS\n";
