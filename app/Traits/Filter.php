<?php

namespace App\Traits;

use DB;

/**
 * Trait Filter
 * @package App\Traits
 */
trait Filter
{
    /**
     * Filter the 'guitar search' query.
     *
     * @param  \Illuminate\Database\Eloquent\Relations\belongsToMany  $query
     * @param  array $filter_types
     * @param  array  $filter_brands
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany  $query
     */
    protected function filterGuitars($query, $filter_types, $filter_brands)
    {
        if ($filter_types) {
            foreach ($filter_types as $filter_type) {
                $query->whereHas('guitarTypes', function ($q) use ($filter_type) {
                    $q->where('id', $filter_type);
                });
            }
        }

        if ($filter_brands) {
            $query->where(function ($q) use ($filter_brands) {
                foreach ($filter_brands as $filter_brand) {
                    $q->orWhere('brand_id', $filter_brand);
                }
            });
        }

        return $query;
    }

    /**
     * Filter the 'user search' query.
     *
     * @param  \Illuminate\Database\Eloquent\Relations\belongsToMany  $query
     * @param  string  $haversine
     * @param  boolean  $proximity
     * @param  integer  $radius
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany  $query
     */
    protected function filterUsers($query, $haversine, $proximity, $radius)
    {
        if ($proximity) {
            $query->orderBy('distance');
        }

        if ($radius) {
            // Get all users within the specified radius (in km).
            // For some reason 'having' is not working with pagination/counting results.
            $query->whereRaw("{$haversine} < ?", [$radius]);
        }

        return $query;
    }
}
