<?php

namespace PageScraper;

/**
* @author Muhammad Mahad Azad <mahadazad@gmail.com>
*/
class PageUtility
{
    /**
     * @param  string $url
     * @return string
     */
    public static function getUrlWithoutQueryPart($url)
    {
        $url_parts = parse_url($url);
        $url = $url_parts['scheme'].'://'.$url_parts['host'];
        $url = isset($url_parts['path']) ? $url.$url_parts['path'] : $url;

        return $url;
    }

    /**
     * @param string url
     * @return array
     */
    public static function getQueryFromUrl($url)
    {
        parse_str(parse_url($url, PHP_URL_QUERY), $params);

        return $params;
    }

    /**
     * @param string $url
     * @param array  $param
     */
    public static function replaceQueryInUrl($url, $param, $remove = false)
    {
        $url_tmp = static::getUrlWithoutQueryPart($url);
        $url_params = static::getQueryFromUrl($url);
        $filtered_params = static::getArrayWithoutKey($url_params, $param);

        if (!$remove) {
            $filtered_params = array_merge($filtered_params, $param);
        }

        return $url_tmp.'?'.http_build_query($filtered_params);
    }

    /**
     * @param  array        $array
     * @return array|string
     */
    public static function getArrayWithoutKey(array $array, $key)
    {
        $keys = is_array($key) ? array_flip($key) : array( $key => 0 );

        return array_diff_key($array, $keys);
    }

    /**
     * @param  string       $url
     * @return array|string
     */
    public static function getUrlWithoutQuery($url, $key)
    {
        $key = is_array($key) ? $key : array($key);

        return static::replaceQueryInUrl($url, $key, true);
    }
}
