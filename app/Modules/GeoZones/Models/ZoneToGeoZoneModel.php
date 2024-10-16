<?php

namespace App\Modules\GeoZones\Models;

use App\Models\MyModel;

class ZoneToGeoZoneModel extends MyModel
{
    protected $table = 'zone_to_geo_zone';
    protected $primaryKey = 'zone_to_geo_zone_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'country_id',
        'zone_id',
        'geo_zone_id',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function getZoneToGeoZones($geo_zone_id)
    {
        $result = $this->where('geo_zone_id', $geo_zone_id)->findAll();
        if (empty($result)) {
            return [];
        }

        return $result;
    }
}
