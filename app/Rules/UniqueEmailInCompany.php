<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Company;
use App\Models\Employee;

class UniqueEmailInCompany implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */

     protected $company_name;

     public function __construct($company_name)
     {
         $this->company_name = $company_name;
     }
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $company = Company::where('id', $this->company_name)->first();

        if (!$company) {
            return ; // Company not found
        }

        echo !Employee::where('email', $value)
                        ->where('company_id', $company->id)
                        ->exists();
}
public function message()
    {
        return 'The email address is already registered with this company.';
    }
}