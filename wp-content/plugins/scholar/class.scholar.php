<?php
//Управление на плъгина и навигацията му
class Scholar {
	public static $scholar_db_version = '1.0';
	public static $view_content = array();
	public static $table_prefix = 'sc1_';
	public static $tables = array(
		'answers' => '',
		'areas' => '',
		'difficulties' => '',
		'questions' => '',
		'tests' => '',
		'tests_answered' => '',
		'tests_answers' => ''
	);
	public static $wpdb;

	public static function init(){
		global $wpdb;
		static::$wpdb = $wpdb;
		static::$table_prefix = static::$wpdb->prefix . static::$table_prefix;
		foreach(static::$tables as $key => $val){
			static::$tables[$key] = static::$table_prefix . $key;
		}
		
		define( 'SCHOLAR__VIEWS_DIR', realpath( SCHOLAR__PLUGIN_DIR . 'views') );
		require_once( SCHOLAR__PLUGIN_DIR . 'class.html.php' );
		
	}
	
	public static function plugin_activation() {
		//Регистриране на функция за добавяне на точки в менюто
		add_action( 'admin_menu', array('Scholar', 'scholar_menu') );
	}

	
	//Създаване на новите таблици в базата при първоначална активация на плъгина
	public static function ssql_install() {
		global $wpdb;

		//Име на таблицата 
		//$wpdb->prefix - префикс на таблиците на текушата инсталация
		$prefix = static::$table_prefix;
		
		//Колация на базата данни
		$collate = $wpdb->get_charset_collate();

		require_once( SCHOLAR__PLUGIN_DIR . 'db.php' );
		$sql_arr = explode(';', $sql);
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		
		foreach($sql_arr as $sql){
			if(trim($sql) != ''){
				dbDelta( $sql );
			}
		}

		add_option( 'scholar_db_version', static::$scholar_db_version );
		
		$difficulties = array(
			1 => 1,
			2 => 2,
			3 => 4,
			4 => 8
		);
		foreach($difficulties as $key => $val){
			$wpdb->insert( 
				static::$tables['difficulties'],
				array( 
					'id' => $key, 
					'weight' => $val
				) 
			);
		}
		
		$areas = array(
			1 => 'Математика',
			2 => 'БЕЛ',
			3 => 'Физика',
			4 => 'История',
			5 => 'География',
			6 => 'Химия'
		);
		
		foreach($areas as $key => $val){
			$wpdb->insert( 
				static::$tables['areas'],
				array( 
					'id' => $key, 
					'area' => $val
				) 
			);
		}		
	}
	
	//Функция за добавяне на точки в менюто
	public static function scholar_menu() {
		add_menu_page('Scholar', 'Scholar', 'edit_posts', 'scholar',  array('Scholar', 'scholar_main'), plugins_url('t.gif', __FILE__), 10);
		add_submenu_page('scholar', 'Въпроси / отговори', 'Въпроси / отговори', 'edit_posts', 'questions',  array('Scholar', 'scholar_questions'));
		add_submenu_page('scholar', 'Добавяне въпрос', 'Добавяне на въпрос', 'edit_posts', 'questions_add', array('Scholar', 'scholar_questions_add'));
		add_submenu_page('scholar', 'Тестове', 'Тестове', 'edit_posts', 'scholar_tests', array('Scholar', 'scholar_tests'));		
		add_submenu_page('scholar', 'Добавяне на тестове', 'Добавяне на тестове', 'edit_posts', 'scholar_tests_add', array('Scholar', 'scholar_tests_add'));	}
	
	public static function scholar_main() {
		if ( !current_user_can( 'edit_posts' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
		static::$view_content['arr'] = array(1,2,3);
		//Взима изглед с името на функцията
		static::renderView(__FUNCTION__);
	}

	public static function scholar_questions() {
		if ( !current_user_can( 'edit_posts' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
		static::$view_content['questions'] = Processor::questions((int)@$_GET['area']);
		static::renderView(__FUNCTION__);
	}

	public static function scholar_questions_add() {
		if ( !current_user_can( 'edit_posts' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
		static::$view_content['form_data'] = Processor::addQuestion();
		//Взима изглед с името на функцията
		static::renderView(__FUNCTION__);
	}	

	public static function scholar_tests() {
		if ( !current_user_can( 'edit_posts' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
		$action = strtolower(@$_GET['action']);
		switch($action){
			case 'view':
				$view = __FUNCTION__ . '_view';
				static::$view_content['tests'] = Processor::testView((int)@$_GET['id']);
				break;
			case 'correct':
				$view = __FUNCTION__ . '_correct';
				static::$view_content['tests'] = Processor::testView((int)@$_GET['id']);
				break;
			case 'solved':
				$view = __FUNCTION__ . '_solved';
				static::$view_content['tests'] = Processor::testsSolved((int)@$_GET['id']);
				break;
			default:
				$view = __FUNCTION__;
				static::$view_content['tests'] = Processor::tests((int)@$_GET['area']);
		}

		static::renderView($view);
	}	

	public static function scholar_tests_add() {
		if ( !current_user_can( 'edit_posts' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
		static::$view_content['tets'] = Processor::test();
		//Взима изглед с името на функцията
		static::renderView(__FUNCTION__);
	}	
	
	//Връща резултата от изпълнен изглед
	public static function includeView($view_file){
		ob_start();
		require(SCHOLAR__VIEWS_DIR . '/' . $view_file . '.php');
		return ob_get_clean();
	}
	
	//Взима резултата от изпълнен индекс и го включва в основен темплейт
	public static function renderView($view_file, $template_file = 'scholar_main_template'){
		$content = static::includeView($view_file);
		require( SCHOLAR__VIEWS_DIR . '/' . $template_file . '.php');

	}
	
	public static function scholar_ajax_save_answer() {
		if(get_current_user_id() > 0){
			echo Processor::saveAnswer($_POST['data']);
		}
		wp_die();
	}
	
}