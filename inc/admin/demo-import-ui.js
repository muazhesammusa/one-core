/* global BPDemoSteps, wp */
(function(){
  const { createElement: h, render, useState, useEffect } = window.wp.element || {};
  if (!h || !render) return;

  const OPTIONS = [
    { key: 'buddypress', label: 'BuddyPress', locked: true },
    { key: 'menus', label: 'Menus', locked: true },
    { key: 'customizer', label: 'Customizer', locked: true },
    { key: 'pages', label: 'Pages', locked: false },
    { key: 'events', label: 'Events', locked: false },
    { key: 'woocommerce', label: 'WooCommerce', locked: false },
    { key: 'directory', label: 'Directory', locked: false },
    { key: 'job_manager', label: 'Job Manager', locked: false },
    { key: 'courses', label: 'Courses (Tutor LMS)', locked: false },
    { key: 'forums', label: 'Forums (bbPress)', locked: false },
    { key: 'pmp', label: 'Paid Memberships Pro', locked: false },
    { key: 'media_pages', label: 'Media Pages', locked: false },
  ];

  function Toggle({checked, disabled, onChange}){
    const base = 'relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-200';
    const on  = 'bg-blue-600';
    const off = 'bg-gray-300';
    return h('button', {
      type: 'button',
      disabled: !!disabled,
      onClick: ()=>{ if (!disabled) onChange(!checked); },
      className: base + ' ' + (checked ? on : off) + (disabled ? ' opacity-60 cursor-not-allowed' : '')
    },
      h('span', {
        className: 'inline-block h-4 w-4 transform rounded-full bg-white transition-transform duration-200 ' + (checked ? 'translate-x-6' : 'translate-x-1')
      })
    );
  }

  function App(){
    const [selected, setSelected] = useState(()=>{
      const d = BPDemoSteps.defaults || {};
      const state = {};
      OPTIONS.forEach(o=>{ state[o.key] = !!d[o.key]; });
      if (!BPDemoSteps.license_active) {
        state.pages = false;
      }
      return state;
    });
    const [done, setDone] = useState(()=>{
      try { 
        // Clear localStorage on fresh installs
        if (BPDemoSteps.is_fresh_install) {
          localStorage.removeItem('one_demo_done');
          localStorage.removeItem('one_demo_selected');
          return {};
        }
        
        // Also check if we're on a fresh page load and clear if needed
        const hasExistingContent = document.querySelector('.wp-list-table') || 
                                  document.querySelector('.dashboard-widgets') || 
                                  document.querySelector('.post-count') ||
                                  document.querySelector('.user-count');
        
        if (!hasExistingContent && Object.keys(JSON.parse(localStorage.getItem('one_demo_done') || '{}')).length > 0) {
          localStorage.removeItem('one_demo_done');
          localStorage.removeItem('one_demo_selected');
          return {};
        }
        
        return JSON.parse(localStorage.getItem('one_demo_done') || '{}'); 
      } catch(e){ 
        localStorage.removeItem('one_demo_done');
        localStorage.removeItem('one_demo_selected');
        return {}; 
      }
    });

    function toggle(key){
      const opt = OPTIONS.find(o=>o.key===key);
      if (opt && opt.locked) return;
      if (!BPDemoSteps.license_active && key === 'pages') return;
      setSelected(s=>({ ...s, [key]: !s[key] }));
    }

    function handleStartImport(){
      if (Object.keys(selected).filter(k => selected[k]).length === 0) return;
      
      // Build steps array
      const steps = [];
      
      // Add plugin installation step if needed
      const pluginsToInstall = [];
      if (selected.buddypress && !done.buddypress) pluginsToInstall.push('buddypress');
      if (selected.forums && !done.forums) pluginsToInstall.push('bbpress');
      if (selected.events && !done.events) pluginsToInstall.push('the-events-calendar');
      if (selected.woocommerce && !done.woocommerce) pluginsToInstall.push('woocommerce');
      if (selected.directory && !done.directory) pluginsToInstall.push('directorist');
      if (selected.job_manager && !done.job_manager) pluginsToInstall.push('wp-job-manager');
      if (selected.courses && !done.courses) pluginsToInstall.push('tutor');
      if (selected.pmp && !done.pmp) pluginsToInstall.push('paid-memberships-pro');
      //default elementor
      pluginsToInstall.push('elementor');
      
      if (pluginsToInstall.length > 0) {
        steps.push({
          action: 'install_plugins',
          payload: pluginsToInstall
        });
      }
      
      // Add import steps for selected items
      Object.keys(selected).forEach(key => {
        if (!selected[key] || done[key]) return; // Skip if not selected or already done
        
        switch(key) {
          case 'customizer':
            steps.push({ action: 'import_customizer' });
            break;
          case 'menus':
            steps.push({ action: 'import_menus' });
            break;
          case 'buddypress':
            steps.push({ action: 'import_buddypress' });
            break;
          case 'events':
            steps.push({ action: 'import_events' });
            break;
          case 'woocommerce':
            steps.push({ action: 'import_woocommerce' });
            break;
          case 'directory':
            steps.push({ action: 'import_directory' });
            break;
          case 'job_manager':
            steps.push({ action: 'import_job_manager' });
            break;
          case 'courses':
            steps.push({ action: 'import_courses' });
            break;
          case 'forums':
            steps.push({ action: 'import_forums' });
            break;
          case 'pmp':
            steps.push({ action: 'import_pmp' });
            break;
          case 'media_pages':
            steps.push({ action: 'create_media_pages' });
            break;
          case 'pages':
            steps.push({ action: 'import_all_templates' });
            break;
        }
      });
      
      // Add demo data import step
      if (Object.keys(selected).filter(k => selected[k]).length > 0) {
        steps.push({
          action: 'import_exported_demo',
          payload: Object.keys(selected).filter(k => selected[k])
        });
      }
      
      window.ONE_DEMO_SELECTED_STEPS = steps;
      window.oneDemoModal.startImport();
    }

    // Build steps for demo-import.js
    useEffect(()=>{
      const steps = [];
      // plugins to install based on selections
      const pluginSlugs = [];
      if (selected.buddypress && !done.buddypress) pluginSlugs.push('buddypress');
      if (selected.forums && !done.forums) pluginSlugs.push('bbpress');
      if (selected.events && !done.events) {
          pluginSlugs.push('the-events-calendar');
          pluginSlugs.push('event-tickets');
      } 
      if (selected.woocommerce && !done.woocommerce) pluginSlugs.push('woocommerce');
      if (selected.directory && !done.directory) {
          pluginSlugs.push('directorist');
          pluginSlugs.push('addonskit-for-elementor');
      } 
      if (selected.job_manager && !done.job_manager) pluginSlugs.push('wp-job-manager');
      if (selected.courses && !done.courses) {
          pluginSlugs.push('tutor');
          pluginSlugs.push('tutor-lms-elementor-addons');
      } 
      if (selected.pmp && !done.pmp) pluginSlugs.push('paid-memberships-pro');
      //default elementor
      pluginSlugs.push('elementor');

      steps.push({ step: 'install_plugins', payload: { slugs: pluginSlugs } });

      // Import exported demo JSON file if present (expects admin to place file path)
      // Example sections map keys: tutor_lms, directorist, events, woocommerce, wp_job_manager
      const demoPath = window.ONE_DEMO_JSON_PATH || 'inc/admin/demo-data/extension-demo.json';
      const sections = {};
      if (selected.courses && !done.courses) sections['tutor_lms'] = true;
      if (selected.directory && !done.directory) sections['directorist'] = true;
      if (selected.events && !done.events) sections['events'] = true;
      if (selected.woocommerce && !done.woocommerce) sections['woocommerce'] = true;
      if (selected.job_manager && !done.job_manager) sections['wp_job_manager'] = true;
      if (demoPath && Object.keys(sections).length) {
        steps.push({ 
          step: 'import_exported_demo', 
          payload: { 
            path: demoPath, 
            sections: Object.keys(sections),
            label: 'Importing exported demo data...'
          } 
        });
      } else if (Object.keys(sections).length) {
        // If no demo file, import extension demo content directly
        steps.push({ 
          step: 'import_extension_demos', 
          payload: { 
            sections: Object.keys(sections),
            label: 'Importing extension demo content...'
          } 
        });
      }

      if (selected.buddypress && !done.buddypress) {
        steps.push({ step: 'enable_groups_component' });
        steps.push({ step: 'import_activities' });
      }
      if (BPDemoSteps.license_active && selected.pages && !done.pages) {
        steps.push({ step: 'list_templates', payload: { label: 'Importing templates list…' } });
        // placeholder; demo-import.js will expand this into per-template steps dynamically
        steps.push({ step: '__import_templates_dynamic__' });
      }
      if (selected.customizer && !done.customizer) steps.push({ step: 'import_customizer', payload: { label: 'Importing Customizer…' } });
      if (selected.menus && !done.menus) steps.push({ step: 'import_menus', payload: { label: 'Importing Menus…' } });
      if (selected.forums && !done.forums) steps.push({ step: 'import_forums', payload: { label: 'Importing Forums…' } });
      // widgets always helpful
      steps.push({ step: 'import_widgets', payload: { label: 'Importing Widgets…' } });
      steps.push({ step: 'setup_homepage', payload: { label: 'Setting up Homepage…' } });

      window.ONE_DEMO_SELECTED_STEPS = steps;
    }, [selected, done]);

    return h('div', { className: 'p-4 border rounded bg-white mb-4' },
      h('div', null,
        (!BPDemoSteps.license_active ? h('div', { className: 'mb-3 p-3 rounded bg-amber-50 border border-amber-200 text-amber-900' },
          h('div', { className: 'font-medium mb-1' }, 'License not active'),
          h('div', null,
            'Core demo import works. Page templates import requires license. ',
            h('a', { href: BPDemoSteps.license_link, target: '_blank', className: 'underline' }, 'Activate license')
          )
        ) : null),
        h('div', { className: 'flex items-center justify-between mb-4' },
          h('h3', { className: 'text-lg font-semibold' }, 'Select what to import'),
          h('button', { 
            onClick: () => {
              localStorage.removeItem('one_demo_done');
              window.location.reload();
            },
            className: 'px-3 py-1 text-sm text-red-600 bg-red-50 border border-red-200 rounded hover:bg-red-100 transition-colors'
          }, 'Reset Import Status')
        ),
        h('div', { className: 'grid grid-cols-1 md:grid-cols-2 xl:grid-cols-2 gap-3' },
          OPTIONS.map(opt => {
            const disabled = !!opt.locked || (!BPDemoSteps.license_active && opt.key === 'pages');
            return h('div', {
              key: opt.key,
              className: 'flex items-center justify-between gap-3 rounded-lg border border-gray-200 px-4 py-3 hover:border-blue-400 transition-colors' + (disabled ? ' opacity-60' : '')
            },
              h('div', { className: 'flex items-center gap-2' },
                h('div', { className: 'h-8 w-8 flex items-center justify-center rounded-md bg-gray-100 text-gray-600' }, opt.label.charAt(0)),
                h('div', null,
                  h('div', { className: 'font-medium' }, opt.label),
                  done[opt.key]
                    ? h('div', { className: 'text-xs text-green-600 flex items-center gap-1' },
                        h('span', { className: 'inline-block h-2 w-2 bg-green-500 rounded-full' }),
                        'Imported'
                      )
                    : (disabled
                        ? h('div', { className: 'text-xs text-gray-500 flex items-center gap-1' },
                            h('span', { className: 'inline-block h-2 w-2 bg-gray-400 rounded-full' }),
                            opt.locked ? 'Required' : 'License required'
                          )
                        : h('div', { className: 'text-xs text-gray-500' }, 'Optional')
                      )
                )
              ),
              h(Toggle, { checked: !!selected[opt.key], disabled: disabled, onChange: ()=> toggle(opt.key) })
            );
          })
        )
      )
    );
  }

  const root = document.getElementById('one-demo-react-root');
  if (root) render(h(App), root);
})();
