<h2>Тестове</h2>
<form id="areaFilter" method="get" action="">
	<label>Филтриране по област</label>
	<input type="hidden" name="page" value="scholar_tests"/>
	<select name="area" onchange="jQuery(this).closest('form').submit();">
		<option value="">Изберете област</option>
<?php echo Html::options(Html::getAreas(), @$_GET['area']); ?>
	</select>
</form>
<table class="wp-list-table widefat fixed striped posts" id="tests">
	<thead>
	<tr>
		<th>ID</th><th>Уникален номер</th><th>Име</th><th>Област</th><th>Последна редакция</th><th>Време за решаване</th><th>Линк</th><th>Действие</th>
	</tr>
	</thead>
	<tbody>
<?php 
foreach(static::$view_content['tests'] as $val):
?>
	<tr>
		<td><?php echo $val->id;?></td><td><?php echo $val->uid;?></td><td><?php echo $val->name;?></td><td><?php echo $val->area;?></td><td><?php echo $val->last_edit;?></td><td><?php echo $val->time_to_solve;?></td>
		<td><?php echo site_url();?>/tests/<?php echo $val->uid;?>/</td>
		<td>
		<!--<a href="<?php echo admin_url() . 'admin.php?page=scholar_tests_add&amp;id=' . $val->id;?>">Редакция</a> | <br/>-->
		 
		<a href="<?php echo admin_url() . 'admin.php?page=scholar_tests&amp;id=' . $val->id;?>&amp;action=correct">Верни отговори</a> | <br/>
		<a href="<?php echo admin_url() . 'admin.php?page=scholar_tests&amp;id=' . $val->id;?>&amp;action=view">Преглед</a> | <br/>
		<a href="<?php echo admin_url() . 'admin.php?page=scholar_tests&amp;id=' . $val->id;?>&amp;action=solved">Решени тестове</a>
		</td>
	</tr>
<?php
endforeach;
?>
	</tbody>
</table>
