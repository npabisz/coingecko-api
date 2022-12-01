# PHP API Client for CoinGecko.com

PHP API client for [coingecko.com](https://coingecko.com).

## Requirements
* PHP >= 7.2
* ext-json

## Installation

```bash
composer require npabisz/coingecko-api
```

## Example

```php
use CoinGecko\Client;

// Basic usage
$client = new Client();

// Modify underlying HTTP client config
$client = new Client([], [
    'timeout' => 15,
])

// Use PRO api
$client = new Client([
    'api_mode' => 'pro',
    'api_key' => '************',
]);

$response = $client->Ping->get();
```

### [Ping](https://www.coingecko.com/api/documentations/v3#/ping)

```php
// [/ping]
$response = $client->Ping->get();
```

### [Simple](https://www.coingecko.com/api/documentations/v3#/simple/get_simple_price)

```php
// [/simple/price]
$response = $client->Simple->Price->get([
    'ids' => 'bitcoin',
    'vs_currencies' => 'usd',
]);

// [/simple/token_price/{id}]
$response = $client->Simple->TokenPrice('ethereum')->get([
    'contract_addresses' => '0xdac17f958d2ee523a2206206994597c13d831ec7',
    'vs_currencies' => 'usd',
]);

// [/simple/supported_vs_currencies]
$response = $client->Simple->SupportedVsCurrencies->get()
```

### [Coins](https://www.coingecko.com/api/documentations/v3#/coins/get_coins_list)

```php
// [/coins/list]
$response = $client->Coins->List->get();

// [/coins/markets]
$response = $client->Coins->Markets->get([
    'vs_currency' => 'usd',
]);

// [/coins/{id}]
$response = $client->Coins('bitcoin')->get();

// [/coins/{id}/tickers]
$response = $client->Coins('bitcoin')->Tickers->get();

// [/coins/{id}/history]
$response = $client->Coins('bitcoin')->History->get([
    'date' => '30-11-2022'
]);

// [/coins/{id}/market_chart]
$response = $client->Coins('bitcoin')->MarketChart->get([
    'vs_currency' => 'usd',
    'days' => 7,
]);

// [/coins/{id}/market_chart/range]
$response = $client->Coins('bitcoin')->MarketChart->Range->get([
    'vs_currency' => 'usd',
    'from' => 1669676400,
    'to' => 1669762800,
]);

// [/coins/{id}/ohlc]
$response = $client->Coins('bitcoin')->Ohlc->get([
    'vs_currency' => 'usd',
    'days' => 7,
]);
```

### [Contract](https://www.coingecko.com/api/documentations/v3#/contract)

```php
// [/coins/{id}/contract/{contract_address}]
$response = $client->Coins('ethereum')->Contract('0xdac17f958d2ee523a2206206994597c13d831ec7')->get();

// [/coins/{id}/contract/{contract_address}/market_chart]
$response = $client->Coins('ethereum')->Contract('0xdac17f958d2ee523a2206206994597c13d831ec7')->MarketChart->get([
    'vs_currency' => 'usd',
    'days' => 7,
]);

// [/coins/{id}/contract/{contract_address}/market_chart/range]
$response = $client->Coins('ethereum')->Contract('0xdac17f958d2ee523a2206206994597c13d831ec7')->MarketChart->Range->get([
    'vs_currency' => 'usd',
    'from' => 1669676400,
    'to' => 1669762800,
]);
```

### [AssetsPlatforms](https://www.coingecko.com/api/documentations/v3#/asset_platforms/get_asset_platforms)

```php
// [/assets_platforms]
$response = $client->AssetPlatforms->get();
```

### [Categories](https://www.coingecko.com/api/documentations/v3#/categories/get_coins_categories_list)

```php
// [/coins/categories]
$response = $client->Coins->Categories->get();

// [/coins/categories/list]
$response = $client->Coins->Categories->List->get();
```

### [Exchanges](https://www.coingecko.com/api/documentations/v3#/exchanges)

```php
// [/exchanges]
$response = $client->Exchanges->get();

// [/exchanges/list]
$response = $client->Exchanges->List->get();

// [/exchanges/{id}]
$response = $client->Exchanges('binance')->get();

// [/exchanges/{id}/tickers]
$response = $client->Exchanges('binance')->Tickers->get();

// [/exchanges/{id}/volume_chart]
$response = $client->Exchanges('binance')->VolumeChart->get([
    'days' => 7,
]);
```

### [Indexes](https://www.coingecko.com/api/documentations/v3#/indexes/get_indexes)

```php
// [/indexes]
$response = $client->Indexes->get();

// [/indexes/{market_id}/{id}]
$response = $client->Indexes($marketId, $id)->get();

// [/indexes/list]
$response = $client->Indexes->List->get();
```

### [Derivatives](https://www.coingecko.com/api/documentations/v3#/derivatives/get_derivatives)

```php
// [/derivatives]
$response = $client->Derivatives->get();

// [/derivatives/exchanges]
$response = $client->Derivatives->Exchanges->get();

// [/derivatives/exchanges/list]
$response = $client->Derivatives->Exchanges()->List->get();

// [/derivatives/exchanges/{id}]
$response = $client->Derivatives->Exchanges('binance_futures')->get();
```

### [NFTs](https://www.coingecko.com/api/documentations/v3#/nfts%20(beta)/get_nfts_list)

```php
// [/nfts/list]
$response = $client->Nfts->List->get();

// [/nfts/{id}]
$response = $client->Nfts('8bit')->get();

// [/nfts/{asset_platform_id}/contract/{contract_address}]
$response = $client->Nfts('ethereum')->Contract('0xaae71bbbaa359be0d81d5cbc9b1e88a8b7c58a94')->get();
```

### [ExchangeRates](https://www.coingecko.com/api/documentations/v3#/exchange_rates)

```php
// [/exchange_rates]
$response = $client->ExchangeRates->get();
```

### [Search](https://www.coingecko.com/api/documentations/v3#/search)

```php
// [/search]
$response = $client->Search->get([
    'query' => 'bitcoin',
]);
```

### [Trending](https://www.coingecko.com/api/documentations/v3#/trending/get_search_trending)

```php
// [/search/trending]
$response = $client->Search->Trending->get();
```

### [Global](https://www.coingecko.com/api/documentations/v3#/global)

```php
// [/global]
$response = $client->Global->get();

// [/global/decentralized_finance_defi]
$response = $client->Global->DecentralizedFinanceDefi->get();
```

### [Companies](https://www.coingecko.com/api/documentations/v3#/companies%20(beta))

```php
// [/companies/public_treasury/{coin_id}]
$response = $client->Companies->PublicTreasury('ethereum')->get();
```

### [API PRO Version](https://coingeckoapi.notion.site/coingeckoapi/CoinGecko-Pro-API-exclusive-endpoints-529f4bb5c4d84d5fad797b09cfdb4b53)

```php
// [/nfts/markets]
$response = $client->Nfts->Markets->get();

// [/nfts/{id}/market_chart]
$response = $client->Nfts('8bit')->MarketChart->get();

// [/nfts/{id}/tickers]
$response = $client->Nfts('8bit')->Tickers->get();

// [/global/market_cap_chart]
$response = $client->Global->MarketCapChart->get();
```

## License

`npabisz/coingecko-api` is released under the MIT License. See the bundled [LICENSE](./LICENSE) for details.