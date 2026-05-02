// bp-demo-import.js
jQuery(document).ready(function ($) {
  let steps = Array.isArray(BPDemoSteps.steps) ? BPDemoSteps.steps : [];
  let currentStep = 0;
  let cancelled = false;

  const statusEl = $('#bp-demo-log');
  const logEl = $('#bp-demo-log-text');
  const progressEl = statusEl.find('.bp-demo-progress');
  const barEl = progressEl.find('.bar');
  const modal = $('#bp-demo-modal');
  const loader = $('#bp-demo-loader');
  const finalBtns = $('#bp-demo-final-buttons');
  const startBtn = $('#bp-start-import');

  // ensure inline spinner style exists
  (function ensureSpinnerCSS(){
    if (document.getElementById('one-inline-spinner-style')) return;
    const css = '.one-inline-spinner{display:inline-block;width:14px;height:14px;border:2px solid #ccc;border-top-color:#2271b1;border-radius:50%;animation:oneSpin .6s linear infinite;margin-right:8px;vertical-align:-2px}@keyframes oneSpin{to{transform:rotate(360deg)}}';
    const style = document.createElement('style');
    style.id = 'one-inline-spinner-style';
    style.appendChild(document.createTextNode(css));
    document.head.appendChild(style);
  })();

  function showMessage(message, isError = false, showCheckmark = false) {
    let icon = '';
    if (showCheckmark) {
      icon = '<span style="display: inline-block; width: 16px; height: 16px; border-radius: 50%; background: #00a32a; color: white; text-align: center; line-height: 16px; font-size: 12px; margin-right: 8px; vertical-align: -2px;">✓</span>';
    } else {
      icon = '<span class="one-inline-spinner"></span>';
    }
    logEl.html(icon + $('<div>').text(message).html());
    logEl.css('color', isError ? 'red' : '');
  }

  function updateProgress() {
    const percent = ((currentStep + 1) / steps.length) * 100;
    barEl.css('width', percent + '%');
  }

  function runNextStep() {
    if (cancelled) {
      showMessage('');
      loader.hide();
      startBtn.show();
      $('#bp-cancel-import').hide();
      return;
    }
    if (currentStep >= steps.length) {
      showMessage('Import complete!', false, true);
      loader.hide();
      finalBtns.show();
      $('#bp-cancel-import').hide();
      return;
    }

    const entry = steps[currentStep];
    const step = typeof entry === 'string' ? entry : entry.step;
    const payload = typeof entry === 'object' ? (entry.payload || {}) : {};
    // Dynamic expansion: if placeholder step, expand using previously fetched template list
    if (step === '__import_templates_dynamic__' && Array.isArray(window.ONE_TPL_LIST) && window.ONE_TPL_LIST.length) {
      const inject = window.ONE_TPL_LIST.map(t => ({ step: 'import_template', payload: { template_id: t.id, template_name: t.name, label: `Importing template -> ${t.name}` } }));
      // replace placeholder with injected steps
      steps.splice(currentStep, 1, ...inject);
      runNextStep();
      return;
    }

    const baseText = (payload && payload.label) ? payload.label : `Importing ${step.replace(/_/g, ' ')}`;
    const label = baseText;
    showMessage(label, false);

    $.ajax({
      url: BPDemoSteps.ajax_url,
      method: 'POST',
      dataType: 'json',
      data: Object.assign({ action: 'bp_demo_import_step', step: step }, payload)
    })
    .done(function (response) {
      if (response.success) {
        if (step === 'list_templates' && response.data && Array.isArray(response.data.templates)) {
          window.ONE_TPL_LIST = response.data.templates;
        }
        showMessage(label);
        // mark step as done for idempotency in UI (rough mapping by step name)
        try {
          const done = JSON.parse(localStorage.getItem('one_demo_done') || '{}');
          if (step === 'import_customizer') done.customizer = true;
          if (step === 'import_menus') done.menus = true;
          if (step === 'import_forums') done.forums = true;
          if (step === 'import_template') done.pages = true;
          if (step === 'enable_groups_component' || step === 'import_activities') done.buddypress = true;
          if (step === 'import_exported_demo') {
            const sel = JSON.parse(localStorage.getItem('one_demo_selected') || '{}');
            if (sel.courses) done.courses = true;
            if (sel.directory) done.directory = true;
            if (sel.events) done.events = true;
            if (sel.woocommerce) done.woocommerce = true;
            if (sel.job_manager) done.job_manager = true;
          }
          if (step === 'import_extension_demos') {
            const sel = JSON.parse(localStorage.getItem('one_demo_selected') || '{}');
            if (sel.courses) done.courses = true;
            if (sel.directory) done.directory = true;
            if (sel.events) done.events = true;
            if (sel.woocommerce) done.woocommerce = true;
            if (sel.job_manager) done.job_manager = true;
          }
          localStorage.setItem('one_demo_done', JSON.stringify(done));
        } catch(e){}
      } else {
        const msg = response.data?.message || 'Unknown error';
        showMessage(`Failed: ${msg}`, true);
      }
      updateProgress();
      currentStep++;
      setTimeout(runNextStep, 800); // smoother transition
    })
    .fail(function (xhr, status, error) {
      console.error('AJAX failed:', error);
      showMessage(`AJAX error: ${error}`, true);
      updateProgress();
      currentStep++;
      setTimeout(runNextStep, 800);
    });
  }



  $('#start-demo-import').on('click', function () {
    modal.fadeIn();
    logEl.text('Ready to import...');
    progressEl.hide();
    barEl.css('width', '0');
    loader.hide();
    finalBtns.hide();
    $('#bp-cancel-import').show();
  });

  $('#bp-close-import').on('click', function(){
    modal.fadeOut();
  });

  startBtn.on('click', function () {
    loader.show();
    startBtn.hide();
    // keep cancel visible during import as a close button only
    cancelled = false;
    currentStep = 0;
    progressEl.show();
    logEl.text('');
    barEl.css('width', '0');
    // Pick up selected steps from UI
    if (Array.isArray(window.ONE_DEMO_SELECTED_STEPS)) {
      steps = window.ONE_DEMO_SELECTED_STEPS;
    }
    runNextStep();
  });

  $('#bp-cancel-import').on('click', function(){
    cancelled = true;
    modal.fadeOut();
    loader.hide();
    startBtn.show();
    $('#bp-cancel-import').show();
    logEl.text('');
    progressEl.hide();
    barEl.css('width', '0');
  });
});


// TEmPLATES IMPORT MODAL

jQuery(document).ready(function($) {
  let selectedTemplateId = null;

  $('.import-button').on('click', function () {
    if (!BPDemoSteps.license_active) {
      $('#bp-demo-modal').fadeIn();
      return;
    }

    selectedTemplateId = $(this).data('template-id');

    // Check if Elementor is installed
    if (!BPDemoSteps.elementor_installed) {
      $('.elementor-warning').show();
    } else {
      $('.elementor-warning').hide();
    }
    const $btn = $('#confirm-import-button');
    const $text = $btn.find('.text');
    const $loader = $btn.find('.loader');

    $loader.hide();
    $text.text('Import');

    $('#import-page-selector').val('');
    $('#new-page-title').val('');
    $('#template-import-modal').fadeIn();

    $('#import-success-message').hide();
      $('#imported-page-link').attr('href', '');

    // Hide all form-related inputs and buttons (to avoid confusion)
    $('#import-page-selector').show();
    $('#new-page-title').show();
    $('#confirm-import-button').show();
    $('label[for="import-page-selector"]').show();
    $('#import-page-selector').prev('p').show(); // hides "Select existing page:" <p>
    $('#new-page-title').prev('p').show();       // hides "Or create a new page:" <p>
  });

  $('#cancel-import-button').on('click', function () {
    $('#template-import-modal').fadeOut();
  });

  $('#confirm-import-button').on('click', function () {
    const $btn = $(this);
    const $text = $btn.find('.text');
    const $loader = $btn.find('.loader');
  
    const pageId = $('#import-page-selector').val();
    const newTitle = $('#new-page-title').val();
  
    // Show loader
    $text.text('Importing...');
    $loader.show();
  
    $.post(BPDemoSteps.ajax_url, {
      action: 'bp_demo_import_step',
      step: 'import_elementor_template',
      template_id: selectedTemplateId,
      page_id: pageId,
      new_title: newTitle
    }, function(response) {
      // Hide loader
      
      if (response.success) {
        $loader.hide();
        $text.text('Import');
        $('#import-success-message').show();
        $('#imported-page-link').attr('href', response.data.page_url);
  
        $('#import-page-selector, #new-page-title, #confirm-import-button').hide();
        $('label[for="import-page-selector"]').hide();
        $('#import-page-selector').prev('p').hide();
        $('#new-page-title').prev('p').hide();
      } else {
        console.log(response);
        alert('Import failure: ' + (response.data?.message || 'Unknown error'));
      }
    });
  });
  
});
