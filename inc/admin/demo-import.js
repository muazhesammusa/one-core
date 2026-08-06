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
      icon = '<span class="one-demo-status-icon one-demo-status-icon--success">✓</span>';
    } else if (!isError) {
      icon = '<span class="one-inline-spinner"></span>';
    }

    logEl.html(icon + $('<span>').text(message).prop('outerHTML'));
    logEl.toggleClass('is-error', !!isError);
  }

  function updateProgress() {
    const percent = steps.length > 0 ? ((currentStep + 1) / steps.length) * 100 : 0;
    barEl.css('width', Math.min(100, percent) + '%');
  }

  function responseMessage(response, fallback) {
    if (response && response.data && typeof response.data.message === 'string') {
      return response.data.message;
    }
    return fallback;
  }

  function stopImport(message) {
    cancelled = true;
    showMessage(`Import stopped: ${message}`, true);
    loader.hide();
    startBtn.show();
    startBtn.prop('disabled', false);
    $('#bp-cancel-import').show();
  }

  function ajaxFailureMessage(xhr, status, error) {
    if (xhr && xhr.responseJSON) {
      return responseMessage(xhr.responseJSON, error || status || 'Request failed.');
    }

    const contentType = xhr && typeof xhr.getResponseHeader === 'function'
      ? (xhr.getResponseHeader('content-type') || '')
      : '';

    if (contentType.indexOf('text/html') !== -1 || /^\s*</.test((xhr && xhr.responseText) || '')) {
      return 'The server returned an HTML page instead of JSON. Reload this page and try again.';
    }

    return error || status || 'Request failed.';
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
      if (!response || response.success !== true) {
        stopImport(responseMessage(response, 'Unknown server error.'));
        return;
      }

      showMessage(label);
      try {
        const done = JSON.parse(localStorage.getItem('one_demo_done') || '{}');
        if (step === 'import_customizer') done.customizer = true;
        if (step === 'import_menus') done.menus = true;
        if (step === 'import_forums') done.forums = true;
        if (step === 'configure_buddypress') done.buddypress = true;
        localStorage.setItem('one_demo_done', JSON.stringify(done));
      } catch (error) {
        // Browser storage is optional and must not block the importer.
      }

      updateProgress();
      currentStep++;
      setTimeout(runNextStep, 450);
    })
    .fail(function (xhr, status, error) {
      console.error('Demo import AJAX failed:', {
        status,
        error,
        httpStatus: xhr ? xhr.status : 0,
        response: xhr ? xhr.responseText : '',
      });
      stopImport(`${step}: ${ajaxFailureMessage(xhr, status, error)}`);
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
    startBtn.hide().prop('disabled', true);
    cancelled = false;
    currentStep = 0;
    progressEl.show();
    logEl.text('').removeClass('is-error');
    barEl.css('width', '0');

    if (Array.isArray(window.ONE_DEMO_SELECTED_STEPS)) {
      steps = window.ONE_DEMO_SELECTED_STEPS;
    }

    if (!Array.isArray(steps) || steps.length === 0) {
      stopImport('No import steps are available. Reload this page and try again.');
      return;
    }

    runNextStep();
  });

  $('#bp-cancel-import').on('click', function(){
    cancelled = true;
    modal.fadeOut();
    loader.hide();
    startBtn.show().prop('disabled', false);
    $('#bp-cancel-import').show();
    logEl.text('').removeClass('is-error');
    progressEl.hide();
    barEl.css('width', '0');
  });
});
