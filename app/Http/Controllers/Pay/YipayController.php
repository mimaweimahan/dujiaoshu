<?php
namespace App\Http\Controllers\Pay;

use App\Exceptions\RuleValidationException;
use App\Http\Controllers\PayController;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class YipayController extends PayController
{

    public function gateway(string $payway, string $orderSN,string $type = null)
    {
        try {
            // 加载网关
            $this->loadGateWay($orderSN, $payway);
            //组装支付参数
            $parameter = [
                'pid' =>  $this->payGateway->merchant_id,
                'type' => $payway,
                'out_trade_no' => $this->order->order_sn,
                "clientip" => "8.8.8.8",
                'return_url' => route('yipay-return', ['order_id' => $this->order->order_sn]),
                'notify_url' => url($this->payGateway->pay_handleroute . '/notify_url'),
                'name'   => $this->order->order_sn,
                'money'  => (float)$this->order->actual_price * (float)dujiaoka_config_get("huilv"),
                'sign' => $this->payGateway->merchant_pem,
                'sign_type' =>'MD5'
            ];
            ksort($parameter); //重新排序$data数组
            reset($parameter); //内部指针指向数组中的第一个元素
            $sign = '';
            foreach ($parameter as $key => $val) {
                if ($key == "sign" || $key == "sign_type" || $val == "") continue;
                if ($key != 'sign') {
                    if ($sign != '') {
                        $sign .= "&";
                    }
                    $sign .= "$key=$val"; //拼接为url参数形式
                }
            }

            $sign = md5($sign . $this->payGateway->merchant_pem);//密码追加进入开始MD5签名
            $parameter['sign'] = $sign;
            if($type == "json"){
                $url = $this->payGateway->merchant_key."mapi.php";
                $resdata = $this->request_url($url,$parameter);
                return $resdata;
            }
            //待请求参数数组
            $sHtml = "<form id='alipaysubmit' name='alipaysubmit' action='" . $this->payGateway->merchant_key . "submit.php' method='get'>";
            foreach($parameter as $key => $val) {
                $sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
            }
            //submit按钮控件请不要含有name属性
            $sHtml = $sHtml."<input type='submit' value=''></form>";
            $sHtml = $sHtml."<script>document.forms['alipaysubmit'].submit();</script>";
            return $sHtml;
        } catch (RuleValidationException $exception) {
            if($type == "json"){
                return $exception->getMessage();
            }
            return $this->err($exception->getMessage());
        }
    }

    public function notifyUrl(Request $request)
    {
        $data = $request->all();
        $order = $this->orderService->detailOrderSN($data['out_trade_no']);
        if (!$order) {
            return 'fail';
        }
        $payGateway = $this->payService->detail($order->pay_id);
        if (!$payGateway) {
            return 'fail';
        }
        if($payGateway->pay_handleroute != '/pay/yipay'){
            return 'fail';
        }
        ksort($data); //重新排序$data数组
        reset($data); //内部指针指向数组中的第一个元素
        $sign = '';
        foreach ($data as $key => $val) {
            if ($key == "sign" || $key == "sign_type" || $val == "") continue;
            if ($key != 'sign') {
                if ($sign != '') {
                    $sign .= "&";
                }
                $sign .= "$key=$val"; //拼接为url参数形式
            }
        }
        if (!$data['trade_no'] || md5($sign . $payGateway->merchant_pem) != $data['sign']) { //不合法的数据
            return 'fail';  //返回失败 继续补单
        } else {
            //合法的数据
            //业务处理
            $this->orderProcessService->completedOrder($data['out_trade_no'], $data['money'], $data['trade_no']);
            return 'success';
        }
    }

    public function returnUrl(Request $request)
    {
        $oid = $request->get('order_id');
        // 有些易支付太垃了，异步通知还没到就跳转了，导致订单显示待支付，其实已经支付了，所以这里休眠2秒
        sleep(2);
        return redirect(url('detail-order-sn', ['orderSN' => $oid]));
    }

    /**
     * 请求一个地址
     *
     * @param   string $url 需要请求的地址
     * @param   array $post 需要以post的方式发送的数据
     * @param   bool $is_async 是否是异步方式请求；暂未实现
     * @param   int $retry 重试次数；默认0
     * @param   bool $verify_ssl 是否验证 ssl 证书；默认禁用
     * @return  mixed|string
     */
    public function request_url($url, $post = array(), $is_async = FALSE, $retry = 0, $verify_ssl = false)
    {
        if (empty($url)) return '';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);

        // 需要以post的方式发送的数据
        if (!empty($post)) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, is_array($post) ? http_build_query($post): $post);
        }

        // HTTPS
        if (!$verify_ssl) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
        }

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true); // 自动设置Referer
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 返回curl获取到的内容而不是直接输出
        curl_setopt($ch, CURLOPT_HEADER, false); // 不显示返回的header内容
        curl_setopt($ch, CURLOPT_TIMEOUT, 5); // 5秒超时
        $content = curl_exec($ch);

        if($content === false){
            throw new Exception('Http request message :'.curl_error($ch));
        }

        // 重试
        if ($retry > 0 && $content === false) {
            $try = 0;
            do {
                $content = curl_exec($ch); ++$try;
            }
            while ($content === false && $try <= $retry);
        }

        curl_close($ch);
        return $content;
    }

}
