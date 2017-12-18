<?php

class Utils {
	public static function get_partial($partial, $data = null) {
		$child   = get_stylesheet_directory() . '/ns-ad-manager/' . $partial . '.php';
		$parent  = get_template_directory() . '/ns-ad-manager/' . $partial . '.php';
		$default = plugin_dir_path( __DIR__ ) . 'templates/' . $partial . '.php';

		ob_start();

		if (file_exists($child)) {
			include ($child);
		} else if (file_exists($parent)) {
			include ($parent);
		} else if (file_exists($default)) {
			include ($default);
		} else {
			return $default;
		}

		$string = ob_get_clean();
		return trim($string);
	}

	public static function split_string_by_words($text, $splitLength = 75) {
        // Explode the text into an array of words
        $wordArray = explode(' ', $text);

        if ( sizeof($wordArray) > $splitLength ) {
            // Split words into two arrays
            $firstWordArray = array_slice($wordArray, 0, $splitLength);
            $lastWordArray = array_slice($wordArray, $splitLength, sizeof($wordArray));

            // Turn array back into two split strings
            $firstString = implode(' ', $firstWordArray);
            $lastString = implode(' ', $lastWordArray);
            return array($firstString, $lastString);
		}

        // If our array is under the limit send it straight back
        return array($text);
    }
}
