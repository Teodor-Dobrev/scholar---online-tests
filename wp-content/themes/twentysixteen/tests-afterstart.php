<?php
/**
 * Изглед на теста след започване започване на решаване
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<h2>Моля, попълнете теста. Времето тече!</h2>
<form method="post" action="">
	<input type="hidden" name="teststarted"/>
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
foreach(Processor::testView($test_id) as $key => $val):
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
		<td>&nbsp;</td><td><?php echo(++ $question_number);?>. <input type="radio" name="answer[<?php echo $val->question_id;?>]" value="<?php echo $val->answer_id;?>" onclick="sendAnswer(<?php echo $val->question_id;?>, <?php echo $val->answer_id;?>);" <?php echo $val->answer_id == @$answers[$val->question_id] ? ' checked="checked"' : '';?>/><?php echo $val->answer;?></td>
	</tr>
<?php
endforeach;
?>
	</tbody>
</table>
<p><input type="submit" name="finish" value="ПРИКЛЮЧВАНЕ НА ТЕСТА"/></p>
</form>


		</div><!-- .entry-content -->

	<footer class="entry-footer">
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
<script type="text/javascript">
var ajaxurl = "<?php echo admin_url('admin-ajax.php');?>";
function sendAnswer(question_id, answer_id){
	jQuery.post(
		ajaxurl, 
		{
			'action': 'save_answer',
			'data':   {
				question_id: question_id,
				answer_id: answer_id,
				test_uid: '<?php echo $test_uid;?>'
			}
		}, 
		function(response){
		}
	);
}
</script>