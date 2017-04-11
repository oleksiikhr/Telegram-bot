<?php

namespace tlg;

class Web
{
    /**
     * Send request to website.
     *
     * @param string $url
     * @param bool   $decode
     * @param bool   $isPost
     * @param array  $fields
     *
     * @return object
     */
    public function request($url, $decode = false, $isPost = false, $fields = [])
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        if ($isPost) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        }

        $result = curl_exec($ch);
        curl_close($ch);

        return $decode ? json_decode($result) : $result;
    }
}
