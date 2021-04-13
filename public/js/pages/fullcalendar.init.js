/**
 * Thang update
 *
 */
$(function() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    var calendarEl = document.getElementById("calendar");

    var calendar = $("#calendar").fullCalendar({
        header: {
            left: "prev,next today",
            center: "title",
            right: "month,agendaWeek,agendaDay,listWeek"
        },
        events: [{
            title: 'My Event',
            start: '2021-04-07T14:30:00',
            allDay: false
        }], //"/calendar",
        displayEventTime: false,
        editable: true,
        views: {
            month: { // name of view
                titleFormat: 'YYYY, MM, DD'
                    // other view-specific options here
            }
        },
        eventRender: function(event, element, view) {
            if (event.allDay === "true") {
                event.allDay = true;
            } else {
                event.allDay = false;
            }
        },
        timeFormat: 'h(:mm)t',
        timezone: 'local',
        slotDuration: "00:15:00",
        defaultView: "month",
        handleWindowResize: !0,
        editable: true,
        droppable: true, // this allows things to be dropped onto the calendar
        navLinks: true, // can click day/week names to navigate views
        eventLimit: true, // when too many events in a day, show the popover

        selectable: true,
        selectHelper: false,

        eventMouseover: function(event, jsEvent, view) {
            if (view.name !== "agendaDay") {
                $(jsEvent.target).attr("description", event.description);
            }
        },
        select: function(start, end, allDay) {
            //model
            var description;
            var o = this;
            (this.$body = $("body")),
            (this.$modal = $("#event-modal")),
            (this.$calendarObj = null);
            $("#event-modal").modal({ backdrop: "static" });
            var i = $("<form></form>");
            i.append("<div class='row'></div>"),
                i
                .find(".row")
                .append("<h4 class='modal-title mt-0'><strong>Add New Event</strong></h4>")
                .append(
                    "<div class='col-md-12'><div class='form-group'><label class='control-label'>Event Name</label><input class='form-control' placeholder='Insert Event Name' type='text' name='title'/></div></div>"
                )
                .append(
                    "<div class='col-md-12'><div class='form-group'><label class='control-label'>Category</label><select class='form-control' name='category'></select></div></div>"
                )
                .append("<div class='col-md-6'><div class='form-group'><label class='control-label'>Start</label><input class='form-control' type='datetime-local' name='start' ></div></div>")
                .append("<div class='col-md-6'><div class='form-group'><label class='control-label'>End</label><input class='form-control' type='datetime-local' name='end'></div></div>")
                .append(
                    "<div class='col-md-12'><div class='form-group'><label class='control-label'>Descriptions Event</label><textarea class='form-control' placeholder='Insert Event Description' name='description' rows='4' cols = '50'></textarea></div></div>"
                )
                .find("select[name='category']")
                .append("<option value='bg-primary'>Primary</option>")
                .append("<option value='bg-success'>Success</option>")
                .append("<option value='bg-purple'>Purple</option>")
                .append("<option value='bg-danger'>Danger</option>")
                .append("<option value='bg-pink'>Pink</option>")
                .append("<option value='bg-info'>Info</option>")
                .append("<option value='bg-inverse'>Inverse</option>")
                .append(
                    "<option value='bg-warning'>Warning</option></div></div>"
                ),
                $("#event-modal")
                .find(".delete-event")
                .hide()
                .end()
                .find(".save-event")
                .show()
                .end()
                .find(".modal-body")
                .empty()
                .prepend(i)
                .end()
                .find(".save-event")
                .unbind("click")
                .click(function() {
                    i.submit();
                }),
                o.$modal.find("form").on("submit", function() {
                    var e = i.find("input[name='title']").val(),
                        t = i
                        .find("select[name='category'] option:checked")
                        .val(),
                        t1 = i
                        .find("input[name='start']")
                        .val(),
                        t2 = i
                        .find("input[name='end']")
                        .val(),
                        d = i.find("textarea[name='description']").val();
                    return (
                        null !== e && 0 != e.length // var start = $.fullCalendar.formatDate(start, "Y-MM-DD");
                        ? // var end = $.fullCalendar.formatDate(end, "Y-MM-DD");
                        (
                            (
                                start = moment(t1).format("Y-MM-DD H:M:S"),
                                end = moment(t2).format("Y-MM-DD H:M:S"),
                                $.ajax({
                                    url: "/calenderAjax",
                                    data: {
                                        title: e,
                                        description: d,
                                        start: start,
                                        end: end,
                                        className: t,
                                        type: "add"
                                    },
                                    type: "POST",
                                    success: function(data) {
                                        displayMessage(
                                            "Event Created Successfully"
                                        );

                                        calendar.fullCalendar(
                                            "renderEvent", {
                                                id: data.id,
                                                title: data.title,
                                                start: start,
                                                end: end,
                                                allDay: allDay,
                                                className: data.className
                                            },
                                            true
                                        );

                                        calendar.fullCalendar("unselect");
                                    }
                                })
                            ),
                            $("#event-modal").modal("hide")) :
                        alert("moi nhap title"), !1
                    );
                });
        },
        eventDrop: function(event) {
            start = moment(event.start).format("Y-MM-DD H:M:S"),
                end = moment(event.end).format("Y-MM-DD H:M:S"),
                $.ajax({
                    url: "/calenderAjax",
                    data: {
                        title: event.title,
                        start: start,
                        end: end,
                        id: event.id,
                        type: "update"
                    },
                    type: "POST",
                    success: function(response) {
                        displayMessage("Event Updated Successfully");
                    }
                });
        },
        eventClick: function(event, allDay) {
            $("#event-modal").modal({ backdrop: "static" });
            var i = $("<form></form>");
            i.append("<div class='row'></div>"),
                i
                .find(".row")
                .append("<div class='modal-header'><h4 class='modal-title mt-0'><strong>Update New Event</strong></h4></div>")
                .append(
                    "<div class='col-md-12'><div class='form-group'><label class='control-label'>Event Name</label><input class='form-control' placeholder='Insert Event Name' type='text' value='" +
                    event.title +
                    "' name='title'/></div></div>"
                )
                .append(
                    "<div class='col-md-12'><div class='form-group'><label class='control-label'>Category</label><select class='form-control' name='category'></select></div></div>"
                )
                .append("<div class='col-md-6'><div class='form-group'><label class='control-label'>Start</label><input class='form-control' type='datetime-local' name='start' value=" + Date('YYYY-MM-DDTHH:mm', (Date.parse(event.start) / 1000)) + " ></div></div>")
                .append("<div class='col-md-6'><div class='form-group'><label class='control-label'>End</label><input class='form-control' type='datetime-local' name='end'></div></div>")
                .append(
                    "<div class='col-md-12'><div class='form-group'><label class='control-label'>Descriptions Event</label><textarea class='form-control' placeholder='Insert Event Description' name='description' rows='4' cols = '50'>" +
                    event.description +
                    "</textarea></div></div>"
                )
                // .append("<span class='input-group-append'><button type='submit' class='btn btn-success btn-md waves-effect waves-light'><i class='fa fa-check'></i> Save</button></span>")
                .find("select[name='category']")
                .append("<option value='bg-primary'>Primary</option>")
                .append("<option value='bg-success'>Success</option>")
                .append("<option value='bg-purple' >Purple</option>")
                .append("<option value='bg-danger'>Danger</option>")
                .append("<option value='bg-pink'>Pink</option>")
                .append("<option value='bg-info'>Info</option>")
                .append("<option value='bg-inverse'>Inverse</option>")
                .append(
                    "<option value='bg-warning'>Warning</option></div></div>"
                )

            $("#event-modal")
                .find(".save-event")
                .show()
                .end()
                .find(".delete-event")
                .show()
                .end()
                .find(".modal-body")
                .empty()
                .prepend(i)
                .end()
                .find(".delete-event")
                .unbind("click")
                .click(function() {
                    $.ajax({
                        type: "POST",
                        url: '/calenderAjax',
                        data: {
                            id: event.id,
                            type: 'delete'
                        },
                        success: function(response) {
                            calendar.fullCalendar('removeEvents', event.id);
                            displayMessage("Event Deleted Successfully");
                        }
                    });
                    $("#event-modal").modal("hide");
                })
                .end()
                .find(".save-event")
                .unbind("click")
                .click(function() {
                    var e = i.find("input[name='title']").val(),
                        t = i
                        .find("select[name='category'] option:checked")
                        .val(),
                        d = i.find("textarea[name='description']").val();
                    (start = moment(event.start).format()),
                    (end = moment(event.end).format()),
                    $.ajax({
                            type: "POST",
                            url: "/calenderAjax",
                            data: {
                                title: e,
                                description: d,
                                start: start,
                                end: end,
                                className: t,
                                id: event.id,
                                type: "update",
                            },
                            success: function(response) {
                                displayMessage(
                                    "Event Update Successfully"
                                );
                                calendar.fullCalendar(
                                    "renderEvent", {
                                        id: data.id,
                                        title: data.title,
                                        start: data.start,
                                        end: data.end,
                                        allDay: !1,
                                        className: data.className
                                    },
                                    true
                                );
                                calendar.fullCalendar("unselect");
                            }
                        }),
                        $("#event-modal").modal("hide");
                })
                .end();
        }
    });
});

function displayMessage(message) {
    toastr.success(message, "Event");
}
