<?php
use Illuminate\Support\Str;

/**
 * Compatibility helper to ensure `str()` is available when some
 * generated files (e.g. by IDE helper packages) call it.
 */
if (! function_exists('str')) {
    /**
     * Create a new Stringable object or return an empty Stringable
     * when called without parameters.
     *
     * @param  mixed  $value
     * @return \Illuminate\Support\Stringable
     */
    function str($value = null)
    {
        // Use Str::of which returns a Stringable instance
        return Str::of($value);
    }
}
