/* global BPDemoSteps, wp */
(function(){
  const { createElement: h, render, useState, useEffect } = window.wp.element || {};
  if (!h || !render) return;

  const PLUGIN_LABELS = {
    buddypress: 'BuddyPress',
    bbpress: 'bbPress',
    elementor: 'Elementor',
  };

  const OPTIONS = [
    { key: 'buddypress', label: 'BuddyPress', locked: true },
    { key: 'menus', label: 'Menus', locked: true },
    { key: 'customizer', label: 'Customizer', locked: true },
    { key: 'forums', label: 'bbPress Forums', locked: false },
  ];

  function Toggle({ checked, disabled, onChange }) {
    const base = 'relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-200';
    const stateClass = checked ? 'bg-blue-600' : 'bg-gray-300';

    return h('button', {
      type: 'button',
      disabled: !!disabled,
      onClick: () => { if (!disabled) onChange(!checked); },
      className: `${base} ${stateClass}${disabled ? ' opacity-60 cursor-not-allowed' : ''}`,
      'aria-pressed': checked ? 'true' : 'false',
    },
      h('span', {
        className: `inline-block h-4 w-4 transform rounded-full bg-white transition-transform duration-200 ${checked ? 'translate-x-6' : 'translate-x-1'}`,
      })
    );
  }

  function App() {
    const [selected, setSelected] = useState(() => {
      const defaults = BPDemoSteps.defaults || {};
      const state = {};
      OPTIONS.forEach((option) => { state[option.key] = !!defaults[option.key]; });
      return state;
    });

    const [done] = useState(() => {
      try {
        if (BPDemoSteps.is_fresh_install) {
          localStorage.removeItem('one_demo_done');
          return {};
        }

        const saved = JSON.parse(localStorage.getItem('one_demo_done') || '{}');
        const supported = {};
        OPTIONS.forEach((option) => {
          if (saved[option.key]) supported[option.key] = true;
        });
        return supported;
      } catch (error) {
        localStorage.removeItem('one_demo_done');
        return {};
      }
    });

    function toggle(key) {
      const option = OPTIONS.find((item) => item.key === key);
      if (!option || option.locked) return;
      setSelected((current) => ({ ...current, [key]: !current[key] }));
    }

    useEffect(() => {
      const steps = [];
      const pluginSlugs = [];

      if (selected.buddypress && !done.buddypress) pluginSlugs.push('buddypress');
      if (selected.forums && !done.forums) pluginSlugs.push('bbpress');
      pluginSlugs.push('elementor');

      pluginSlugs.forEach((slug) => {
        steps.push({
          step: 'install_plugins',
          payload: {
            slugs: [slug],
            label: `Installing plugin: ${PLUGIN_LABELS[slug] || slug}`,
          },
        });
      });

      if (selected.buddypress && !done.buddypress) {
        steps.push({ step: 'configure_buddypress', payload: { label: 'Configuring BuddyPress community…' } });
        steps.push({ step: 'import_activities', payload: { label: 'Importing BuddyPress activity…' } });
      }

      if (selected.customizer && !done.customizer) {
        steps.push({ step: 'import_customizer', payload: { label: 'Importing Customizer…' } });
      }

      if (selected.menus && !done.menus) {
        steps.push({ step: 'import_menus', payload: { label: 'Importing Menus…' } });
      }

      if (selected.forums && !done.forums) {
        steps.push({ step: 'import_forums', payload: { label: 'Importing bbPress forums…' } });
      }

      steps.push({ step: 'import_widgets', payload: { label: 'Importing Widgets…' } });
      steps.push({ step: 'setup_homepage', payload: { label: 'Setting up Homepage…' } });

      window.ONE_DEMO_SELECTED_STEPS = steps;
    }, [selected, done]);

    return h('div', { className: 'p-0' },
      h('div', { className: 'space-y-4' },
        h('div', { className: 'flex items-center justify-between mb-4' },
          h('h3', { className: 'text-lg font-semibold' }, 'Select what to import'),
          h('button', {
            type: 'button',
            onClick: () => {
              localStorage.removeItem('one_demo_done');
              window.location.reload();
            },
            className: 'px-3 py-1 text-sm text-red-600 bg-red-50 border border-red-200 rounded hover:bg-red-100 transition-colors',
          }, 'Reset Import Status')
        ),
        h('div', { className: 'grid grid-cols-1 md:grid-cols-2 gap-3' },
          OPTIONS.map((option) => {
            const disabled = !!option.locked;
            return h('div', {
              key: option.key,
              className: `flex items-center justify-between gap-3 rounded-lg border border-gray-200 px-3 py-2 hover:border-blue-400 transition-colors${disabled ? ' opacity-60' : ''}`,
            },
              h('div', { className: 'flex items-center gap-2' },
                h('div', { className: 'h-8 w-8 flex items-center justify-center rounded-md bg-gray-100 text-gray-600' }, option.label.charAt(0)),
                h('div', null,
                  h('div', { className: 'font-medium' }, option.label),
                  done[option.key]
                    ? h('div', { className: 'text-xs text-green-600 flex items-center gap-1' },
                        h('span', { className: 'inline-block h-2 w-2 bg-green-500 rounded-full' }),
                        'Imported'
                      )
                    : disabled
                      ? h('div', { className: 'text-xs text-gray-500 flex items-center gap-1' },
                          h('span', { className: 'inline-block h-2 w-2 bg-gray-400 rounded-full' }),
                          'Required'
                        )
                      : h('div', { className: 'text-xs text-gray-500' }, 'Optional')
                )
              ),
              h(Toggle, {
                checked: !!selected[option.key],
                disabled,
                onChange: () => toggle(option.key),
              })
            );
          })
        )
      )
    );
  }

  const root = document.getElementById('one-demo-react-root');
  if (root) render(h(App), root);
})();
