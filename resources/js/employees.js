import $ from "jquery";
import {ajaxGet} from "./ajax_helpers";

export default function() {

    $('#acceptTask').click(function (e) {
        e.preventDefault();
        var url = baseUrl + `/api/tasks/${ $(this).data('id') }/accept`;
        var accepted = false;
        ajaxGet(url, () => {
            accepted = true;
        }, () => {
            $("#message-target").flash("Server error. Please try later or contact web masters.",
                {type: "danger", fade: 5000});
        });

    });
}