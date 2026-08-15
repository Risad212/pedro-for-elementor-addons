/**
 * Widget Manager dashboard interactions:
 * search filter, live stat counts, and enable/disable all.
 */
(function () {
	'use strict';

	var form    = document.querySelector('.pedroea-wm-form');
	var cards   = document.querySelectorAll('.pedroea-wm-card');
	var inputs  = document.querySelectorAll('.pedroea-wm-card input[type="checkbox"]');
	var statOn  = document.querySelector('.pedroea-wm-stat-enabled .pedroea-wm-stat-num');
	var statOff = document.querySelector('.pedroea-wm-stat-disabled .pedroea-wm-stat-num');
	var search  = document.getElementById('pedroea-wm-search');
	var counter = document.getElementById('pedroea-wm-count');

	function updateCounts() {
		var enabled = 0;
		for (var i = 0; i < inputs.length; i++) {
			if (inputs[i].checked) {
				enabled++;
			}
		}
		statOn.textContent  = enabled;
		statOff.textContent = inputs.length - enabled;
	}

	function setCardState(input) {
		var card = input.closest('.pedroea-wm-card');
		if (card) {
			card.classList.toggle('pedroea-wm-card-disabled', !input.checked);
		}
	}

	function applyFilter() {
		var q       = (search.value || '').toLowerCase();
		var visible = 0;
		for (var i = 0; i < cards.length; i++) {
			var card  = cards[i];
			var title = card.getAttribute('data-title');
			var name  = card.getAttribute('data-name');
			var match = !q || (title && title.indexOf(q) !== -1) || (name && name.indexOf(q) !== -1);
			card.style.display = match ? '' : 'none';
			if (match) {
				visible++;
			}
		}
		counter.textContent = visible + ' / ' + cards.length;
	}

	function setAll(value) {
		for (var i = 0; i < inputs.length; i++) {
			inputs[i].checked = value;
			setCardState(inputs[i]);
		}
		updateCounts();
	}

	for (var i = 0; i < inputs.length; i++) {
		inputs[i].addEventListener('change', function () {
			setCardState(this);
			updateCounts();
		});
	}

	if (search) {
		search.addEventListener('input', applyFilter);
	}

	document.getElementById('pedroea-wm-enable-all').addEventListener('click', function () {
		setAll(true);
		if (form) {
			form.submit();
		}
	});

	document.getElementById('pedroea-wm-disable-all').addEventListener('click', function () {
		setAll(false);
		if (form) {
			form.submit();
		}
	});

	updateCounts();
	applyFilter();
})();
