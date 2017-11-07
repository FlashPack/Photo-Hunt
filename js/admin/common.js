$(function(){
	$('input[name="checkAll"]').click(function(){
		check=$(this).val();
		if($('.'+check).attr('checked')){
			$('.'+check).attr('checked',false)
		}else{
			$('.'+check).attr('checked',true)
		}
	});
	$('.text').click(function(){
		$(this).hide();
		selector=$($(this).parent()).find('.edit');
		selector.show();
	});
});
function get_page(url,container){
	$.ajax({
		type:'post',
		url:url,
		beforeSend:function(){
			$(container).html('<img src="templates/images/loading.gif" />');
		},
		success:function(response){
			$(container).html(response);
		}
	})
}
function _activate(object,url,field){
	status=$(object).attr('checked');
	_id=$(object).attr('rel');
	$.ajax({
		type:'post',
		url :url,
		data:'status='+status+'&'+field+'='+_id
	});
}
function _delete(object,url,field,alert_id){
	tr=$($(object).parent()).parent();
	if(confirm('Are you sure?')){
		_id=$(object).attr('rel');
		$.ajax({
			type:'post',
			url :url,
			data:field+'='+_id,
			beforeSend:function(){
				$(alert_id).html('<img src="templates/images/loading.gif" />');
			},
			success:function(response){
				$(alert_id).html('<br>');
				tr.fadeOut();
			}
		});
	}
}
