!(function(e) {
    "use strict";
    var o = function() {
        this.$body = e("body");
    };
    e("#upcoming, #inprogress, #completed") //e("#New, #Inprogress, #Pending, #overDue, #Done")
        .sortable({
            connectWith: ".taskList",
            placeholder: "task-placeholder",
            forcePlaceholderSize: !0,
            update: function(o, t) {
                e("#todo").sortable("toArray"),
                    e("#inprogress").sortable("toArray"),
                    e("#completed").sortable("toArray");
            }
        })
        .disableSelection(),
        (o.prototype.init = function() {}),
        (e.KanbanBoard = new o()),
        (e.KanbanBoard.Constructor = o);
})(window.jQuery),
(function(o) {
    "use strict";
    window.jQuery.KanbanBoard.init();
})();
