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
});
        