<?php

namespace Amo\Sdk\Traits;

trait ServiceInitializer
{
    /**
     * @param $method
     * @param $arguments
     * @return false|mixed
     */
    public function __call($method, $arguments)
    {
        $version = property_exists($this, 'versionMapper') ?
            (
                $this->versionMapper[lcfirst($method)] ?? null
                    ? $this->versionMapper[lcfirst($method)] . '\\'
                    : ''
            ) : '';

        $serviceClassName = '\\Amo\\Sdk\\Service\\' . $version . ucfirst($method) . 'Service';
        if (!class_exists($serviceClassName)) {
            throw new \BadMethodCallException(
                'Call to undefined method ' . get_class($this) . '::' . $method . '()'
            );
        }

        $instance = new $serviceClassName();
        if (method_exists($instance, 'factory')) {
            call_user_func_array([$instance, 'factory'], array_merge([$this], $arguments));
        }
        return $instance;
    }
}
