<?php
	$test = @static::$view_content['test'][0];
?>
<h2>Добавяне/редакция на тест</h2>

<form method="post" action="">
	<input type="hidden" name="test_id" value="<?php echo @$test->id;?>"/>
	<label>Име на теста</label><br/>
	<input type="text" name="name" required value="<?php echo @$test->name;?>"/><br/>
	<label>Област</label><br/>
	<select name="area">
<?php echo Html::options(Html::getAreas(), @$test->area_id); ?>
	</select><br/>
	<label>Брой въпроси от всяка трудност</label><br/>
	<input type="number" name="questions" required value="<?php echo @$test->name;?>" min="1" max="3"/><br/>
	<label>Брой отговори от всеки въпрос</label><br/>
	<input type="number" name="answers" required value="<?php echo @$test->name;?>" min="1" max="4"/><br/>
	<label>Време за решаване (мин.)</label><br/>
	<input type="number" name="time_to_solve" required value="<?php echo @$test->time_to_solve;?>" min="1"/><br/><br/>
	
	<input type="submit" name="submitter" value="ЗАПИШИ ВСИЧКО" class="button"/>
	
</form>