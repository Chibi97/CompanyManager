import $ from "jquery";
import {ajaxGet, ajaxPut} from "./ajax_helpers";

let tasks = [];

export default function() {
    tasks = $(".task-slider").data('tasks');
    $('.acceptTask').click(function (e) {
        e.preventDefault();
        var url = baseUrl + `/api/tasks/${ $(this).data('id') }/accept`;
        ajaxPut(url, {}, () => {
            getPendingTasks($(this).data('id'));
        }, (xhr) => {
           console.log(xhr);
        });
    });

    $('.denyTask').click(function (e) {
        e.preventDefault();
        var url = baseUrl + `/api/tasks/${ $(this).data('id') }/deny`;
        ajaxPut(url, {}, () => {
            getPendingTasks($(this).data('id'));
        }, (xhr) => {
            console.log(xhr);
        });
    });


    $('.task-status-change').change(function () {
        var formLoading = $(this).closest("aside").find($(".form-loading"));
        formLoading.css('display', 'flex');
        formLoading.css('z-index', '999');
        var status = $(this).val();
        var url = baseUrl + `/api/tasks/${ $(this).data('task') }/status`;
        ajaxPut(url, {
            status: status
        }, () => {
            console.log('success');
            formLoading.css('display', 'none');
        }, (xhr)=> {
            console.log(xhr);
            formLoading.css('display', 'none');
        })
    })
}

function syncSlider(id) {
    console.log(tasks);
    let slickIndex = tasks.indexOf(id);
    tasks.splice(slickIndex, 1);
    $(".task-slider").slick('slickRemove', slickIndex);
}

function getPendingTasks(id) {
    var url = baseUrl + `/api/user/tasks/pending`;

    ajaxGet(url, (resp) => {
        syncSlider(id);
    }, () => {});
}



// function singleTask(task) {
//     return `<div class="px-3 col-md-6 col-xl-4 col-rewrite">
//     <aside class="profile-nav alt">
//         <section class="card">
//             <div class="card-header user-header alt bg-dark">
//                 <div class="media">
//                     <div class="media-body">
//                         <h2 class="text-light display-6">
//                             ${task.name}</h2>
//                     </div>
//                 </div>
//             </div>
//
//
//             <ul class="list-group list-group-flush">
//                 <li class="d-flex justify-content-around p-3">
//                     <a href="#" class="acceptTask btn info-bg" data-id="${task.id}">
//                     <i class="fas fa-user-check text-white"></i>
//                     Accept
//                 </a>
//
//                 <a href="#" class="denyTask btn danger-bg"
//                         data-id="${task.id}">
//                     <i class="fas fa-user-times m-r-10 text-white"></i>
//                     Deny
//                 </a>
//                 </li>
//                 <li class="list-group-item d-flex">
//                     <div>
//                         <i class="fas fa-hourglass-start pr-4"></i>
//                     </div>
//
//                     <div class="d-flex">
//                         <p class="info-color border-r-light">Start date</p>
//                         <p class="fw-500">${task.start_date}</p>
//                     </div>
//
//                 </li>
//                 <li class="list-group-item d-flex">
//                     <div>
//                         <i class="fas fa-hourglass-end pr-4"></i>
//                     </div>
//                     <div class="d-flex">
//                         <p class="info-color mr-3 border-r-light">End date</p>
//                         <p class="fw-500">${task.end_date}</p>
//                     </div>
//                 </li>
//                 <li class="list-group-item d-flex">
//                     <div>
//                         <i class="pr-4 icon-tally"></i>
//                     </div>
//                     <div>
//                         ${evaluateEmployeeCount(task.count)}
//                     </div>
//                 </li>
//                 <li class="list-group-item d-flex">
//                     <div>
//                         <i class="fas fa-highlighter pr-4"></i>
//                     </div>
//                     <div class="d-flex">
//                         <p class="info-color mr-3 border-r-light">Priority</p>
//                         <p class="fw-500">${task.task_priority.name}</p>
//                     </div>
//
//                 <li class="list-group-item d-flex">
//                     <div>
//                         <i class="fas fa-battery-half pr-4"></i>
//                     </div>
//                     <div class="d-flex">
//                         <p class="info-color mr-3 border-r-light">Status</p>
//                         <p class="fw-500">${task.task_status.name}</p>
//                     </div>
//
//                 </li>
//
//                 <li class="list-group-item d-flex">
//                     <p>
//                         <ul class="lst-none">
//                             ${evaluateList(task.users)}
//                         </ul>
//                     </p>
//                 </li>
//
//
//             <li class="list-group-item d-flex">
//                 <div>
//                     <i class="fas fa-paragraph pr-4"></i>
//                 </div>
//                 <div>
//                     <p class="info-color">Description</p>
//                     <p class="fw-500">${task.description}</p>
//                 </div>
//             </li>
//             </ul>
//
//         </section>
//     </aside>
// </div>`;
// }
//
// function evaluateEmployeeCount(count) {
//     var html = ``;
//     var word = 'employees';
//     if(count == 0) {
//         html += `<p class="info-color">This task, beside assigned ones, shouldn't
//      take any employee.</p>`;
//     } else {
//         html += `<p class="info-color">This task, beside assigned ones, should
//      take</p>`;
//
//         if(count == 1) {
//             word = 'employee';
//         }
//         html += ` <p class="fw-500">${count} ${word}</p>`;
//     }
//     return html;
// }
//
// function evaluateList(users) {
//     var html = ``;
//     users.forEach(function (user) {
//         html += `<li class="d-flex">
//           <i class="fas fa-user pr-4"></i>
//           <p class="fw-500">${user.first_name} ${user.last_name}</p>
//         </li>`;
//     });
//
//     return html;
//
// }