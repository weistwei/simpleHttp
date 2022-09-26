<?php

namespace NickStudio\Net;

use Exception;

/**
 * Class SimpleHttp
 * @package NickStudio\Net
 * @author Nick <weist.wei@gmail.com>
 * @date 2021/7/31
 */
class HtmlParse {

    /**
     * @param string $htmlContents
     * @return mixed
     * @author Nick <weist.wei@gmail.com>
     * @date 2021/7/31
     */
    public static function getMetaRedirectUrl(string $htmlContents){
        preg_match('/URL=(.*?)"/si', $htmlContents, $matches);
        return str_replace('&amp;', '&', $matches[1] ?? '');
    }

    /**
     * @param string $url
     * @return array|false|int|string|null
     * @author Nick <weist.wei@gmail.com>
     * @date 2021/7/31
     */
    public static function parseUrl(string $url){
        $urlInfo = parse_url($url);
        parse_str($urlInfo['query'], $urlInfo['query']);
        return $urlInfo;
    }


}
