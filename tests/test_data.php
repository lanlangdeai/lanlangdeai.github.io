<?php


class EncryptAndDecrypt
{

    /**
     * 加解密算法
     * @param  string $string 加密数据
     * @param  string $rand   加密随机字符串
     * @param  string $action 加解密方式标识
     * @return string         加解密之后数据
     */
    public static function mymd5($string, $rand='randstring', $action="EN")
    {
        $secret_string = $rand.'5*a,.^&;?.%#@!';

        if($string=="")
            return "";
        if($action=="EN"){
            $md5code=substr(md5($string),8,10);
        }else{
            $md5code=substr($string,-10);
            $string=substr($string,0,strlen($string)-10);
        }
        //$key = md5($md5code.$_SERVER["HTTP_USER_AGENT"].$secret_string);
        $key = md5($md5code.$secret_string);
        $string = ($action=="EN" ? $string : base64_decode($string));
        $len = strlen($key);
        $code = "";
        for($i=0; $i<strlen($string); $i++){
            $k = $i%$len;
            $code .= $string[$i]^$key[$k];
        }
        $code = $action == "DE" ? (substr(md5($code),8,10) == $md5code ? $code : NULL) : base64_encode($code)."$md5code";

        return $code;
    }

    // base64_encode
    public static function b64encode( $string ) {
        $data = base64_encode( $string );
        $data = str_replace( array ( '+' , '/' , '=' ), array ( '-' , '_' , '' ), $data );
        return $data;
    }
    // base64_decode
    public static function b64decode( $string ) {
        $data = str_replace( array ( '-' , '_' ), array ( '+' , '/' ), $string );
        $mod4 = strlen( $data ) % 4;
        if ( $mod4 ) {
            $data .= substr( '====', $mod4 );
        }
        return base64_decode( $data );
    }

}

$name = 'xing';
$randStr = '1111111111111111111111111111111111111111111';
$en1 = EncryptAndDecrypt::mymd5($name, $randStr);
var_dump($en1);
$de1 = EncryptAndDecrypt::mymd5($en1, $randStr, 'DE');
var_dump($de1);

die;










class Coding
{
    /**
     * 加密
     * @param  string  $str    需加密字符串
     * @param  integer $factor 分类
     * @return string          加密之后的字符串
     */
    static function  doEncode($str , $factor = 0){
        $len = strlen($str);
        if(!$len){
            return;
        }
        if($factor  === 0){
            $factor = mt_rand(1, min(255 , ceil($len / 3)));
        }
        $c = $factor % 8;

        $slice = str_split($str ,$factor);
        for($i=0;$i < count($slice);$i++){
            for($j=0;$j< strlen($slice[$i]) ;$j ++){
                $slice[$i][$j] = chr(ord($slice[$i][$j]) + $c + $i);
            }
        }
        $ret = pack('C' , $factor).implode('' , $slice);
        return self::base64URLEncode($ret);
    }

    /**
     * 解密
     * @param  string $str 需解密字符串
     * @return string      解密之后的字符串
     */
    static function doDecode($str)
    {
        if($str == ''){
            return;
        }
        $str = self::base64URLDecode($str);
        $factor =  ord(substr($str , 0 ,1));
        $c = $factor % 8;
        $entity = substr($str , 1);
        $slice = str_split($entity , $factor);
        if(!$slice){
            return false;
        }
        for($i=0;$i < count($slice); $i++){
            for($j =0 ; $j < strlen($slice[$i]); $j++){
                $slice[$i][$j] = chr(ord($slice[$i][$j]) - $c - $i );
            }
        }
        return implode($slice);
    }

    static function base64URLEncode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    static function base64URLDecode($data)
    {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }
}


$name = 'xing';
$factor = 1;
$en1 = Coding::doEncode($name,$factor);
var_dump($en1);
$de1 = Coding::doDecode($en1);
var_dump($de1);

$factor = 2;
$en1 = Coding::doEncode($name,$factor);
var_dump($en1);
$de1 = Coding::doDecode($en1);
var_dump($de1);







die;


// 判断是否是微信浏览器
function isWechat()
{
    return strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false;
}




/**
 * 验证日期与是否是整点
 * @param  string 日期
 * @param  bool   整点验证
 */
function validateDate($date,$isZero=false)
{
    $timestamp = strtotime($date);
    if(false === $timestamp){
        return false;
    }
    if($isZero){
        $today = strtotime('today');
        $interval = abs($timestamp - $today);
        if( !is_int($interval/(24*60*60) ) ){
            return false;
        }
    }
    return $timestamp;
}


/**
 * 获取指定月份始末时间戳
 * @param  integer $year  年份
 * @param  integer $month 月份
 */
function getMonthTimestamps($year,$month)
{
    if( !checkdate($month, 1, $year) ){
        return false;
    }

    $start = mktime(0, 0, 0, $month, 1, $year);
    $end   = mktime(23, 59, 59, $month, date('t',$start), $year);
    return $start && $end ? [$start,$end] : false;
}

print_r(getMonthTimestamps(2021,2));

die;



/**
 * 浮点数求和（如果是减 就把参数前加 - 号）
 * @param array ...$params(5.6以上写法)
 * @return mixed 保留两位小数
 */
function add(...$params) {
    return array_reduce($params,function($base,$n){
        $base = bcadd($base,+$n,2);
        return $base;
    });
}

$ret1 = add(10.01, 20.22, 0.1);
print_r($ret1);











die;
/**
 * 导出CSV文件
 * @param  string 文件名称
 * @param  Array  数据头
 * @param  Array  数据体
 */
function exportCsv($fileName, $titleArr=[], $dataArr=[])
{
    ini_set('memory_limit','128M');
    ini_set('max_execution_time',0);
    ob_end_clean();
    ob_start();
    header("Content-Type: text/csv");
    header("Content-Disposition:filename=".$fileName);
    $fp=fopen('php://output','w');
    fwrite($fp, chr(0xEF).chr(0xBB).chr(0xBF));//防止乱码(比如微信昵称)
    fputcsv($fp,$titleArr);
    $index = 0;
    foreach ($dataArr as $item) {
        if($index==1000){
            $index=0;
            ob_flush();
            flush();
        }
        $index++;
        fputcsv($fp,$item);
    }

    ob_flush();
    flush();
    ob_end_clean();
}


/**
 * 导出CSV格式数据
 * @param $fileName
 * @param array $titleArr
 * @param array $dataArr
 */
//function exportCsv($fileName, $titleArr=[], $dataArr=[])
//{
//    ini_set('memory_limit', '128M');
//    ini_set('max_execution_time',0);
//
//    $output = fopen($fileName, 'w');
//    //add BOM to fix UTF-8 in Excel
//    fputs($output, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ) );
//    //告诉浏览器这个是一个csv文件
//    header("Content-Type: application/csv;charset=utf-8");
//    header("Content-Disposition: attachment; filename={$fileName}");
//    header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
//    header('Expires:0');
//    header('Pragma:public');
//
//    fputcsv($output, $titleArr); //输出表头
//
//    foreach ($dataArr as $v) { //输出每一行数据到文件中
//        fputcsv($output, array_values($v));
//    }
//
//    fclose($output);
//}

/**
 * 过滤并获取有用数据
 * @param  array $data      原数据
 * @param  array $standard  保留的参数
 */
function filterData($data, array $standard){
    if(empty($data) || !is_array($data) || !is_array($standard)) return [];

    $standardArr = array_fill_keys($standard, '');

    $data = array_intersect_key($data,$standardArr);

    return array_merge($standardArr,$data);
}

$arr = ['name'=>'xing','age'=>23,'sex'=>1];
$standard = ['age'];


$ret = filterData($arr, $standard);
var_dump($ret);
die;










/**
 * 生成一定数量的不重复随机数
 * @param  integer $min 最小值
 * @param  integer $max 最大值
 * @param  integer $num 随机数数量
 * @return array        返回值
 */
function generateUniqueRand(int $min, int $max,int $num)
{
    $count = 0;
    $return = [];
    if(($max-$min+1)<$num){
        return $return;
    }

    while ($count < $num) {
        $return[] = mt_rand($min, $max);
        $return   = array_flip(array_flip($return));
        $count    = count($return);
    }
    shuffle($return);
    return $return;
}

print_r(generateUniqueRand(1, 10, 10));

die;

function reduceArray($array) {
    $return = [];
    array_walk_recursive($array, function ($x) use (&$return) {
        $return[] = $x;
    });
    return $return;
}

$data = [
    ['php','python','golang'],
    ['mysql','sqlite','mongodb','redis','Memcache']
];

print_r(reduceArray($data));
die;







/**
 * 数组中数据的求和（支持多维数组）
 * @param array $array
 * @return int|mixed
 */
function arraySum(array $array)
{
    $total = 0;
    foreach(new RecursiveIteratorIterator( new RecursiveArrayIterator($array) ) as $num){
        $total += $num;
    }
    return $total;
}

$arr = [[11,22],33, [44,55,[66,77]]];
print_r(arraySum($arr));

die;








/**
 * 将对象数据转换成数据
 * @param $object
 * @return array
 */
function objectToArray($object)
{
    if(!is_array($object) && !is_object($object)){
        return $object;
    }
    if( is_object($object) ){
        $object = get_object_vars($object);
    }
    return array_map('objectToArray',$object);
}

//$data = ['name'=>'xing','age'=>20];
//$obj = (object)$data;
//
//print_r($obj);
//
//$arr = objectToArray($obj);
//print_r(objectToArray($obj));
//
//
//
//
//die;














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
    ['name'=>'xing','age'=>23,'sex'=>111],
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

$ret = array_merge_multi($data, $arr);
var_dump($ret);
die;

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

function listDir($dir, $recursion = true)
{
    $dirInfo = [];
    if (is_dir($dir)) {
        foreach (glob($dir . DS . '*') as $v) {
            if ($recursion && is_dir($v)) {
                $dirInfo = array_merge($dirInfo, listDir($v));
            } else {
                $dirInfo[] = $v;
            }

        }
    }
    return $dirInfo;
}

//$path = realpath(__FILE__);
//echo $path;
//$ret = listDir($path);
//var_dump($ret);
//echo get_uuid();