<?php

class Html {
	public static function options($options = array(), $value = ''){
		$result = array();
		foreach($options as $key => $val){
			$result[] = '<option value="' . $val->value . '"' . ($val->value == $value ? ' selected="selected"' : '') . '>' . $val->text . '</option>';
		}
		return implode(PHP_EOL, $result);
	}
	
	public static function optionsArr($options = array(), $value = ''){
		$opt = array();
		foreach($options as $key => $val){
			$opt[] = (object)array('value' => $key, 'text' => $val);
		}
		return static::options($opt, $value);
	}
	
	public static function getDifficulties(){
		$sql = "SELECT `id` AS `value`, `weight` AS `text` FROM " . Scholar::$tables['difficulties'] . " ORDER BY `weight`;";
		$result = Scholar::$wpdb->get_results($sql);
		
		return $result;
	}
	
	public static function getAreas(){
		$sql = "SELECT `id` AS `value`, `area` AS `text` FROM " . Scholar::$tables['areas'] . " ORDER BY `area`;";
		$result = Scholar::$wpdb->get_results($sql);
		
		return $result;
	}	
}