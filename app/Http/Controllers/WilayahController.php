<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class WilayahController extends Controller
{
    /**
     * Get all provinces from wilayah.id API
     */
    public function provinces()
    {
        try {
            // Cache for 7 days since provinces rarely change
            $provinces = Cache::remember('wilayah_provinces', 60 * 24 * 7, function () {
                $response = Http::timeout(10)->get('https://wilayah.id/api/provinces.json');
                
                if ($response->successful()) {
                    return $response->json();
                }
                
                return null;
            });

            if ($provinces) {
                return response()->json($provinces);
            }

            return response()->json([
                'data' => []
            ], 500);

        } catch (\Exception $e) {
            return response()->json([
                'data' => [],
                'error' => 'Failed to fetch provinces'
            ], 500);
        }
    }

    /**
     * Get regencies by province code
     */
    public function regencies($provinceCode)
    {
        try {
            // Cache for 7 days
            $regencies = Cache::remember("wilayah_regencies_{$provinceCode}", 60 * 24 * 7, function () use ($provinceCode) {
                $response = Http::timeout(10)->get("https://wilayah.id/api/regencies/{$provinceCode}.json");
                
                if ($response->successful()) {
                    return $response->json();
                }
                
                return null;
            });

            if ($regencies) {
                return response()->json($regencies);
            }

            return response()->json([
                'data' => []
            ], 500);

        } catch (\Exception $e) {
            return response()->json([
                'data' => [],
                'error' => 'Failed to fetch regencies'
            ], 500);
        }
    }

    /**
     * Get districts by regency code
     */
    public function districts($regencyCode)
    {
        try {
            // Cache for 7 days
            $districts = Cache::remember("wilayah_districts_{$regencyCode}", 60 * 24 * 7, function () use ($regencyCode) {
                $response = Http::timeout(10)->get("https://wilayah.id/api/districts/{$regencyCode}.json");
                
                if ($response->successful()) {
                    return $response->json();
                }
                
                return null;
            });

            if ($districts) {
                return response()->json($districts);
            }

            return response()->json([
                'data' => []
            ], 500);

        } catch (\Exception $e) {
            return response()->json([
                'data' => [],
                'error' => 'Failed to fetch districts'
            ], 500);
        }
    }

    /**
     * Get villages by district code
     */
    public function villages($districtCode)
    {
        try {
            // Cache for 7 days
            $villages = Cache::remember("wilayah_villages_{$districtCode}", 60 * 24 * 7, function () use ($districtCode) {
                $response = Http::timeout(10)->get("https://wilayah.id/api/villages/{$districtCode}.json");
                
                if ($response->successful()) {
                    return $response->json();
                }
                
                return null;
            });

            if ($villages) {
                return response()->json($villages);
            }

            return response()->json([
                'data' => []
            ], 500);

        } catch (\Exception $e) {
            return response()->json([
                'data' => [],
                'error' => 'Failed to fetch villages'
            ], 500);
        }
    }
}
