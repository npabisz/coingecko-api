<?php

namespace CoinGecko\Resources;

/**
 * URL: https://www.coingecko.com/pl/api/documentation#operations-tag-companies_\(beta\)
 *
 * @property-read PublicTreasury $PublicTreasury
 *
 * @method PublicTreasury PublicTreasury(string $coinId)
 */
class Companies extends CoinGeckoResource
{
    /**
     * @inheritDoc
     */
    public $resourceKey = 'companies';

    /**
     * @inheritDoc
     */
    protected $childResource = [
        'PublicTreasury',
    ];
}
