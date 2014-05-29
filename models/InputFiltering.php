<?php

Class InputFiltering{

	/**
	 * Strip all tags from a string except the ones that is allowed.
	 * @param  string $data        The provides string to work against.
	 * @param  string $allowedTags Allowed tags, format example: '<p><e><strong>'. 
	 * @return string              The result.
	 */
	public function stripTags($data, $allowedTags){
		return strip_tags($data, $allowedTags);
	}	

	/**
	 * Transform a string so it can be used as an URI.
	 * @param  string $string Target string.
	 * @return string         URI ready string.
	 */
    public function stringToUri($string){

		$string = trim($string);
		$string = strip_tags($string);
		$string = preg_replace('/\s+/', '_', $string);
		$string = mb_strtolower($string, 'UTF-8');
		
		// transliterate, for instance ö to o and ä to a. 
  		$string = iconv('utf-8', 'us-ascii//TRANSLIT', $string);

  		// remove all characters except (A-Z, a-z, 0-9, -, /, _)
		$string = preg_replace('/[^A-Za-z0-9-_\/]/', '', $string);

		return $string;
    }

}