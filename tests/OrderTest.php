<?php

namespace KuCoin\Futures\SDK\Tests;

use KuCoin\Futures\SDK\PrivateApi\Order;

class OrderTest extends TestCase
{
    protected $apiClass    = Order::class;
    protected $apiWithAuth = true;

    /**
     * @dataProvider apiProvider
     * @param Order $api
     * @return array|string
     * @throws \KuCoin\Futures\SDK\Exceptions\BusinessException
     * @throws \KuCoin\Futures\SDK\Exceptions\HttpException
     * @throws \KuCoin\Futures\SDK\Exceptions\InvalidApiUriException
     */
    public function testCreateLimit(Order $api)
    {
        $order = [
            'clientOid' => uniqid(),
            'type'      => 'limit',
            'side'      => 'buy',
            'symbol'    => 'XBTUSDM',
            'leverage'  => 2,
            'remark'    => '\中文备注 ',

            'price' => 100,
            'size'  => 1,
        ];
        $data = $api->create($order);
        $this->assertInternalType('array', $data);
        $this->assertArrayHasKey('orderId', $data);
    }

    /**
     * @dataProvider apiProvider
     * @param Order $api
     * @return array|string
     * @throws \KuCoin\Futures\SDK\Exceptions\BusinessException
     * @throws \KuCoin\Futures\SDK\Exceptions\HttpException
     * @throws \KuCoin\Futures\SDK\Exceptions\InvalidApiUriException
     */
    public function testCreateMarket(Order $api)
    {
        $order = [
            'clientOid' => uniqid(),
            'type'      => 'market',
            'side'      => 'buy',
            'symbol'    => 'XBTUSDM',
            'leverage'  => 2,
            'remark'    => 'Test Order ' . time(),

            'size' => 1,
        ];
        $data = $api->create($order);
        $this->assertInternalType('array', $data);
        $this->assertArrayHasKey('orderId', $data);
    }

    /**
     * @dataProvider apiProvider
     * @param Order $api
     * @throws \KuCoin\Futures\SDK\Exceptions\BusinessException
     * @throws \KuCoin\Futures\SDK\Exceptions\HttpException
     * @throws \KuCoin\Futures\SDK\Exceptions\InvalidApiUriException
     */
    public function testGetList(Order $api)
    {
        $data = $api->getList(['symbol' => 'XBTUSDM'], ['currentPage' => 1, 'pageSize' => 10]);
        $this->assertPagination($data);
        foreach ($data['items'] as $item) {
            $this->assertArrayHasKey('symbol', $item);
            $this->assertArrayHasKey('hidden', $item);
            $this->assertArrayHasKey('type', $item);
            $this->assertArrayHasKey('iceberg', $item);
            $this->assertArrayHasKey('createdAt', $item);
            $this->assertArrayHasKey('stopTriggered', $item);
            $this->assertArrayHasKey('id', $item);
            $this->assertArrayHasKey('timeInForce', $item);
            $this->assertArrayHasKey('side', $item);
            $this->assertArrayHasKey('dealSize', $item);
            $this->assertArrayHasKey('stp', $item);
            $this->assertArrayHasKey('postOnly', $item);
            $this->assertArrayHasKey('size', $item);
            $this->assertArrayHasKey('stop', $item);
            $this->assertArrayHasKey('settleCurrency', $item);
            $this->assertArrayHasKey('status', $item);
            $this->assertArrayHasKey('updatedAt', $item);
            $this->assertArrayHasKey('orderTime', $item);
        }
    }

    /**
     * @dataProvider apiProvider
     * @param Order $api
     * @throws \KuCoin\Futures\SDK\Exceptions\BusinessException
     * @throws \KuCoin\Futures\SDK\Exceptions\HttpException
     * @throws \KuCoin\Futures\SDK\Exceptions\InvalidApiUriException
     */
    public function testGetDetail(Order $api)
    {
        $data = $api->getList(['symbol' => 'XBTUSDM'], ['currentPage' => 1, 'pageSize' => 10]);
        $this->assertPagination($data);
        $orders = $data['items'];
        if (isset($orders[0])) {
            $order = $api->getDetail($orders[0]['id']);
            $this->assertArrayHasKey('symbol', $order);
            $this->assertArrayHasKey('hidden', $order);
            $this->assertArrayHasKey('type', $order);
            $this->assertArrayHasKey('iceberg', $order);
            $this->assertArrayHasKey('createdAt', $order);
            $this->assertArrayHasKey('stopTriggered', $order);
            $this->assertArrayHasKey('id', $order);
            $this->assertArrayHasKey('timeInForce', $order);
            $this->assertArrayHasKey('side', $order);
            $this->assertArrayHasKey('dealSize', $order);
            $this->assertArrayHasKey('stp', $order);
            $this->assertArrayHasKey('postOnly', $order);
            $this->assertArrayHasKey('size', $order);
            $this->assertArrayHasKey('stop', $order);
            $this->assertArrayHasKey('settleCurrency', $order);
            $this->assertArrayHasKey('status', $order);
            $this->assertArrayHasKey('updatedAt', $order);
            $this->assertArrayHasKey('orderTime', $order);
        }
    }

    /**
     * @dataProvider apiProvider
     * @param Order $api
     * @throws \KuCoin\Futures\SDK\Exceptions\BusinessException
     * @throws \KuCoin\Futures\SDK\Exceptions\HttpException
     * @throws \KuCoin\Futures\SDK\Exceptions\InvalidApiUriException
     */
    public function testCancel($api)
    {
        $result = $api->cancel($this->getOrderId($api));
        $this->assertInternalType('array', $result);
        $this->assertArrayHasKey('cancelledOrderIds', $result);
    }

    /**
     * @dataProvider apiProvider
     * @param Order $api
     * @throws \KuCoin\Futures\SDK\Exceptions\BusinessException
     * @throws \KuCoin\Futures\SDK\Exceptions\HttpException
     * @throws \KuCoin\Futures\SDK\Exceptions\InvalidApiUriException
     */
    public function testBatchCancel($api)
    {
        $result = $api->batchCancel('XBTUSDM');
        $this->assertInternalType('array', $result);
        $this->assertArrayHasKey('cancelledOrderIds', $result);
    }

    /**
     * @dataProvider apiProvider
     * @param Order $api
     * @throws \KuCoin\Futures\SDK\Exceptions\BusinessException
     * @throws \KuCoin\Futures\SDK\Exceptions\HttpException
     * @throws \KuCoin\Futures\SDK\Exceptions\InvalidApiUriException
     */
    public function testGetRecentList(Order $api)
    {
        $items = $api->getRecentDoneOrders();
        foreach ($items as $order) {
            $this->assertArrayHasKey('symbol', $order);
            $this->assertArrayHasKey('hidden', $order);
            $this->assertArrayHasKey('type', $order);
            $this->assertArrayHasKey('iceberg', $order);
            $this->assertArrayHasKey('createdAt', $order);
            $this->assertArrayHasKey('stopTriggered', $order);
            $this->assertArrayHasKey('id', $order);
            $this->assertArrayHasKey('timeInForce', $order);
            $this->assertArrayHasKey('side', $order);
            $this->assertArrayHasKey('dealSize', $order);
            $this->assertArrayHasKey('stp', $order);
            $this->assertArrayHasKey('postOnly', $order);
            $this->assertArrayHasKey('size', $order);
            $this->assertArrayHasKey('stop', $order);
        }
    }

    /**
     * @dataProvider apiProvider
     * @param Order $api
     * @throws \KuCoin\Futures\SDK\Exceptions\BusinessException
     * @throws \KuCoin\Futures\SDK\Exceptions\HttpException
     * @throws \KuCoin\Futures\SDK\Exceptions\InvalidApiUriException
     */
    public function testOpenOrderStatistics($api)
    {
        $result = $api->getOpenOrderStatistics('XBTUSDM');
        $this->assertInternalType('array', $result);
        $this->assertArrayHasKey('openOrderBuySize', $result);
        $this->assertArrayHasKey('openOrderSellSize', $result);
        $this->assertArrayHasKey('openOrderBuyCost', $result);
        $this->assertArrayHasKey('openOrderSellCost', $result);
    }

    /**
     * @dataProvider apiProvider.
     *
     * @param Order $api
     * @throws \KuCoin\Futures\SDK\Exceptions\BusinessException
     * @throws \KuCoin\Futures\SDK\Exceptions\HttpException
     * @throws \KuCoin\Futures\SDK\Exceptions\InvalidApiUriException
     */
    private function getOrderId($api)
    {
        $order = [
            'clientOid' => uniqid(),
            'type'      => 'limit',
            'side'      => 'buy',
            'symbol'    => 'XBTUSDM',
            'leverage'  => 2,
            'remark'    => '\中文备注 ',

            'price' => 100,
            'size'  => 1,
        ];
        $data = $api->create($order);
        $this->assertInternalType('array', $data);
        $this->assertArrayHasKey('orderId', $data);
        return $data['orderId'];
    }

    /**
     * @dataProvider apiProvider
     * @param Order $api
     * @throws \KuCoin\Futures\SDK\Exceptions\BusinessException
     * @throws \KuCoin\Futures\SDK\Exceptions\HttpException
     * @throws \KuCoin\Futures\SDK\Exceptions\InvalidApiUriException
     */
    public function testGetDetailByClientOid(Order $api)
    {
        $clientOid = uniqid();
        $order =  [
            'clientOid' => $clientOid,
            'type'      => 'limit',
            'side'      => 'buy',
            'symbol'    => 'XBTUSDTM',
            'leverage'  => 1,
            'remark'    => 'create test order',
            'price'     => '1',
            'size'      => '1',
        ];

        $api->create($order);
        $clientOid = $clientOid;
        $order = $api->getDetailByClientOid($clientOid);
        $this->assertArrayHasKey('symbol', $order);
        $this->assertArrayHasKey('hidden', $order);
        $this->assertArrayHasKey('type', $order);
        $this->assertArrayHasKey('iceberg', $order);
        $this->assertArrayHasKey('createdAt', $order);
        $this->assertArrayHasKey('stopTriggered', $order);
        $this->assertArrayHasKey('id', $order);
        $this->assertArrayHasKey('timeInForce', $order);
        $this->assertArrayHasKey('side', $order);
        $this->assertArrayHasKey('dealSize', $order);
        $this->assertArrayHasKey('stp', $order);
        $this->assertArrayHasKey('postOnly', $order);
        $this->assertArrayHasKey('size', $order);
        $this->assertArrayHasKey('stop', $order);
        $this->assertArrayHasKey('settleCurrency', $order);
        $this->assertArrayHasKey('status', $order);
        $this->assertArrayHasKey('updatedAt', $order);
        $this->assertArrayHasKey('orderTime', $order);
        $api->cancel($order['id']);
    }

    /**
     * @dataProvider apiProvider
     * @param Order $api
     * @throws \KuCoin\Futures\SDK\Exceptions\BusinessException
     * @throws \KuCoin\Futures\SDK\Exceptions\HttpException
     * @throws \KuCoin\Futures\SDK\Exceptions\InvalidApiUriException
     */
    public function testCancelByClientOid($api)
    {
        $clientId = uniqid();
        $symbol = 'DOTUSDTM';
        $order = [
            'clientOid' => $clientId,
            'type'      => 'limit',
            'side'      => 'buy',
            'symbol'    => $symbol,
            'leverage'  => 5,
            'remark'    => 'test cancel order',

            'price' => 6,
            'size'  => 1,
        ];

        $api->create($order);
        $result = $api->cancelByClientOid($clientId, $symbol);
        $this->assertInternalType('array', $result);
        $this->assertArrayHasKey('clientOid', $result);
    }

    /**
     * @dataProvider apiProvider
     * @param Order $api
     * @return void
     * @throws \KuCoin\Futures\SDK\Exceptions\BusinessException
     * @throws \KuCoin\Futures\SDK\Exceptions\HttpException
     * @throws \KuCoin\Futures\SDK\Exceptions\InvalidApiUriException
     */
    public function testCreateTest(Order $api)
    {
        $order = [
            'clientOid' => uniqid(),
            'type'      => 'limit',
            'side'      => 'buy',
            'symbol'    => 'DOTUSDM',
            'leverage'  => 2,
            'remark'    => 'create test order',

            'price' => '1',
            'size'  => '1',
        ];
        $data = $api->createTest($order);
        $this->assertInternalType('array', $data);
        $this->assertArrayHasKey('orderId', $data);
    }

    /**
     * @dataProvider apiProvider
     *
     * @param Order $api
     * @return void
     * @throws \KuCoin\Futures\SDK\Exceptions\BusinessException
     * @throws \KuCoin\Futures\SDK\Exceptions\HttpException
     * @throws \KuCoin\Futures\SDK\Exceptions\InvalidApiUriException
     */
    public function testCreateMultiOrders(Order $api)
    {
        $orders = [
            [
                'clientOid' => uniqid(),
                'type'      => 'limit',
                'side'      => 'buy',
                'symbol'    => 'AAVEUSDTM',
                'leverage'  => 5,
                'remark'    => 'create test order',
                'price'     => '1',
                'size'      => '1',
            ],
            [
                'clientOid' => uniqid(),
                'type'      => 'limit',
                'side'      => 'buy',
                'symbol'    => 'ETHUSDTM',
                'leverage'  => 5,
                'remark'    => 'create test order',
                'price'     => '1',
                'size'      => '1',
            ],
        ];

        $result = $api->createMultiOrders($orders);
        foreach ($result as $item) {
            $this->assertInternalType('array', $item);
            $this->assertArrayHasKey('orderId', $item);
            $this->assertArrayHasKey('clientOid', $item);
            $this->assertArrayHasKey('symbol', $item);
        }
    }

    /**
     * @dataProvider apiProvider
     *
     * @param Order $api
     * @return void
     * @throws \KuCoin\Futures\SDK\Exceptions\BusinessException
     * @throws \KuCoin\Futures\SDK\Exceptions\HttpException
     * @throws \KuCoin\Futures\SDK\Exceptions\InvalidApiUriException
     */
    public function testCreateStOrder(Order $api)
    {
        $order = [
            'clientOid'            => uniqid(),
            'type'                 => 'limit',
            'side'                 => 'buy',
            'symbol'               => 'XBTUSDTM',
            'leverage'             => 1,
            'remark'               => 'create test order',
            'price'                => '800',
            'size'                 => 1,
            'stopPriceType'        => 'TP',
            'triggerStopUpPrice'   => '9000',
            'triggerStopDownPrice' => '700',
            'marginMode'           => 'ISOLATED',
        ];
        $result = $api->createStOrder($order);
        $this->assertInternalType('array', $result);
        $this->assertArrayHasKey('orderId', $result);
        $this->assertArrayHasKey('clientOid', $result);
    }
}
