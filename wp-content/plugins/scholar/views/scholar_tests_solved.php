<h2>Започнати / решени тестове</h2>
<?php if(count(static::$view_content['tests']) > 0):?>
<p>Тест - <b><?php echo static::$view_content['tests'][0]->name; ?></b></p>
<p>Номер - <b><?php echo static::$view_content['tests'][0]->uid; ?></b></p>
<?php endif;?>
<table class="wp-list-table widefat fixed striped posts" id="tests">
	<thead>
	<tr>
		<th>ID</th><th>Ученик</th><th>Линк</th>
	</tr>
	</thead>
	<tbody>
<?php 
foreach(static::$view_content['tests'] as $val):
?>
	<tr>
		<td><?php echo $val->student_id;?></td>
		<td><?php echo get_userdata($val->student_id)->display_name;?></td>
		<td><a href="<?php echo site_url();?>/tests/<?php echo $val->uid;?>-<?php echo $val->student_id;?>/" target="_blank"><?php echo site_url();?>/tests/<?php echo $val->uid;?>-<?php echo $val->student_id;?>/</a></td>
		
	</tr>
<?php
endforeach;
?>
	</tbody>
</table>
