<?php

use Coursework\Validator;
use PHPUnit\Framework\TestCase;

class ValidatorTests extends TestCase
{
    public function testValidateReturnsTrueIfCorrectDate()
    {
        $validator = new Validator;
        $this->assertTrue($validator->validateDate('10/16/2003 12:12:12'));
    }

    public function testValidateReturnsFalseIfIncorrectDate()
    {
        $validator = new Validator();
        $this->assertFalse($validator->validateDate('NotADate'));
    }

    public function testValidateReturnsTrueIfCorrectBearer()
    {
        $validator = new Validator();
        $this->assertTrue($validator->validateBearer('SMS'));
    }

    public function testValidateReturnsFalseIfIncorrectBearer()
    {
        $validator = new Validator();
        $this->assertFalse($validator->validateBearer(101));
    }

    public function testValidateReturnsTrueIfCorrectSourcemsisdn()
    {
        $validator = new Validator();
        $this->assertTrue($validator->validateSourcemsisdn(123));
    }

    public function testValidateReturnsFalseIfIncorrectSourcemsisdn()
    {
        $validator = new Validator();
        $this->assertFalse($validator->validateSourcemsisdn('should be number'));
    }

    public function testValidateReturnsTrueIfCorrectValidateDestinationmsisdn()
    {
        $validator = new Validator();
        $this->assertTrue($validator->validateDestinationmsisdn(123));
    }

    public function testValidateReturnsFalseIfIncorrectValidateDestinationmsisdn()
    {
        $validator = new Validator();
        $this->assertFalse($validator->validateDestinationmsisdn('should be number'));
    }

    public function testValidateReturnsTrueIfCorrectValidateFan()
    {
        $validator = new Validator();
        $this->assertTrue($validator->validateFan('forward'));
    }

    public function testValidateReturnsFalseIfIncorrectValidateFan()
    {
        $validator = new Validator();
        $this->assertFalse($validator->validateFan('left'));
    }

    public function testValidateReturnsTrueIfCorrectValidateHeater()
    {
        $validator = new Validator();
        $this->assertTrue($validator->validateHeater(21));
    }

    public function testValidateReturnsFalseIfIncorrectValidateHeater()
    {
        $validator = new Validator();
        $this->assertFalse($validator->validateHeater('should be number'));
    }

    public function testValidateReturnsTrueIfCorrectValidateKeypad()
    {
        $validator = new Validator();
        $this->assertTrue($validator->validateKeypad(4));
    }

    public function testValidateReturnsFalseIfIncorrectValidateKeypad()
    {
        $validator = new Validator();
        $this->assertFalse($validator->validateKeypad('should be number'));
    }

    public function testValidateReturnsTrueIfCorrectValidateSwitch()
    {
        $validator = new Validator();
        $this->assertTrue($validator->validateSwitch('on'));
    }

    public function testValidateReturnsFalseIfIncorrectValidateSwitch()
    {
        $validator = new Validator();
        $this->assertFalse($validator->validateSwitch(123));
    }

}