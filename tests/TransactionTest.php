<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

use App\Models\User;

class TransactionTest extends TestCase
{

    private $payer;
    private $payee;

    use DatabaseMigrations, DatabaseTransactions;

   public function setUp(): void
   {
        parent::setUp();

        $this->payer = User::factory()->create([
            'name'     => 'William Mec',
            'password' => '#1$AA00',
            'document' => '41203922045',
            'email'    => 'mwli@hotmail.com',
            'type'     => 'client',
            'balance'  => 1500
        ]);


        $this->payee = User::factory()->create([
            'name'     => 'Webber Games',
            'password' => '#1$AA00',
            'document' => '48760301000140',
            'email'    => 'webber@gmail.com',
            'type'     => 'shopkeeper',
            'balance'  => 4000
        ]);
   }

   public function testWithTheZeroedValue()
   {
        $response = $this->post('/transaction', [
            'payer' => $this->payer->id,
            'payee' => $this->payee->id,
            'value' => 0
        ]);

        $response->assertResponseStatus(422);

        $response->seeJson([
            "value" => [
                "The value must be at least 0.1."
            ]
        ]);
   }

   public function testUnauthorizedPermissionToTransfer()
   {
        $response = $this->post('/transaction', [
            'payer' => $this->payee->id,
            'payee' => $this->payer->id,
            'value' => 10
        ]);

        $response->assertResponseStatus(422);

        $response->seeJson([
            "payer" => [
                "Shopkeepers cannot make transfers."
            ]
        ]);
   }

   public function testTheTransferAmountIsGreaterThanTheBalance()
   {
        $response = $this->post('/transaction', [
            'payer' => $this->payer->id,
            'payee' => $this->payee->id,
            'value' => 8000
        ]);

        $response->assertResponseStatus(422);

        $response->seeJson([
            "payer" => [
                "Insufficient balance to complete a transaction."
            ]
        ]);
   }

   public function testThePayerIsTheSameAsTheBeneficiary()
   {
        $response = $this->post('/transaction', [
            'payer' => $this->payer->id,
            'payee' => $this->payer->id,
            'value' => 10
        ]);

        $response->assertResponseStatus(422);

        $response->seeJson([
            "payee" => [
                "The payee and payer must be different."
            ]
        ]);
   }

   public function testSuccessfulTransaction()
   {
        $response = $this->post('/transaction', [
            'payer' => $this->payer->id,
            'payee' => $this->payee->id,
            'value' => 100
        ]);

        $response->assertResponseStatus(200);
   }
   
}
