<?php
// 应用公共文件


function diyDate($timestamp)
{
    if (strlen($timestamp) != 10) {
        $timestamp = strtotime($timestamp);
    }

    $strTime = array("秒", "分钟", "小时", "天", "月", "年");
    $length = array("60", "60", "24", "30", "12", "10");
    $currentTime = time();
    if ($currentTime >= $timestamp) {
        $diff = time() - $timestamp;
        for ($i = 0; $diff >= $length[$i] && $i < count($length) - 1; $i++) {
            $diff = $diff / $length[$i];
        }
        $diff = round($diff);
        return $diff . " " . $strTime[$i] . "前";
    }
}

//判断是否从相关搜索引擎来的
function isSearchEngine()
{
    if (empty($_SERVER['HTTP_REFERER'])) {
        return false;
    }
    $url = $_SERVER['HTTP_REFERER'];

    $url_info = parse_url($url);

    $host_list = [
        'baidu.com',
        'sogou.com',
        'google.com',
        'sm.cn',
        'toutiao',
        'bing',
        'so.com',
    ];

    foreach ($host_list as $key => $value) {
        if (strpos($url_info['host'], $value) !== false) {
            return true;
        }
    }
    return false;
}

function isSpider()
{
    $useragent = addslashes(strtolower($_SERVER['HTTP_USER_AGENT']));
    $useragent = strtolower($useragent);

    if (strpos($useragent, 'googlebot') !== false) {
        $bot = 'Google';
    } elseif (strpos($useragent, 'mediapartners-google') !== false) {
        $bot = 'Google Adsense';
    } elseif (strpos($useragent, 'baiduspider') !== false) {
        $bot = 'Baidu';
    } elseif (strpos($useragent, 'sogou spider') !== false) {
        $bot = 'Sogou';
    } elseif (strpos($useragent, 'sogou web') !== false) {
        $bot = 'Sogou web';
    } elseif (strpos($useragent, 'sosospider') !== false) {
        $bot = 'SOSO';
    } elseif (strpos($useragent, '360spider') !== false) {
        $bot = '360Spider';
    } elseif (strpos($useragent, 'yahoo') !== false) {
        $bot = 'Yahoo';
    } elseif (strpos($useragent, 'msn') !== false) {
        $bot = 'MSN';
    } elseif (strpos($useragent, 'msnbot') !== false) {
        $bot = 'msnbot';
    } elseif (strpos($useragent, 'sohu') !== false) {
        $bot = 'Sohu';
    } elseif (strpos($useragent, 'yodaoBot') !== false) {
        $bot = 'Yodao';
    } elseif (strpos($useragent, 'twiceler') !== false) {
        $bot = 'Twiceler';
    } elseif (strpos($useragent, 'ia_archiver') !== false) {
        $bot = 'Alexa_';
    } elseif (strpos($useragent, 'iaarchiver') !== false) {
        $bot = 'Alexa';
    } elseif (strpos($useragent, 'slurp') !== false) {
        $bot = 'yahoo';
    } elseif (strpos($useragent, 'bot') !== false) {
        $bot = 'other';
    } else {
        return [
            'is' => false,
            'name' => '',
        ];
    }

    return [
        'is' => true,
        'name' => $bot,
    ];
}
