<?php
namespace Yebto\GeoIPAPI;

use Illuminate\Support\Arr;
use RuntimeException;

class GeoIPAPI
{
    /**
     * Query a GeoIP database (city|country|asn).
     *
     * @param  string       $db   One of: city, country, asn
     * @param  string|null  $ip   Optional ip address; if null, backend uses Request::ip()
     * @param  array        $extra Extra POST params if needed
     * @return array
     */
    public function query(string $db, ?string $ip = null, array $extra = []): array
    {
        $db = strtolower($db);
        if (!in_array($db, ['city', 'country', 'asn'], true)) {
            throw new RuntimeException('Invalid DB: use city|country|asn');
        }

        $payload = $extra;
        if ($ip !== null) {
            $payload['ip'] = $ip;
        }

        return $this->post("geoip/{$db}", $payload);
    }

    /** Convenience: city lookup */
    public function city(?string $ip = null, array $extra = []): array
    {
        return $this->query('city', $ip, $extra);
    }

    /** Convenience: country lookup */
    public function country(?string $ip = null, array $extra = []): array
    {
        return $this->query('country', $ip, $extra);
    }

    /** Convenience: ASN lookup */
    public function asn(?string $ip = null, array $extra = []): array
    {
        return $this->query('asn', $ip, $extra);
    }

    /* ───────────────── private helpers ───────────────── */

    private function post(string $endpoint, array $payload = []): array
    {
        $base = rtrim(config('geoipapi.base_url'), '/');
        $url  = "{$base}/" . ltrim($endpoint, '/');
        $key  = config('geoipapi.key');

        if (!$key) {
            throw new RuntimeException('Missing YEB_KEY_ID in .env');
        }

        $payload = array_merge($payload, ['api_key' => $key]);
        $body    = json_encode($payload, JSON_UNESCAPED_UNICODE);

        $ch = curl_init($url);
        curl_setopt_array($ch, $this->curlOpts([
            CURLOPT_POST       => true,
            CURLOPT_POSTFIELDS => $body,
        ]));

        $raw  = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        $err  = curl_error($ch);
        curl_close($ch);

        if ($err) {
            throw new RuntimeException("cURL error: {$err}");
        }

        $json = json_decode($raw, true);

        if ($code !== 200) {
            $msg = is_array($json) ? (Arr::get($json, 'error', 'Unknown API error')) : 'Unknown API error';
            throw new RuntimeException("GeoIP API [{$code}]: {$msg}");
        }

        return $json;
    }

    private function curlOpts(array $extra): array
    {
        return $extra + config('geoipapi.curl', []);
    }
}
