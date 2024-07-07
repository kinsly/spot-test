<?php

namespace Tests\Feature;

use App\Enums\OrderStatus;
use App\Models\User;
use App\Services\ProcessIdSelector;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a user and log in
        $this->user = User::factory()->create();
        Auth::login($this->user);
    }
    

    /** Test new order is created and stored on database */
    public function test_creating_a_new_order(){

        // request data
        $requestData = [
            'customer_name' => 'John Doe',
            'value' => 250.00,
        ];

        // Make the request to the store method
        $response = $this->postJson(route('orders.store'), $requestData);

        // Assert the response status
        $response->assertStatus(200);

        // Assert the order is created in the database
        $this->assertDatabaseHas('orders', [
            'customer_name' => 'John Doe',
            'value' => 250.00,
            'status' => OrderStatus::PROCESSING,
            'user_id' => $this->user->id,
        ]);
    }

    /**
     * Testing above created order is displayed
     */
    public function test_displaying_created_orders()
    {
        // Make the request to the index method
        $response = $this->getJson(route('orders.index'));

        // Assert the response status and structure
        $response->assertStatus(200)
                // Assert the JSON response structure
                ->assertJsonStructure([
                '*' => [
                    'order_id',
                    'created_at',
                    'updated_at',
                    'deleted_at',
                    'customer_name',
                    'status',
                    'process_id',
                    'value',
                ]
                ]);
    }


}
