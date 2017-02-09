<h2>Списък с налични въпроси</h2>
<form id="areaFilter" method="get" action="">
	<label>Филтриране по област</label>
	<input type="hidden" name="page" value="questions"/>
	<select name="area" onchange="jQuery(this).closest('form').submit();">
		<option value="">Изберете област</option>
<?php echo Html::options(Html::getAreas(), @$_GET['area']); ?>
	</select>
</form>
<table class="wp-list-table widefat fixed striped posts" id="questions">
	<thead>
	<tr>
		<th>ID</th><th>Въпрос</th><th>Отговори</th><th>Трудност</th><th>Област</th><th>Действие</th>
	</tr>
	</thead>
	<tbody>
<?php 
foreach(static::$view_content['questions'] as $val):
?>
	<tr>
		<td><?php echo $val->id;?></td><td><?php echo $val->question;?></td><td><?php echo $val->answers;?></td><td><?php echo $val->weight;?></td><td><?php echo $val->area;?></td><td><a href="<?php echo admin_url() . 'admin.php?page=questions_add&id=' . $val->id;?>">Редакция</a></td>
	</tr>
<?php
endforeach;
?>
	</tbody>
</table>
