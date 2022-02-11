<?php

namespace App\Model;

class Position
{
    public $id;
    public $title;
    public $seniorityLevel;
    public $country;
    public $city;
    public $salary;
    public $currency;
    public $skillSet;
    public $companySize;
    public $companyDomain;

    /**
     * @param int $id
     * @param string $title
     * @param string $seniorityLevel
     * @param string $country
     * @param string $city
     * @param int $salary
     * @param string $currency
     * @param array $skillSet
     * @param string $companySize
     * @param string $companyDomain
     */
    public function __construct(
        int    $id,
        string $title,
        string $seniorityLevel,
        string $country,
        string $city,
        int    $salary,
        string $currency,
        array  $skillSet,
        string $companySize,
        string $companyDomain
    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->seniorityLevel = $seniorityLevel;
        $this->country = $country;
        $this->city = $city;
        $this->salary = $salary;
        $this->currency = $currency;
        $this->skillSet = $skillSet;
        $this->companySize = $companySize;
        $this->companyDomain = $companyDomain;
    }

    public function toArray(): array
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "seniority_level" => $this->seniorityLevel,
            "country" => $this->country,
            "city" => $this->city,
            "salary" => $this->salary,
            "currency" => $this->currency,
            "skillSet" => $this->skillSet,
            "companySize" => $this->companySize,
            "companyDomain" => $this->companyDomain
        ];
    }
}