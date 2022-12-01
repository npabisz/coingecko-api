<?php

namespace CoinGecko\Resources;

/**
 * URL: https://www.coingecko.com/pl/api/documentation#operations-tag-search
 *
 * @property-read Trending $Trending
 *
 * @method Trending Trending()
 */
class Search extends CoinGeckoResource
{
    /**
     * @inheritDoc
     */
    public $resourceKey = 'search';

    /**
     * @inheritDoc
     */
    protected $childResource = [
        'Trending',
    ];
}
