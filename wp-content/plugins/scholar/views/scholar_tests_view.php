<h2>Преглед на тест - <?php echo static::$view_content['tests'][0]->uid;?></h2>

<table class="wp-list-table widefat fixed striped posts" id="tests">
	<thead>
	<tr>
		<th>#</th><th>Въпрос</th>
	</tr>
	</thead>
	<tbody>
<?php 
$last_question_id = 0;
$question_number = 0;
$answer_number = 0;
foreach(static::$view_content['tests'] as $key => $val):
	if($val->question_id != $last_question_id):
?>
	<tr>
		<th><b><?php echo(++ $answer_number);?>.</b></th><th><b><?php echo $val->question;?></b></th>
	</tr>
<?php
		$last_question_id = $val->question_id;
		$question_number = 0;
	endif;
?>
	<tr>
		<td>&nbsp;<?php echo(++ $question_number);?>.</td><td><?php echo $val->answer;?></th>
	</tr>
<?php
endforeach;
?>
	</tbody>
</table>
