<?php
/**
 * RoseMary Framework: strings manipulations
 *
 * @package	rosemary
 * @since	rosemary 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Check multibyte functions
if ( ! defined( 'ROSEMARY_MULTIBYTE' ) ) define( 'ROSEMARY_MULTIBYTE', function_exists('mb_strpos') ? 'UTF-8' : false );

if (!function_exists('rosemary_strlen')) {
	function rosemary_strlen($text) {
		return ROSEMARY_MULTIBYTE ? mb_strlen($text) : strlen($text);
	}
}

if (!function_exists('rosemary_strpos')) {
	function rosemary_strpos($text, $char, $from=0) {
		return ROSEMARY_MULTIBYTE ? mb_strpos($text, $char, $from) : strpos($text, $char, $from);
	}
}

if (!function_exists('rosemary_strrpos')) {
	function rosemary_strrpos($text, $char, $from=0) {
		return ROSEMARY_MULTIBYTE ? mb_strrpos($text, $char, $from) : strrpos($text, $char, $from);
	}
}

if (!function_exists('rosemary_substr')) {
	function rosemary_substr($text, $from, $len=-999999) {
		if ($len==-999999) { 
			if ($from < 0)
				$len = -$from; 
			else
				$len = rosemary_strlen($text)-$from;
		}
		return ROSEMARY_MULTIBYTE ? mb_substr($text, $from, $len) : substr($text, $from, $len);
	}
}

if (!function_exists('rosemary_strtolower')) {
	function rosemary_strtolower($text) {
		return ROSEMARY_MULTIBYTE ? mb_strtolower($text) : strtolower($text);
	}
}

if (!function_exists('rosemary_strtoupper')) {
	function rosemary_strtoupper($text) {
		return ROSEMARY_MULTIBYTE ? mb_strtoupper($text) : strtoupper($text);
	}
}

if (!function_exists('rosemary_strtoproper')) {
	function rosemary_strtoproper($text) {
		$rez = ''; $last = ' ';
		for ($i=0; $i<rosemary_strlen($text); $i++) {
			$ch = rosemary_substr($text, $i, 1);
			$rez .= rosemary_strpos(' .,:;?!()[]{}+=', $last)!==false ? rosemary_strtoupper($ch) : rosemary_strtolower($ch);
			$last = $ch;
		}
		return $rez;
	}
}

if (!function_exists('rosemary_strrepeat')) {
	function rosemary_strrepeat($str, $n) {
		$rez = '';
		for ($i=0; $i<$n; $i++)
			$rez .= $str;
		return $rez;
	}
}

if (!function_exists('rosemary_strshort')) {
	function rosemary_strshort($str, $maxlength, $add='...') {
	//	if ($add && rosemary_substr($add, 0, 1) != ' ')
	//		$add .= ' ';
		if ($maxlength < 0) 
			return $str;
		if ($maxlength < 1 || $maxlength >= rosemary_strlen($str))
			return strip_tags($str);
		$str = rosemary_substr(strip_tags($str), 0, $maxlength - rosemary_strlen($add));
		$ch = rosemary_substr($str, $maxlength - rosemary_strlen($add), 1);
		if ($ch != ' ') {
			for ($i = rosemary_strlen($str) - 1; $i > 0; $i--)
				if (rosemary_substr($str, $i, 1) == ' ') break;
			$str = trim(rosemary_substr($str, 0, $i));
		}
		if (!empty($str) && rosemary_strpos(',.:;-', rosemary_substr($str, -1))!==false) $str = rosemary_substr($str, 0, -1);
		return ($str) . ($add);
	}
}

// Clear string from spaces, line breaks and tags (only around text)
if (!function_exists('rosemary_strclear')) {
	function rosemary_strclear($text, $tags=array()) {
		if (empty($text)) return $text;
		if (!is_array($tags)) {
			if ($tags != '')
				$tags = explode($tags, ',');
			else
				$tags = array();
		}
		$text = trim(chop($text));
		if (is_array($tags) && count($tags) > 0) {
			foreach ($tags as $tag) {
				$open  = '<'.esc_attr($tag);
				$close = '</'.esc_attr($tag).'>';
				if (rosemary_substr($text, 0, rosemary_strlen($open))==$open) {
					$pos = rosemary_strpos($text, '>');
					if ($pos!==false) $text = rosemary_substr($text, $pos+1);
				}
				if (rosemary_substr($text, -rosemary_strlen($close))==$close) $text = rosemary_substr($text, 0, rosemary_strlen($text) - rosemary_strlen($close));
				$text = trim(chop($text));
			}
		}
		return $text;
	}
}

// Return slug for the any title string
if (!function_exists('rosemary_get_slug')) {
	function rosemary_get_slug($title) {
		return rosemary_strtolower(str_replace(array('\\','/','-',' ','.'), '_', $title));
	}
}

// Replace macros in the string
if (!function_exists('rosemary_strmacros')) {
	function rosemary_strmacros($str) {
		return str_replace(array("{{", "}}", "((", "))", "||"), array("<i>", "</i>", "<b>", "</b>", "<br>"), $str);
	}
}

// Unserialize string (try replace \n with \r\n)
if (!function_exists('rosemary_unserialize')) {
	function rosemary_unserialize($str) {
		if ( is_serialized($str) ) {
			try {
				$data = unserialize($str);
			} catch (Exception $e) {
				dcl($e->getMessage());
				$data = false;
			}
			if ($data===false) {
				try {
					$data = @unserialize(str_replace("\n", "\r\n", $str));
				} catch (Exception $e) {
					dcl($e->getMessage());
					$data = false;
				}
			}
			//if ($data===false) $data = @unserialize(str_replace(array("\n", "\r"), array('\\n','\\r'), $str));
			return $data;
		} else
			return $str;
	}
}
?>