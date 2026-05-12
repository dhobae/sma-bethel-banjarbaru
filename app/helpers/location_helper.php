<?php

/**
 * Location Helper - Menangani pengecekan WFO/WFH berdasarkan IP dan Koordinat
 * Lokasi sekolah: -3.4347868476902974, 114.83472584098024
 * Radius WFO: 300 meter
 */

// Koordinat pusat sekolah
const SCHOOL_LAT = -3.434947;
const SCHOOL_LNG = 114.835456;

// rumahku
// const SCHOOL_LAT = -3.4342626805540206;
// const SCHOOL_LNG = 114.84252087287351;

const WFO_RADIUS = 150; // dalam meter

/**
 * Menghitung jarak antara 2 koordinat menggunakan Haversine formula
 * @param float $lat1 Latitude titik 1
 * @param float $lon1 Longitude titik 1
 * @param float $lat2 Latitude titik 2
 * @param float $lon2 Longitude titik 2
 * @return float Jarak dalam meter
 */
function calculateDistance($lat1, $lon1, $lat2, $lon2)
{
    $earthRadius = 6371000; // radius bumi dalam meter
    
    $latFrom = deg2rad($lat1);
    $lonFrom = deg2rad($lon1);
    $latTo = deg2rad($lat2);
    $lonTo = deg2rad($lon2);
    
    $latDelta = $latTo - $latFrom;
    $lonDelta = $lonTo - $lonFrom;
    
    $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
        cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
    
    return $angle * $earthRadius;
}


/**
 * Parse koordinat dari string "lat,lng"
 * @param string $locString Format: "lat,lng"
 * @return array|false Array dengan key 'lat' dan 'lng', atau false jika format tidak valid
 */
function parseLocation($locString)
{
    if (empty($locString) || $locString == '-') {
        return false;
    }
    
    $parts = explode(',', str_replace(' ', '', $locString));
    
    if (count($parts) != 2) {
        return false;
    }
    
    $lat = floatval($parts[0]);
    $lng = floatval($parts[1]);
    
    // Validasi range koordinat (Indonesia)
    if ($lat < -10 || $lat > 6 || $lng < 95 || $lng > 141) {
        return false;
    }
    
    return [
        'lat' => $lat,
        'lng' => $lng
    ];
}

/**
 * Format jarak untuk tampilan user-friendly
 * @param float $meters Jarak dalam meter
 * @return string Format jarak
 */
function formatDistance($meters)
{
    if ($meters === null) {
        return 'N/A';
    }
    
    if ($meters >= 1000) {
        return number_format($meters / 1000, 2, '.', '') . ' km';
    }
    
    return number_format($meters, 2, '.', '') . ' m';
}

/**
 * Mendapatkan informasi lokasi sekolah
 * @return array Array dengan koordinat sekolah
 */
function getSchoolLocation()
{
    return [
        'latitude'  => SCHOOL_LAT,
        'longitude' => SCHOOL_LNG,
        'radius'    => WFO_RADIUS,
        'name'      => 'Sekolah'
    ];
}
