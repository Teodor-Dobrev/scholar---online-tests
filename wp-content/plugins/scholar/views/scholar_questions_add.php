<?php
	$question = @static::$view_content['question'][0];
	$answers = @static::$view_content['answers'];
	$right = array('Грешен', 'Верен');
?>
<h2>Добавяне/редакция на върос</h2>

<table id="answersSample" style="display:none"> 
	<tr id="nr_{id}">
		<td>
			<input type="text" name="q[n_{id}]" value="" required/>
		</td>
		<td><select name="c[n_{id}]">
<?php echo Html::optionsArr($right); ?>
			</select>
		</td>
		<td>
			<a class="button" onclick="removeAnswer('#nr_{id}')">Изтриване</a>
		</td>	
	</tr>
</table>	

<form method="post" action="">
	<input type="hidden" name="question_id" value="<?php echo @$question->id;?>"/>
	<label>Въпрос</label>
	<textarea name="question" required><?php echo @$question->question;?></textarea>
	<label>Област</label>
	<select name="area">
<?php echo Html::options(Html::getAreas(), @$question->area_id); ?>
	</select>
	<label>Трудност</label>
	<select name="difficulty">
<?php echo Html::options(Html::getDifficulties(), @$question->difficulty_id); ?>
	</select>
	<a class="button" onclick="addAnswer()">Добавяне на отговор</a>
	<input type="submit" name="submitter" value="ЗАПИШИ ВСИЧКО" class="button fr"/>
	
<h2>Отговори</h2>

<table id="answers" class="wp-list-table widefat fixed striped posts"> 
	<thead>
		<tr><th>Отговор</th><th>Верен / Грешен</th><th>Действие</th></tr>
	</thead>
	<tbody>
<?php if(count($answers) > 0):
	foreach($answers as $val):
?>
	<tr id="r_<?php echo $val->id;?>">
		<td>
			<input type="text" name="q[<?php echo $val->id;?>]" value="<?php echo $val->answer;?>" required/>
		</td>
		<td><select name="c[<?php echo $val->id;?>]">
<?php echo Html::optionsArr($right, $val->correct); ?>
			</select>
		</td>
		<td>
			<a class="button" onclick="removeAnswer('#r_<?php echo $val->id;?>')">Изтриване</a>
		</td>	
	</tr>
<?php
	endforeach;
else:
?>
	<tr id="nr_0">
		<td>
			<input type="text" name="q[n_0]" value=""/>
		</td>
		<td><select name="c[n_0]">
<?php echo Html::optionsArr($right); ?>
			</select>
		</td>
		<td>
			<a class="button" onclick="removeAnswer('#nr_0')">Изтриване</a>
		</td>	
	</tr>
<?php
endif;
?>
	</tbody>
</table>	


</form>
<script type="text/javascript">
var new_number = 1;
function addAnswer(){
	var $row = jQuery('#answersSample tbody').html();
	$row = $row.replace(/\{id\}/g, new_number);
	jQuery('#answers tr:last').after($row);
	new_number ++;
}
function removeAnswer(selector){
	jQuery(selector).remove();
}
</script>