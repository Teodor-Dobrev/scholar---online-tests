<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
Processor::createTestForStudent();
get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();
			$test_uid = Processor::testUIDByURL();
			$test_data = Processor::testData($test_uid);
			$test_id = $test_data[0]->id;
			
			
			if(isset($_POST['starttest'])){
				Processor::startTest($test_id);
			}
			if(isset($_POST['teststarted'])){
				Processor::saveAnswers(
					array(
						'test_uid' => Processor::testUIDByURL(),
						'data' => $_POST
					)
				);
			}			
			$current_test_data = Processor::testStartDate($test_id);
			
			if(! $current_test_data){
				include( 'tests-beforestart.php' );
			}else{
				$time_passed = ($current_test_data->now - $current_test_data->opened) / 60;
				$answers = Processor::answeredQuestions($test_id);
				
				if($test_data[0]->time_to_solve > $time_passed){

					include( 'tests-afterstart.php' );
				}else{
					include( 'tests-afterfinish.php' );
				}
				
			}

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}


			// End of the loop.
		endwhile;
		?>

	</main><!-- .site-main -->

	<?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
