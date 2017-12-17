<?php

namespace GL\Models\BaseStation;

use Carbon\Carbon;
use GL\Support\Database\Eloquent\UuidModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Base station of china unicom
 *
 * @property int $lac
 * @property int $cellId
 * @property double $lat
 * @property double $lon
 * @property int $radius
 * @property string $province
 * @property string $city
 * @property string $district
 * @property string $township
 * @property string $address
 * @property Carbon|null $dataRefreshAt
 */
class ChinaUnicom extends UuidModel
{
    use SoftDeletes;

    const MORE_INFO = [
        'province',
        'city',
        'district',
        'township',
        'address',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'china_unicoms';

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'lac', 'cell_id', 'lat', 'lon', 'radius',
        'more_info',
        'more_info->province', 'more_info->city',
        'more_info->district', 'more_info->township',
        'more_info->address',
        'data_refresh_at',
    ];

    /**
     * @inheritdoc
     */
    protected $casts = [
        'data_refresh_at' => 'datetime',
        'more_info'       => 'json',  // or array
    ];

    public function scopeOfLac(Builder $query, $lac)
    {
        return $query->where('lac', $lac);
    }

    public function scopeOfCellId(Builder $query, $cellId)
    {
        return $query->where('cell_id', $cellId);
    }

    /**
     * Shape a base station of china unicom
     *
     * @param int $lac
     * @param int $cellId
     * @param $lat
     * @param $lon
     * @param int $radius
     * @param string|null $province
     * @param string|null $city
     * @param string|null $district
     * @param string|null $township
     * @param string|null $address
     * @param Carbon|null $dataRefreshAt
     * @return bool|static
     */
    public static function shape(int $lac, int $cellId, $lat, $lon, int $radius,
                                 string $province = null, string $city = null,
                                 string $district = null, string $township = null,
                                 string $address = null, Carbon $dataRefreshAt = null)
    {
        $chinaMobile = new static();
        $chinaMobile->lac           = $lac;
        $chinaMobile->cellId        = $cellId;
        $chinaMobile->lat           = $lat;
        $chinaMobile->lon           = $lon;
        $chinaMobile->radius        = $radius;
        $chinaMobile->province      = $province;
        $chinaMobile->city          = $city;
        $chinaMobile->district      = $district;
        $chinaMobile->township      = $township;
        $chinaMobile->address       = $address;
        $chinaMobile->dataRefreshAt = $dataRefreshAt;

        return $chinaMobile->save() ? $chinaMobile : false;
    }

    /**
     * Get field from more info
     *
     * @param string $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        $snakeCaseKey = snake_case($key);

        if (in_array($snakeCaseKey, self::MORE_INFO)) {
            return array_get($this->moreInfo, $snakeCaseKey);
        }

        return parent::getAttribute($key);
    }

    /**
     * Set field in more info
     *
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function setAttribute($key, $value)
    {
        $snakeCaseKey = snake_case($key);

        if (in_array($snakeCaseKey, self::MORE_INFO)) {
            return parent::setAttribute('more_info->' . $key, $value);
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * Find base station of china unicom
     *
     * @param int $lac
     * @param int $cellId
     * @return static|null
     */
    public static function findBy(int $lac, int $cellId)
    {
        return self::ofLac($lac)->ofCellId($cellId)->first();
    }
}