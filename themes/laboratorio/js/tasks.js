var TaskList = function () {

    return {

        initTaskWidget: function () {
			$('input.list-child').change(function() {
                                var tarea_id = $(this).attr('tarea');
                                alert(tarea_id);
				if ($(this).is(':checked')) {
					$(this).parents('li').addClass("task-done");
                                        $('#ampliar_tarea'+tarea_id).hide();
				} else { 
					$(this).parents('li').removeClass("task-done");
                                        $('#ampliar_tarea'+tarea_id).show();
				}
			}); 
        }

    };

}();