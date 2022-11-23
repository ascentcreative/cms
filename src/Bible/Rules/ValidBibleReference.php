<?php

namespace AscentCreative\CMS\Bible\Rules;

// use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\InvokableRule;

/**
 * The specified date must fall within an open Royalty Period
 */
class ValidBibleReference implements InvokableRule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {

        try {

            $brp = new \AscentCreative\CMS\Bible\BibleReferenceParser();
            $parsed = $brp->parseBibleRef($value);
    
        } catch (\Exception $e) {
            $fail('Unable to parse reference from "' . $value . '"');
        }
    
    }

}
