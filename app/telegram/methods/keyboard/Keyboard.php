<?php

namespace tlg\telegram\methods\keyboard;

class Keyboard
{
    /**
     * Additional interface options.
     *
     * @param array          $k Keyboard
     * @param bool           $rk Rezise keyboard
     * @param bool           $otk One time keyboard
     * @param bool           $s Selective
     *
     * @return string JSON
     */
	public static function replyKeyboardMarkup($k, $rk = null, $otk = null, $s = null)
    {
		return json_encode( array_filter([
			'keyboard'          => $k,
			'resize_keyboard'   => $rk,
			'one_time_keyboard' => $otk,
			'selective'         => $s
		]) );
	}
}
