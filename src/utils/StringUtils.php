<?php
class StringUtils
{
	/**
	 * This class should not be instantiated
	 */
	private function __construct() {}

	/**
	 * Removes whitespace chars from left, right and inside a string
	 *
	 * @param string $str Input string
	 * @return string
	 * @static
	 */
	public static function allTrim($str) {
		return StringUtils::stripBlank(trim($str));
	}

	/**
	 * Replaces 2 or more whitespace chars in a string
	 *
	 * @param string $str Input string
	 * @param string $replace Replacement string
	 * @return string
	 * @static
	 */
	public static function stripBlank($str, $replace=' ') {
		return ereg_replace("[[:blank:]]{1,}", $replace, $str);
	}

	/**
	 * Get $n chars from the left side of a string
	 *
	 * @param string $str Input string
	 * @param int $n Number of chars
	 * @return string
	 * @static
	 */
	public static function left($str, $n=0) {
		if (!TypeUtils::isInteger($n))
		return $str;
		if ($n == 0)
		return '';
		return substr($str, 0, $n);
	}

	/**
	 * Get $n chars from the right side of a string
	 *
	 * @param string $str Input string
	 * @param int $n Number of chars
	 * @return string
	 * @static
	 */
	public static function right($str, $n=0) {
		if (!TypeUtils::isInteger($n))
		return $str;
		if ($n == 0)
		return '';
		return substr($str, strlen($str) - $n, strlen($str)-1);
	}

	/**
	 * Reads a portion of a string, start at $startAt
	 *
	 * The start index is 1-based. Example:
	 * <code>
	 * $sb = new String Buffer('hello world');
	 * /* prints "hello" {@*}
	 * print $sb->mid(1, 5);
	 * </code>
	 *
	 * @param string $str Input string
	 * @param int $startAt Start index
	 * @param int $chars Substring length
	 * @return string
	 * @static
	 */
	public static function mid($str, $startAt=1, $chars=0) {
		if (!TypeUtils::isInteger($chars))
		return $str;
		if ($str == '' || $chars == 0)
		return '';
		if (($startAt + $chars) > strlen($str))
		return $str;
		if ($startAt == 0) $startAt = 1;
		return substr($str, $startAt-1, $chars);
	}

	/**
	 * Reads a char from a string
	 *
	 * @param string $str Input string
	 * @param int $index Char index
	 * @return string
	 * @static
	 */
	public static function charAt($str, $index) {
		if (!TypeUtils::isInteger($index))
		return '';
		if ($str == '' || $index < 0 || $index >= strlen($str))
		return '';
		$strTranslated = strval($str);
		return $strTranslated[$index];
	}

	/**
	 * Checks if a value is present in a given string
	 *
	 * @param string $str Input string
	 * @param string $search Search value
	 * @param bool $caseSensitive Whether to do case sensitive search
	 * @return bool
	 * @static
	 */
	public static function match($str, $search, $caseSensitive=TRUE) {
		if (!$caseSensitive) $search = strtolower($search);
		if (strlen($search) == 0) {
			return FALSE;
		} else {
			$pos = strpos($str, $search);
			return ($pos !== FALSE);
		}
	}

	/**
	 * Checks if a given string starts with a given value
	 *
	 * @param string $str Input string
	 * @param string $slice Comparison value
	 * @param bool $caseSensitive Case sensitive?
	 * @param bool $ignSpaces Ignore initial whitespace chars
	 * @return bool
	 * @static
	 */
	public static function startsWith($str, $slice, $caseSensitive=TRUE, $ignSpaces=TRUE) {
		if (!$caseSensitive) {
			$strUsed = ($ignSpaces) ? ltrim(strtolower($str)) : strtolower($str);
			$sliceUsed = strtolower($slice);
		} else {
			$strUsed = ($ignSpaces) ? ltrim($str) : $str;
			$sliceUsed = $slice;
		}
		return (StringUtils::left($strUsed, strlen($sliceUsed)) == $sliceUsed);
	}

	/**
	 * Checks if a given string ends with a given value
	 *
	 * @param string $str Input string
	 * @param string $slice Comparison value
	 * @param bool $caseSensitive Case sensitive?
	 * @param bool $ignSpaces Ignore initial whitespace chars
	 * @return bool
	 * @static
	 */
	public static function endsWith($str, $slice, $caseSensitive=TRUE, $ignSpaces=TRUE) {
		if (!$caseSensitive) {
			$strUsed = ($ignSpaces) ? rtrim(strtolower($str)) : strtolower($str);
			$sliceUsed = strtolower($slice);
		} else {
			$strUsed = ($ignSpaces) ? rtrim($str) : $str;
			$sliceUsed = $slice;
		}
		return (StringUtils::right($strUsed, strlen($sliceUsed)) == $sliceUsed);
	}

	/**
	 * Checks if a string is composed only by uppercase chars
	 *
	 * @param string $str Input string
	 * @return bool
	 * @static
	 */
	public static function isAllUpper($str) {
		return (preg_match("/[a-z]/", $str) !== FALSE);
	}

	/**
	 * Checks if a string is composed only by lowercase chars
	 *
	 * @param string $str Input string
	 * @return bool
	 * @static
	 */
	public static function isAllLower($str) {
		return (preg_match("/[A-Z]/", $str) !== FALSE);
	}

	/**
	 * Safely checks if a string is empty
	 *
	 * A string will be considered empty when its length
	 * is 0 and a call to the {@link empty()} public static function
	 * returns TRUE.
	 *
	 * @param string $str Input string
	 * @return bool
	 * @static
	 */
	public static function isEmpty($str) {
		$str = strval($str);
		return (empty($str) && strlen($str) == 0);
	}
	
	/**
	 * Safely checks if a string is blank
	 *
	 * A string will be considered empty when its length
	 * is 0 and a call to the {@link empty()} public static function
	 * returns TRUE.
	 *
	 * @param string $str Input string
	 * @return bool
	 * @static
	 */
	public static function isBlank($str) {
		$str = strval($str);
		return (empty($str) && strlen(trim($str)) == 0);
	}

	/**
	 * Returns a fallback value when a given string is empty
	 *
	 * @param string $str Input string
	 * @param string $replacement Fallback string
	 * @return string
	 * @static
	 */
	public static function ifEmpty($str, $replacement) {
		return (StringUtils::isEmpty($str) ? $replacement : $str);
	}
	
	/**
	 * Returns a fallback value when a given string is blank
	 *
	 * @param string $str Input string
	 * @param string $replacement Fallback string
	 * @return string
	 * @static
	 */
	public static function ifBlank($str, $replacement) {
		return (StringUtils::isBlank($str) ? $replacement : $str);
	}
	
	/**
	 * Replaces all occurrences of $from by $to in a given string
	 *
	 * @param string $str Input string
	 * @param string $from Search
	 * @param string $to Replace
	 * @return string
	 * @static
	 */
	public static function replace($str, $from, $to) {
		return str_replace($from, $to, $str);
	}

	/**
	 * Performs a regular expression search and replace on a string
	 *
	 * @param string $str Input string
	 * @param string $pattern PCRE pattern
	 * @param string $replacement Replacement
	 * @return string
	 * @static
	 */
	public static function regexReplace($str, $pattern, $replacement) {
		if (empty($pattern))
		return $str;
		$matches = array();
		if (preg_match('!\W(\w+)$!s', $pattern, $matches) && (strpos($matches[1], 'e') !== FALSE))
		$pattern = substr($pattern, 0, -strlen($matches[1])) . str_replace('e', '', $matches[1]);
		return preg_replace($pattern, $replacement, $str);
	}
	
	/**
	 * format phoneNumber
	 * 
	 * @param String $phoneNumber
	 * @param String $international
	 * @return String
	 */
	public static function formatFrenchPhoneNumber($phoneNumber, $international = false){
		//Supprimer tous les caractères qui ne sont pas des chiffres
		$phoneNumber = preg_replace('/[^0-9]+/', '', $phoneNumber);
		//Garder les 9 derniers chiffres
		$phoneNumber = substr($phoneNumber, -9);
		//On ajoute +33 si la variable $international vaut true et 0 dans tous les autres cas
		$motif = $international ? '+33 (\1) \2 \3 \4 \5' : '0\1 \2 \3 \4 \5';
		$phoneNumber = preg_replace('/(\d{1})(\d{2})(\d{2})(\d{2})(\d{2})/', $motif, $phoneNumber);
		
		return $phoneNumber;
	}
}
?>