<?php

namespace App\Http\Controllers\Home;
use App\Http\Controllers\BaseController;
use App\Models\Goods;
use App\Models\Lang;
use App\Models\Order;
use App\Models\Pay;
use App\Models\User;
use App\Service\ButtonService;
use App\Service\PayService;
use App\Service\Util;
use App\Util\ButtonUtil;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Symfony\Component\Debug\Exception\FatalThrowableError;
use TelegramBot\Api\Client;
use TelegramBot\Api\HttpException;
use TelegramBot\Api\Types\Update;

class BotController extends BaseController
{
    /**
     * 商品服务层.
     * @var \App\Service\PayService
     */
    private $goodsService;

    /**
     * 支付服务层
     * @var \App\Service\PayService
     */
    private $payService;

    /**
     * 按钮服务层
     * @var \App\Service\ButtonService
     */
    private $buttonService;

    /**
     * 订单服务层
     * @var \App\Service\OrderService
     */
    private $orderService;    //04-7F-0E-5F-7F-9D

    public function __construct()
    {
        $this->goodsService = app('Service\GoodsService');
        $this->payService = app('Service\PayService');
        $this->orderService = app('Service\OrderService');
        $this->buttonService = new ButtonService();
    }

    public function index(){
        
        try {
           
        }catch (\Exception $e){
            die($e->getMessage());
        }
        //exit();
        $token = dujiaoka_config_get("telegram_bot_api_token");
        if(!$token){
            echo_json(-1,"没有填写token");
        }
        $bot = new Client($token);
        try {
            $bot->getMe();
        }catch (HttpException $e){
            echo_json($e->getCode(),$e->getMessage());
        }
        //开始命令
        $bot->command("start",function($message) use ($bot){
            if($message->getChat()->getType() == "private") {
                $id = $message->getChat()->getId();
                $userInfo = Util::getUserTelegramId($id);
                $user = new User();
                $arr = getUserAndShop($message->getText());
                $isshop = false;
                if($arr){
                    if(isset($arr["upuser"])){
                        $user->pid = $arr["upuser"];
                    }
                    if(isset($arr["shop"])){
                        $isshop = true;
                    }
                }
                if(!$userInfo){
                    //https://t.me/fkdemo68Bot?start=user|777777-shopid|6666
                    $user->telegram_id = $id;
                    $user->telegram_username = $message->getFrom()->getUsername();
                    $user->telegram_nick = $message->getChat()->getFirstName()." ".$message->getChat()->getLastName();
                    $user->platform = "telegram_bot";
                    $user->money = dujiaoka_config_get("regmoney");
                    $user->password = bcrypt("123456");
                    $user->last_login = now()->toDateTimeString();
                    $user->register_at = now()->toDateTimeString();
                    $user->invite_code = Str::random(8);
                    $user->created_at = now()->toDateTimeString();
                    $user->updated_at = now()->toDateTimeString();
                    $user->save();
                }
                if($isshop){
                    $buttonInfo = $this->buttonService->withButtonData("goodsinfo",$userInfo["lang"]);
                    $content = str_replace("{gd_name}",$arr["shop"]["gd_name"],$buttonInfo["content"]);
                    if($arr["shop"]["type"] == \App\Models\Goods::AUTOMATIC_DELIVERY){
                        // 修复：将语言代码从 zh-CN 转换为 zh_CN 格式
                        $type = __('hyper.buy_automatic_delivery',[],str_replace("-", "_", $userInfo["lang"]));
                    }else{
                        // 修复：将语言代码从 zh-CN 转换为 zh_CN 格式
                        $type = __('hyper.buy_charge',[],str_replace("-", "_", $userInfo["lang"]));
                    }
                    $content = str_replace("{type}",$type,$content);
                    $content = str_replace("{cardscount}",$arr["shop"]["carmis_count"],$content);
                    $content = str_replace("{price}",$arr["shop"]["actual_price"],$content);
                    $content = str_replace("{info}",$arr["shop"]["gd_description"],$content);
                    $button  = str_replace("{id}", $arr["shop"]["id"],$buttonInfo["button_json"]);
                    $buttonArr = json_decode($button,true);
                    if(is_array($buttonArr)){
                        $buttonObj = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($buttonArr);
                    }else{
                        $buttonObj = null;
                    }
                    $bot->sendMessage(
                        $id,
                        TelegramText($content),
                        $buttonInfo["mode"],
                        (int)$buttonInfo["is_show"],
                        $message->getMessageId(),
                        $buttonObj
                    );
                    exit();
                }else{
                    $buttonInfo = $this->buttonService->withButtonData("start",$userInfo["lang"]);
                    $buttonArr = json_decode($buttonInfo["button_json"],true);
                    if(is_array($buttonArr)){
                        $buttonObj = new \TelegramBot\Api\Types\ReplyKeyboardMarkup($buttonArr, false,true);
                    }else{
                        $buttonObj = null;
                    }
                    $bot->sendMessage(
                        $id,
                        TelegramText($buttonInfo["content"]),
                        $buttonInfo["mode"],
                        (int)$buttonInfo["is_show"],
                        $message->getMessageId(),
                        $buttonObj
                    );
                }
            }
        });
        //帮助命令
        $bot->command("help",function($message) use ($bot){
            $id = $message->getChat()->getId();
            $userInfo = Util::getUserTelegramId($id);
            $buttonInfo = $this->buttonService->withButtonData("help",$userInfo["lang"]);
            $buttonArr = json_decode($buttonInfo["button_json"],true);
            if(is_array($buttonArr)){
                $buttonObj = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($buttonArr);
            }else{
                $buttonObj = null;
            }
            $bot->sendMessage(
                $id,
                TelegramText($buttonInfo["content"]),
                $buttonInfo["mode"],
                (int)$buttonInfo["is_show"],
                $message->getMessageId(),
                $buttonObj
            );
        });
        //能量购买命令
        $bot->command("energy",function($message) use ($bot){
            $id = $message->getChat()->getId();
            $userInfo = Util::getUserTelegramId($id);
            $buttonInfo = $this->buttonService->withButtonData("energy",$userInfo["lang"]);
            $buttonArr = json_decode($buttonInfo["button_json"],true);
            if(is_array($buttonArr)){
                $buttonObj = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($buttonArr);
            }else{
                $buttonObj = null;
            }
            $bot->sendMessage(
                $id,
                TelegramText($buttonInfo["content"]),
                $buttonInfo["mode"],
                (int)$buttonInfo["is_show"],
                $message->getMessageId(),
                $buttonObj
            );
        });
        //会员购买命令
        $bot->command("premium",function($message) use ($bot){
            $id = $message->getChat()->getId();
            $userInfo = Util::getUserTelegramId($id);
            $buttonInfo = $this->buttonService->withButtonData("premium",$userInfo["lang"]);
            $buttonArr = json_decode($buttonInfo["button_json"],true);
            if(is_array($buttonArr)){
                $buttonObj = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($buttonArr);
            }else{
                $buttonObj = null;
            }
            $bot->sendMessage(
                $id,
                TelegramText($buttonInfo["content"]),
                $buttonInfo["mode"],
                (int)$buttonInfo["is_show"],
                $message->getMessageId(),
                $buttonObj
            );
        });
        //星星购买命令
        $bot->command("stars",function($message) use ($bot){
            $bot->sendMessage($message->getChat()->getId(),"功能还未开发");exit();
        });

        $bot->on(function(Update $update) use ($bot){
            //普通消息
            if($update->getMessage()){
                $id = $update->getMessage()->getChat()->getId();
                $userInfo = Util::getUserTelegramId($id);
                if($update->getMessage()->getText() ==  null ){
                    exit();
                }
                if($update->getMessage()->getChat()->getType() == "private") {
                    $buttonInfo = $this->buttonService->withButtonTitleData($update->getMessage()->getText(),$userInfo["lang"]?$userInfo["lang"]:"zh-CN");
                    if ($buttonInfo) {
                        $button = json_decode($buttonInfo["button_json"], true);
                        if (is_array($button)) {
                            $buttonObj = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($button);
                        } else {
                            $buttonObj = null;
                        }
                        switch ($buttonInfo["keyword"]) {
                            //分类列表
                            case "shoplist":
                                $classList = $this->goodsService->withGroupTelegram();
                                $arr = [];
                                foreach ($classList as $class) {
                                    $arr[] = [["text" => $class["gp_name"], "callback_data" => "goods_" . $class["id"]]];
                                }
                                $arr[] = [["text" => trans("dujiaoka.clone",[],str_replace("-", "_", $userInfo["lang"])), "callback_data" => "clone"]];
                                $bot->sendMessage(
                                    $id,
                                    TelegramText($buttonInfo["content"]),
                                    $buttonInfo["mode"],
                                    $buttonInfo["is_show"],
                                    $update->getMessage()->getMessageId(),
                                    new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($arr)
                                );
                                break;
                            //使用教程
                            case "use":
                                $bot->sendMessage(
                                    $id,
                                    TelegramText($buttonInfo["content"]),
                                    $buttonInfo["mode"],
                                    $buttonInfo["is_show"],
                                    $update->getMessage()->getMessageId(),
                                    $buttonObj
                                );
                                break;
                            //个人中心
                            case "my":
                                $content = str_replace("{id}", $userInfo["telegram_id"], $buttonInfo["content"]);
                                $content = str_replace("{username}", $userInfo["telegram_username"], $content);
                                $content = str_replace("{nick}", $userInfo["telegram_nick"], $content);
                                $content = str_replace("{amount}", $userInfo["money"], $content);
                                $content = str_replace("{invite_code}", $userInfo["invite_code"], $content);
                                $content = str_replace("{lang}", $userInfo["lang"], $content);
                                $content = str_replace("{time}", $userInfo["register_at"], $content);
                                $orderObj = Order::query()->where(['email'=> $id."@qq.com"])->where("goods_id","<>",0)->where(["status"=>4]);
                                //var_dump($orderObj->sum("buy_amount"));exit();
                                $content = str_replace("{countnumber}", $orderObj->sum("buy_amount"), $content);
                                $content = str_replace("{countamount}", $orderObj->sum("total_price"), $content);
                                $content = str_replace("{grade}", $userInfo["grade"], $content);
                                $content = str_replace("{link}", "https://t.me/" . dujiaoka_config_get("telegram_bot_username") . "?start=" . $userInfo["telegram_id"], $content);
                                $bot->sendMessage(
                                    $id,
                                    TelegramText($content),
                                    $buttonInfo["mode"],
                                    $buttonInfo["is_show"],
                                    $update->getMessage()->getMessageId(),
                                    $buttonObj
                                );
                                break;
                            //余额充值
                            case "recharge":
                                $rechargeList = dujiaoka_config_get("recharge_promotion");
                                $button = [];
                                $arr = [];
                                for ($i = 0; $i < count($rechargeList); $i++) {
                                    if($rechargeList[$i]["value"]){
                                        $text = $rechargeList[$i]["amount"] . dujiaoka_config_get("recharge_text") . "(" . trans("dujiaoka.give",[],str_replace("-", "_", $userInfo["lang"])) . $rechargeList[$i]["value"] . dujiaoka_config_get("recharge_text") . ")";
                                    }else{
                                        $text = $rechargeList[$i]["amount"] . dujiaoka_config_get("recharge_text");
                                    }
                                    $arr[] = ["text" => $text, "callback_data" => "rechargeamount_" . $rechargeList[$i]["amount"]];
                                    if ($i != 0) {
                                        if (($i + 1) % 3 == 0) {
                                            array_push($button, $arr);
                                            $arr = [];
                                        }
                                    }
                                }
                                if ($arr) {
                                    array_push($button, $arr);
                                }
                                array_push($button, [["text" => "自定义充值金额", "callback_data" => "customrecharge"]]);
                                array_push($button, [["text" => "关闭", "callback_data" => "clone"]]);
                                $bot->sendMessage(
                                    $id,
                                    TelegramText($buttonInfo["content"]),
                                    $buttonInfo["mode"],
                                    $buttonInfo["is_show"],
                                    $update->getMessage()->getMessageId(),
                                    new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($button)
                                );
                                break;
                            case "orderlist":
                                $orders = $this->orderService->withEmailAndPassword($id . "@qq.com", "")->toArray();
                                if (!$orders) {
                                    $bot->sendMessage($id, trans("dujiaoka.Order_list_null", [], str_replace("-", "_", $userInfo["lang"])));
                                    exit();
                                }
                                $content = "";
                                $button = [];
                                foreach ($orders as $order) {
                                    $content = $content . $order["order_sn"] . "\r\n";
                                    $button[] = [["text" => $order["order_sn"], "callback_data" => "getorder_" . $order["order_sn"]]];
                                }
                                $bot->sendMessage($id, $content, $buttonInfo["mode"], $buttonInfo["is_show"], $update->getMessage()->getMessageId(),
                                    new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($button));
                                break;
                            case "lang":
                                $langs = Lang::query()->get();
                                $arr = [];
                                foreach ($langs as $lang) {
                                    if ($lang->code == $userInfo["lang"]) {
                                        $chang = "✅";
                                    } else {
                                        $chang = "";
                                    }
                                    $arr[] = [["text" => $chang . " " . $lang->icon . $lang->title, "callback_data" => "setlang_" . $lang->code]];
                                }
                                $bot->sendMessage(
                                    $id,
                                    $buttonInfo["content"],
                                    $buttonInfo["mode"],
                                    $buttonInfo["is_show"],
                                    $update->getMessage()->getMessageId(),
                                    new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($arr));
                                break;
                            default:
                                $bot->sendMessage(
                                    $id,
                                    TelegramText($buttonInfo["content"]),
                                    $buttonInfo["mode"],
                                    $buttonInfo["is_show"],
                                    $update->getMessage()->getMessageId(),
                                    $buttonObj
                                );
                                break;

                        }
                        clone_cache_all($id);
                        exit();
                    }

                    //查找订单
                    try {
                        $data = $this->orderService->detailOrderSN(trim($update->getMessage()->getText()));
                        if ($data) {
                            $resdata = $data->toArray();
                            $button = $this->buttonService->withButtonData("queryorder", $userInfo["lang"]);
                            $content = str_replace("{ordersn}", $resdata["order_sn"], $button["content"]);
                            $content = str_replace("{gd_name}", $resdata["title"], $content);
                            $content = str_replace("{amount}", $resdata["actual_price"], $content);
                            if ($resdata["pay_id"] > 0) {
                                $payname = $resdata['pay']['pay_name'];
                            } else {
                                $payname = trans("dujiaoka.yuepay", [], str_replace("-", "_", $userInfo["lang"]));
                            }
                            $content = str_replace("{paytype}", $payname, $content);

                            switch ($resdata['status']) {
                                case \App\Models\Order::STATUS_EXPIRED:
                                    $status = __('hyper.orderinfo_status_expired');
                                    break;
                                case \App\Models\Order::STATUS_WAIT_PAY:
                                    $status = __('hyper.orderinfo_status_wait_pay');
                                    break;
                                case \App\Models\Order::STATUS_PENDING:
                                    $status = __('hyper.orderinfo_status_pending');
                                    break;
                                case \App\Models\Order::STATUS_PROCESSING:
                                    $status = __('hyper.orderinfo_status_processed');
                                    break;
                                case \App\Models\Order::STATUS_COMPLETED:
                                    $status = __('hyper.orderinfo_status_completed');
                                    break;
                                case \App\Models\Order::STATUS_FAILURE:
                                    $status = __('hyper.orderinfo_status_failed');
                                    break;
                            }
                            $content = str_replace("{paystatus}", $status, $content);
                            $resbutton = [[["text" => $resdata["order_sn"], "callback_data" => "getorder_" . $resdata["order_sn"]]]];
                            $bot->sendMessage($id, TelegramText($content), $button["mode"], $button["is_show"], $update->getMessage()->getMessageId(), new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($resbutton));
                            clone_cache_all($id);
                            exit();
                        }
                    }catch (\Exception $e){
                        echo $e->getMessage();
                    }

                    //为他人冲会员
                    if (Cache::get($update->getMessage()->getChat()->getId() . "premiumother")) {
                        $otherUsername = trim($update->getMessage()->getText());
                        $userName = trim($otherUsername, "@");
                        $buttonInfo = $this->buttonService->withButtonData("premiumself", $userInfo["lang"]);
                        $content = str_replace("{username}", $otherUsername, $buttonInfo["content"]);
                        //echo $content;exit();
                        $huiyuanConfig = json_decode(dujiaoka_config_get("subscribe_buy_config"), true);
                        $button = [];
                        if (is_array($huiyuanConfig)) {
                            foreach ($huiyuanConfig as $k => $v) {
                                $string = $k . trans("dujiaoka.month", [], str_replace("-", "_", $userInfo["lang"])) . "(" . $v . " USDT)";
                                $button[] = [["text" => $string, "callback_data" => "confirmrehuiyuan_" . $userName . "_" . $k]];
                            }
                            $button[] = [["text" => trans("clone", [], str_replace("-", "_", $userInfo["lang"])), "callback_data" => "clone"]];
                            $bot->sendMessage(
                                $update->getMessage()->getChat()->getId(),
                                TelegramText($content),
                                $buttonInfo["mode"],
                                $buttonInfo["is_show"],
                                $update->getMessage()->getMessageId(),
                                new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($button)
                            );
                        } else {
                            $bot->sendMessage($update->getCallbackQuery()->getMessage()->getChat()->getId(), trans("dujiaoka,not_huiyuan_config", [], str_replace("-", "_", $userInfo["lang"])));
                            exit();
                        }
                        clone_cache_all($update->getMessage()->getChat()->getId());
                        exit();
                    }

                    //商品购买的
                    if (Cache::get($update->getMessage()->getChat()->getId() . "buygoods")) {
                        $goodsid = Cache::get($update->getMessage()->getChat()->getId() . "buygoods");
                        $buynum = trim($update->getMessage()->getText(), "购买 ");
                        if (!is_numeric($buynum)) {
                            $bot->sendMessage($update->getMessage()->getChat()->getId(), "请输入有效数字");
                            exit();
                        }
                        $goods = $this->goodsService->detail($goodsid);
                        if ($buynum > $goods["carmis_count"]) {
                            $bot->sendMessage($update->getMessage()->getChat()->getId(), "您购买的数量大于库存，请重新输入");
                            exit();
                        }
                        $buttonInfo = $this->buttonService->withButtonData("changpaytype", $userInfo["lang"]);

                        $this->goodsService->validatorGoodsStatus($goods);
                        // 有没有优惠码可以展示
                        if (count($goods->coupon)) {
                            $goods->open_coupon = 1;
                        }
                        $formatGoods = $this->goodsService->format($goods);
                        // 加载支付方式.
                        $client = Pay::PAY_CLIENT_PC;
                        if (app('Jenssegers\Agent')->isMobile()) {
                            $client = Pay::PAY_CLIENT_MOBILE;
                        }
                        $formatGoods->payways = $this->payService->pays($client);
                        if ($formatGoods->payment_limit) {
                            $formatGoods->payment_limit = json_decode($formatGoods->payment_limit, true);
                            if (count($formatGoods->payment_limit))
                                $formatGoods->payways = array_filter($formatGoods->payways, function ($way) use ($formatGoods) {
                                    return in_array($way['id'], $formatGoods->payment_limit);
                                });
                        }

                        /**
                        start - ♻️开始菜单
                        help - ❓帮助命令系统的使用说明
                        energy - ♻️能量租用命令
                        premium - 🔰自助开通telegram会员命令

                         **/


                        if ($goods->preselection >= 0)
                            $formatGoods->selectable = $this->goodsService->getSelectableCarmis($id);
                        $formateGoodsArr = $formatGoods->toArray();
                        $arr[] = [["text" => trans("dujiaoka.yue", [], str_replace("-", "_", $userInfo["lang"])), "callback_data" => "confirmorder_0_" . $goodsid . "_" . $buynum]];
                        foreach ($formateGoodsArr["payways"] as $payways) {
                            $arr[] = [["text" => $payways["pay_name"], "callback_data" => "confirmorder_" . $payways["id"] . "_" . $goodsid . "_" . $buynum]];
                        }
                        $arr[] = [["text" => trans("dujiaoka.return", [], str_replace("-", "_", $userInfo["lang"])), "callback_data" => "shoplist"], ["text" => trans("dujiaoka.clone", [], str_replace("-", "_", $userInfo["lang"])), "callback_data" => "clone"]];
                        $content = str_replace("{gd_name}", $formateGoodsArr["gd_name"], $buttonInfo["content"]);
                        $content = str_replace("{price}", $formateGoodsArr["actual_price"], $content);
                        $content = str_replace("{number}", $buynum, $content);
                        $bot->sendMessage(
                            $update->getMessage()->getChat()->getId(),
                            TelegramText($content),
                            $buttonInfo["mode"],
                            $buttonInfo["is_show"],
                            $update->getMessage()->getMessageId(),
                            new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($arr)
                        );
                        clone_cache_all($update->getMessage()->getChat()->getId());
                        exit();
                    }


                    //自定义充值
                    if (Cache::get($update->getMessage()->getChat()->getId() . "customrecharge")) {
                        $buynum = trim($update->getMessage()->getText());
                        if (!is_numeric($buynum)) {
                            $bot->sendMessage($update->getMessage()->getChat()->getId(), "请输入有效金额");
                            exit();
                        }
                        if ($buynum < dujiaoka_config_get("mini_deposit_amount")) {
                            $bot->sendMessage($update->getMessage()->getChat()->getId(), "您输入的金额小于最低充值");
                            exit();
                        }
                        if ($buynum > dujiaoka_config_get("max_deposit_amount")) {
                            $bot->sendMessage($update->getMessage()->getChat()->getId(), "您输入的金额大于最高充值");
                            exit();
                        }
                        $buttonInfo = $this->buttonService->withButtonData("rechargeamount", $userInfo["lang"]);
                        // 加载支付方式
                        $client = Pay::PAY_CLIENT_PC;
                        if (app('Jenssegers\Agent')->isMobile()) {
                            $client = Pay::PAY_CLIENT_MOBILE;
                        }
                        $payways = (new PayService())->pays($client);
                        // 获取配置值
                        $configValue = dujiaoka_config_get('open_czid');;   //充值支付方式ID
                        // 如果配置值不为0，应用过滤
                        if ($configValue !== '0') {
                            $allowedPayways = explode(',', $configValue); // 将配置值转换为数组
                            $payways = array_filter($payways, function ($way) use ($allowedPayways) {
                                return in_array($way['id'], $allowedPayways);
                            });
                        }
                        $arr = [];
                        foreach ($payways as $pay) {
                            $arr[] = [["text" => $pay["pay_name"], "callback_data" => "confirmrecharge_" . $pay["id"] . "_" . $buynum]];
                        }
                        $arr[] = [["text" => trans("dujiaoka.clone", [], str_replace("-", "_", $userInfo["lang"])), "callback_data" => "clone"]];
                        $bot->sendMessage(
                            $update->getMessage()->getChat()->getId(),
                            TelegramText($buttonInfo["content"]),
                            $buttonInfo["mode"],
                            $buttonInfo["is_show"],
                            $update->getMessage()->getMessageId(),
                            new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($arr)
                        );
                        clone_cache_all($update->getMessage()->getChat()->getId());
                        exit();
                    }
                }
                $text = trim($update->getMessage()->getText());
                if(dujiaoka_config_get("search_keyword")) {
                    if ($update->getMessage()->getChat()->getType() !== "private") {
                        if (strpos($text, dujiaoka_config_get("search_keyword")) === 0) { // 注意这里的条件判断，因为strpos返回的是位置，从0开始计数
                            $text = trim($text, dujiaoka_config_get("search_keyword"));
                            $text = trim($text);
                        } else {
                            exit();
                        }
                    }
                }
                //搜索商品
                $goodList = Goods::query()
                    ->where("gd_name","like","%{$text}%")
                    ->orWhere("gd_description","like","%{$text}%")
                    ->where("is_open",1)
                    ->where("deleted_at",null)
                    ->get()
                    ->toArray();
                $arr = [];

                foreach ($goodList as $good){
                    $arr[] = [["text" =>$good["gd_name"],"url" => "https://t.me/".dujiaoka_config_get("telegram_bot_username")."?start=shop=".$good["id"]]];
                }
                $buttonInfo = $this->buttonService->withButtonData("searcgoods");
                if($arr){
                    $button = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($arr);
                }else{
                    $button = null;
                }
                $bot->sendMessage(
                    $update->getMessage()->getChat()->getId(),
                    TelegramText($buttonInfo["content"]),
                    $buttonInfo["mode"],
                    $buttonInfo["is_show"],
                    $update->getMessage()->getMessageId(),
                    $button
                );
            }

            //内联按钮
            if($update->getCallbackQuery()){
                $arr = explode("_",$update->getCallbackQuery()->getData());
                $ButtonObj = $arr[0];
                try {
                    $function = new ButtonUtil();
                    $res = $function->$ButtonObj($update, $bot);
                }catch (FatalThrowableError $e){
                    exit();
                }
                if(is_array($res["button"])){
                    $buttonObj = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($res["button"]);
                }else{
                    $buttonObj = null;
                }
                switch($res["type"]){
                    case "send":
                        $bot->sendMessage(
                            $update->getCallbackQuery()->getMessage()->getChat()->getId(),
                            TelegramText($res["content"]),
                            $res["mode"],
                            $res["is_show"],
                            $update->getCallbackQuery()->getMessage()->getMessageId(),
                            $buttonObj
                        );
                        break;
                    case "photo":
                        $bot->deleteMessage($update->getCallbackQuery()->getMessage()->getChat()->getId(),$update->getCallbackQuery()->getMessage()->getMessageId());
                        $bot->sendPhoto(
                            $update->getCallbackQuery()->getMessage()->getChat()->getId(),
                            $res["photo"],
                            TelegramText($res["content"]),
                            null,
                            $buttonObj,
                            $res["is_show"],
                            $res["mode"]
                        );
                        break;
                    case "video":
                        $bot->deleteMessage($update->getCallbackQuery()->getMessage()->getChat()->getId(),$update->getCallbackQuery()->getMessage()->getMessageId());
                        $bot->sendVideo(
                            $update->getCallbackQuery()->getMessage()->getChat()->getId(),
                            $res["video"],
                            null,
                            TelegramText($res["content"]),
                            null,
                            $buttonObj,
                            $res["is_show"],
                            false,
                            $res["mode"]
                        );
                        break;
                    default:
                        $bot->editMessageText(
                            $update->getCallbackQuery()->getMessage()->getChat()->getId(),
                            $update->getCallbackQuery()->getMessage()->getMessageId(),
                            TelegramText($res["content"]),
                            $res["mode"],
                            $res["is_show"],
                            $buttonObj
                        );
                }
            }
        },function(){
            return true;
        });
        $bot->run();

    }
}
