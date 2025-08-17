<?php
namespace Yebto\GeoIPAPI\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array query(string $db, ?string $ip = null, array $extra = [])
 * @method static array city(?string $ip = null, array $extra = [])
 * @method static array country(?string $ip = null, array $extra = [])
 * @method static array asn(?string $ip = null, array $extra = [])
 */
class GeoIPAPI extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'geoipapi';
    }
}
