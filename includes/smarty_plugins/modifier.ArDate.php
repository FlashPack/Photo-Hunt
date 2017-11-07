<?php
function smarty_modifier_ArDate($timestamp,$time_=null)
{
	//return $time?'time':null;
	$months=array('Jan'=>'يناير','Feb'=>'فبراير','Mar'=>'مارس','Apr'=>'إبريل','May'=>'مايو','Jun'=>'يونيه','Jul'=>'يوليه','Aug'=>'أغسطس','Sep'=>'سبتمبر','Act'=>'أكتوبر','Nov'=>'نوفمبر','Des'=>'ديسمبر');
	$meridiem=array('am'=>'ص','pm'=>'م');
	list($date,$time)=explode('/' ,date('Y-M-d/h:i a',$timestamp));
	list($year,$month,$day)=explode('-',$date);
	if($time_){
		$time=explode(' ',$time);
		$time=$time[0].' '.$meridiem[$time[1]];
	}else
		$time=null;
	
	return $day.' '.$months[$month].' '.$year.'&nbsp;&nbsp;&nbsp; '.$time;
}

/* vim: set expandtab: */

?>
