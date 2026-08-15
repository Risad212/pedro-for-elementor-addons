(function() {
    var select = document.getElementById('pedroea-condition-select');
    var wrap = document.getElementById('pedroea-condition-specific-wrap');
    if (!select || !wrap) return;
    select.addEventListener('change', function() {
        wrap.style.display = this.value === 'specific' ? '' : 'none';
    });
})();