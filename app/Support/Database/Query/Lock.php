<?php
namespace GL\Support\Database\Query;

use Illuminate\Database\Eloquent\Builder;

trait Lock
{
    /**
     * add lock if options has lock params
     *
     * @param Builder $query
     * @param array $options   array keys taken:
     *                          - lock string [shared_lock or lock_for_update]
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws \Exception
     */
    protected function checkLock(Builder $query, array $options = [])
    {
        if (!is_null($lock = array_get($options, 'lock'))) {
            if ('shared_lock' == $lock) {
                $query->sharedLock();
            } elseif ('lock_for_update' == $lock) {
                $query->lockForUpdate();
            } else {
                throw new \Exception('invalid lock for db');
            }
        }

        return $query;
    }
}