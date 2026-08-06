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
    return h('button', {
      type: 'button',
      disabled: !!disabled,
      onClick: () => { if (!disabled) onChange(!checked); },
      className: `one-demo-toggle${checked ? ' is-active' : ''}${disabled ? ' is-disabled' : ''}`,
      'aria-pressed': checked ? 'true' : 'false',
    }, h('span', { className: 'one-demo-toggle__thumb' }));
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

    return h('div', { className: 'one-demo-selector' },
      h('div', { className: 'one-demo-selector__header' },
        h('h3', null, 'Select what to import'),
        h('button', {
          type: 'button',
          onClick: () => {
            localStorage.removeItem('one_demo_done');
            window.location.reload();
          },
          className: 'one-demo-reset',
        }, 'Reset Import Status')
      ),
      h('div', { className: 'one-demo-options' },
        OPTIONS.map((option) => {
          const disabled = !!option.locked;
          return h('div', {
            key: option.key,
            className: `one-demo-option${disabled ? ' is-locked' : ''}`,
          },
            h('div', { className: 'one-demo-option__main' },
              h('div', { className: 'one-demo-option__icon', 'aria-hidden': 'true' }, option.label.charAt(0)),
              h('div', { className: 'one-demo-option__copy' },
                h('strong', null, option.label),
                done[option.key]
                  ? h('span', { className: 'one-demo-option__meta is-done' },
                      h('i', { 'aria-hidden': 'true' }),
                      'Imported'
                    )
                  : disabled
                    ? h('span', { className: 'one-demo-option__meta' },
                        h('i', { 'aria-hidden': 'true' }),
                        'Required'
                      )
                    : h('span', { className: 'one-demo-option__meta' }, 'Optional')
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
    );
  }

  const root = document.getElementById('one-demo-react-root');
  if (root) render(h(App), root);
})();
