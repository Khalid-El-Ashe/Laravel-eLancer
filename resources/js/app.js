import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

window.Echo.private(`App.Models.User.${userId}`).notification((data) => {
    const list = $("#notificationsList");
    const counter = $("#newNotifications");

    list.prepend(`
            <li class="notifications-not-read">
                <a href="${data.url}?notify_id=${data.id}">
                    <span class="notification-icon">
                        <i class="icon-material-outline-group"></i>
                    </span>
                    <span class="notification-text">
                        ${data.body}
                    </span>
                </a>
            </li>
        `);

    let count = Number(counter.data("count")) + 1;
    counter.data("count", count);
    counter.text(count > 10 ? "10+" : count);
});

// window.Echo.private(`App.Models.User.${userId}`).notification((data) => {
//     $("#notificationsList").append(` <li class="notifications-not-read">
//                             <a href="${data.url}?notify_id=${data.id}">
//                                 <span class="notification-icon"><i class="icon-material-outline-group"></i></span>
//                                 <span class="notification-text">
//                                     <strong>*</strong>
//                                     ${data.body}
//                                 </span>
//                             </a>
//                         </li>`);
//     let count = Number($("#newNotifications").text());
//     count++;
//     if (count > 10) {
//         count = "10+";
//     }
//     $("#newNotifications").text(count);
// });

window.Echo.join(`channel-messages.${userId}`).listen(
    ".message.created",
    function (data) {
        alert(data.message.message);
    },
);
