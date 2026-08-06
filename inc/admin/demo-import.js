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

    const baseText = (payload && payload.label) ? payload.label : `Importing ${step.replace(/_/g, ' ')}`;
    const label = baseText;
    showMessage(label, false);

    $.ajax({
      url: BPDemoSteps.ajax_url,
      method: 'POST',
      dataType: 'json',
      data: Object.assign({ action: 'bp_demo_import_step', step: step, _wpnonce: BPDemoSteps.nonce }, payload)
    })
    .done(function (response) {
      if (response.success) {
        showMessage(label);
        // mark step as done for idempotency in UI (rough mapping by step name)
        try {
          const done = JSON.parse(localStorage.getItem('one_demo_done') || '{}');
          if (step === 'import_customizer') done.customizer = true;
          if (step === 'import_menus') done.menus = true;
          if (step === 'import_forums') done.forums = true;
          if (step === 'configure_buddypress' || step === 'import_activities') done.buddypress = true;
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
