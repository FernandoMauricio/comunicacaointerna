//MODAL
$(function(){
			$('#modalButton').click(function(){
					$('#modal').modal('show')
						.find('#modalContent')
						.load($(this).attr('value'));
	});
});

//uploadExtraData
/*function() {
    var obj = {};
    $('.comunicacao-interna-com-form').find('input').each(function() {
        var id = $(this).attr('id'), val = $(this).val();
        obj[id] = val;
    });
    return obj;
}*/