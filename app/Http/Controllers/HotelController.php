<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HotelController extends Controller
{
    public function search(Request $request)
    {
        // Fetch JSON data from the API
        $response = Http::get('https://api.npoint.io/dd85ed11b9d8646c5709');

        // Check if request failed
        if (!$response->successful()) {
            return response()->json(['error' => 'Failed to fetch hotel data'], $response->status());
        }

        // Retrieve hotels data
        $hotels = $response->json()['hotels'];
        

        $filteredHotels = collect($hotels)->filter(function ($hotel) use ($request) {
            // Search By Name
            if ($request->has('name') && !empty($request->name)) {
                $nameMatch = stripos($hotel['name'], $request->name) !== false;
                if (!$nameMatch) {
                    return false;
                }
            }

            // Search By Destination
            if ($request->has('destination') && !empty($request->destination)) {
                $destinationMatch = stripos($hotel['city'], $request->destination) !== false;
                if (!$destinationMatch) {
                    return false;
                }
            }

            // Search By Price Range
            if ($request->has('price_range') && !empty($request->price_range)) {
                $priceRange = explode(':', $request->price_range);
                $minPrice = (float) $priceRange[0];
                $maxPrice = (float) $priceRange[1];
                if ($hotel['price'] < $minPrice || $hotel['price'] > $maxPrice) {
                    return false;
                }
            }

            // Search By Date Range
            if ($request->has('date_range') && !empty($request->date_range)) {
                $dateRange = explode(':', $request->date_range);
                $startDate = strtotime($dateRange[0]);
                $endDate = strtotime($dateRange[1]);

                foreach ($hotel['availability'] as $availability) {
                    $from = strtotime($availability['from']);
                    $to = strtotime($availability['to']);
                    if ($from <= $endDate && $to >= $startDate) {
                        return true;
                    }
                }
                return false;
            }

            return true;
        });

        // Return Data Of Hotels
        return response()->json($filteredHotels->values());
    }
}
