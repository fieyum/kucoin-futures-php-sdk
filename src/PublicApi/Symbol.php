<?php

namespace KuMEX\SDK\PublicApi;

use KuMEX\SDK\Http\Request;
use KuMEX\SDK\KuMEXApi;

/**
 * Class Symbol
 * @package KuMEX\SDK\PublicApi
 * @see https://docs.KuMEX.com/#symbol
 */
class Symbol extends KuMEXApi
{
    /**
     * Get the ticker details of a symbol.
     *
     * @param  string $symbol
     * @return array
     * @throws \KuMEX\SDK\Exceptions\BusinessException
     * @throws \KuMEX\SDK\Exceptions\HttpException
     * @throws \KuMEX\SDK\Exceptions\InvalidApiUriException
     */
    public function getTicker($symbol)
    {
        $response = $this->call(Request::METHOD_GET, '/api/v1/ticker', compact('symbol'));
        return $response->getApiData();
    }

    /**
     * Get the snapshot details of a symbol.
     *
     * @param  string $symbol
     * @return array
     * @throws \KuMEX\SDK\Exceptions\BusinessException
     * @throws \KuMEX\SDK\Exceptions\HttpException
     * @throws \KuMEX\SDK\Exceptions\InvalidApiUriException
     */
    public function getLevel2Snapshot($symbol)
    {
        $response = $this->call(Request::METHOD_GET, '/api/v1/level2/snapshot', compact('symbol'));
        return $response->getApiData();
    }

    /**
     * Get the snapshot details of a symbol.
     *
     * @param  string $symbol
     * @return array
     * @throws \KuMEX\SDK\Exceptions\BusinessException
     * @throws \KuMEX\SDK\Exceptions\HttpException
     * @throws \KuMEX\SDK\Exceptions\InvalidApiUriException
     */
    public function getLevel3Snapshot($symbol)
    {
        $response = $this->call(Request::METHOD_GET, '/api/v1/level3/snapshot', compact('symbol'));
        return $response->getApiData();
    }

    /**
     * Get the level2 message of a symbol.
     *
     * @param  string $symbol
     * @param  number $start
     * @param  number $end
     * @return array
     * @throws \KuMEX\SDK\Exceptions\BusinessException
     * @throws \KuMEX\SDK\Exceptions\HttpException
     * @throws \KuMEX\SDK\Exceptions\InvalidApiUriException
     */
    public function getLevel2Message($symbol, $start, $end)
    {
        $response = $this->call(Request::METHOD_GET, '/api/v1/level2/message/query',
            compact('symbol', 'start', 'end')
        );
        return $response->getApiData();
    }

    /**
     * @deprecated
     *
     * Get the level3 message of a symbol.
     *
     * @param  string $symbol
     * @param  number $start
     * @param  number $end
     * @return array
     * @throws \KuMEX\SDK\Exceptions\BusinessException
     * @throws \KuMEX\SDK\Exceptions\HttpException
     * @throws \KuMEX\SDK\Exceptions\InvalidApiUriException
     */
    public function getLevel3Message($symbol, $start, $end)
    {
        $response = $this->call(Request::METHOD_GET, '/api/v1/level3/message/query',
            compact('symbol', 'start', 'end')
        );
        return $response->getApiData();
    }

    /**
     * Get the trade history details of a symbol.
     *
     * @param  string $symbol
     * @return array
     * @throws \KuMEX\SDK\Exceptions\BusinessException
     * @throws \KuMEX\SDK\Exceptions\HttpException
     * @throws \KuMEX\SDK\Exceptions\InvalidApiUriException
     */
    public function getTradeHistory($symbol)
    {
        $response = $this->call(Request::METHOD_GET, '/api/v1/trade/history', compact('symbol'));
        return $response->getApiData();
    }
}
