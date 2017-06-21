<?php

namespace tlg\telegram\methods\keyboard\types;

class BTN
{
    /**
     * This object represents one button of the reply keyboard.
     *
     * @param string $text
     * @param bool   $requestContact
     * @param bool   $requestLocation
     *
     * @return array
     */
	public static function new($text, $requestContact = null, $requestLocation = null)
	{
		return array_filter([
			'text'             => $text,
			'request_contact'  => $requestContact,
			'request_location' => $requestLocation
		]);
	}
}
