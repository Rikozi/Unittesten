<?php
require '../../vendor/autoload.php';
use Controllers\Account;
use PHPUnit\Framework\TestCase;

class AccountTests extends TestCase
{
    protected $account;

    protected function setUp() : void {
        $this->account = new Account();
    }

    public function testPasswordSetting() {
        $password = 'examplePassword';
        $this->account->setPassword($password);
        $this->assertSame($password, $this->account->getPassword());
    }

    public function testAccountRegistrationWithValidData() {
        $this->account->setPassword('secure123');
        $this->account->username = 'newUser';
        $this->account->email = 'user@example.com';

        $registrationErrors = $this->account->registerAccount();

        $this->assertEmpty($registrationErrors, "Registration should not produce errors");
    }

    public function testUserValidations() {
        $this->account->setPassword('secure123');
        $this->account->username = 'newUser';

        $validationErrors = $this->account->validateAccount();

        $this->assertEmpty($validationErrors, "Validation should pass without errors");
    }

    public function testUserRetrieval() {
        $username = 'existingUser';
        $userData = $this->account->getUser($username);
        $this->assertIsArray($userData, "User data should be returned as an array");
    }
}

$testSuite = new AccountTests('Account Test Suite');

$results = [];
$testSuite->setUp();

$results[] = ["Test 1 (Set Password)", $testSuite->testPasswordSetting() ? "passed" : "failed"];
$results[] = ["Test 2 (Account Registration)", $testSuite->testAccountRegistrationWithValidData() ? "passed" : "failed"];
$results[] = ["Test 3 (User Validation)", $testSuite->testUserValidations() ? "passed" : "failed"];
$results[] = ["Test 4 (User Retrieval)", $testSuite->testUserRetrieval() ? "passed" : "failed"];

echo "<h1>Account Class Tests</h1>";
foreach ($results as $test) {
    echo "<div style='width: 300px; display: flex; justify-content: space-between;'><span>{$test[0]}</span><span>{$test[1]}</span></div><br>";
}
