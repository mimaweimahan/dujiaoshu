<?php

namespace App\Util;

class BaseUtil
{
    public function calculatePriceWithExchangeRate(float $price, int $payID): float
    {
        if ($payID > 0) {
            $payDetail = app('Service\PayService')->detail($payID);

            // 检查 is_openhui 字段是否为 1 以及 pay_qhuilv 是否有效
            if ($payDetail->is_openhui == 1 && !empty($payDetail->pay_qhuilv) && $payDetail->pay_qhuilv != 0) {
                $exchangeRate = $payDetail->pay_qhuilv;
                $operation = $payDetail->pay_operation ?? '*'; // 默认为乘法

                // 如果价格为0，直接返回0，避免不必要的计算
                if ($price == 0) {
                    return 0.00;
                }

                // 根据运算符号计算新价格
                switch ($operation) {
                    case '*':
                        $price *= $exchangeRate;
                        break;
                    case '/':
                        // 防止除以0
                        if ($exchangeRate != 0) {
                            $price /= $exchangeRate;
                        } else {
                            // 如果汇率为0，避免除法操作，直接返回原价
                            return $price;
                        }
                        break;
                    default:
                        // 如果运算符不是乘或除，不调整价格
                        return $price;
                }

                return round($price, 2); // 返回四舍五入到小数点后两位的结果
            }
        }

        // 如果 payID 小于等于 0，或 is_openhui 不为 1，或汇率值无效，则返回原价
        return $price;
    }


    /**
     * 计算手续费
     * @param float $price
     * @param int $payID
     * @return float
     */
    public function calculatePayFee(float $price, int $payID): float
    {
        if ($payID > 0) {
            $payDetail = app('Service\PayService')->detail($payID);

            // 检查 is_openfee 字段是否为 1
            if ($payDetail->is_openfee == 1) {
                $fee = $payDetail->pay_fee;

                // 如果价格为 0 或手续费率为 0，则手续费为 0
                if (!$price || $fee == 0) {
                    return 0.00;
                }

                // 计算手续费
                $fee = ceil($fee * $price) / 100;
                return $fee;
            }
        }

        // 如果 payID 小于等于 0，或 is_openfee 不为 1，则手续费为 0
        return 0.00;
    }
}
