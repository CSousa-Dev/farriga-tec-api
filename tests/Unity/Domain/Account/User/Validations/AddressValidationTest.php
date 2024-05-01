<?php 
namespace App\Tests\Unity\Domain\Account\User\Validations;
use App\Service\Validation\SymfonyValidator;
use PHPUnit\Framework\TestCase;
use App\Service\Validation\SymfonyValidationConstraints;
use App\Domain\Account\User\ValidationRules\AddressValidation;

class AddressValidationTest extends TestCase
{
    private AddressValidation $addressValidation;
    public function setUp(): void
    {
        $symfonyValidator = new SymfonyValidator();
        $this->addressValidation = new AddressValidation($symfonyValidator, new SymfonyValidationConstraints());
        parent::setUp();
    }

    public function testErrosForNotBlanckFields()
    {
        $street = '';
        $number = '';
        $neighborhood = '';
        $city = '';
        $state = '';
        $country = '';
        $zipCode = '';
        
        $validationResult = $this->addressValidation->validateStreet($street);
        $validationResult->addAnotherValidationResult($this->addressValidation->validateNumber($number));
        $validationResult->addAnotherValidationResult($this->addressValidation->validateNeighborhood($neighborhood));
        $validationResult->addAnotherValidationResult($this->addressValidation->validateCity($city));
        $validationResult->addAnotherValidationResult($this->addressValidation->validateState($state));
        $validationResult->addAnotherValidationResult($this->addressValidation->validateCountry($country));
        $validationResult->addAnotherValidationResult($this->addressValidation->validateZipCode($zipCode));

        $this->assertTrue($validationResult->hasErrors());
        $this->assertContains('street', array_keys($validationResult->errors()['homeAddress']));
        $this->assertContains('É obrigatório.', $validationResult->errors()['homeAddress']['street']);
        $this->assertContains('number', array_keys($validationResult->errors()['homeAddress']));
        $this->assertContains('É obrigatório.', $validationResult->errors()['homeAddress']['number']);
        $this->assertContains('neighborhood', array_keys($validationResult->errors()['homeAddress']));
        $this->assertContains('É obrigatório.', $validationResult->errors()['homeAddress']['neighborhood']);
        $this->assertContains('city', array_keys($validationResult->errors()['homeAddress']));
        $this->assertContains('É obrigatório.', $validationResult->errors()['homeAddress']['city']);
        $this->assertContains('state', array_keys($validationResult->errors()['homeAddress']));
        $this->assertContains('É obrigatório.', $validationResult->errors()['homeAddress']['state']);
        $this->assertContains('country', array_keys($validationResult->errors()['homeAddress']));
        $this->assertContains('É obrigatório.', $validationResult->errors()['homeAddress']['country']);
        $this->assertContains('zipCode', array_keys($validationResult->errors()['homeAddress']));
        $this->assertContains('É obrigatório.', $validationResult->errors()['homeAddress']['zipCode']);
    }

    public function testMaxLengthForFields()
    {
        $street101Characters = 'street das Flores, 123, neighborhood das Flores, cidade das Flores, state das Flores, country das Flores street das';
        $number51Characters = '123456789012345678901234567890123456789012345678901';
        $neighborhood51Characters = 'neighborhood das Flores, neighborhood das Flores, neighborhood das Fl';
        $city51Characters = 'cidade das Flores, cidade das Flores, cidade das Fl';
        $state31Characters = 'statae das Flores, state das Fa';
        $country31Characters = 'country das Flores, country das Flore';
        $zipCode21Characters = '123456789012345678901';
        $reference101Characters = 'street das Flores, 123, neighborhood das Flores, city das Flores, state das Flores, country das Flores street das';
        $complement101Characters = 'street das Flores, 123, neighborhood das Flores, city das Flores, state das Flores, country das Flores street das';

                
        $validationResult = $this->addressValidation->validateStreet($street101Characters);
        $validationResult->addAnotherValidationResult($this->addressValidation->validateNumber($number51Characters));
        $validationResult->addAnotherValidationResult($this->addressValidation->validateNeighborhood($neighborhood51Characters));
        $validationResult->addAnotherValidationResult($this->addressValidation->validateCity($city51Characters));
        $validationResult->addAnotherValidationResult($this->addressValidation->validateState($state31Characters));
        $validationResult->addAnotherValidationResult($this->addressValidation->validateCountry($country31Characters));
        $validationResult->addAnotherValidationResult($this->addressValidation->validateZipCode($zipCode21Characters));
        $validationResult->addAnotherValidationResult($this->addressValidation->validateReference($reference101Characters));
        $validationResult->addAnotherValidationResult($this->addressValidation->validateComplement($complement101Characters));

        $this->assertTrue($validationResult->hasErrors());
        $this->assertContains('street', array_keys($validationResult->errors()['homeAddress']));
        $this->assertContains('Deve ter no máximo 100 caracteres.', $validationResult->errors()['homeAddress']['street']);
        $this->assertContains('number', array_keys($validationResult->errors()['homeAddress']));
        $this->assertContains('Deve ter no máximo 50 caracteres.', $validationResult->errors()['homeAddress']['number']);
        $this->assertContains('neighborhood', array_keys($validationResult->errors()['homeAddress']));
        $this->assertContains('Deve ter no máximo 50 caracteres.', $validationResult->errors()['homeAddress']['neighborhood']);
        $this->assertContains('city', array_keys($validationResult->errors()['homeAddress']));
        $this->assertContains('Deve ter no máximo 50 caracteres.', $validationResult->errors()['homeAddress']['city']);
        $this->assertContains('state', array_keys($validationResult->errors()['homeAddress']));
        $this->assertContains('Deve ter no máximo 30 caracteres.', $validationResult->errors()['homeAddress']['state']);   
        $this->assertContains('country', array_keys($validationResult->errors()['homeAddress']));
        $this->assertContains('Deve ter no máximo 30 caracteres.', $validationResult->errors()['homeAddress']['country']);
        $this->assertContains('zipCode', array_keys($validationResult->errors()['homeAddress']));
        $this->assertContains('Deve ter no máximo 20 caracteres.', $validationResult->errors()['homeAddress']['zipCode']);
        $this->assertContains('reference', array_keys($validationResult->errors()['homeAddress']));
        $this->assertContains('Deve ter no máximo 100 caracteres.', $validationResult->errors()['homeAddress']['reference']);
        $this->assertContains('complement', array_keys($validationResult->errors()['homeAddress']));
        $this->assertContains('Deve ter no máximo 100 caracteres.', $validationResult->errors()['homeAddress']['complement']);
    }
}