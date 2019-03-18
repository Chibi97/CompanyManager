
const showMessage = function(message, type) {
    return $(`<div class="alert alert-${type}">
          <!--<div class="d-flex justify-content-end">-->
              <!--<button type="button" class="close" data-dismiss="alert">-->
                  <!--<span>&times;</span>-->
              <!--</button>-->
          <!--</div>-->
              ${message}
      </div>`);
}

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

        // if(opts.fixed) {
        //     div.addClass('prettifyModal');
        // }
    }
}
export default init;
