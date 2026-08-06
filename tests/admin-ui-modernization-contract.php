<?php

declare(strict_types=1);

$root = dirname(__DIR__);
$importPhp = file_get_contents($root . '/inc/admin/demo-import.php');
$importCss = file_get_contents($root . '/inc/admin/demo-import.css');
$importJs = file_get_contents($root . '/inc/admin/demo-import.js');
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
    'bbPress remains optional and defaults off' => str_contains($importPhp, "'forums' => false"),
    'BuddyPress setup runs before community content import' => str_contains($importPhp, "case 'configure_buddypress':")
        && str_contains($importPhp, 'bp_demo_configure_buddypress()'),
    'BuddyPress community components are activated' => str_contains($importPhp, "['groups', 'friends', 'messages']"),
    'BuddyPress AJAX setup avoids admin-screen-only helper' => !str_contains($importPhp, 'bp_core_admin_get_active_components_from_submitted_settings')
        && str_contains($importPhp, "bp_get_option('bp-active-components', [])")
        && str_contains($importPhp, '$active_components[$component] = 1'),
    'demo AJAX handler returns JSON for runtime errors' => str_contains($importPhp, 'catch (Throwable $e)')
        && str_contains($importPhp, "'one_demo_import_step_failed'")
        && str_contains($importPhp, '], 500);'),
    'import pipeline stops after failed step' => is_string($importJs)
        && str_contains($importJs, 'function stopImport(message)')
        && str_contains($importJs, 'stopImport(`Import stopped: ${msg}`)')
        && !str_contains($importJs, 'showMessage(`AJAX error: ${error}`, true)'),
    'BuddyPress community options are activated' => str_contains($importPhp, "bp_update_option('bp-enable-members-invitations', 1)")
        && str_contains($importPhp, "bp_update_option('bp-enable-membership-requests', 1)")
        && str_contains($importPhp, "bp_update_option('one_enable_user_profile_invitation', 1)"),
    'legacy groups-only setup step removed' => !str_contains($importPhp, "case 'enable_groups_component':")
        && !str_contains($importPhp, 'bp_demo_enable_groups_component_properly'),
    'unsupported integrations removed from importer config' => !str_contains($importPhp, "'events' =>")
        && !str_contains($importPhp, "'woocommerce' =>")
        && !str_contains($importPhp, "'directory' =>")
        && !str_contains($importPhp, "'job_manager' =>")
        && !str_contains($importPhp, "'courses' =>")
        && !str_contains($importPhp, "'pmp' =>")
        && !str_contains($importPhp, "'media_pages' =>"),
    'extension demo routes removed' => !str_contains($importPhp, "case 'import_exported_demo':")
        && !str_contains($importPhp, "case 'import_extension_demos':")
        && !str_contains($importPhp, "case 'create_media_pages':"),
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
