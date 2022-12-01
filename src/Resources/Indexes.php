<?php

namespace CoinGecko\Resources;

/**
 * URL: https://www.coingecko.com/pl/api/documentation#operations-tag-indexes
 *
 * @property-read Listing $List
 * @property-read Tickers $Tickers
 * @property-read VolumeChart $VolumeChart
 *
 * @method Listing List()
 * @method Tickers Tickers()
 * @method VolumeChart VolumeChart()
 */
class Indexes extends CoinGeckoResource
{
    /**
     * @inheritDoc
     */
    public $resourceKey = 'indexes';

    /**
     * @inheritDoc
     */
    protected $childResource = [
        'Listing' => 'List',
        'Tickers',
        'VolumeChart',
    ];
}
