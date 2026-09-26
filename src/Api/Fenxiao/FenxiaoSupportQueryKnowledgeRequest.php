<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Fenxiao;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.fenxiao:fenxiaoSupportQueryKnowledge-1
 * 生成自官方 SDK 参数类 FenxiaoSupportQueryKnowledgeParam（bin/generate.php，勿手改，重跑覆盖）
 * @todo 联调核对 apiName（驼峰还原可能有歧义，报 gw.APIUnsupported 时改 bin/generate.php 的 API_NAME_OVERRIDES 后重跑）
 */
final class FenxiaoSupportQueryKnowledgeRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.fenxiao';
    }

    public function getApiName(): string
    {
        return 'fenxiaoSupportQueryKnowledge';
    }

    /** 铺货工具工具ID | 示例: 123456 */
    public ?string $appKey = null;
    /** 渠道  thyny：淘宝 tm：天猫 douyin：抖音 pinduoduo：拼多多 kuaituantuan：快团团 xiaohongshu：小红书 kuaishou：快手 weixin：视频号 jingdong：京东 youzan：有赞 weidian：微店 taote：淘特 amazon：亚马逊 weixinxiaodian：微信小店 | 示例: thyny */
    public ?string $channel = null;
    /** 图片URL，一张 | 示例: https://cbu01.alicdn.com/img/ibank/O1CN01WJMghr2IEqh094VOS_!!3584959255-0-cib.jpg */
    public ?string $imageUrl = null;
    /** 问答描述 | 示例: 怎么铺货到淘宝 */
    public ?string $query = null;
    /** 会话ID：用于会话记忆，首次调用不必传，如要使用会话记忆二次调用可以传 | 示例: 304c04a4-bd25-4534-8bfe-44430f254afa */
    public ?string $sessionId = null;
    /** 用户id | 示例: 1233345 */
    public ?int $userId = null;

    protected function wrapKey(): ?string
    {
        return 'queryRequest';
    }
}
