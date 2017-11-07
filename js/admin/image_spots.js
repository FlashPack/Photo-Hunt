$(document).ready(function() {
	spot=false;
	total_spots=0;
	$('.total span').html(total_spots);
	var x1,x2,y1,y2;
	$('.spacer').mousedown(function(e) {
		spot=true;
		total_spots++
		$('#current').attr({ id: ''})
		box = $('<div style="border:1px #000000 solid;position:absolute;background:white" />').hide();
		$(document.body).append(box);
		x1 = e.pageX;
		y1 = e.pageY;
		box.attr({id: 'current'}).css({
				 top: e.pageY, 
				 left: e.pageX 
		}).addClass('spot'+total_spots).fadeIn();
	});
	$('.spacer').mousemove(function(e) {
		spacer_id=$(this).attr('id');
		$('#current').css({
		  width:Math.abs(e.pageX - x1), 
		  height:Math.abs(e.pageY - y1) 
		}).fadeIn();
		switch(spacer_id){
			case 'spacer1':
				offsetX=15;
				offsetY=54;
			break;
			case 'spacer2':
				offsetX=412;
				offsetY=54;
			break;
		}
		$('.mouse_x span').html(e.pageX-offsetX);
		$('.mouse_y span').html(e.pageY-54);
	});
	$(document).mouseup(function() {
		width=$('#current').css('width');
		height=$('#current').css('height');
		if(spot==true && width!='0px' && height!='0px'){
			id=$('#current').attr('class');
			x=$('#current').css('left');
			y=$('#current').css('top');
			$('#current').attr({ id: ''})
			$('.total span').html(total_spots);
			spot=false;
			insert_spot(x,y,width,height,$('.image').attr('id'));
			draw_spot(x,y,width,height,id,'#spacer2');
		}
	});
	function draw_spot(x,y,width,height,id,selector){
		x=parseInt(x);
		y=parseInt(y);
		width=parseInt(width);
		height=parseInt(height);
		x-=19;
		y-=54
		spot=$('<div></div>',{style:'left:'+x+'px;top:'+y+'px;width:'+width+'px;height:'+height+'px;'}).addClass('spot').addClass(id);
		$('#spacer2').append(spot);
	}
	function log(x,y,width,height,id){
		undo_anchor=$('<a></a>',{href:'javascript:;',html:'Undo','rel':id,click:undo_func,mouseover:highlight_func,mouseout:remove_highlight_func});
		li=$('<li></li>',{html:'Spot '+total_spots});
		new_spot_div=$('<div></div>',{id:'log_'+id,mouseover:highlight_func,mouseout:remove_highlight_func});
		new_spot_div.addClass('new_spot');
		details_text='X:'+x+'<br>Y:'+y+'<br>Width:'+width+'<br>Height:'+height;
		li.append(undo_anchor);
		details=$('<div></div>',{html:details_text});
		details.addClass('details');
		new_spot_div.append(li).append(details);
		$('.new_spots').append(new_spot_div);
	}
	function insert_spot(x,y,width,height,img_id){
		$.ajax({
			type:'post',
			url:'admin.php?view=levels&ajax=true&action=insert_spot',
			data:'x='+x+'&y='+y+'&width='+width+'&height='+height+'&img_id='+img_id,
			success:function(response){
				log(x,y,width,height,id);
				$('.'+id).attr('id',response);
			}
		});
	}
	function undo_func(e){
		id=$(e.target).attr('rel');
		spot_id=$('.'+id).attr('id');
		$.ajax({
			type:'post',
			url:'admin.php?view=levels&ajax=true&action=remove_spot',
			data:'spot_id='+spot_id,
			success:function(response){
				$('.'+id).remove();
				$('#log_'+id).remove();
				$('.total span').html(total_spots>0?--total_spots:'');
				
			}
		});
	}
	function highlight_func(e){
		id=$(e.target).find('a').attr('rel');
		id=id==undefined?$(e.target).attr('rel'):id; 
		$('.'+id).css('background-color','#66E961').css('border','1px dashed');
	}
	function remove_highlight_func(e){
		id=$(e.target).find('a').attr('rel');
		id=id==undefined?$(e.target).attr('rel'):id; 
		$('.'+id).css('background-color','white').css('border','1px solid');
	}
});
