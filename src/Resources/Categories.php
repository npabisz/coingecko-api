<?php

namespace CoinGecko\Resources;

/**
 * URL: https://www.coingecko.com/pl/api/documentation#operations-tag-categories
 *
 * @property-read Listing $List
 *
 * @method Listing List()
 */
class Categories extends CoinGeckoResource
{
    /**
     * @inheritDoc
     */
    public $resourceKey = 'categories';

    /**
     * @inheritDoc
     */
    protected $childResource = [
        'Listing' => 'List',
    ];
}
