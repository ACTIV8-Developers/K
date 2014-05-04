<?php
namespace Core\Libraries\Transliterate;

/**
* Class for transliteration of HTML code with
* Latin characters to Cyrilic Serbian characters.
* @author miloskajnaco@gmail.net
*/
class Transliterate
{
	// Text statuses
	const ON = 1, OFF = 0;
	// Tag statuses
	const NO_TAG = 2, TAG_START_BEGIN = 3, TAG_START_END = 4, TAG_CLOSE_START = 5;

	/**
	* Lookup table for self closing tags
	* @param array
	*/
	private $tags = [
		'img', 'hr', 'br', 'col', 'embed', 'input', 'meta', 'source', 'area', 'link', 'param'
	];

	/**
	* Lookup table for switching chars
	* @param array
	*/
	private $lookup = [
		'b' => 'б',
		'B' => 'Б',
		'v' => 'в',
		'V' => 'В',
		'g' => 'г',
		'G' => 'Г',
		'd' => 'д',
		'D' => 'Д',
		'đ' => 'ђ',
		'Đ' => 'Ђ',
		'ž' => 'ж',
		'Ž' => 'Ж',
		'z' => 'з',
		'Z' => 'З',
		'i' => 'и',
		'I' => 'И',
		'j' => 'ј',
		'J' => 'Ј',
		'l' => 'л',
		'L' => 'Л',
		'lj' => 'љ',
		'lJ' => 'Љ',
		'Lj' => 'Љ',
		'LJ' => 'Љ',
		'm' => 'м',
		'n' => 'н',
		'N' => 'Н',
		'nj' => 'њ',
		'nJ' => 'Њ',
		'Nj' => 'Њ',
		'NJ' => 'Њ',
		'p' => 'п',
		'P' => 'П',
		'r' => 'р',
		'R' => 'Р',
		's' => 'с',
		'S' => 'С',
		't' => 'т',
		'T' => 'Т',
		'u' => 'у',
		'U' => 'У',
		'ć' => 'ћ',
		'Ć' => 'Ћ',
		'u' => 'у',
		'U' => 'У',
		'f' => 'ф',
		'F' => 'Ф',
		'h' => 'х',
		'H' => 'Х',
		'c' => 'ц',
		'C' => 'Ц',
		"č" => 'ч',
		'Č' => 'Ч',
		'dž' => 'џ',
		'dŽ' => 'Џ',
		'Dž' => 'Џ',
		'DŽ' => 'Џ',
		"š" => 'ш',
		'Š' => 'Ш',
	];

	/**
	* Final output buffer.
	* @var string
	*/
	private $output = '';

	/**
	* Status tells to what part of HTML tag character belongs
	* (if character is not part of tag NO_TAG flag is set)
	* @var int
	*/
	private $tagStatus = self::NO_TAG;

	/**
	* Status tells does character need to be
	* transliterated or not.
	* @var int
	*/
	private $textStatus = self::OFF;

	/**
	* Buffer keeps current tag name.
	* @var string
	*/
	private $tagBuffer = '';

	/**
	* Convert input string from Latin to Cyrilic.
	* @param string
	* @return string
	*/
	public function convert($input)
	{
		$input = html_entity_decode($input); // Turm HTML entities to normal characters
		$input = $this->mb_str_split($input); // Turn input into array
		$len = count($input); // Get input lenght

		for($i = 0; $i<$len; ++$i) { // Iterate over input array

			switch($input[$i]) { // Whats the status ?
				case '<';
					if($this->tagStatus == self::TAG_START_END) { // Start of tag
						$this->tagStatus = self::TAG_CLOSE_START;
						$this->textStatus = self::OFF;
					} else {
						$this->tagStatus = self::TAG_START_BEGIN;
						$this->textStatus = self::OFF;
						$this->tagBuffer = '<';// Reset tag buffer
						// Iterate to find tag name
						while($input[++$i]!=' ' && $input[$i]!='>') {
							$this->tagBuffer.=$input[$i];
						}
						// Set tag buffer as next thing to append to final output
						$input[--$i] = $this->tagBuffer;
					}
					break;
				case '>';
					if(in_array($this->tagBuffer, $this->tags)) { // Check if tag is self-closing
						$this->tagStatus = self::NO_TAG;
						$this->textStatus = self::OFF;
					} else if ($this->tagStatus == self::TAG_START_BEGIN) {
						$this->tagStatus = self::TAG_START_END;
						$this->textStatus = self::OFF;
					} else if ($this->tagStatus == self::TAG_CLOSE_START) {
						$this->tagStatus = self::NO_TAG;
						$this->textStatus = self::OFF;
					}
					break;
				default:
				// If character doesn't belong to any tag turn transliterate flag ON
				if(($this->tagStatus != self::TAG_START_BEGIN && $this->tagStatus != self::TAG_CLOSE_START) || $this->tagStatus == self::NO_TAG) {
					$this->textStatus = self::ON;
				}
			}

			// Translitarete or just append tag char (depends on status)
			if($this->textStatus == self::ON) {
				// Some character are written as two letters, check for them
				if(($input[$i]=='l' || $input[$i]=='L') && ($input[$i+1]=='J' || $input[$i+1]=='j')) {
					$input[$i] = $input[$i].$input[++$i];
				}
				if(($input[$i]=='n' || $input[$i]=='N') && ($input[$i+1]=='J' || $input[$i+1]=='j')) {
					$input[$i] = $input[$i].$input[++$i];
				}
				if(($input[$i]=='d' || $input[$i]=='D') && ($input[$i+1]=='ž' || $input[$i+1]=='Ž')) {
					$input[$i] = $input[$i].$input[++$i];
				}
				// Transliterate then append
				$this->output.=$this->trans($input[$i]);
			} else { // Append tag character
				$this->output.=$input[$i];
			}
		}
		// Final output
		return $this->output;
	}

	/**
	* Convert from latin to cyrilic char.
	* @param char|string
	* @return char
	*/
	private function trans($char)
	{
		if(array_key_exists($char, $this->lookup)) {
			return $this->lookup[$char];
		}
		return $char;
	}

	/**
	* Unicode safe function to split string into array
	* @param string
	* @return array
	*/
	private function mb_str_split( $string ) { 
	    # Split at all position not after the start: ^ 
	    # and not before the end: $ 
	    return preg_split('/(?<!^)(?!$)/u', $string); 
	} 
}