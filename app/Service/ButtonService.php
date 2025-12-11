<?php

namespace App\Service;

use App\Models\Button;

class ButtonService
{
    /**
     * 通过按钮的keyword查询整个按钮的数据
     *
     * @param int $goodsID 商品id
     * @param int $byAmount 数量
     * @return array|null
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    public function withButtonData(string $keyword,string $lang = "zh-CN")
    {
        $button = Button::query()
            ->where('keyword', $keyword)
            ->where('lang',$lang)
            ->first();
        return $button ? $button->toArray() : null;
    }

    /**
     * 通过按钮的标题查询整个按钮的数据
     *
     * @param int $goodsID 商品id
     * @param int $byAmount 数量
     * @return array|null
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    public function withButtonTitleData(string $keyword,string $lang = "zh-CN")
    {
        $button = Button::query()
            ->where('title', $keyword)
            ->where('lang',$lang)
            ->first();
        return $button ? $button->toArray() : null;
    }
}
