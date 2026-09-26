<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Tests\Unit\Api;

use Is4ngle\AlibabaOpen\Api\Fenxiao\ProductKeywordsSearchRequest;
use Is4ngle\AlibabaOpen\Api\Trade\GetBuyerViewRequest;
use Is4ngle\AlibabaOpen\Api\Trade\FenxiaoOrderCreateRequest;
use Is4ngle\AlibabaOpen\Api\Registry;
use PHPUnit\Framework\TestCase;

/**
 * 生成类抽样测试：平铺型 / 包裹型 / 嵌套型三类代表 + Registry 完整性。
 */
final class GeneratedRequestTest extends TestCase
{
    /** 包裹型：字段平铺书写，toParams() 自动包进 param 键 */
    public function testWrappedRequest(): void
    {
        $req = new ProductKeywordsSearchRequest();
        $req->keywords = '保温杯';
        $req->pageNum = 1;
        $req->pageSize = 20;
        $req->filter = ['fxBrandOffer'];

        $this->assertSame('com.alibaba.fenxiao', $req->getNamespace());
        $this->assertSame('productKeywordsSearch', $req->getApiName());
        $this->assertSame(1, $req->getVersion());
        $this->assertSame('com.alibaba.fenxiao:productKeywordsSearch-1', $req->toApiId());

        $params = $req->toParams();
        // 全部字段包在 param 键下
        $this->assertSame(['param'], array_keys($params));
        $this->assertSame('保温杯', $params['param']['keywords']);
        $this->assertSame(1, $params['param']['pageNum']);
        $this->assertSame(['fxBrandOffer'], $params['param']['filter']);
    }

    /** 包裹型：未设置的字段（null）不进参数 */
    public function testWrappedRequestOmitsNulls(): void
    {
        $req = new ProductKeywordsSearchRequest();
        $req->keywords = 'x';

        $params = $req->toParams();
        $this->assertSame(['keywords' => 'x'], $params['param']);
    }

    /** 平铺型：字段即顶层参数 */
    public function testFlatRequest(): void
    {
        $req = new GetBuyerViewRequest();
        $req->webSite = '1688';
        $req->orderId = 123456;
        $req->includeFields = 'GuaranteesTerms,NativeLogistics';

        $this->assertSame('com.alibaba.trade', $req->getNamespace());
        $this->assertSame('alibaba.trade.get.buyerView', $req->getApiName());

        $params = $req->toParams();
        $this->assertSame('1688', $params['webSite']);
        $this->assertSame(123456, $params['orderId']);
        $this->assertSame('GuaranteesTerms,NativeLogistics', $params['includeFields']);
        $this->assertArrayNotHasKey('outOrderId', $params);
    }

    /** 嵌套型：嵌套结构以 array 传递（Client 负责 json_encode） */
    public function testNestedRequest(): void
    {
        $req = new FenxiaoOrderCreateRequest();
        $req->flow = 'fenxiao';
        $req->addressParam = ['fullName' => '张三', 'mobile' => '15200000000'];
        $req->cargoParamList = [
            ['offerId' => 554456348334, 'specId' => 'b266...', 'quantity' => 5],
        ];

        $params = $req->toParams();
        $this->assertSame('fenxiao', $params['flow']);
        $this->assertSame('张三', $params['addressParam']['fullName']);
        $this->assertSame(554456348334, $params['cargoParamList'][0]['offerId']);
    }

    /** Registry：106 个 API、可按短名查找 */
    public function testRegistry(): void
    {
        $all = Registry::all();
        $this->assertCount(106, $all);

        $found = Registry::find('ProductKeywordsSearch');
        $this->assertNotNull($found);
        $this->assertSame(ProductKeywordsSearchRequest::class, $found['class']);
        $this->assertSame('com.alibaba.fenxiao:productKeywordsSearch-1', $found['api']);

        $this->assertNull(Registry::find('NotExist'));
    }

    /** 生成的类全部可实例化（语法/继承冒烟） */
    public function testAllGeneratedClassesInstantiate(): void
    {
        $missing = [];
        foreach (Registry::all() as $short => $meta) {
            if (!class_exists($meta['class'])) {
                $missing[] = $short;
                continue;
            }
            $req = new $meta['class']();
            $this->assertInstanceOf(\Is4ngle\AlibabaOpen\Request\AbstractRequest::class, $req);
            // 三元组非空
            $this->assertNotSame('', $req->getNamespace());
            $this->assertNotSame('', $req->getApiName());
        }
        $this->assertSame([], $missing);
    }
}
