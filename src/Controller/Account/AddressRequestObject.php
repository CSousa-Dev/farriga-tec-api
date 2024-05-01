<?php 
namespace App\Controller\Account;

class AddressRequestObject
{   
     public string $street;
    public string $number;
    public string $complement;
    public string $neighborhood;
    public string $city;
    public string $state;
    public string $country;
    public string $zipCode;

    public function __construct(
        string $street,
        string $number,
        string $complement,
        string $neighborhood,
        string $city,
        string $state,
        string $country,
        string $zipCode
    ) {
        $this->street = $street;
        $this->number = $number;
        $this->complement = $complement;
        $this->neighborhood = $neighborhood;
        $this->city = $city;
        $this->state = $state;
        $this->country = $country;
        $this->zipCode = $zipCode;
    }
}