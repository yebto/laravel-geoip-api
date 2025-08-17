# Laravel GeoIP API SDK

[![Latest Version on Packagist](https://img.shields.io/packagist/v/yebto/laravel-geoip-api.svg?style=flat-square)](https://packagist.org/packages/yebto/laravel-geoip-api)
[![Total Downloads](https://img.shields.io/packagist/dt/yebto/laravel-geoip-api.svg?style=flat-square)](https://packagist.org/packages/yebto/laravel-geoip-api)

Official Laravel SDK for the **[YEB GeoIP API](https://yeb.to/api/geoip)** by [NETOX Ltd.](https://yeb.to/about) — a lightweight wrapper for fast and accurate **IP geolocation** (City, Country, ASN) in Laravel applications.

---

## Table of Contents

* [Installation](#installation)
* [Usage](#usage)
* [Available Methods](#available-methods)
* [Parameters Reference](#parameters-reference)
* [Configuration](#configuration)
* [Features](#features)
* [Free Tier Access](#free-tier-access)
* [Troubleshooting](#troubleshooting)
* [Support](#support)
* [License](#license)

---

## Installation

Install the package using Composer:

```bash
composer require yebto/laravel-geoip-api
```

Publish the configuration file:

```bash
php artisan vendor:publish --tag=geoipapi-config
```

Add your API key to your `.env` file:

```env
YEB_KEY_ID=your_api_key_here
```

---

## Usage

Import the facade and start making API calls:

```php
use GeoIPAPI;
```

### Examples

**1) City Lookup**

```php
$city = GeoIPAPI::city('21.85.7.138');

// Sample shape:
// $city['data'] => [
//   'ip', 'hostname', 'city', 'region', 'country', 'loc', 'org', 'postal', 'timezone', ...
// ]
```

**2) Country Lookup**

```php
$country = GeoIPAPI::country('85.85.7.138');

// Sample shape:
// $country['data'] => [
//   'ip', 'country', 'country_name', 'isEU', 'country_flag',
//   'continent' => ['code', 'name'],
// ]
```

**3) ASN Lookup**

```php
$asn = GeoIPAPI::asn('55.85.7.138');

// Sample shape:
// $asn['data'] => [ 'ip', 'org', 'asn', 'network' ]
```

**4) Generic Query**

```php
$response = GeoIPAPI::query('city', '77.85.7.138');
// Supported databases: 'city', 'country', 'asn'
```

> 💡 If the IP is omitted (e.g. `GeoIPAPI::city();`), the backend uses the requester's IP automatically via `Request::ip()`.

**5) Error Handling**

```php
try {
    $city = GeoIPAPI::city('67.85.7.138');
} catch (\RuntimeException $e) {
    // Log or handle the error
    \Log::error($e->getMessage());
}
```

---

## Available Methods

* `GeoIPAPI::city(?string $ip = null)` – [API Docs](https://yeb.to/api/geoip)
* `GeoIPAPI::country(?string $ip = null)` – [API Docs](https://yeb.to/api/geoip)
* `GeoIPAPI::asn(?string $ip = null)` – [API Docs](https://yeb.to/api/geoip)
* `GeoIPAPI::query(string $db, ?string $ip = null)` – [API Docs](https://yeb.to/api/geoip)

---

## Parameters Reference

| Helper    | Required                            | Optional                      |
| --------- | ----------------------------------- | ----------------------------- |
| `city`    | `ip` (when not auto-detected)       | –                             |
| `country` | `ip` (when not auto-detected)       | –                             |
| `asn`     | `ip` (when not auto-detected)       | –                             |
| `query`   | `db` (`city` \| `country` \| `asn`) | `ip` (when not auto-detected) |

> 💡 All methods accept additional parameters supported by the API, which will be forwarded transparently.

---

## Configuration

The SDK uses a single environment variable:

```env
YEB_KEY_ID=your_api_key_here
```

You may customize other configuration settings via `config/geoipapi.php` after publishing:

```php
return [
    'base_url' => 'https://api.yeb.to/v1/', // default
    'key'      => env('YEB_KEY_ID'),
    'curl'     => [
        CURLOPT_TIMEOUT   => 3,
        CURLOPT_USERAGENT => 'Laravel-GeoIP-Client',
        // Add more cURL options as needed
    ],
];
```

---

## Features

* Simple, expressive API via a Laravel Facade
* City, Country, and ASN lookups
* Auto-detects the requester IP when omitted
* Small footprint — no local databases to maintain
* Customizable cURL options (timeouts, user agent, etc.)
* Clean error handling with `RuntimeException` on failed requests
* Built for Laravel; zero-config auto-discovery

---

## Free Tier Access

🎁 Get **1,000+ free API requests** by registering on [yeb.to](https://yeb.to) using your **Google account**.

**Steps:**

1. Visit **[https://yeb.to](https://yeb.to)**
2. Click **Login with Google**
3. Retrieve your API key and add it to `.env` as `YEB_KEY_ID`

*No credit card required!*

---

## Troubleshooting

* Ensure your API key is correct and active (`YEB_KEY_ID`)
* Double-check that the config file is published (`php artisan vendor:publish --tag=geoipapi-config`)
* Validate parameters against the [API reference](https://yeb.to/api/geoip)
* Check for typos in method names or required fields
* Consider adjusting `CURLOPT_TIMEOUT` in `config/geoipapi.php` for slower networks
* Inspect your application/network firewall rules if requests time out

---

## Support

* 📘 API Documentation: **[https://yeb.to/api/geoip](https://yeb.to/api/geoip)**
* 📧 Email: **[support@yeb.to](mailto:support@yeb.to)**
* 🐛 Issues: **[https://github.com/yebto/laravel-geoip-api/issues](https://github.com/yebto/laravel-geoip-api/issues)**

---

## License

© NETOX Ltd. Licensed under a proprietary or custom license unless stated otherwise in the repository.

> 💬 Have a feature request or improvement idea?
> Reach out at **[support@yeb.to](mailto:support@yeb.to)** — we’d love to hear from you!
