<?php

namespace GL\Models\BaseStation;

use GL\Support\Database\Eloquent\UuidModel;

/**
 * Base station
 *
 * @property string $id
 * @property double $lat
 * @property double $lng
 */
class BaseStation extends UuidModel
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'base_stations';

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'lat', 'lng',
    ];

    public static function findByIds(array $ids)
    {
        $idsWithLocations = array_fill_keys($ids, null);

        $baseStations = self::whereIn('id', $ids)->get()->all();

        /** @var static $baseStation */
        foreach ($baseStations as $baseStation) {
            $idsWithLocations[$baseStation->id] = [
                'lat' => $baseStation->lat,
                'lng' => $baseStation->lng,
            ];
        }

        return $idsWithLocations;
    }
}