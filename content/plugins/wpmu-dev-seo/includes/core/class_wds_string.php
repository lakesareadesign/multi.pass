<?php

class WDS_String {

	const READABILITY_FLESCH = 'flesch';
	const READABILITY_KINCAID = 'kincaid';

	/**
	 * Converts string to lowercase version
	 *
	 * @param string $str String to process
	 *
	 * @return string Lowercased string
	 */
	public static function lowercase ($str='') {
		if (empty($str)) return '';

		return function_exists('mb_strtolower')
			? mb_strtolower($str)
			: strtolower($str)
		;
	}

	/**
	 * Converts string to uppercase version
	 *
	 * @param string $str String to process
	 *
	 * @return string Uppercased string
	 */
	public static function uppercase ($str='') {
		if (empty($str)) return '';

		return function_exists('mb_strtoupper')
			? mb_strtoupper($str)
			: strtoupper($str)
		;
	}

	/**
	 * Counts letters in a string
	 *
	 * @param string $str String to count
	 *
	 * @return int Letter count
	 */
	public static function len ($str='') {
		if (empty($str)) return 0;

		$vals = array();
		return preg_match_all('/./u', $str, $vals);
	}

	/**
     * Unicode-safe substr() port.
     * Works just like substr(), except that it handles Unicode strings better.
     *
     * @param string s String to extract from
     * @param int start Where to start substring extraction (optional)
     * @param int length Substring length (optional)
	 *
	 * @return string Extracted substring
     */
    public static function substr ($str, $start=0, $length=false) {
		$start = (int)$start;
		$length = (int)$length;
		$total = self::len($str);

        if (!$length) $length = $total;
        $max_len = $total - $start;
        if ($length > $max_len) $length = $max_len;

		return $start
			? preg_replace ('/^.{'.$start.'}(.{'.$length.'}).*$/mu', '\1', $str)
			: preg_replace ('/^(.{'.$length.'}).*$/mu', '\1', $str)
		;
    }

	/**
	 * Extracts sentences from text
	 *
	 * @param string $text Text to process
	 * @param bool $preserve_punctuation Whether to preserve sentence delimiters (defaults to no)
	 *
	 * @return array List of recognized sentences
	 */
	public static function sentences ($text, $preserve_punctuation=false) {
		if (empty($text)) return array();
		$raw = preg_split('/([?.!]+)/', $text, null, PREG_SPLIT_DELIM_CAPTURE|PREG_SPLIT_NO_EMPTY);
		$len = count($raw);
		$sentences = array();

		for ($i=1; $i <= $len; $i+=2) {
			$current = $i-1;
			$snt = isset($raw[$current]) ? $raw[$current] : false;
			if (!$snt) continue;

			$snt = preg_replace('/(^\s+|\s+$)/', '', $snt);
			if ($preserve_punctuation) $snt .= $raw[$i];

			$sentences[] = $snt;
		}

		return $sentences;
	}

	/**
	 * Normalizes newlines in text
	 *
	 * @param string $str Text to process
	 *
	 * @return string Normalized text
	 */
	public static function normalize_newlines ($str) {
		return preg_replace('/(\r\n|\r|\n)/', "\n", $str);
	}

	/**
	 * Extracts paragrapsh from text
	 *
	 * @param string $text Text to process
	 *
	 * @return array List of recognized paragraphs
	 */
	public static function paragraphs ($text='') {
		if (empty($text)) return array();
		$paragraphs = array();

		$raw = preg_split('/\n/', self::normalize_newlines($text), null, PREG_SPLIT_NO_EMPTY);
		foreach ($raw as $para) {
			$para = preg_replace('/(^\s+|\s+$)/', '', $para);
			if (!preg_match('/[[:punct:]]$/', $para)) $para .= '.';
			$paragraphs[] = $para;
		}

		return $paragraphs;
	}

	/**
	 * Extracts words from text
	 *
	 * @param string $text Text to process
	 *
	 * @return array Recognized normalized words
	 */
	public static function words ($text='') {
		$words = array();

		if (empty($text)) return $words;
		$text = join(' ', self::paragraphs($text));

		$text = preg_replace('/[^ [:alnum:]]/iu', '', self::lowercase($text));
		$words = array_filter(explode(' ', $text));

		return $words;
	}

	/**
	 * Returns approximate number of syllables
	 *
	 * Very simplistic implementation.
	 *
	 * @param string $text Text to process
	 *
	 * @return int Positive integer on success, or:
	 *             -1 for empty string
	 *             -2 for encoding issue
	 */
	public static function syllables_count ($text) {
		$syls = array();

		if (empty($text)) return -1;
		$words = self::words($text);

		foreach ($words as $word) {
			$word = preg_replace('/[^a-z]/', '', $word);
			if (empty($word)) continue; // Nothing here

			$word = preg_replace('/^[aeiouy]|[aeiouy]$/', '', $word);
			$tmp = preg_split('/[aeiouy]+/', $word, null, PREG_SPLIT_NO_EMPTY);
			if (2 === count($tmp) && strlen($word) <= 4) $tmp = array($word); // Simple threshold approximation
			$syls = array_merge($syls, $tmp);
		}
		if (count($syls) === 0 /*|| count($syls) === count($words)*/) return -2; // Well that didn't work

		return count($syls);
	}

	/**
	 * Calculates readability score
	 *
	 * @param string $text Text to process
	 * @param string $strategy Strategy to use
	 *
	 * @return float|bool Readability score as float, or (bool)false o failure
	 */
	public static function readability_score ($text, $strategy=false) {
		$score = 0.0;
		$error = false;

		if (empty($text)) return $error;
		if (empty($strategy)) $strategy = self::get_readability_strategy();

		$sentences = self::sentences($text);
		if (empty($sentences)) return $error;

		$words = self::words($text);
		if (empty($words)) return $error;

		$syllables = self::syllables_count($text);
		if ($syllables <= 0) return $error;

		if (count($sentences) > count($words)) return $error; // WTF
		$asl = count($words) / count($sentences);

		if (count($words) > $syllables) return $error; // WTF
		$asw = $syllables / count($words);

		$score = self::READABILITY_FLESCH === $strategy
			// http://www.readabilityformulas.com/flesch-grade-level-readability-formula.php
			? ((0.39 * $asl) + (11.8 * $asw)) - 15.59
			// http://www.readabilityformulas.com/flesch-reading-ease-readability-formula.php
			: 206.835 - (1.015 * $asl) - (84.6 * $asw)
		;

		return $score;
	}

	/**
	 * Decides on readability strategy
	 *
	 * @return string
	 */
	public static function get_readability_strategy () {
		return apply_filters(
			'wds-string-readability_strategy',
			self::READABILITY_KINCAID
		);
	}

	/**
	 * Checks if a given string contains stopwords
	 *
	 * @param string $str String to check
	 *
	 * @return bool
	 */
	public static function has_stopwords ($str) {
		$has = false;
		$stops = self::get_stopwords();
		$words = self::words($str);

		foreach ($words as $word) {
			if (!in_array($word, $stops)) continue;
			$has = true;
			break;
		}

		return $has;
	}

	/**
	 * Gets a list of english language stopwords
	 *
	 * http://xpo6.com/list-of-english-stop-words/
	 *
	 * @return array List of stopwords
	 */
	public static function get_stopwords () {
		$stopwords = array(
"a", "about", "above", "above", "across", "after", "afterwards", "again", "against", "all", "almost", "alone", "along", "already", "also","although","always","am","among", "amongst", "amoungst", "amount",  "an", "and", "another", "any","anyhow","anyone","anything","anyway", "anywhere", "are", "around", "as",  "at", "back","be","became", "because","become","becomes", "becoming", "been", "before", "beforehand", "behind", "being", "below", "beside", "besides", "between", "beyond", "bill", "both", "bottom","but", "by", "call", "can", "cannot", "cant", "co", "con", "could", "couldnt", "cry", "de", "describe", "detail", "do", "done", "down", "due", "during", "each", "eg", "eight", "either", "eleven","else", "elsewhere", "empty", "enough", "etc", "even", "ever", "every", "everyone", "everything", "everywhere", "except", "few", "fifteen", "fify", "fill", "find", "fire", "first", "five", "for", "former", "formerly", "forty", "found", "four", "from", "front", "full", "further", "get", "give", "go", "had", "has", "hasnt", "have", "he", "hence", "her", "here", "hereafter", "hereby", "herein", "hereupon", "hers", "herself", "him", "himself", "his", "how", "however", "hundred", "ie", "if", "in", "inc", "indeed", "interest", "into", "is", "it", "its", "itself", "keep", "last", "latter", "latterly", "least", "less", "ltd", "made", "many", "may", "me", "meanwhile", "might", "mill", "mine", "more", "moreover", "most", "mostly", "move", "much", "must", "my", "myself", "name", "namely", "neither", "never", "nevertheless", "next", "nine", "no", "nobody", "none", "noone", "nor", "not", "nothing", "now", "nowhere", "of", "off", "often", "on", "once", "one", "only", "onto", "or", "other", "others", "otherwise", "our", "ours", "ourselves", "out", "over", "own","part", "per", "perhaps", "please", "put", "rather", "re", "same", "see", "seem", "seemed", "seeming", "seems", "serious", "several", "she", "should", "show", "side", "since", "sincere", "six", "sixty", "so", "some", "somehow", "someone", "something", "sometime", "sometimes", "somewhere", "still", "such", "system", "take", "ten", "than", "that", "the", "their", "them", "themselves", "then", "thence", "there", "thereafter", "thereby", "therefore", "therein", "thereupon", "these", "they", "thickv", "thin", "third", "this", "those", "though", "three", "through", "throughout", "thru", "thus", "to", "together", "too", "top", "toward", "towards", "twelve", "twenty", "two", "un", "under", "until", "up", "upon", "us", "very", "via", "was", "we", "well", "were", "what", "whatever", "when", "whence", "whenever", "where", "whereafter", "whereas", "whereby", "wherein", "whereupon", "wherever", "whether", "which", "while", "whither", "who", "whoever", "whole", "whom", "whose", "why", "will", "with", "within", "without", "would", "yet", "you", "your", "yours", "yourself", "yourselves", "the"
		);

		return $stopwords;
	}

	public static function keywords ($text, $limit=false) {
		$keywords = array();
		$limit = (int)$limit;
		if (empty($text)) return $keywords;

		$words = self::words($text);
		if (empty($words)) return $keywords;

		$stopwords = self::get_stopwords();

		foreach ($words as $word) {
			if (in_array($word, $stopwords)) continue;
			if (empty($keywords[$word])) $keywords[$word] = 0;
			$keywords[$word]++;
		}
		arsort($keywords);

		return !empty($limit)
			? array_slice($keywords, 0, $limit)
			: $keywords
		;
	}

}