window.addEventListener('DOMContentLoaded', event => {

    function showTime() {
        var options = {hour12 : false};
        var date = new Date(),
            utc = new Date(
                date.getFullYear(),
                date.getMonth(),
                date.getDate(),
                date.getHours(),
                date.getMinutes(),
                date.getSeconds()
            );
        document.getElementById('time').innerHTML = utc.toLocaleTimeString('id-ID', options);
    }
    setInterval(showTime, 1000);

    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'en'
        }, 'google_translate_element');
    }

    function triggerHtmlEvent(element, eventName) {
        var event;
        if (document.createEvent) {
            event = document.createEvent('HTMLEvents');
            event.initEvent(eventName, true, true);
            element.dispatchEvent(event);
        } else {
            event = document.createEventObject();
            event.eventType = eventName;
            element.fireEvent('on' + event.eventType, event);
        }
    }
    $(document).ready(function() {
        $(".lang-select").click(function() {
            var theLang = $(this).attr('data-lang');
            $(".goog-te-combo").val(theLang);
            window.location = $(this).attr('href');
            window.location.reload();
        });
    });     
});
        