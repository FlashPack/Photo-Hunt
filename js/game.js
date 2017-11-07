(function($){
$.fn.game=function(options){
	var defaults={
		sound:'',
		current_level_id:'',
		total_levels_id:'',
		game_score_id:'',
		image1_id:'',
		image2_id:'',
		image_width:'',
		image_height:'',
		total_score_id:'',
		level_score_id:'',
		spots_left_id:'',
		wrong_clicks_id:'',
		spot_progress_id:'',
		pause_dialog:'',
		loading_id:'',
		cat_id:'',
		correct_spot_icon:'',
		allowed_hints:3,
		timer_duration:'',
		allowed_pauses:'',
		correct_click_score:'',
		unused_hints_score:'',
		wrong_click_p:'',
		level_dir:''
	}
	var game_vars={
		images:[],
		spots:[],
		level_score:0,
		game_score:0,
		total_score:0,
		total_spots:0,
		time_bonus:0,
		unusedhints_bonus:0,
		total_level_score:0,
		correct_spot_ids:[],
		spots_left:0,
		wrong_clicks:0,
		current_level:0,
		used_hints:0,
		timer_duration:'',
		time_passed:0,
		timer:'stopped',
		used_pauses:0,
		offsetX:19,
		offsetY:52,
		images_loaded:false
	}
	var options=$.extend(defaults,options);
	game_vars.timer_duration=options.timer_duration;
	game_vars.total_score=options.total_score;
	window_width=$(window).width();
	options.correct_spot_icon=$(options.spot_progress_id).find('img');
	return this.each(function(){
		get_level_data();
		$('#img1,#img2,#spacer1,#spacer2').click(function(e){
			switch($(this).attr('id')){
			case 'img1':
				offsetX=35;
				offsetY=160;
				break; 
			case 'img2':
				offsetX=430;
				offsetY=165;
				break; 
			case 'spacer1':
				offsetX=31;
				offsetY=183;
				break; 
			case 'spacer2':
				offsetX=449;
				offsetY=183;
				break; 
			}
			check_click(Math.abs(e.pageX)-offsetX,Math.abs(e.pageY)-offsetY);
		})
		$('.game_contine').click(function(){
			$(options.pause_dialog).dialog('close');
			timer_start();
		})
		$('.finish').click(function(){
			window.close();
		});
		$('.new_game').click(function(){
			$(options.game_report_dialog).dialog('close');
			location.replace('index.php?view=play');
		});
		$('.next_level').click(function(){
			$(options.level_report_dialog).dialog('close');
			get_level_data();
		})
		$('.hints a').click(function(){
			if($(this).attr('rel')=='unused'){
				if(use_hint()){
					$(this).addClass('transparent');
					$(this).attr('rel','used');
					game_sync();
				}
			}
		});
		$('.buttons a').click(function(){
			switch($(this).attr('rel')){
				case 'pause':
					if(game_vars.used_pauses<options.allowed_pauses){
						$(options.pause_dialog).dialog('open');
						time_pause();
						game_sync();
					}
				break;
				case 'new':
					location.replace('index.php?view=play');
				break;
			}
		});
	});
	function check_click(mouseX,mouseY){
		if(game_vars.timer=='active'){
			correct=false;
			for(i=0;i<game_vars.spots.length;i++){
				spot_x1=Number(game_vars.spots[i].attr('x'))-game_vars.offsetX;
				spot_x2=spot_x1+Number(game_vars.spots[i].attr('width'));
				spot_y1=Number(game_vars.spots[i].attr('y'))-game_vars.offsetY;
				spot_y2=spot_y1+Number(game_vars.spots[i].attr('height'));
				spot_id=spot_x1+spot_y1;
				if(mouseX>=spot_x1 && mouseX<=spot_x2 && mouseY>=spot_y1 && mouseY<=spot_y2 && !in_array(spot_id,game_vars.correct_spot_ids)){
					correct_click(spot_id,game_vars.spots[i]);
					correct=true;
				}
			}
			if(!correct){
				wrong_click();
			}
			game_sync();
		}
	}
	function level_finish(){
		game_vars.time_bonus=game_vars.time_left*options.time_bonus_score;
		game_vars.unusedhints_bonus=(options.allowed_hints-game_vars.used_hints)*options.unusedhints_score;
		game_vars.level_total_score=game_vars.level_score+game_vars.unusedhints_bonus+game_vars.time_bonus;
		game_vars.total_score+=game_vars.level_total_score;
		game_vars.game_score+=game_vars.level_total_score;
		$(options.level_report_dialog).find('.time_bonus span').html(game_vars.time_bonus);
		$(options.level_report_dialog).find('.unusedhints_bonus span').html(game_vars.unusedhints_bonus);
		$(options.level_report_dialog).find('.level_total_score span').html(game_vars.level_total_score);
		$(options.level_report_dialog).dialog('open');
		update_score();
		time_stop();
		empty_vars();
	}
	function empty_vars(){
		game_vars.images=[];
		game_vars.spots=[];
		game_vars.time_bonus=0;
		game_vars.unusedhints_bonus=0;
		game_vars.level_total_score=0;
		game_vars.correct_spot_ids=[];
		
	}
	function use_hint(){
		if(game_vars.timer=='active' && game_vars.used_hints<options.allowed_hints){
			game_vars.used_hints++;
			for(i=0;i<game_vars.spots.length;i++){
				spot_x1=Number(game_vars.spots[i].attr('x'))-game_vars.offsetX;
				spot_y1=Number(game_vars.spots[i].attr('y'))-game_vars.offsetY;
				spot_id=spot_x1+spot_y1;
				if(!in_array(spot_id,game_vars.correct_spot_ids)){
					correct_click(spot_id,game_vars.spots[i]);
					return true; 
				}
			}
		}
		return false;
	}
	function correct_click(spot_id,spot,hint){
		game_vars.spots_left--;
		game_vars.correct_spot_ids[game_vars.correct_spot_ids.length]=spot_id;
		draw_spot(spot.attr('x'),spot.attr('y'),spot.attr('width'),spot.attr('height'),false);
		$(options.spot_progress_id).find('img:nth('+(game_vars.correct_spot_ids.length-1)+')').each(function(){
			$(this).removeClass('transparent');
			return true;
		});
		game_vars.level_score+=options.correct_click_score;
		if(game_vars.correct_spot_ids.length==game_vars.spots.length){
			level_finish();
		}
		return;
	}
	function wrong_click(){
		game_vars.timer_duration-=parseInt((options.wrong_click_p*options.timer_duration)/100);;
		game_vars.timer_duration=game_vars.timer_duration>0?game_vars.timer_duration:0;
		timer_start();
		game_vars.wrong_clicks+=1;
	}
	function game_sync(){
		$(options.level_score_id).find('span').html(game_vars.level_score);
		$(options.total_score_id).find('span').html(game_vars.total_score);
		$(options.level_report_dialog).find('.level_score span').html(game_vars.level_score);
		$(options.game_score_id).find('span').html(game_vars.game_score);
		$(options.spots_left_id).find('span').html(game_vars.spots_left);
		$(options.wrong_clicks_id).find('span').html(game_vars.wrong_clicks);
		$(options.level_score_id).find('span').html(game_vars.level_score);
		$(options.pause_dialog).find('.allowed_pauses span').html(options.allowed_pauses);
		$(options.pause_dialog).find('.remained_pauses span').html(options.allowed_pauses-game_vars.used_pauses);
	}
	function in_array(needle, haystack) {
		var length = haystack.length;
		for(var i = 0; i < length; i++) {
			if(haystack[i] == needle) return true;
		}
		return false;
	}

	function get_level_data(){
		if(Number($(options.total_levels_id).find('span').html())>=(game_vars.current_level+1)){
			$.ajax({
				type:'post',
				url:'index.php?ajax=true&view=play',
				data:'action=start&do=get_level_data&cat_id='+options.cat_id,
				beforeSend:function(){
					$(options.loading_id).show();
				},
				success:function(XMLResponse){
					XML = $(XMLResponse) ; 
					game_vars.total_spots=XML.find('spot').length;
					XML.find('image').each(function(){
						game_vars.images[game_vars.images.length]=$(this);
					})
					XML.find('spot').each(function(){
						game_vars.spots[game_vars.spots.length]=$(this);
					})
					options.level_dir=XML.find('level_dir').text();
					if(game_vars.images.length==2 && game_vars.total_spots>=1){
						game_initialize();
						return ;
					}
				}
			})
		}else{
			game_over();
		}
	}
	function game_initialize(){
		game_vars.current_level++;
		$(options.current_level_id).find('span').html(game_vars.current_level);
		$(options.game_score_id).find('span').html(game_vars.game_score);
		$(options.total_score_id).find('span').html(game_vars.total_score);
		game_vars.spots_left=game_vars.spots.length;
		$(options.spots_left_id).find('span').html(game_vars.spots_left);
		$(options.wrong_clicks_id).find('span').html(game_vars.wrong_clicks);
		$(options.image1_id).find('img').hide();
		$(options.image2_id).find('img').hide();
		options.image_width=Number($(options.image1_id).find('img').width());
		options.image_height=Number($(options.image1_id).find('img').width());
		loading_left=($(window).width()-$(options.loading_id).css('width').replace('px',''))/2;
		$(options.loading_id).css('margin-left',loading_left-20+'px');
		$(options.spot_progress_id).html('');
		$('.spacer').html('');
		game_vars.level_score=0;
		for(i=0;i<game_vars.total_spots;i++){
			spot_icon=$('<img></img>',{src:options.correct_spot_icon.attr('src')});
			spot_icon.addClass('transparent');
			spot_icon.appendTo($(options.spot_progress_id));
		}
		load_image('#img1',game_vars.images[0].attr('src'));
		load_image('#img2',game_vars.images[1].attr('src'),true);
		/*for(i=0;i<game_vars.spots.length;i++){
			draw_spot(game_vars.spots[i].attr('x'),game_vars.spots[i].attr('y'),game_vars.spots[i].attr('width'),game_vars.spots[i].attr('height'),false);
		}*/
		game_vars.timer_duration=options.timer_duration;
		timer_start();
		game_sync();
		return ;
	}
	function load_image(id,source,var_){
		var img = new Image();
		$(img).load(function () {
			$(id).html(this);
			$(options.loading_id).hide();
			if(var_==true){
				images_loaded=true
			}
		}).error(function (){
		}).attr('src',options.level_dir+source);
	} 
	function update_score(){
		$.ajax({
			type:'post',
			url:'index.php?ajax=true&view=play',
			data:'action=start&do=update_score&total_score='+game_vars.total_score+'&level='+game_vars.current_level
		});
	}
	
	function timer_start(){
		if(game_vars.timer!='active'){
			$(".timer").everyTime(1000, function(i) {
				game_vars.time_left=game_vars.timer_duration-i;
				$(this).find('span').html(game_vars.time_left);
				if(game_vars.time_left<=0){
					$(this).find('span').html(0);
					game_over();
				}else{
					game_vars.timer='active';
				}
			});
		}
 	}
	function game_over(){
		$(".timer").stopTime();
		game_vars.timer='over';
		$(options.game_report_dialog).find('.game_score span').html(game_vars.game_score);
		$(options.game_report_dialog).find('.total_score span').html(game_vars.total_score);
		$(options.game_report_dialog).find('.played_levels span').html(game_vars.current_level);
		$(options.game_report_dialog).find('.wrong_clicks span').html(game_vars.wrong_clicks);
		$(options.game_report_dialog).dialog('open');
		
	}
	function time_pause(){
		$(".timer").stopTime();
		game_vars.timer='paused';
		game_vars.timer_duration=game_vars.time_left;
		game_vars.used_pauses++;
	}
	function time_stop(){
		$(".timer").stopTime();
		game_vars.timer='stopprd';
	}
	
	function draw_spot(x,y,width,height,hint){
		spot_style=hint==true?'hint_spot':'spot';
		x-=game_vars.offsetX;
		y-=game_vars.offsetY;
		spot=$('<div></div>',{style:'left:'+x+'px;top:'+y+'px;width:'+width+'px;height:'+height+'px;'}).addClass(spot_style);
		$('.spacer').append(spot);
	}
}

})(jQuery);