<?php

namespace GL\Support\Database\Eloquent;

/**
 * for models whose identifiers are pre-set (and set) before instead of after
 * persistence.
 */
abstract class PreIdentifiedModel extends Model
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        /**
         * Attach to the 'creating' Model Event to provide a value
         * for the `id` field (provided by $model->getKeyName())
         */
        static::creating(function (Model $model) {
            if (is_null($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = $model->genIdentifier();
            }
        });
    }

    /**
     * generate identifier
     *
     * @return string
     */
    protected abstract function genIdentifier();
}