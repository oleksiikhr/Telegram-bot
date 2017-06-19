<?php

namespace tlg\telegram\methods\keyboard\types;

class KeyboardButton
{
    /**
     * This object represents one button of the reply keyboard.
     *
     * @param string $text
     * @param bool   $request_contact
     * @param bool   $request_location
     *
     * @return array
     */
	public static function new($text, $request_contact = null, $request_location = null)
	{
		return array_filter([
			'text'             => $text,
			'request_contact'  => $request_contact,
			'request_location' => $request_location
		]);
	}
}
