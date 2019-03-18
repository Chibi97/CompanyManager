const showMessage = (message, type) => ($(`<div class="alert alert-${type}">${message}</div>`));

function init() {
    $.fn.flash = function (message, opts = {}) {
        let html = "";
        if(typeof message === 'object') {
            for(let elem in message) {
                html += `<p>${message[elem]}</p>`;
            }
        } else {
            html = message;
        }

        let div = showMessage(html, opts.type);
        $(this).prepend(div);

        if(opts.fade) {
            setTimeout(() => { div.fadeOut(1000) }, opts.fade)
        }

    }
}
export default init;