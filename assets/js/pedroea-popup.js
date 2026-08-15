(function ($) {
    "use strict";

    function openPopup(popup) {
        if (popup.hasClass('pedroea-popup-open')) {
            return;
        }

        popup.addClass('pedroea-popup-open');
        document.body.classList.add('pedroea-popup-body-open');

        if (popup.data('once') == '1') {
            localStorage.setItem('pedroea_popup_once_' + popup.data('popup-id'), '1');
        }
    }

    function closePopup(popup) {
        popup.removeClass('pedroea-popup-open');
        document.body.classList.remove('pedroea-popup-body-open');
    }

    function maybeOpen(popup) {
        var shown = localStorage.getItem('pedroea_popup_once_' + popup.data('popup-id'));

        if (popup.data('once') == '1' && shown) {
            return;
        }

        openPopup(popup);
    }

    function initPopup(popup) {
        var trigger = popup.data('trigger');
        var delay = parseInt(popup.data('delay') || 0, 10);

        function openNow() {
            maybeOpen(popup);
        }

        if (trigger === 'load') {
            setTimeout(openNow, delay * 1000);
        }

        if (trigger === 'scroll') {
            var percent = parseInt(popup.data('percent') || 25, 10);
            var key = 'scroll.pedroea_popup_' + popup.data('popup-id');

            $(window).on(key, function () {
                var docHeight = $(document).height() - window.innerHeight;
                if (docHeight <= 0) {
                    return;
                }

                var scrolled = ($(window).scrollTop() / docHeight) * 100;

                if (scrolled >= percent) {
                    $(window).off(key);
                    openNow();
                }
            });
        }

        if (trigger === 'click') {
            var selector = popup.data('selector');

            if (selector) {
                $(document).on('click', selector, function () {
                    openNow();
                });
            }
        }

        if (trigger === 'exit') {
            document.addEventListener('mouseout', function (e) {
                if (!e.relatedTarget && e.clientY <= 10) {
                    openNow();
                }
            });
        }

        popup.find('.pedroea-popup-close').on('click', function () {
            closePopup(popup);
        });

        popup.on('click', function (e) {
            if (e.target === this) {
                closePopup(popup);
            }
        });
    }

    $(function () {
        $('.pedroea-popup-overlay').each(function () {
            initPopup($(this));
        });

        $(document).on('click', '.pedroea-popup-trigger', function () {
            var id = $(this).data('popup-trigger');
            var popup = $('.pedroea-popup-overlay[data-popup-id="' + id + '"]');

            if (popup.length) {
                maybeOpen(popup);
            }
        });

        $(document).keyup(function (e) {
            if (e.key === 'Escape') {
                $('.pedroea-popup-overlay.pedroea-popup-open').each(function () {
                    closePopup($(this));
                });
            }
        });
    });
})(jQuery);
