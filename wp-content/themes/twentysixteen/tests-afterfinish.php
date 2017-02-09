<?php
/**
 * Изглед на теста преди започване на решаване
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
$correct_answers = 0;
$incorrect_answers = 0;
$test = Processor::testView($test_id);
foreach($test as $key => $val){
	if(isset($answers[$val->question_id])){
		if($val->answer_id == $answers[$val->question_id]){
			if($val->correct == 1){
				$correct_answers ++;
			}else{
				$incorrect_answers ++;
			}
		}
	}
}
$missing_answers = count($answers) - $correct_answers - $incorrect_answers;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<h2>Тестът е приключен!</h2>
		<h3>Резултати:</h3>
		<p>Верни отговори: <span style="color:#5a1"><?php echo $correct_answers;?></span>; грешни отговори: <span style="color:#a51"><?php echo $incorrect_answers;?></span>; непосочени отговори: <span style="color:#aa1"><?php echo $missing_answers;?></span>.</p>
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
foreach($test as $key => $val):
	if($val->question_id != $last_question_id):
?>
	<tr>
		<th><b><?php echo(++ $answer_number);?>.</b></th><th><b><?php echo $val->question;?></b></th>
	</tr>
<?php
		$last_question_id = $val->question_id;
		$question_number = 0;
		$na = false;
	endif;
	$question_number ++;
	if((! isset($answers[$val->question_id]) || $answers[$val->question_id] == 0) && ! $na):
		$na = true;
?>
	<tr>
		<td colspan="2">Няма посочен отговор</td>		
	</tr>
<?php
	else:
		if($val->answer_id == $answers[$val->question_id]):
?>
	<tr>
		<td><?php echo $val->correct == 1 ? '<span style="color:#5a1">Верен</span>' : '<span style="color:#a51">Грешен</span>';?></td><td><?php echo($question_number);?>. <?php echo $val->answer;?></td>
	</tr>
<?php
		endif;
	endif;
endforeach;
?>
	</tbody>
</table>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
