(function () {
    function initConditionFields() {
        var select = document.getElementById('pedroea-condition-select');
        if (!select) return;

        var typeWrap = document.getElementById('pedroea-condition-type-wrap');
        var specificWrap = document.getElementById('pedroea-condition-specific-wrap');

        function sync() {
            var value = select.value;
            if (typeWrap) {
                typeWrap.classList.toggle('pedroea-condition-hidden', value !== 'post_type' && value !== 'specific');
            }
            if (specificWrap) {
                specificWrap.classList.toggle('pedroea-condition-hidden', value !== 'specific');
            }
        }

        select.addEventListener('change', sync);
        sync();
    }

    function initSpecificPicker() {
        var picker = document.querySelector('.pedroea-specific-picker');
        if (!picker) return;

        var input = picker.querySelector('.pedroea-specific-search');
        var hidden = picker.querySelector('.pedroea-specific-id');
        var selectedWrap = picker.querySelector('.pedroea-specific-selected');
        var results = picker.querySelector('.pedroea-specific-results');
        var nonce = picker.getAttribute('data-nonce');
        var typeField = document.getElementById('pedroea-tb-post-type');
        var timer;

        if (!input || !hidden || !selectedWrap || !results) return;

        function currentType() {
            return (typeField && typeField.value) ? typeField.value : 'post';
        }

        function clearSelection() {
            hidden.value = '';
            selectedWrap.innerHTML = '';
            input.value = '';
        }

        function selectPost(item) {
            hidden.value = item.id;
            selectedWrap.innerHTML = '';
            var chip = document.createElement('span');
            chip.className = 'pedroea-specific-chip';
            chip.textContent = item.title;
            var remove = document.createElement('a');
            remove.href = '#';
            remove.className = 'pedroea-specific-remove';
            remove.setAttribute('title', 'Remove');
            remove.textContent = '\u00d7';
            remove.addEventListener('click', function (e) {
                e.preventDefault();
                clearSelection();
            });
            chip.appendChild(remove);
            selectedWrap.appendChild(chip);
            input.value = '';
            results.style.display = 'none';
        }

        function search(term) {
            clearTimeout(timer);
            timer = setTimeout(function () {
                if (!window.ajaxurl) return;

                var url = window.ajaxurl +
                    '?action=pedroea_tb_search_posts' +
                    '&post_type=' + encodeURIComponent(currentType()) +
                    '&q=' + encodeURIComponent(term) +
                    '&nonce=' + encodeURIComponent(nonce);

                fetch(url)
                    .then(function (response) { return response.json(); })
                    .then(function (data) {
                        results.innerHTML = '';
                        if (!data.success || !data.data || !data.data.length) {
                            results.style.display = '';
                            var empty = document.createElement('div');
                            empty.className = 'pedroea-specific-empty';
                            empty.textContent = 'No results';
                            results.appendChild(empty);
                            return;
                        }

                        data.data.forEach(function (item) {
                            var option = document.createElement('div');
                            option.className = 'pedroea-specific-option';
                            option.textContent = item.title;
                            option.addEventListener('click', function () {
                                selectPost(item);
                            });
                            results.appendChild(option);
                        });

                        results.style.display = '';
                    })
                    .catch(function () {
                        results.innerHTML = '';
                    });
            }, 250);
        }

        input.addEventListener('input', function () {
            search(this.value);
        });

        input.addEventListener('focus', function () {
            if (this.value) {
                search(this.value);
            }
        });

        input.addEventListener('blur', function () {
            setTimeout(function () {
                results.style.display = 'none';
            }, 150);
        });

        var existingRemove = selectedWrap.querySelector('.pedroea-specific-remove');
        if (existingRemove) {
            existingRemove.addEventListener('click', function (e) {
                e.preventDefault();
                clearSelection();
            });
        }
    }

    initConditionFields();
    initSpecificPicker();
})();
