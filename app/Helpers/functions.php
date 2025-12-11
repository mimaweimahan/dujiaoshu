<?php
/**
 * The file was created by Assimon.
 *
 * @author    assimon<ashang@utf8.hk>
 * @copyright assimon<ashang@utf8.hk>
 * @link      http://utf8.hk/
 */


use App\Exceptions\AppException;
use App\Service\Util;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

if (! function_exists('replace_mail_tpl')) {

    /**
     * 替换邮件模板
     *
     * @param array $mailtpl 模板
     * @param array $data 内容
     * @return array|false|mixed
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    function replace_mail_tpl($mailtpl = [], $data = [])
    {
        if (!$mailtpl) {
            return false;
        }
        if ($data) {
            foreach ($data as $key => $val) {
                $title = str_replace('{' . $key . '}', $val, isset($title) ? $title : $mailtpl['tpl_name']);
                $content = str_replace('{' . $key . '}', $val, isset($content) ? $content : $mailtpl['tpl_content']);
            }
            return ['tpl_name' => $title, 'tpl_content' => $content];
        }
        return $mailtpl;
    }
}


if (! function_exists('dujiaoka_config_get')) {

    /**
     * 系统配置获取
     *
     * @param string $key 要获取的key
     * @param $default 默认
     * @return mixed|null
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    function dujiaoka_config_get(string $key, $default = null)
    {
       $sysConfig = Cache::get('system-setting');
       return $sysConfig[$key] ?? $default;
    }
}

if (! function_exists('format_wholesale_price')) {

    /**
     * 格式化批发价
     *
     * @param string $wholesalePriceArr 批发价配置
     * @return array|null
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    function format_wholesale_price(string $wholesalePriceArr): ?array
    {
        $waitArr = explode(PHP_EOL, $wholesalePriceArr);
        $formatData = [];
        foreach ($waitArr as $key => $val) {
            if ($val != "") {
                $explodeFormat = explode('=', delete_html_code($val));
                if (count($explodeFormat) != 2) {
                    return null;
                }
                $formatData[$key]['number'] = $explodeFormat[0];
                $formatData[$key]['price'] = $explodeFormat[1];
            }
        }
        sort($formatData);
        return $formatData;
    }
}

if (! function_exists('delete_html_code')) {

    /**
     * 去除html内容
     * @param string $str 需要去掉的字符串
     * @return string
     */
    function delete_html_code(string $str): string
    {
        $str = trim($str); //清除字符串两边的空格
        $str = preg_replace("/\t/", "", $str); //使用正则表达式替换内容，如：空格，换行，并将替换为空。
        $str = preg_replace("/\r\n/", "", $str);
        $str = preg_replace("/\r/", "", $str);
        $str = preg_replace("/\n/", "", $str);
        $str = preg_replace("/ /", "", $str);
        $str = preg_replace("/  /", "", $str);  //匹配html中的空格
        return trim($str); //返回字符串
    }
}

if (! function_exists('format_charge_input')) {

    /**
     * 格式化代充框
     *
     * @param string $charge
     * @return array|null
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    function format_charge_input(string $charge): ?array
    {
        $inputArr = explode(PHP_EOL, $charge);
        $formatData = [];
        foreach ($inputArr as $key => $val) {
            if ($val != "") {
                $explodeFormat = explode('=', delete_html_code($val));
                if (count($explodeFormat) < 3) {
                    return null;
                }
                $formatData[$key]['field'] = $explodeFormat[0];
                $formatData[$key]['desc'] = $explodeFormat[1];
                $formatData[$key]['rule'] = filter_var($explodeFormat[2], FILTER_VALIDATE_BOOLEAN);
                if(count($explodeFormat) > 3){
                    $formatData[$key]['placeholder'] = $explodeFormat[3];
                }else{
                    $formatData[$key]['placeholder'] = $formatData[$key]['desc'];
                }
            }
        }
        return $formatData;
    }
}


if (! function_exists('site_url')) {

    /**
     * 获取顶级域名 带协议
     * @return string
     */
    function site_url()
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $domainName = $_SERVER['HTTP_HOST'] . '/';
        return $protocol . $domainName;
    }
}

if (! function_exists('md5_signquery')) {

    function md5_signquery(array $parameter, string $signKey)
    {
        ksort($parameter); //重新排序$data数组
        reset($parameter); //内部指针指向数组中的第一个元素
        $sign = '';
        $urls = '';
        foreach ($parameter as $key => $val) {
            if ($val == '') continue;
            if ($key != 'sign') {
                if ($sign != '') {
                    $sign .= "&";
                    $urls .= "&";
                }
                $sign .= "$key=$val"; //拼接为url参数形式
                $urls .= "$key=" . urlencode($val); //拼接为url参数形式
            }
        }
        $sign = md5($sign . $signKey);//密码追加进入开始MD5签名
        $query = $urls . '&sign=' . $sign; //创建订单所需的参数
        return $query;
    }
}

if (! function_exists('signquery_string')) {

    function signquery_string(array $data)
    {
        ksort($data); //排序post参数
        reset($data); //内部指针指向数组中的第一个元素
        $sign = ''; //加密字符串初始化
        foreach ($data as $key => $val) {
            if ($val == '' || $key == 'sign') continue; //跳过这些不签名
            if ($sign) $sign .= '&'; //第一个字符串签名不加& 其他加&连接起来参数
            $sign .= "$key=$val"; //拼接为url参数形式
        }
        return $sign;
    }
}

if (!function_exists('picture_ulr')) {

    /**
     * 生成前台图片链接 不存在使用默认图
     * 如果地址已经是完整URL了，则直接输出
     * @param string $file 图片地址
     * @param false $getHost 是否只获取图片前缀域名
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\UrlGenerator|string
     */
    function picture_ulr($file, $getHost = false)
    {
        if ($getHost) return Storage::disk('admin')->url('');
        if (Illuminate\Support\Facades\URL::isValidUrl($file)) return $file;
        return $file ? Storage::disk('admin')->url($file) : url('assets/common/images/default.jpg');
    }
}

if(!function_exists("licensess")) {
    function licensess() {
        return true;
        }
    }


    // 已删除后门函数 check_update() - 原函数连接远程服务器进行授权验证
    
    // 已删除后门函数 jwt_encode() - 原函数使用 FunctionAction 类写入授权文件
    
    // 已删除后门函数 getJwtDecode() - 原函数使用 FunctionAction 类读取授权文件


    /**
     * 使用PHP检测能否ping通IP或域名
     * @param type $address
     * @return boolean
     */
    function pingAddress($address) {
        $outcome = "";
        $status = -1;
        if (strcasecmp(PHP_OS, 'WINNT') === 0) {
            // Windows 服务器下
            $pingresult = exec("ping -n 1 {$address}", $outcome, $status);
        } elseif (strcasecmp(PHP_OS, 'Linux') === 0) {
            // Linux 服务器下
            $pingresult = exec("ping -c 1 {$address}", $outcome, $status);
        }
        if (0 == $status) {
            $status = true;
        } else {
            $status = false;
        }
        return $status;
    }


if (!function_exists('assoc_unique')) {
    function assoc_unique($arr, $key)
    {
        $tmp_arr = array();
        foreach ($arr as $k => $v) {
            if (in_array($v[$key], $tmp_arr)) {//搜索$v[$key]是否在$tmp_arr数组中存在，若存在返回true
                unset($arr[$k]);
            } else {
                $tmp_arr[] = $v[$key];
            }
        }
        sort($arr); //sort函数对数组进行排序
        return $arr;
    }
}

//发送能量租用http请求
if(!function_exists('curl_post_data_json')){
    function curl_post_data_json($url,$header = [],$data = []){
        return energy_post($url,$header,$data);
    }
}

//能量请求的签名
if(!function_exists('energy_sign')){
    function energy_sign($data,$key = null){
        $hash = hash_hmac('sha256', $data, $key);
        return $hash;
    }
}

//开始购买能量
if(!function_exists('start_energy_buy')){

    function start_energy_buy($count,$address = null){
        $apikey = dujiaoka_config_get("energy_api_token");
        $timestamp = time();
        $head = [
            "x-api-key:".$apikey,
            "x-timestamp:".$timestamp,
            "x-signature:".energy_sign($apikey.$timestamp,dujiaoka_config_get("energy_api_secret")),
            "'Content-Type: application/x-www-form-urlencoded'"
        ];
        $data = [
            "count"=>$count,
            "period"=>"1h",
            "address"=>$address
        ];
        $resdata = curl_post_data_json("https://weidubot.cc/api/v2/buy_energy",$head,$data);
        return $resdata;
    }
}

//能量api构建的post请求
if(!function_exists('energy_post')){
    function energy_post($url, $header, $content,$ispost = true)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, $ispost);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($content));
        $response   = curl_exec($ch);
        if ($error = curl_error($ch)) {
            throw new \Exception($error);
        }
        curl_close($ch);
        return $response;
    }
}

if(!function_exists("query_energy")){
    function query_energy($orderid = null){
        $apikey = dujiaoka_config_get("energy_api_token");
        $timestamp = time();
        $head = [
            "x-api-key:".$apikey,
            "x-timestamp:".$timestamp,
            "x-signature:".energy_sign($apikey.$timestamp,dujiaoka_config_get("energy_api_secret")),
            "'Content-Type: application/x-www-form-urlencoded'"
        ];
        $resdata = curl_post_data_json("https://weidubot.cc/api/v2/query_result?order_sn=ff1e1aad931e143fb1c6d93806835994",$head,[],false);
        return $resdata;
    }
}

if(!function_exists("echo_json")){
    function echo_json($code = 0,$message = '',$data = []){
        echo json_encode(["code"=>$code,"data"=>$data,"message"=>$message],JSON_UNESCAPED_UNICODE);exit();
    }
}

if(!function_exists("getUserAndShop")){
    function getUserAndShop($text){
        $start = explode(" ",$text);
        $arr = [];
        if(count($start) > 1){
            $httpbuild = str_replace("and", "&", $start[1]);
            parse_str($httpbuild, $output);
            if(isset($output["user"])){
                $upuser = Util::getUserTelegramId($output["user"]);
                if($upuser) {
                    $arr["upuser"] = $upuser->id;
                }else{
                    $arr["upuser"] = null;
                }
                //商品数据信息
            }
            if(isset($output["shop"])){
                $goods = new  \App\Service\GoodsService();
                $shop = $goods->detail($output["shop"]);
                if($shop) {
                    $arr["shop"] = $shop;
                }
            }
        }  //https://t.me/fkdemo68Bot?start=user=15andshop=23423423
        return $arr;
    }
}

if(!function_exists("TelegramText")){
    function TelegramText($string){
        $new_string = str_replace(".", "\.", $string);
        $new_string = str_replace("#", "\#", $new_string);
        $new_string = str_replace(">", "\>", $new_string);
        $new_string = str_replace("=", "\=", $new_string);
        $new_string = str_replace("{", "\{", $new_string);
        $new_string = str_replace("}", "\}", $new_string);
        $new_string = str_replace("-", "\-", $new_string);
        $new_string = str_replace("|", "\|", $new_string);
        $new_string = str_replace("_", "\_", $new_string);
        $new_string = str_replace("+", "\+", $new_string);
        $new_string = str_replace("(", "\(", $new_string);
        $new_string = str_replace(")", "\)", $new_string);
        $new_string = str_replace("<", "\<", $new_string);
        $new_string = str_replace(">", "\>", $new_string);
        $new_string = str_replace("!", "\!", $new_string);
        $new_string = str_replace("_", "\_", $new_string);
        return $new_string;
    }
}


//发货哦
if(!function_exists("Shipping")){
    function Shipping($order){
        $orderArr = $order->toArray();
        $filename = "";
        $carmiList = explode("\n",$order["info"]);
        $bot = new \TelegramBot\Api\Client(dujiaoka_config_get("telegram_bot_api_token"));
        $chatId = explode("@",$orderArr["email"])[0];
        $filetype = "file";
        $zip = new \ZipArchive();
        if($zip->open($_SERVER['DOCUMENT_ROOT']."/files/dispatch/".$orderArr["order_sn"].".zip",ZipArchive::CREATE) === TRUE) {
            foreach ($carmiList as $carmi) {
                //文件卡密
                if (is_file($_SERVER['DOCUMENT_ROOT'] . "/files/filecarmi/" . $carmi)) {
                    $zip->addFile($_SERVER['DOCUMENT_ROOT'] . "/files/filecarmi/" . $carmi,$carmi);
                    $filename = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . "/files/dispatch/" . $orderArr["order_sn"] . ".zip";
                    //文件夹卡密
                } elseif (is_dir($_SERVER['DOCUMENT_ROOT'] . "/files/filecarmi/" . $carmi)) {
                    $zip->addFile($_SERVER['DOCUMENT_ROOT'] . "/files/filecarmi/" .$carmi."/",$carmi);
                    $filename = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . "/files/dispatch/" . $orderArr["order_sn"] . ".zip";
                } else {
                    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/files/dispatch/" . $orderArr["order_sn"] . ".txt", $carmi . "\r\n", FILE_APPEND);
                    $filename = $_SERVER['DOCUMENT_ROOT'] . "/files/dispatch/" . $orderArr["order_sn"] . ".txt";
                    $filetype = "txt";
                }
            }
        }
        $zip->close();
        switch ($filetype) {
            case "txt":
                $document = new \CURLFile($filename);
                try {
                    $bot->sendDocument($chatId, $document, $orderArr["order_sn"]);
                }catch (\TelegramBot\Api\HttpException $e){

                }
                break;
            case "file":
                try {
                    $bot->sendDocument($chatId, $filename, $orderArr["order_sn"]);
                }catch (\TelegramBot\Api\HttpException $e){

                }
                break;
        }

    }
}

/**
 * 处理ZIP文件的简化函数
 * 功能：获取压缩包根目录下的所有文件和文件夹并解压到指定目录
 *
 * @param string $zipFilePath ZIP文件的绝对路径
 * @param string $extractBasePath 解压的目标目录路径
 * @return array 处理结果数组，包含成功状态、根目录项列表和解压路径
 */
function processZipUpload($zipFilePath, $extractBasePath) {
    // 1. 验证文件路径是否为空
    if (empty($zipFilePath)) {
        return [
            'success' => false,
            'message' => 'ZIP文件路径不能为空',
            'root_items' => [],
            'extract_path' => ''
        ];
    }

    // 2. 验证文件是否存在
    if (!file_exists($zipFilePath)) {
        return [
            'success' => false,
            'message' => '指定的ZIP文件不存在',
            'root_items' => [],
            'extract_path' => ''
        ];
    }

    // 3. 验证是否为文件（而不是目录）
    if (!is_file($zipFilePath)) {
        return [
            'success' => false,
            'message' => '指定路径不是文件',
            'root_items' => [],
            'extract_path' => ''
        ];
    }

    // 4. 验证文件扩展名是否为zip（不区分大小写）
    $fileInfo = pathinfo($zipFilePath);
    if (!isset($fileInfo['extension']) || strtolower($fileInfo['extension']) !== 'zip') {
        return [
            'success' => false,
            'message' => '只允许处理.zip格式的文件',
            'root_items' => [],
            'extract_path' => ''
        ];
    }

    // 5. 检查服务器是否支持ZIP扩展
    if (!extension_loaded('zip')) {
        return [
            'success' => false,
            'message' => '服务器未安装或启用ZIP扩展',
            'root_items' => [],
            'extract_path' => ''
        ];
    }

    // 6. 打开ZIP文件进行分析
    $zip = new ZipArchive();
    if ($zip->open($zipFilePath) !== true) {
        return [
            'success' => false,
            'message' => '无法打开ZIP文件',
            'root_items' => [],
            'extract_path' => ''
        ];
    }

    // 7. 分析ZIP文件的根目录结构
    // 初始化根目录项数组
    $rootItems = [];      // 根目录所有项目

    // 遍历ZIP文件中的所有项目
    for ($i = 0; $i < $zip->numFiles; $i++) {
        // 获取当前项目的名称
        $entryName = $zip->getNameIndex($i);

        // 分割路径以确定层级结构
        $pathParts = explode('/', trim($entryName, '/'));

        // 只处理根目录项（第一层）
        if (count($pathParts) > 0 && count($pathParts) == 1) {
            $rootItem = $pathParts[0];

            // 避免重复添加和特殊目录项
            if (!in_array($rootItem, $rootItems) && $rootItem != '.' && $rootItem != '..') {
                $rootItems[] = $rootItem;
            }
        }
    }

    // 8. 创建解压目标目录（如果不存在）
    if (!is_dir($extractBasePath)) {
        mkdir($extractBasePath, 0755, true);
    }

    // 9. 执行解压操作
    $extractResult = $zip->extractTo($extractBasePath);
    $zip->close();

    // 10. 检查解压结果
    if (!$extractResult) {
        return [
            'success' => false,
            'message' => '文件解压失败',
            'root_items' => [],
            'extract_path' => ''
        ];
    }

    // 11. 返回成功结果
    return [
        'success' => true,
        'message' => 'ZIP文件处理并解压成功',
        'root_items' => $rootItems,           // 根目录所有项目列表
        'extract_path' => $extractBasePath    // 解压目标路径
    ];
}


function curl_get_https($url,$headers=null,$raw=null,$time=6){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_TIMEOUT, $time);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    if(!empty($headers)){
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);//设置请求头
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);  // 从证书中检查SSL加密算法是否存在
    if($raw){
        curl_setopt($curl, CURLOPT_POSTFIELDS, $raw); // Post提交的数据包
    }
    $tmpInfo = curl_exec($curl);     //返回api的json对象
    curl_close($curl);
    return $tmpInfo;
}


function curl_post_https($url,$data,$headers=null,$cookie=null){ // 模拟提交数据函数
    $curl = curl_init(); // 启动一个CURL会话
    curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
    //curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
    // curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
    //curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
    if(!empty($headers)){
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);//设置请求头
    }
    if(!empty($cookie)){
        curl_setopt($curl, CURLOPT_COOKIE, $cookie); // 带上COOKIE请求
    }
    curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
    curl_setopt($curl, CURLOPT_TIMEOUT, 50); // 设置超时限制防止死循环
    curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
    $tmpInfo = curl_exec($curl); // 执行操作
    curl_close($curl); // 关闭CURL会话
    return $tmpInfo; // 返回数据
}

function getFragmentInfo($username,$numt = 3){
    /** 第一步骤 **/
    $url = "https://fragment.com/api?hash=".dujiaoka_config_get("fragment_hash");
    $user=curl_post_https(
        $url,
        "query={$username}&months={$numt}&method=searchPremiumGiftRecipient",
        null,
        dujiaoka_config_get("fragment_cookie")
    );
    //echo $user;
    $json = json_decode($user,true); //json编码
    //var_dump($json);exit();
    if(empty($json['ok'])){
        throw new Exception("Get Fragment Error");
    }
    $userName = $json['found']['name']??"未知";//获得用户昵称
    $recipient = $json['found']['recipient']; //获得用户唯一标识 第2步需要使用
    $photo = $json['found']['photo'];//获得用户头像
    /*** 用户标识 ***/

    #第二步 创建ton支付订单 注意其中的 $recipient 是第一步获取的
    $order=curl_post_https("https://fragment.com/api?hash=".dujiaoka_config_get("fragment_hash"),"recipient={$recipient}&months={$numt}&method=initGiftPremiumRequest",null,dujiaoka_config_get("fragment_cookie"));
    $json = json_decode($order,true); //json编码
    if(empty($json['req_id'])){
        throw new Exception("Created ton order error");
    }
    $req_id = $json['req_id']; //获得订单号 后续都需要使用
    $amount = $json['amount'];
    /** 订单金额信息 **/

    #第三步 确认支付订单
    $order=curl_post_https("https://fragment.com/api?hash=".dujiaoka_config_get("fragment_hash"),"id={$req_id}&show_sender=1&method=getGiftPremiumLink",null,dujiaoka_config_get("fragment_cookie"));
    $json = json_decode($order,true); //json编码
    if(empty($json['ok'])){
        throw new Exception("Confirmre ton order error");
    }
    $qr_link = $json['qr_link']; //获得支付地址（自己生成二维码） 任何TON钱包扫这个二维码支付就可以自动开通会员，当然这是手动模式了
    $expire = time() + $json['expire_after'];

    /** 订单信息 **/


    #第四步 解码订单数据 并调用TON接口 实现自动支付从而实现自动开通会员
    $order=curl_get_https("https://fragment.com/tonkeeper/rawRequest?id={$req_id}&qr=1");
    $json = json_decode($order,true); //json编码
    if(empty($json['body']['params']['messages'])){
        throw new Exception("Decode order data error");
    }
    $money = base64_decode($json['body']['params']['messages'][0]['amount']); //最终支付金额(精度9) 也就是 amount * 1000000000
    $base32 = base64_decode($json['body']['params']['messages'][0]['payload']); //不是完整正确的解码
    $base32 = explode("#",$base32);
    $base32 = "Telegram Premium for 3 months Ref#".$base32[1];#最终(支付网关)订单数据 需要传递给golang 支付网关

    #第5步 由于只找到JAVA C++ GOlang 的 SDK，没有找到PHP版本的,所以这里我使用GOlang 网关（只负责Ton支付业务）  代码一并开源了的
    $raw = '{
    "EQBAjaOyi2wGWlk-EDkSabqqnF-MrrwMadnwqrurKpkla9nE": "'.$money.'"
}';//这里面这个TON钱包地址就是fragment官方开会员的固定收款钱包地址 - 请参阅顶部技术文档

    //发起支付
    $payok  = curl_get_https(trim(dujiaoka_config_get("subscribe_api"),"/")."/sendTransactions?comment={$base32}&send_mode=1","Content-Type:application/json",$raw);
    //127.0.0.1  是golang 支付网关运行在本地
    return $payok;
}

//api开会员
function apiHuiyuanPay($username,$numt = 3){
    $apikey = dujiaoka_config_get("energy_api_token");
    $timestamp = time();
    $head = [
        "x-api-key:".$apikey,
        "x-timestamp:".$timestamp,
        "x-signature:".energy_sign($apikey.$timestamp,dujiaoka_config_get("energy_api_secret")),
        "'Content-Type: application/x-www-form-urlencoded'"
    ];
    $data = [
        "username"=>$username,
        "month"=>$numt
    ];
    $resdata = curl_post_data_json("https://weidubot.cc/api/v2/buy_premium",$head,$data);
    try {
        $res = json_decode($resdata, true);
    }catch (Exception $e){
        throw new Exception("Caused by IP not being whitelisted");
    }
    if(is_array($res)){
        throw new Exception("Caused by IP not being whitelisted");
    }
    if($res["code"] != 1){
        throw new Exception($res["msg"]);
    }
    return $res;
}

function clone_cache_all($uid){
    Cache::put($uid."premiumother",null);
    Cache::put($uid."buygoods",null);
    Cache::put($uid."customrecharge",null);
}

function putshoulu($goodid){
    $goodsInfo = \App\Models\Goods::query()->where("id",$goodid)->first()->toArray();
    $apiurl = config("dujiaoka.apiurl")."/api/groups/insertgood.html";
    if(!config("dujiaoka.apiurl")){
        return;
    }
    $botinfo = file_get_contents("https://api.telegram.org/bot".dujiaoka_config_get("telegram_bot_api_token")."/getme");
    $botArr = json_decode($botinfo,true);
    $arr = [
        "name" => $goodsInfo["gd_name"],
        "username" => $botArr["result"]["username"]."?start=shop=".$goodid,
        "description" => $goodsInfo["gd_description"]
    ];
    curl_post_https($apiurl,http_build_query($arr));
}
