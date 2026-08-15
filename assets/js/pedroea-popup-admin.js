(function () {
    function initTriggerPills() {
        var group = document.getElementById('pedroea-trigger-pills');
        if (!group) return;

        var pills = group.querySelectorAll('.pedroea-trigger-pill');
        var inputs = group.querySelectorAll('input[name="trigger"]');
        var fields = document.querySelectorAll('[data-trigger-fields]');
        var note = document.getElementById('pedroea-trigger-note');

        function sync() {
            var selected = group.querySelector('input[name="trigger"]:checked');
            if (!selected) return;

            pills.forEach(function (pill) {
                pill.classList.toggle('is-selected', pill.querySelector('input') === selected);
            });

            var value = selected.value;

            fields.forEach(function (field) {
                field.style.display = field.getAttribute('data-trigger-fields') === value ? '' : 'none';
            });

            if (note) {
                note.textContent = selected.getAttribute('data-desc') || '';
            }
        }

        inputs.forEach(function (input) {
            input.addEventListener('change', sync);
        });

        sync();
    }

    function initConditionFields() {
        var select = document.getElementById('pedroea-condition-select');
        var wrap = document.getElementById('pedroea-condition-specific-wrap');
        if (!select || !wrap) return;

        select.addEventListener('change', function () {
            wrap.style.display = this.value === 'specific' ? '' : 'none';
        });
    }

    function initToggleSwitches() {
        var toggles = document.querySelectorAll('.pedroea-popup-toggle');

        toggles.forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                if (checkbox.dataset.url) {
                    window.location.href = checkbox.dataset.url;
                }
            });
        });
    }

    initTriggerPills();
    initConditionFields();
    initToggleSwitches();
})();
