<?php
//Функции за работа по въпроси/отговори/тестове
class Processor {
	//Редакция на въпроси/отговори
	public static function addQuestion(){
		global $wpdb;

		if(isset($_POST['question_id']) && trim((string)$_POST['question']) != ''){
			if((int)$_POST['question_id'] > 0){
				$id = (int)$_POST['question_id'];
				$wpdb->update(
					Scholar::$tables['questions'],	//Таблица
					array(							//Колони
						'question' => trim((string)$_POST['question']),
						'user_id' => (int)get_current_user_id(),
						'difficulty_id' =>(int)$_POST['difficulty'],
						'area_id' =>(int)$_POST['area']
					),
					array(
						'id' => $id					//Условие
					)
				);				
			}else{
				$wpdb->insert(
					Scholar::$tables['questions'],
					array(
						'question' => trim((string)$_POST['question']),
						'user_id' => (int)get_current_user_id(),
						'difficulty_id' =>(int)$_POST['difficulty'],
						'area_id' =>(int)$_POST['area']
					)
				);
				$id = $wpdb->insert_id;
			}
			if($id > 0 && isset($_POST['q'])){
				foreach($_POST['q'] as $key => $val){
					$correct = $_POST['c'][$key];
					
					if(strpos($key, 'n_') !== false){
						$wpdb->insert(
							Scholar::$tables['answers'],
							array(
							  'question_id' => $id,
							  'answer' => $val,
							  'correct' => $correct
							)
						);
					}else{
						$wpdb->update(
							Scholar::$tables['answers'],
							array(
							  'answer' => $val,
							  'correct' => $correct
							),
							array(
								'id' => (int)$key
							)
						);
					}
					
				}
			}

		}
		if(isset($_GET['id']) && $_GET['id'] > 0){
			$sql = $wpdb->prepare("SELECT * FROM " . Scholar::$tables['questions'] . " WHERE `id` = %d;", 
				(int)$_GET['id']
			);
			Scholar::$view_content['question'] = $wpdb->get_results($sql);
			
			$sql = $wpdb->prepare("SELECT * FROM " . Scholar::$tables['answers'] . " WHERE question_id = %d", 
				(int)$_GET['id']
			);
			Scholar::$view_content['answers'] = $wpdb->get_results($sql);
		}		
	}
	
	//Списък с въпросите
	public static function questions($area_id = 0){
		global $wpdb;
		
		$where = '';
		if($area_id > 0){
			$where = "WHERE `q`.`area_id` = " . (int)$area_id; 
		}
		$sql = "SELECT `q`.`id`, `q`.`question`, 
						`d`.`weight`,
						`a`.`area`,
						COUNT(`a1`.`id`) AS `answers`
						
					FROM " . Scholar::$tables['questions'] . " `q`
					LEFT JOIN " . Scholar::$tables['difficulties'] . " `d` ON `q`.`difficulty_id` = `d`.`id`
					LEFT JOIN " . Scholar::$tables['areas'] . " `a` ON `q`.`area_id` = `a`.`id`					
					LEFT JOIN " . Scholar::$tables['answers'] . " `a1` ON `q`.`id` = `a1`.`question_id`
					{$where}
					GROUP BY 1, 2, 3;";
		
		return $wpdb->get_results($sql);		
	}
	
	public static function tests($area_id = 0){
		global $wpdb;
		
		$where = '';
		if($area_id > 0){
			$where = "WHERE `t`.`area_id` = " . (int)$area_id;
		}
		
		$sql = "SELECT `t`.*, `a`.`area`
					FROM " . Scholar::$tables['tests'] . " `t`
					LEFT JOIN " . Scholar::$tables['areas'] . " `a` ON `t`.`area_id` = `a`.`id`
					{$where}
					ORDER BY uid DESC;";
		return $wpdb->get_results($sql);		
	}	

	public static function testsSolved($test_id = 0){
		global $wpdb;
		$result = array();
		if($test_id > 0){
			$sql = $wpdb->prepare("SELECT `ta`.`test_id`, `ta`.`student_id`, `t`.`uid`, `t`.`name`
	FROM " . Scholar::$tables['tests_answered'] . " `ta`
	LEFT JOIN " . Scholar::$tables['tests'] . " `t` ON `ta`.`test_id` = `t`.`id`
	WHERE `t`.`id` = %d
	GROUP BY 1, 2, 3, 4;",
				(int)$test_id
			);
			$result = $wpdb->get_results($sql);
		}
		return $result;
	}
	
	public static function testView($test_id = 0){
		global $wpdb;
		$result = array();
		if($test_id > 0){
			$sql = $wpdb->prepare("SELECT `t`.*, `ta`.`correct`, `q`.`id` AS `question_id`, `q`.`question`, `a`.`answer`, `a`.`id` AS `answer_id`
	FROM " . Scholar::$tables['tests'] . " `t`
	LEFT JOIN  " . Scholar::$tables['tests_answers'] . " `ta` ON `t`.`id` = `ta`.`test_id`
	LEFT JOIN  " . Scholar::$tables['answers'] . " `a` ON `ta`.`answer_id` = `a`.`id`						
	LEFT JOIN  " . Scholar::$tables['questions'] . " `q` ON `a`.`question_id` = `q`.`id`
	WHERE `t`.`id` = %d
	ORDER BY uid DESC;",
				(int)$test_id
			);
			$result = $wpdb->get_results($sql);
		}
		return $result;		
	}	
	
	public static function test(){
		global $wpdb;
		$result = array(stdClass);
		if(isset($_POST['test_id']) && trim((string)$_POST['name']) != ''){
			if((int)$_POST['test_id'] > 0){
			}else{
				$wpdb->insert(
					Scholar::$tables['tests'],
					array(
						'uid' => Date('YmdHis') . rand(100, 999),
						'name' => $_POST['name'],
						'time_to_solve' => (int)$_POST['time_to_solve'],
						'user_id' => (int)get_current_user_id(),
						'area_id' => (int)$_POST['area'],
					)	
				);
				$id = $wpdb->insert_id;
				$difficulties = Html::getDifficulties();
				$questions = array();
				$test_questions = array();
				$answers = array();
				$questions_count = (int)$_POST['questions'];
				$answers_count = (int)$_POST['answers'];
				foreach($difficulties as $difficulty){
					$sql = $wpdb->prepare("SELECT *, RAND() AS `rand` FROM " . Scholar::$tables['questions'] . " WHERE area_id = %d AND difficulty_id = %d ORDER BY `rand` ASC;", 
						(int)$_POST['area'],
						(int)$difficulty->value
					);
					$questions[$difficulty->value] = $wpdb->get_results($sql);
					
					$count = 0;
					foreach($questions[$difficulty->value] as $key => $val){
						$correct_answers = $wpdb->get_results(
							$wpdb->prepare("SELECT `id`, `correct`, RAND() AS `rand` FROM " . Scholar::$tables['answers'] . " WHERE question_id = %d AND correct = 1 ORDER BY `rand`;",
								(int)$val->id
							)
						);
						if(count($correct_answers) == 0){
							//Този въпрос няма въведен правилен отговор 
							continue;
						}
						$test_questions[(int)$val->id] = $val;
						$answers[(int)$val->id] = array();
						$incorrect_answers = $wpdb->get_results(
							$wpdb->prepare("SELECT `id`, `correct`, RAND() AS `rand` FROM " . Scholar::$tables['answers'] . " WHERE question_id = %d AND correct = 0 ORDER BY `rand`;",
								(int)$val->id
							)
						);
						$answers[(int)$val->id][] = $correct_answers[0];
						for($i = 0; $i < $answers_count - 1; $i++){
							if(isset($incorrect_answers[$i])){
								$answers[(int)$val->id][] = $incorrect_answers[$i];
							}else{
								break;
							}
						}
						shuffle($answers[(int)$val->id]);
						$count ++;
						if($count >= $questions_count){
							break;
						}
					}
				}
				shuffle($test_questions);
				foreach($test_questions as $val){
					foreach($answers[$val->id] as $val2){
						$wpdb->insert(
							Scholar::$tables['tests_answers'],
							array(
								'test_id' => (int)$id,
								'answer_id' => (int)$val2->id,
								'correct' => (int)$val2->correct
							)
						);
					}
				}
			}
		}
		if(isset($_GET['id']) && $_GET['id'] > 0){
			$sql = $wpdb->prepare("SELECT *
						FROM " . Scholar::$tables['tests'] . "
						WHERE id = %d
						ORDER BY uid DESC;",
						(int)$_GET['id']
					);
			$result = $wpdb->get_results($sql);		
		}
		return $result;
	}	
	
	//Създава пост в WP по уникалния номер на теста и номера на ученика, ако още не е създаден
	//Грижи се за пренасочване на линка към новия пост
	public static function createTestForStudent(){
		global $wp, $post, $wpdb;
		require_once( ABSPATH . 'wp-admin/includes/post.php' );

		$current_url = home_url( $wp->request );
		$test_url = str_ireplace(home_url() . '/tests/', '', $current_url);
		$test_url_arr = explode('-', $test_url);

		$student_id = get_current_user_id();
		$post_name = $test_url_arr[0] . '-' . get_current_user_id();

		$test_data = static::testData($test_url_arr[0]);
		if (count($test_data) > 0){
			if (! is_user_logged_in()) {
				auth_redirect();
				exit();
			}			
			$sql = $wpdb->prepare(
				"SELECT `ID` FROM " . $wpdb->posts . "
				WHERE `post_name` = %s
				AND `post_type` = 'tests'",
				$post_name
			);
			$result = $wpdb->get_results($sql);
			
			if(count($result) == 0){
				$my_post = array(
				  'post_title'    => $test_data[0]->name . ', ученик: ' . get_userdata(get_current_user_id())->display_name,
				  'post_content'  => 'content',
				  'post_status'   => 'publish',
				  'post_author'   => $test_data[0]->user_id,
				  'post_type' => 'tests',
				  'post_name' => $post_name,
				  'comment_status' => 'open'
				);

				wp_insert_post( $my_post );
				wp_safe_redirect(home_url() . '/tests/' . $post_name . '/');
				exit();
			}
			
			if($test_url != $post_name && ! current_user_can( 'edit_posts' )){
				wp_safe_redirect(home_url() . '/tests/' . $post_name . '/');
				exit();
			}
		}
		return true;
	}
	
	public static function testUIDByURL(){
		global $wp;
		$current_url = home_url( $wp->request );
		$test_url = str_ireplace(home_url() . '/tests/', '', $current_url);
		$test_url_arr = explode('-', $test_url);

		return $test_url_arr[0];
	}
	
	public static function getUserIDByTestURL(){
		global $wp;
		$current_url = home_url( $wp->request );
		$test_url = str_ireplace(home_url() . '/tests/', '', $current_url);
		$test_url_arr = explode('-', $test_url);
		
		return (count($test_url_arr) > 1 ? $test_url_arr[1] : 0);
	}	
	
	public static function testData($test_uid = ''){
		global $wpdb;
		$sql = $wpdb->prepare("SELECT `id`, `uid`, `name`, `user_id`, `time_to_solve` FROM " . Scholar::$tables['tests'] . " WHERE `uid` = %s",
			$test_uid
		);
		$result = $wpdb->get_results($sql)	;
		return $result;
	}
	
	public static function answeredQuestions($test_id = 0){
		global $wpdb;
		$return = array();
		
		$user_id = get_current_user_id();
		if(current_user_can( 'edit_posts' ) ){
			$user_id = static::getUserIDByTestURL();
		}
		
		if($test_id > 0){
			$sql = $wpdb->prepare("SELECT `ta`.* FROM " . Scholar::$tables['tests_answered'] . " `ta` WHERE `test_id` = %d AND `student_id` = %d AND `question_id` <> 0;",
				(int)$test_id,
				(int)$user_id
			);
			$result = $wpdb->get_results($sql);
			foreach($result as $val){
				$return[$val->question_id] = $val->answer_id;
			}
		}
		return $return;
	}
	
	//Връща кога е започнат теста и текущото време на SQL сървъра
	//Ако тестът не е започнат, връща FALSE
	public static function testStartDate($test_id = 0){
		global $wpdb;
		
		$user_id = get_current_user_id();
		if(current_user_can( 'edit_posts' ) ){
			$user_id = static::getUserIDByTestURL();
		}
		
		if($test_id > 0){
			$sql = $wpdb->prepare("SELECT MIN(`question_id`) AS `question_id`, MIN(UNIX_TIMESTAMP(`opened`)) AS `opened`, UNIX_TIMESTAMP(NOW()) AS `now` FROM " . Scholar::$tables['tests_answered'] . " WHERE `test_id` = %d AND `student_id` = %d LIMIT 1;",
				(int)$test_id,
				(int)$user_id
			);
			$result = $wpdb->get_results($sql);
			
			if(count($result) > 0){
				if($result[0]->opened !== null){
					if($result[0]->question_id == 0){
						$result[0]->opened = 0;
					}
					return $result[0];
				}
			}
		}
		return false;
	}
	
	public static function startTest($test_id = 0){
		global $wpdb;
		if(! static::testStartDate($test_id)){
			$test_data = static::testView($test_id);
			$last_question_id = 0;
			foreach($test_data as $val){
				if($val->question_id != $last_question_id){
					$wpdb->insert(
						Scholar::$tables['tests_answered'],
						array(
							'test_id' => $test_id,
							'student_id' => (int)get_current_user_id(),
							'question_id' => $val->question_id,
							'answer_id' => 0
						)
					);
					$last_question_id = $val->question_id;
				}
			}
		}
	}
	static function saveAnswers($data){
		global $wpdb;
		$test_data = static::testData($data['test_uid']);
		foreach($data['data']['answer'] as $key => $val){
			$answer_data = array(
				'test_data' => $test_data,
				'answer_id' => (int)$val,
				'question_id' => (int)$key
			);
			static::saveAnswer($data);
		}
		
		$wpdb->insert(
			Scholar::$tables['tests_answered'],
			array(
				'test_id' => $test_data[0]->id,
				'student_id' => (int)get_current_user_id(),
				'question_id' => 0,
				'answer_id' => 0
			)
		);
	}
	
	static function saveAnswer($data){
		global $wpdb;
		if(isset($data['test_data'])){
			$test_data = $data['test_data'];
		}else{
			$test_data = static::testData($data['test_uid']);
		}
		$data['test_id'] = $test_data[0]->id;
		
		$sql = $wpdb->prepare("UPDATE " . Scholar::$tables['tests_answered'] . "
	SET 
		`answer_id` = %d,
		`solved` = NOW()
	WHERE
		`test_id` = %d AND
		`student_id` = %d AND
		`question_id` = %d AND
		`opened` >= DATE_ADD(NOW(), INTERVAL '-%d' MINUTE);",
			(int)$data['answer_id'],
			(int)$data['test_id'],
			(int)get_current_user_id(),
			(int)$data['question_id'],
			(int)$test_data[0]->time_to_solve
		);
		
		return $wpdb->query($sql);

	}
}