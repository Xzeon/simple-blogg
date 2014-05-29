<?php

Class OutputFiltering {

	/**
	 * Loops through provided data and converts specified datefield to desired dateformat.
	 * @param  string $format     Dateformat, example: 'Y-m-d'.
	 * @param  array  $data       The array of data to loop through.
	 * @param  string $fieldname  The fieldname to edit.
	 * @return string
	 */
	public function dateFormat($format, $data, $fieldname){

		foreach ($data as $key => $value) {
			$data[$key][$fieldname] = date($format, strtotime($value[$fieldname]));	
		}

		return $data;
	}
	
	/**
	 * Loops though provided data and fieldname to encapsulate every paragraph with <p> -tags.
	 * @param  array  $data      The array of data to loop through.
	 * @param  string $fieldname The fieldname to edit.
	 * @return array
	 */
	public function nl2p($data, $fieldname){

		foreach ($data as $key => $value) {
			$string = preg_replace('/\n(\s*\n)+/', '</p><p>', $value[$fieldname]);
			$string = '<p>'. $string .'</p>';
			$data[$key][$fieldname] =  $string;
    	}
    	return $data;
	}

	/**
	 * Loops through provided data and fieldname to create excerpt for bloggposts that has
	 * a letter count above a desired amount of letters. Also adds a readmore flag (boolean) 
	 * to the data that shows if an excerpt has been created or not.
	 *
	 * @param  int 	  $count     Max amount of letters before cutting off.
	 * @param  array  $data      The array of data to loop through.
	 * @param  string $fieldname The fieldname to edit.
	 * @return array
	 */
	public function excerpt($count, $data, $fieldname){

		foreach ($data as $key => $value) {
			if(strlen($value[$fieldname]) > $count){
				$data[$key][$fieldname] = substr($value[$fieldname], 0, $count);
				
				// Get position of last space character to prevent excerpt to cut in the middle of a sentence. 
				$lastSpace = strrpos($data[$key][$fieldname], ' ');
				$data[$key][$fieldname] = substr($value[$fieldname], 0, $lastSpace) . '....';

				$data[$key]['readmore'] = true;	
			}else{
				$data[$key]['readmore'] = false;
			}
		}
		return $data;
	}
}