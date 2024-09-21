<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MatchProvinceCode implements ValidationRule
{
    protected string $provinceCode;

    public function __construct(string $provinceId)
    {
        $this->provinceCode = substr($provinceId, 0, 2);
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $childIds = explode(',', $value);

        foreach ($childIds as $childId) {
            $childCode = substr(trim($childId), 0, 2);

            if ($childCode !== $this->provinceCode) {
                $fail('The city_id does not match the province_id.');
            }
        }
    }
}
