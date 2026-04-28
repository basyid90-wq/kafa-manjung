/**
 * Floating Jawi Keyboard — Global Controller
 * Tracks last focused .jawi-input and inserts characters at cursor position.
 */
(function () {
    'use strict';

    var _target = null; // last focused .jawi-input element

    // Track focus on any .jawi-input across the whole page
    document.addEventListener('focusin', function (e) {
        if (e.target && e.target.classList && e.target.classList.contains('jawi-input')) {
            _target = e.target;
        }
    }, true);

    function _insert(el, char) {
        if (!el) return;
        var start = el.selectionStart != null ? el.selectionStart : el.value.length;
        var end   = el.selectionEnd   != null ? el.selectionEnd   : el.value.length;
        el.value  = el.value.slice(0, start) + char + el.value.slice(end);
        var pos   = start + char.length;
        try { el.setSelectionRange(pos, pos); } catch (ignore) {}
        el.dispatchEvent(new Event('input', { bubbles: true }));
        el.focus();
    }

    function _backspace(el) {
        if (!el) return;
        var start = el.selectionStart != null ? el.selectionStart : el.value.length;
        var end   = el.selectionEnd   != null ? el.selectionEnd   : el.value.length;
        if (start !== end) {
            _insert(el, '');
            return;
        }
        if (start > 0) {
            el.value = el.value.slice(0, start - 1) + el.value.slice(start);
            var newPos = start - 1;
            try { el.setSelectionRange(newPos, newPos); } catch (ignore) {}
            el.dispatchEvent(new Event('input', { bubbles: true }));
        }
        el.focus();
    }

    document.addEventListener('DOMContentLoaded', function () {
        var toggleBtn = document.getElementById('jawi-keyboard-toggle');
        var panel     = document.getElementById('jawi-keyboard-panel');
        if (!toggleBtn || !panel) return;

        // Toggle panel open/close
        toggleBtn.addEventListener('click', function () {
            var hidden = panel.classList.contains('d-none');
            panel.classList.toggle('d-none', !hidden);
            toggleBtn.setAttribute('aria-expanded', hidden ? 'true' : 'false');
        });

        // Letter / space keys — use mousedown+preventDefault so input keeps focus
        document.querySelectorAll('.jk-key').forEach(function (btn) {
            btn.addEventListener('mousedown', function (e) {
                e.preventDefault();
                _insert(_target, this.dataset.char);
            });
        });

        // Backspace key
        var bsBtn = document.getElementById('jk-backspace');
        if (bsBtn) {
            bsBtn.addEventListener('mousedown', function (e) {
                e.preventDefault();
                _backspace(_target);
            });
        }
    });
})();
