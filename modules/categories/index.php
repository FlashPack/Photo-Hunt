<?php
$categories=$db->query("select *,(select count(*) from level_category where level_category.cat_id=category.cat_id && (select count(*) from level where level.lv_id=level_category.lv_id && level.lv_status=1)!=0 limit 1) as level_count from category where cat_status=1 order by cat_id");
$smarty->assign('category_dir',config::$upload_dir['categories']);
$smarty->assign('categories',$categories['rows']);
$smarty->display('game/categories.html');
?>