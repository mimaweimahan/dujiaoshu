<?php

namespace App\Util;

use App\Exceptions\RuleValidationException;
use App\Jobs\OrderExpired;
use App\Models\Order;
use App\Models\Pay;
use App\Models\User;
use App\Service\ButtonService;
use App\Service\OrderProcessService;
use App\Service\PayService;
use App\Service\Util;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ButtonUtil extends BaseUtil
{
    /**
     * 订单处理层.
     * @var OrderProcessService
     */
    private $orderProcessService;
    /**
     * 订单服务层
     * @var \App\Service\OrderService
     */
    private $orderService;

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

    public function __construct()
    {
        $this->goodsService = app('Service\GoodsService');
        $this->payService = app('Service\PayService');
        $this->buttonService = new ButtonService();
        $this->orderService = app('Service\OrderService');
        $this->orderProcessService = app('Service\OrderProcessService');
    }

    //关闭按钮
    public function clone($update,$bot){
        $bot->deleteMessage($update->getCallbackQuery()->getMessage()->getChat()->getId(),$update->getCallbackQuery()->getMessage()->getMessageId());
        exit();
    }

    //关闭按钮
    public function close($update,$bot){
        $bot->deleteMessage($update->getCallbackQuery()->getMessage()->getChat()->getId(),$update->getCallbackQuery()->getMessage()->getMessageId());
        exit();
    }

    //分类列表
    public function shoplist($update,$bot){
        $classList = $this->goodsService->withGroupTelegram();
        $userInfo = Util::getUserTelegramId($update->getCallbackQuery()->getMessage()->getChat()->getId());
        $buttonInfo = $this->buttonService->withButtonData("shoplist",$userInfo["lang"]);
        $arr = [];
        foreach ($classList as $class){
            $arr[] = [["text" => $class["gp_name"],"callback_data" => "goods_".$class["id"]]];
        }
        $arr[] = [["text" => trans("dujiaoka.clone",[],str_replace("-", "_", $userInfo["lang"])),"callback_data" => "clone"]];
        return $this->_return($buttonInfo["content"],$buttonInfo["mode"],$buttonInfo["is_show"],$arr);
    }

    //选择支付方式
    public function rechargeamount($update,$bot){
        $userInfo = Util::getUserTelegramId($update->getCallbackQuery()->getMessage()->getChat()->getId());
        $buttonInfo = $this->buttonService->withButtonData("rechargeamount",$userInfo["lang"]);
        $array = explode("_",$update->getCallbackQuery()->getData());
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
            $payways = array_filter($payways, function($way) use ($allowedPayways) {
                return in_array($way['id'], $allowedPayways);
            });
        }
        $arr = [];
        foreach ($payways as $pay){
            $arr[] = [["text" => $pay["pay_name"],"callback_data" => "confirmrecharge_".$pay["id"]."_".$array[1]]];
        }
        $arr[] = [["text" => trans("dujiaoka.clone",[],str_replace("-", "_", $userInfo["lang"])),"callback_data" => "clone"]];
        return $this->_return($buttonInfo["content"],$buttonInfo["mode"],$buttonInfo["is_show"],$arr);
    }


    //订单确认
    public function confirmrecharge($update,$bot){
        $userInfo = Util::getUserTelegramId($update->getCallbackQuery()->getMessage()->getChat()->getId());
        $buttonInfo = $this->buttonService->withButtonData("confirmrecharge",$userInfo["lang"]);
        $array = explode("_",$update->getCallbackQuery()->getData());
        $payinfo = Pay::query()->where("id",$array[1])->first();
        $content = str_replace("{payamount}",$array[2],$buttonInfo["content"]);
        $rechargeList = dujiaoka_config_get("recharge_promotion");
        $amount = 0;
        foreach ($rechargeList as $recharge){
            if($recharge["amount"] == $array[2]){
                $amount = (int)$recharge["value"];
            }
        }
        $content = str_replace("{amount}",$amount,$content);
        $content = str_replace("{paytype}",$payinfo["pay_name"],$content);
        $button = str_replace("{paytype}",$array[1],$buttonInfo["button_json"]);
        $button = str_replace("{amount}",$array[2],$button);
        return $this->_return($content,$buttonInfo["mode"],$buttonInfo["is_show"],json_decode($button,true));
    }


    //支付订单
    public function gorechargepay($update,$bot){
        $userInfo = Util::getUserTelegramId($update->getCallbackQuery()->getMessage()->getChat()->getId());
        $buttonInfo = $this->buttonService->withButtonData("gorechargepay",$userInfo["lang"]);
        $array = explode("_",$update->getCallbackQuery()->getData());
        DB::beginTransaction();
        try {
            // 创建订单
            $order = new Order();
            // 生成订单号
            $order->order_sn = Str::random(16);
            // 设置商品
            $order->goods_id = 0;
            // 标题
            $order->title = "余额充值";
            // 订单类型
            $order->type = 1;
            // 查询密码
            $order->search_pwd = "";
            // 邮箱
            $order->email = $userInfo["telegram_id"]."@qq.com";
            // 支付方式.
            $order->pay_id = $array[1];
            // 商品单价
            // 商品单价 - 使用用户输入的充值金额
            $order->goods_price = $array[2];
            // 购买数量
            $order->buy_amount = 1;
            // 订单详情
            $order->info = "用户余额充值";
            // ip地址
            $order->buy_ip = "8.8.8.8";
            // 订单总价
            // 获取订单总价
            $totalPrice = $array[2];
            $order->total_price = $totalPrice;
            // 计算手续费
            $fee = $this->calculatePayFee($totalPrice, $array[1]);
            // 应用手续费到总价
            $priceWithFee = $totalPrice + $fee;
            // 应用汇率调整到已经包含手续费的价格
            $actualPrice = $this->calculatePriceWithExchangeRate($priceWithFee, $array[1]);
            $order->actual_price = $actualPrice;
            $order->save();
            // 将订单加入队列 x分钟后过期
            $expiredOrderDate = dujiaoka_config_get('order_expire_time', 5);
            OrderExpired::dispatch($order->order_sn)->delay(Carbon::now()->addMinutes($expiredOrderDate));
            DB::commit();
            $payinfo = Pay::query()->where("id",$array[1])->first();
            $payController = "App\\Http\\Controllers\\Pay\\".$payinfo->controller;
            $controller = new $payController();
            $result = $controller->gateway($payinfo->pay_check,$order->order_sn,"json");
            $resultArr = json_decode($result,true);
            var_dump($resultArr);
            if(is_array($resultArr)) {
                switch($payinfo->controller) {
                    case "TokenPayController":
                        if(!$resultArr["success"]){
                            $bot->sendMessage($update->getCallbackQuery()->getMessage()->getChat()->getId(),$resultArr["message"]);exit();
                        }
                        $content = str_replace("{ordersn}", $order->order_sn, $buttonInfo["content"]);
                        $content = str_replace("{payamount}", $resultArr["info"]["Amount"], $content);
                        $content = str_replace("{amount}", $order->goods_price, $content);
                        $content = str_replace("{paytype}", $payinfo->pay_name, $content);
                        $content = str_replace("{address}", $resultArr["info"]["ToAddress"], $content);
                        $buttonjson = str_replace("{url}", $resultArr["data"], $buttonInfo["button_json"]);
                        // 修复：从 ToAddress 中提取纯钱包地址（如果是链接则提取，如果是地址则直接使用）
                        $toAddress = $resultArr["info"]["ToAddress"];
                        // 如果是链接，尝试提取钱包地址（TRC20地址以T开头，34位字符）
                        if (filter_var($toAddress, FILTER_VALIDATE_URL)) {
                            // 尝试从URL中提取地址（可能格式：https://xxx.com/pay?address=TRxxx 或 https://xxx.com/TRxxx）
                            if (preg_match('/(T[A-Za-z1-9]{33})/', $toAddress, $matches)) {
                                $walletAddress = $matches[1];
                            } elseif (preg_match('/(0x[a-fA-F0-9]{40})/', $toAddress, $matches)) {
                                // ERC20地址格式
                                $walletAddress = $matches[1];
                            } else {
                                // 如果无法提取，使用原值
                                $walletAddress = $toAddress;
                            }
                        } else {
                            // 直接是钱包地址
                            $walletAddress = $toAddress;
                        }
                        $photo = dujiaoka_config_get("pay_image_api") . urlencode($walletAddress);
                        break;
                    case "EpusdtController":
                        if($resultArr["status_code"] != 200){
                            $bot->sendMessage($update->getCallbackQuery()->getMessage()->getChat()->getId(),$resultArr["message"]);exit();
                        }
                        $content = str_replace("{ordersn}", $order->order_sn, $buttonInfo["content"]);
                        $content = str_replace("{payamount}", $resultArr["data"]["actual_amount"], $content);
                        $content = str_replace("{amount}", $order->goods_price, $content);
                        $content = str_replace("{paytype}", $payinfo->pay_name, $content);
                        $content = str_replace("{address}", $resultArr["data"]["token"], $content);
                        $buttonjson = str_replace("{url}", $resultArr["data"]["payment_url"], $buttonInfo["button_json"]);
                        // 修复：使用 token（钱包地址）生成二维码，而不是 payment_url（支付链接）
                        $walletAddress = $resultArr["data"]["token"];
                        $photo = dujiaoka_config_get("pay_image_api").urlencode($walletAddress);
                        break;
                    case "YipayController":
                        if($resultArr["code"]  == "-1"){
                            $bot->sendMessage($update->getCallbackQuery()->getMessage()->getChat()->getId(),$resultArr["msg"]);exit();
                        }
                        $content = str_replace("{ordersn}", $order->order_sn, $buttonInfo["content"]);
                        $content = str_replace("{payamount}", (float)$array[2] * (float)dujiaoka_config_get("huilv"), $content);
                        $content = str_replace("{amount}", $order->goods_price, $content);
                        $content = str_replace("{paytype}", $payinfo->pay_name, $content);
                        $content = str_replace("{address}", $resultArr["data"]["payurl"], $content);
                        $buttonjson = str_replace("{url}", $resultArr["data"]["payurl"], $buttonInfo["button_json"]);
                        // 修复：使用 payurl 生成二维码，需要 URL 编码
                        $photo = dujiaoka_config_get("pay_image_api").urlencode($resultArr["data"]["payurl"]);
                        break;
                }
                return $this->_return(
                    $content,
                    $buttonInfo["mode"],
                    $buttonInfo["is_show"],
                    json_decode($buttonjson, true),
                    "photo",
                    $photo
                );
            }else{
                $bot->sendMessage($update->getCallbackQuery()->getMessage()->getChat()->getId(),$result);exit();
            }
        } catch (Exception $exception) {
            DB::rollBack();
            $bot->sendMessage($update->getCallbackQuery()->getMessage()->getChat()->getId(),$exception->getMessage());exit();
        }
    }

    //商品列表
    public function goods($update,$bot){
        $userInfo = Util::getUserTelegramId($update->getCallbackQuery()->getMessage()->getChat()->getId());
        $buttonInfo = $this->buttonService->withButtonData("goods",$userInfo["lang"]);
        $array = explode("_",$update->getCallbackQuery()->getData());
        $goodsList = $this->goodsService->goodsClass($array[1]);
        $arr = [];
        foreach ($goodsList as $goods){
            $arr[] = [["text" => $goods["gd_name"]."(剩余库存".$goods["carmis_count"].")","callback_data" => "goodsinfo_".$goods["id"]]];
        }
        $arr[] = [["text" => trans("dujiaoka.return",[],str_replace("-", "_", $userInfo["lang"])),"callback_data" => "shoplist"],["text" => trans("dujiaoka.clone",[],str_replace("-", "_", $userInfo["lang"])),"callback_data" => "clone"]];
        return $this->_return($buttonInfo["content"],$buttonInfo["mode"],$buttonInfo["is_show"],$arr);
    }

    //获取商品详细信息
    public function goodsinfo($update,$bot){
        $userInfo = Util::getUserTelegramId($update->getCallbackQuery()->getMessage()->getChat()->getId());
        $buttonInfo = $this->buttonService->withButtonData("goodsinfo",$userInfo["lang"]);
        $array = explode("_",$update->getCallbackQuery()->getData());
        $goodsList = $this->goodsService->detail($array[1]);
        //var_dump($goodsList);exit();
        $content = str_replace("{gd_name}", $goodsList["gd_name"], $buttonInfo["content"]);
        $content = str_replace("{info}", $goodsList["gd_description"], $content);
        $content = str_replace("{cardscount}", $goodsList["carmis_count"], $content);
        $content = str_replace("{price}", $goodsList["actual_price"], $content);
        if($goodsList["type"] == \App\Models\Goods::AUTOMATIC_DELIVERY){
            $type = __('hyper.buy_automatic_delivery',[],str_replace("-", "_", $userInfo["lang"]));
        }else{
            $type = __('hyper.buy_charge',[],str_replace("-", "_", $userInfo["lang"]));
        }
        $content = str_replace("{type}", $type, $content);
        $button  = str_replace("{id}", $array[1],$buttonInfo["button_json"]);
        $button  = str_replace("{goodslistid}", $goodsList["group_id"],$button);
        return $this->_return($content,$buttonInfo["mode"],$buttonInfo["is_show"],json_decode($button, true));
    }

    //弹出购买提示
    public function usegoods($update,$bot){
        $userInfo = Util::getUserTelegramId($update->getCallbackQuery()->getMessage()->getChat()->getId());
        $buttonInfo = $this->buttonService->withButtonData("goodsinfo",$userInfo["lang"]);
        $array = explode("_",$update->getCallbackQuery()->getData());
        $goodsList = $this->goodsService->detail($array[1]);
        $text = $goodsList["buy_prompt"];
        $id = $update->getCallbackQuery()->getId();
        $url = "https://api.telegram.org/bot".dujiaoka_config_get("telegram_bot_api_token")."/answerCallbackQuery?show_alert=true&callback_query_id=".$id."&text=".$text;
        file_get_contents($url);exit();
    }

    //购买商品
    public function goodsbuy($update,$bot){
        $userInfo = Util::getUserTelegramId($update->getCallbackQuery()->getMessage()->getChat()->getId());
        $buttonInfo = $this->buttonService->withButtonData("goodsbuy",$userInfo["lang"]);
        $array = explode("_",$update->getCallbackQuery()->getData());
        $goodsList = $this->goodsService->detail($array[1]);
        if($goodsList["carmis_count"] == 0){
            $text = trans("dujiaoka.insufficient_stock",[],str_replace("-", "_", $userInfo["lang"]));
            $id = $update->getCallbackQuery()->getId();
            $url = "https://api.telegram.org/bot".dujiaoka_config_get("telegram_bot_api_token")."/answerCallbackQuery?show_alert=true&callback_query_id=".$id."&text=".$text;
            file_get_contents($url);exit();
        }
        Cache::put($update->getCallbackQuery()->getMessage()->getChat()->getId()."buygoods",$array[1]);
        $bot->sendMessage(
            $update->getCallbackQuery()->getMessage()->getChat()->getId(),
            $buttonInfo["content"],
            $buttonInfo["mode"]
        );exit();
    }

    //支付之前确认页面
    public function confirmorder($update,$bot){
        $userInfo = Util::getUserTelegramId($update->getCallbackQuery()->getMessage()->getChat()->getId());
        $buttonInfo = $this->buttonService->withButtonData("confirmorder",$userInfo["lang"]);
        $array = explode("_",$update->getCallbackQuery()->getData());
        DB::beginTransaction();
        try {
            $request = [
                "gid" => $array[2],
                "by_amount" => $array[3],
            ];
            $goods = $this->orderService->validatorGoodsTg($request);
            $this->orderService->validatorLoopCarmisTg($request);
            // 设置商品
            $this->orderProcessService->setGoods($goods);
            // 优惠码
            //$coupon = $this->orderService->validatorCoupon($request);
            // 设置优惠码
            //$this->orderProcessService->setCoupon($coupon);
            //$otherIpt = $this->orderService->validatorChargeInput($goods, $request);
            //$this->orderProcessService->setOtherIpt($otherIpt);
            //设置预选卡密
            //$carmi_id = intval($request['carmi_id']);
            //$this->orderProcessService->setCarmi($carmi_id);
            // 数量，如果预选了卡密，则只能购买一个
            $this->orderProcessService->setBuyAmount($request['by_amount']);
            // 支付方式
            // 支付方式
            $payment_limit = json_decode($goods->payment_limit, true);
            $payway = $array[1];
            if ($payway > 0 && (is_array($payment_limit) && count($payment_limit) && !in_array($payway, $payment_limit))) {
                return $this->err(trans('dujiaoka.prompt.payment_limit',[],str_replace("-", "_", $userInfo["lang"])));
            }
            $this->orderProcessService->setPayID($payway);
            // 下单邮箱
            $this->orderProcessService->setEmail($update->getCallbackQuery()->getMessage()->getChat()->getId()."@qq.com");
            // ip地址
            $this->orderProcessService->setBuyIP("8.8.8.8");
            // 查询密码
            $this->orderProcessService->setSearchPwd("");
            // 邀请码
            $this->orderProcessService->setAff("");
            // 创建订单
            $order = $this->orderProcessService->createOrder()->toArray();
            DB::commit();
            // 设置订单cookie
            $content = str_replace("{gd_name}", $order["title"], $buttonInfo["content"]);
            $content = str_replace("{ordersn}", $order["order_sn"], $content);
            $content = str_replace("{price}", $order["total_price"], $content);  //actual_price
            $content = str_replace("{number}", $order["buy_amount"], $content);
            if($order["pay_id"] == 0){
                $pay_name = trans("dujiaoka.yue",[],str_replace("-", "_", $userInfo["lang"]));
            }else{
                $payInfo = Pay::query()->where("id",$order["pay_id"])->first()->toArray();
                $pay_name = $payInfo["pay_name"];
            }
            $content = str_replace("{paytype}", $pay_name, $content);
            $button = str_replace("{ordersn}", $order["order_sn"], $buttonInfo["button_json"]);
            return $this->_return($content,$buttonInfo["mode"],$buttonInfo["is_show"],json_decode($button, true));
        } catch (RuleValidationException $exception) {
            DB::rollBack();
            $bot->sendMessage($update->getCallbackQuery()->getMessage()->getChat()->getId(),$exception->getMessage());exit();
        }
    }

    public function gopay($update,$bot){
        $userInfo = Util::getUserTelegramId($update->getCallbackQuery()->getMessage()->getChat()->getId());
        $buttonInfo = $this->buttonService->withButtonData("gopay",$userInfo["lang"]);
        $array = explode("_",$update->getCallbackQuery()->getData());
        $order = $this->orderService->detailOrderSN($array[1])->toArray();

        if($order["pay"]){
            $controllerName = $order["pay"]["controller"];
            $paycheck = $order["pay"]["pay_check"];
            $payname = $order["pay"]["pay_name"];
        }else{
            $controllerName = "WalletController";
            $paycheck = $update->getCallbackQuery()->getMessage()->getChat()->getId();
            $payname = trans("dujiaoka.yue",[],str_replace("-", "_", $userInfo["lang"]));
        }
        $payController = "App\\Http\\Controllers\\Pay\\".$controllerName;
        $controller = new $payController();
        $result = $controller->gateway($paycheck,$order["order_sn"],"json");
        $resultArr = json_decode($result,true);
        if(is_array($resultArr)) {
            switch ($controllerName) {
                case "TokenPayController":
                    if(!$resultArr["success"]){
                        $bot->sendMessage($update->getCallbackQuery()->getMessage()->getChat()->getId(),$resultArr["message"]);exit();
                    }
                    $content = str_replace("{ordersn}", $order["order_sn"], $buttonInfo["content"]);
                    $content = str_replace("{payamount}", $resultArr["info"]["Amount"], $content);
                    $content = str_replace("{amount}", $order["total_price"], $content);
                    $content = str_replace("{paytype}", $payname, $content);
                    $content = str_replace("{address}", $resultArr["info"]["ToAddress"], $content);
                    $buttonjson = str_replace("{url}", $resultArr["data"], $buttonInfo["button_json"]);
                    // 修复：从 ToAddress 中提取纯钱包地址（如果是链接则提取，如果是地址则直接使用）
                    $toAddress = $resultArr["info"]["ToAddress"];
                    // 如果是链接，尝试提取钱包地址（TRC20地址以T开头，34位字符）
                    if (filter_var($toAddress, FILTER_VALIDATE_URL)) {
                        // 尝试从URL中提取地址（可能格式：https://xxx.com/pay?address=TRxxx 或 https://xxx.com/TRxxx）
                        if (preg_match('/(T[A-Za-z1-9]{33})/', $toAddress, $matches)) {
                            $walletAddress = $matches[1];
                        } elseif (preg_match('/(0x[a-fA-F0-9]{40})/', $toAddress, $matches)) {
                            // ERC20地址格式
                            $walletAddress = $matches[1];
                        } else {
                            // 如果无法提取，使用原值
                            $walletAddress = $toAddress;
                        }
                    } else {
                        // 直接是钱包地址
                        $walletAddress = $toAddress;
                    }
                    $photo = dujiaoka_config_get("pay_image_api") . urlencode($walletAddress);
                    break;
                case "EpusdtController":
                    if($resultArr["status_code"] != 200){
                        $bot->sendMessage($update->getCallbackQuery()->getMessage()->getChat()->getId(),$resultArr["message"]);exit();
                    }
                    $content = str_replace("{ordersn}", $order["order_sn"], $buttonInfo["content"]);
                    $content = str_replace("{payamount}", $resultArr["data"]["actual_amount"], $content);
                    $content = str_replace("{amount}", $order["total_price"], $content);
                    $content = str_replace("{paytype}", $payname, $content);
                    $content = str_replace("{address}", $resultArr["data"]["token"], $content);
                    $buttonjson = str_replace("{url}", $resultArr["data"]["payment_url"], $buttonInfo["button_json"]);
                    // 修复：使用 token（钱包地址）生成二维码，而不是 payment_url（支付链接）
                    $walletAddress = $resultArr["data"]["token"];
                    $photo = dujiaoka_config_get("pay_image_api") . urlencode($walletAddress);
                    break;
                case "YipayController":
                    if ($resultArr["code"] == "-1") {
                        $bot->sendMessage($update->getCallbackQuery()->getMessage()->getChat()->getId(), $resultArr["msg"]);
                        exit();
                    }
                    $content = str_replace("{ordersn}", $order["order_sn"], $buttonInfo["content"]);
                    $content = str_replace("{payamount}", (float)$order["total_price"] * (float)dujiaoka_config_get("huilv"), $content);
                    $content = str_replace("{amount}", (float)$order["total_price"] * (float)dujiaoka_config_get("huilv"), $content);
                    $content = str_replace("{paytype}", $payname, $content);
                    $content = str_replace("{address}", $resultArr["data"]["payurl"], $content);
                    $buttonjson = str_replace("{url}", $resultArr["data"]["payurl"], $buttonInfo["button_json"]);
                    // 修复：使用 payurl 生成二维码，需要 URL 编码
                    $photo = dujiaoka_config_get("pay_image_api") . urlencode($resultArr["data"]["payurl"]);
                    break;
                case "WalletController":
                    $bot->sendMessage($update->getCallbackQuery()->getMessage()->getChat()->getId(),$resultArr["message"]);exit();
            }
            return $this->_return(
                $content,
                $buttonInfo["mode"],
                $buttonInfo["is_show"],
                json_decode($buttonjson, true),
                "photo",
                $photo
            );
        }
    }

    public function customrecharge($update,$bot){
        $userInfo = Util::getUserTelegramId($update->getCallbackQuery()->getMessage()->getChat()->getId());
        $buttonInfo = $this->buttonService->withButtonData("customrecharge",$userInfo["lang"]);
        Cache::put($update->getCallbackQuery()->getMessage()->getChat()->getId()."customrecharge","12345");
        $bot->sendMessage($update->getCallbackQuery()->getMessage()->getChat()->getId(),$buttonInfo["content"],$buttonInfo["mode"]);exit();
    }

    //为自己购买会员
    public function premiumself($update,$bot){
        $userInfo = Util::getUserTelegramId($update->getCallbackQuery()->getMessage()->getChat()->getId());
        $buttonInfo = $this->buttonService->withButtonData("premiumself",$userInfo["lang"]);
        $content = str_replace("{username}", $update->getCallbackQuery()->getMessage()->getChat()->getUsername(), $buttonInfo["content"]);
        $huiyuanConfig = json_decode(dujiaoka_config_get("subscribe_buy_config"),true);
        $button = [];
        if(is_array($huiyuanConfig)){
            foreach ($huiyuanConfig as $k=>$v){
                $button[] = [["text"=>$k.trans("dujiaoka.month",[],str_replace("-", "_", $userInfo["lang"]))."(".$v." USDT)","callback_data"=>"confirmrehuiyuan_my_".$k]];
            }
            $button[] = [["text"=>trans("clone",[],str_replace("-", "_", $userInfo["lang"])),"callback_data"=>"clone"]];
            return $this->_return(TelegramText($content),$buttonInfo["mode"],$buttonInfo["is_show"],$button);
        }else{
            $bot->sendMessage($update->getCallbackQuery()->getMessage()->getChat()->getId(),trans("dujiaoka,not_huiyuan_config",[],str_replace("-", "_", $userInfo["lang"])));exit();
        }
    }

    //确认充值会员页面
    public function confirmrehuiyuan($update,$bot){
        $userInfo = Util::getUserTelegramId($update->getCallbackQuery()->getMessage()->getChat()->getId());
        $buttonInfo = $this->buttonService->withButtonData("confirmrehuiyuan",$userInfo["lang"]);
        $data = explode("_",$update->getCallbackQuery()->getData());
        if($data[1] == "my"){
            $username = $update->getCallbackQuery()->getMessage()->getChat()->getUsername();
        }else{
            $username = $data[1];
        }
        $content = str_replace("{username}", "@".$username, $buttonInfo["content"]);
        $content = str_replace("{month}", $data[2], $content);
        $button = str_replace("{username}", $username, $buttonInfo["button_json"]);
        $button = str_replace("{month}", $data[2], $button);
        $huiyuanConfig = json_decode(dujiaoka_config_get("subscribe_buy_config"),true);
        $content = str_replace("{amount}", $huiyuanConfig[$data[2]], $content);
        return $this->_return(TelegramText($content),$buttonInfo["mode"],$buttonInfo["is_show"],json_decode($button, true));
    }


    //支付会员
    public function payhuiyuan($update,$bot){
        $userInfo = User::query()->where("telegram_id",$update->getCallbackQuery()->getMessage()->getChat()->getId())->first();
        $buttonInfo = $this->buttonService->withButtonData("payhuiyuan",$userInfo->lang);
        $data = explode("_",$update->getCallbackQuery()->getData());
        if($data[1] == "my"){
            $username = $update->getCallbackQuery()->getMessage()->getChat()->getUsername();
        }else{
            $username = $data[1];
        }
        $huiyuanConfig = json_decode(dujiaoka_config_get("subscribe_buy_config"),true);
        $amount = $huiyuanConfig[$data[2]];
        if($userInfo->money < $amount){
            $bot->sendMessage($update->getCallbackQuery()->getMessage()->getChat()->getId(),"余额不足");exit();
        }
        //先扣除余额
        try {
            Db::beginTransaction();
            $userInfo->money = bcsub($userInfo->money, $amount, 2);
            $userInfo->save();
            //发货
            if (dujiaoka_config_get("chang_huiyuan") == "fragment") {
                getFragmentInfo($username, $data[2]);
            } else {
                apiHuiyuanPay($username, $data[2]);
            }
            DB::commit();
            $content = str_replace("{amount}", $amount, $buttonInfo["content"]);
            return $this->_return(TelegramText($content),$buttonInfo["mode"],$buttonInfo["is_show"],json_decode($buttonInfo["button_json"], true));
        }catch (Exception $e){
            DB::rollBack();
            $bot->sendMessage($update->getCallbackQuery()->getMessage()->getChat()->getId(),trans("dujiaoka.".$e->getMessage(),[],str_replace("-", "_", $userInfo["lang"])));exit();
        }
    }


    //为他人购买会员
    public function premiumother($update,$bot){
        $userInfo = Util::getUserTelegramId($update->getCallbackQuery()->getMessage()->getChat()->getId());
        $buttonInfo = $this->buttonService->withButtonData("premiumother",$userInfo["lang"]);
        Cache::put($update->getCallbackQuery()->getMessage()->getChat()->getId()."premiumother","12345");
        $bot->sendMessage($update->getCallbackQuery()->getMessage()->getChat()->getId(),$buttonInfo["content"],$buttonInfo["mode"]);exit();
    }

    //重新获取订单文件
    public function getorder($update,$bot){
        $userInfo = Util::getUserTelegramId($update->getCallbackQuery()->getMessage()->getChat()->getId());
        $buttonInfo = $this->buttonService->withButtonData("getorder",$userInfo["lang"]);
        $data = explode("_",$update->getCallbackQuery()->getData());
        if(is_file($_SERVER['DOCUMENT_ROOT']."/files/dispatch/".$data[1].".txt")){
            $filename = $_SERVER['DOCUMENT_ROOT']."/files/dispatch/".$data[1].".txt";
            $document = new \CURLFile($filename);
        }elseif(is_file($_SERVER['DOCUMENT_ROOT']."/files/dispatch/".$data[1].".zip")){
            $document = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . "/files/dispatch/" . $data[1] . ".zip";
        }else{
            $bot->sendMessage($update->getCallbackQuery()->getMessage()->getChat()->getId(),"Not found order file");exit();
        }
        try {
            $bot->sendDocument($update->getCallbackQuery()->getMessage()->getChat()->getId(), $document, $data[1]);
        }catch (\TelegramBot\Api\HttpException $e){

        }
        exit();
    }

    public function setlang($update,$bot){
        $userInfo = Util::getUserTelegramId($update->getCallbackQuery()->getMessage()->getChat()->getId());
        $data = explode("_",$update->getCallbackQuery()->getData());
        if($data[1] == $userInfo["lang"]){
            $bot->sendMessage($update->getCallbackQuery()->getMessage()->getChat()->getId(),trans("dujiaoka.No_need_to_change_language",[],str_replace("-", "_", $userInfo["lang"])));exit();
        }
        $buttonInfo = $this->buttonService->withButtonData("start",$data[1]);
        $buttonArr = json_decode($buttonInfo["button_json"],true);
        if(is_array($buttonArr)){
            $buttonObj = new \TelegramBot\Api\Types\ReplyKeyboardMarkup($buttonArr, false,true);
        }else{
            $buttonObj = null;
        }
        $bot->sendMessage(
            $update->getCallbackQuery()->getMessage()->getChat()->getId(),
            TelegramText($buttonInfo["content"]),
            $buttonInfo["mode"],
            (int)$buttonInfo["is_show"],
            null,
            $buttonObj
        );exit();
    }

    //通用返回
    public function _return($content,$mode,$isshow,$arr,$type = "1234",$url = ""){
        $resdata = [
            $type => $url,
            "content" => $content,
            "mode" => $mode,
            "is_show" => $isshow,
            "button" => $arr,
            "type" => $type
        ];
        return $resdata;
    }
}
