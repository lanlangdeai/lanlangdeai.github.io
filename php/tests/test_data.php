<?php


/**
 * 从二维数组中取出自己要的KEY值
 * @param  array $arrData
 * @param string $key
 * @param $im true 返回逗号分隔
 * @return array
 */
function filter_value($arrData, $key, $im = false)
{
    $re = [];
    foreach ($arrData as $k => $v) {
        if (isset($v[$key])) $re[] = $v[$key];
    }
    if (!empty($re)) {
        $re = array_flip(array_flip($re));
        sort($re);
    }

    return $im ? implode(',', $re) : $re;
}


/**
 * 生成随机字符串
 * @param string $prefix
 * @return string
 */
function get_random($prefix = '')
{
    return $prefix . base_convert(time() * 1000, 10, 36) . "_" . base_convert(microtime(), 10, 36) . uniqid();
}


function array_merge_multi()
{
    $args = func_get_args();
    $array = [];
    foreach ($args as $arg) {
        if (is_array($arg)) {
            foreach ($arg as $k => $v) {
                if (is_array($v)) {
                    $array[$k] = isset($array[$k]) ? $array[$k] : [];
                    $array[$k] = array_merge_multi($array[$k], $v);
                } else {
                    $array[$k] = $v;
                }
            }
        }
    }

    return $array;
}




$data = [
    ['name'=>'xing','age'=>23,'sex'=>1],
    ['name'=>'xia','age'=>20,'sex'=>0],
    ['name'=>'','age'=>0,'sex'=>0],
    ['name'=>'xue','age'=>2,'sex'=>0],
];

//$ret = filter_value($data, 'name', true);
//var_dump($ret);

$name = 'xing-';

//$randStr =  get_random($name);
//
//var_dump($randStr, strlen($randStr));

$arr = [['name'=>'sss', 'age'=>-1]];

//$ret = array_merge_multi($data, $arr);
//var_dump($ret);


/**
 * 格式化字节大小
 * @param  number $size      字节数
 * @param  string $delimiter 数字和单位分隔符
 * @return string            格式化后的带单位的大小
 */
function format_bytes($size, $delimiter = '')
{
    $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
    for ($i = 0; $size >= 1024 && $i < 5; $i++) $size /= 1024;

    return round($size, 2) . $delimiter . $units[$i];
}


function get_uuid($length = 16)
{
    mt_srand((double)microtime()*10000);
    $uuid = sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    $str = base64_encode($uuid);
    return substr($str,  mt_rand(0, strlen($str) - $length), $length);
}

//$fileSize = 1000000;
//echo format_bytes($fileSize);


echo get_uuid();