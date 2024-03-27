# Hotel Search API

This project implements a RESTful API for searching hotels based on various criteria such as name, destination, price range, and date range.

## Assumptions

1. **Availability Date Format**: The availability dates for each hotel are assumed to be in the format "dd-mm-yyyy".

2. **Price Range Inclusive**: When filtering hotels by price range, the minimum and maximum prices provided in the range are considered inclusive.

3. **Case-Insensitive Search For Hotel Name**: The search for hotel names and cities is case-insensitive.

4. **Date Range Inclusivity**: When filtering hotels by date range, if a hotel's availability overlaps with the provided date range (including the start and end dates), it is considered available.

5. **API Endpoint**: The API endpoint for fetching hotel data is assumed to be stable and returns valid JSON data.

6. **HTTP Status Codes**: The API returns appropriate HTTP status codes for different scenarios, such as successful responses, failed requests, and validation errors.

## Usage

- You can use `/api/hotels/search` endpoint to fetch data.
- You can use `/api/hotels/search?name=Name&destination=destination&price_range=100:200&date_range=10-10-2020:15-10-2020` endpoint to filter data.

