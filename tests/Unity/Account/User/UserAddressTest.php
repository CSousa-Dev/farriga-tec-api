<?php 
use Monolog\Test\TestCase;
use App\Infra\SymfonyValidator;
use App\Infra\SymfonyValidationConstraints;
use App\Domain\Account\User\ValidationRules\AddressValidation;

class UserAddressTest extends TestCase
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
        $this->assertContains('Rua', array_keys($validationResult->errors()['Endereço']));
        $this->assertContains('É obrigatório.', $validationResult->errors()['Endereço']['Rua']);
        $this->assertContains('Número', array_keys($validationResult->errors()['Endereço']));
        $this->assertContains('É obrigatório.', $validationResult->errors()['Endereço']['Número']);
        $this->assertContains('Bairro', array_keys($validationResult->errors()['Endereço']));
        $this->assertContains('É obrigatório.', $validationResult->errors()['Endereço']['Bairro']);
        $this->assertContains('Cidade', array_keys($validationResult->errors()['Endereço']));
        $this->assertContains('É obrigatório.', $validationResult->errors()['Endereço']['Cidade']);
        $this->assertContains('Estado', array_keys($validationResult->errors()['Endereço']));
        $this->assertContains('É obrigatório.', $validationResult->errors()['Endereço']['Estado']);
        $this->assertContains('País', array_keys($validationResult->errors()['Endereço']));
        $this->assertContains('É obrigatório.', $validationResult->errors()['Endereço']['País']);
        $this->assertContains('Código Postal', array_keys($validationResult->errors()['Endereço']));
        $this->assertContains('É obrigatório.', $validationResult->errors()['Endereço']['Código Postal']);
    }

    public function testMaxLengthForFields()
    {
        $street101Characters = 'Rua das Flores, 123, Bairro das Flores, Cidade das Flores, Estado das Flores, País das Flores Rua das';
        $number51Characters = '123456789012345678901234567890123456789012345678901';
        $neighborhood51Characters = 'Bairro das Flores, Bairro das Flores, Bairro das Fl';
        $city51Characters = 'Cidade das Flores, Cidade das Flores, Cidade das Fl';
        $state31Characters = 'Estado das Flores, Estado das F';
        $country31Characters = 'País das Flores, País das Flore';
        $zipCode21Characters = '123456789012345678901';
        $reference101Characters = 'Rua das Flores, 123, Bairro das Flores, Cidade das Flores, Estado das Flores, País das Flores Rua das';
        $complement101Characters = 'Rua das Flores, 123, Bairro das Flores, Cidade das Flores, Estado das Flores, País das Flores Rua das';

                
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
        $this->assertContains('Rua', array_keys($validationResult->errors()['Endereço']));
        $this->assertContains('Deve ter no máximo 100 caracteres.', $validationResult->errors()['Endereço']['Rua']);
        $this->assertContains('Número', array_keys($validationResult->errors()['Endereço']));
        $this->assertContains('Deve ter no máximo 50 caracteres.', $validationResult->errors()['Endereço']['Número']);
        $this->assertContains('Bairro', array_keys($validationResult->errors()['Endereço']));
        $this->assertContains('Deve ter no máximo 50 caracteres.', $validationResult->errors()['Endereço']['Bairro']);
        $this->assertContains('Cidade', array_keys($validationResult->errors()['Endereço']));
        $this->assertContains('Deve ter no máximo 50 caracteres.', $validationResult->errors()['Endereço']['Cidade']);
        $this->assertContains('Estado', array_keys($validationResult->errors()['Endereço']));
        $this->assertContains('Deve ter no máximo 30 caracteres.', $validationResult->errors()['Endereço']['Estado']);   
        $this->assertContains('País', array_keys($validationResult->errors()['Endereço']));
        $this->assertContains('Deve ter no máximo 30 caracteres.', $validationResult->errors()['Endereço']['País']);
        $this->assertContains('Código Postal', array_keys($validationResult->errors()['Endereço']));
        $this->assertContains('Deve ter no máximo 20 caracteres.', $validationResult->errors()['Endereço']['Código Postal']);
        $this->assertContains('Referência', array_keys($validationResult->errors()['Endereço']));
        $this->assertContains('Deve ter no máximo 100 caracteres.', $validationResult->errors()['Endereço']['Referência']);
        $this->assertContains('Complemento', array_keys($validationResult->errors()['Endereço']));
        $this->assertContains('Deve ter no máximo 100 caracteres.', $validationResult->errors()['Endereço']['Complemento']);
    }
}