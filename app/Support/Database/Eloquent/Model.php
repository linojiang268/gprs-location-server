<?php

namespace GL\Support\Database\Eloquent;

use GL\Helpers\Clazz as ClassHelper;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Base class for application models. This calls provides:
 * - natural way (in studly case) of using attribute
 */
class Model extends EloquentModel
{
    /**
     * Override Eloquent model's method to use studly-case attribute
     *
     * @inheritdoc
     */
    public function getAttribute($key)
    {
        // relations won't take use of snake case internally
        if ($this->relationLoaded($key)) {
            return $this->relations[$key];
        }

        return parent::getAttribute(snake_case($key));
    }

    /**
     * override Eloquent model's method to stop side-effect of the
     * overridden getAttribute() method above
     *
     * @inheritdoc
     */
    public function getRelationValue($value)
    {
        // the overridden getAttribute() will turn relation names into snake case,
        // which is not right, because we'll have relation methods defined in camel case
        return parent::getRelationValue(studly_case($value));
    }

    /**
     * override Eloquent model's method to use camel-case attribute
     *
     * @inheritdoc
     */
    public function setAttribute($key, $value)
    {
        return parent::setAttribute(snake_case($key), $value);
    }

    /**
     * Find model instance by its id, or throw exception when failed.
     *
     * @param string $id
     * @param string $exceptionClass
     *
     * @return static
     */
    public static function ofIdOrFail(string $id, string $exceptionClass = null)
    {
        if (is_null($instance = static::find($id))) {
            $exceptionClass = $exceptionClass ?: ClassHelper::getConstant(static::class, 'NOT_FOUND_EXCEPTION');

            if (!is_null($exceptionClass)) {
                // $exceptionClass must be sub class of \Sdgj\Exceptions\AppException
                throw (new $exceptionClass)->setData($id);
            }

            // fallback to ModelNotFoundException
            throw (new ModelNotFoundException)->setModel(self::class, $id);
        }

        return $instance;
    }

    /**
     * Determine if two models are logically equal.
     *
     * @param Model|null $model
     * @return bool
     */
    public function equals(Model $model = null)
    {
        if (is_null($model)) {
            return false;
        }

        return $this->is($model);
    }
}