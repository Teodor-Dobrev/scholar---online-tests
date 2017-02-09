<?php
/**
 * Изглед на теста преди започване на решаване
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
		<h2>Тестът не е започнат!</h2>
		<p>Време за решаване - <b><?php echo (int)$test_data[0]->time_to_solve;?> минути</b>. <br/><b>Когато видите теста, времето започва да тече!</b></p>
		<form method="post" action="">
			<input type="hidden" name="starttest" value="1"/>
			<input type="submit" value="СТАРТ НА ТЕСТА" name="start" onclick="javascript:return confirm('Времето ще започне да тече! Сигурни ли сте, че искате да започнете решаването?');"/>
		</form>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
