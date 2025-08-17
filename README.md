# Laravel GeoIP API SDK

[![Latest Version on Packagist](https://img.shields.io/packagist/v/yebto/laravel-geoip-api.svg?style=flat-square)](https://packagist.org/packages/yebto/laravel-geoip-api)
[![Total Downloads](https://img.shields.io/packagist/dt/yebto/laravel-geoip-api.svg?style=flat-square)](https://packagist.org/packages/yebto/laravel-geoip-api)

A lightweight Laravel wrapper for the [**YEB GeoIP API**](https://yeb.to/api/geoip). This SDK makes it easy to integrate **IP geolocation** features into your Laravel application using endpoints for **City**, **Country**, and **ASN** data.

---

## 🔧 Installation

```bash
composer require yebto/laravel-geoip-api
php artisan vendor:publish --tag=geoipapi-config
```

Then set your API key in your `.env` file:

```env
YEB_KEY_ID=****************************************
```

---

## 🚀 Usage

```php
use GeoIPAPI;

/** City DB */
$city = GeoIPAPI::city('21.85.7.138'); 
// or null to auto-detect requester IP
// $city['data'] => [ ip, hostname, city, region, country, loc, org, postal, timezone, ... ]

/** Country DB */
$country = GeoIPAPI::country('85.85.7.138');
// $country['data'] => [ ip, country, country_name, isEU, country_flag, continent: {code, name} ]

/** ASN DB */
$asn = GeoIPAPI::asn('55.85.7.138');
// $asn['data'] => [ ip, org, asn, network ]

/** Generic query (city|country|asn) */
$response = GeoIPAPI::query('city', '77.85.7.138');
```

If the IP is omitted, the backend will use the requester's IP automatically via `Request::ip()`.

---

## 🌐 Endpoints Used

- `POST https://api.yeb.to/v1/geoip/city`
- `POST https://api.yeb.to/v1/geoip/country`
- `POST https://api.yeb.to/v1/geoip/asn`

The SDK sends your API key (`YEB_KEY_ID`) automatically and handles cURL configuration internally.

---

## ❗ Error Handling

All failed API requests will throw a `RuntimeException` with the original API error message.

```php
try {
    $city = GeoIPAPI::city('67.85.7.138');
} catch (\RuntimeException $e) {
    // Log or handle the error
    Log::error($e->getMessage());
}
```

---

## ⚙️ Configuration

Configuration file: `config/geoipapi.php`

```php
return [
    'base_url' => 'https://api.yeb.to/v1/', // default
    'key' => env('YEB_KEY_ID'),
    'curl' => [
        CURLOPT_TIMEOUT => 3,
        CURLOPT_USERAGENT => 'Laravel-GeoIP-Client',
        // Add more cURL options as needed
    ],
];
```

---

## 📄 License

© NETOX Ltd. – [https://yeb.to](https://yeb.to) – [support@yeb.to](mailto:support@yeb.to)

---

✅ Powered by [YEB GeoIP API](https://yeb.to/api/geoip) — your trusted solution for fast and accurate IP geolocation.
