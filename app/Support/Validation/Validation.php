<?php

namespace GL\Support\Validation;

use Illuminate\Contracts\Validation\Factory;
use Illuminate\Validation\ValidationException;

trait Validation
{
    /**
     * The default error bag.
     *
     * @var string
     */
    protected $validatesRequestErrorBag;

    /**
     * Validate the given request with the given rules.
     *
     * @param array  $data
     * @param array  $rules
     * @param string|array $messages
     * @param array  $customAttributes
     */
    public function validate(array $data, array $rules, $messages = null, array $customAttributes = [])
    {
        // for back-compatible
        if (is_string($messages)) {
            $messages = [$messages];
        }

        $validator = $this->getValidationFactory()->make($data, $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            $this->throwValidationException($data, $validator);
        }
    }

    /**
     * Validate the given request with the given rules.
     *
     * @param string $errorBag
     * @param array  $data
     * @param array  $rules
     * @param string $group
     * @param string $segment
     * @param array  $customAttributes
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateWithBag($errorBag, array $data, array $rules, string $group, string $segment, array $customAttributes = [])
    {
        $this->withErrorBag($errorBag, function () use ($data, $rules, $group, $segment, $customAttributes) {
            $this->validate($data, $rules, $group, $segment, $customAttributes);
        });
    }

    /**
     * Throw the failed validation exception.
     *
     * @param  array $data
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function throwValidationException(array $data, $validator)
    {
        throw new ValidationException($validator);
    }

    /**
     * Execute a Closure within with a given error bag set as the default bag.
     *
     * @param  string  $errorBag
     * @param  callable  $callback
     * @return void
     */
    protected function withErrorBag($errorBag, callable $callback)
    {
        $this->validatesRequestErrorBag = $errorBag;

        call_user_func($callback);

        $this->validatesRequestErrorBag = null;
    }

    /**
     * Get the key to be used for the view error bag.
     *
     * @return string
     */
    protected function errorBag()
    {
        return $this->validatesRequestErrorBag ?: 'default';
    }

    /**
     * Get a validation factory instance.
     *
     * @return \Illuminate\Contracts\Validation\Factory
     */
    protected function getValidationFactory()
    {
        return app(Factory::class);
    }

}