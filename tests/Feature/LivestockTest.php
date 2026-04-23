<?php

namespace Tests\Feature;

use App\Models\Livestock;
use Database\Factories\LivestockFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LivestockTest extends TestCase
{

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_users_can_get_a_list_of_breeds(): void
    {

        $livestock = Livestock::factory(3)->create();

        $route = route('livestock.index');

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(200);

        $response->assertJsonCount(3, 'data');

        $response->assertJsonFragment([
            'brand_number' => $livestock->first()->brand_number,
            'electronic_code' => $livestock->first()->electronic_code,
        ]);

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'brand_number',
                    'electronic_code',
                    'name',
                    'entry_date',
                    'birth_date',
                    'general_comment',
                    'tits',
                    'is_enabled',
                    'is_alive',
                    'entry_cause_id',
                    'state_id',
                    'animal_category',
                    'breed_id',
                    'color_id',
                    'classification_id',
                    'owner_id',
                    'technique_id',
                    'father_id',
                    'mother_id',
                    'adoptive_mother_id',
                    'receiving_mother_id',
                ]
            ]
        ]);
    }

    public function test_users_can_get_a_single_breed(): void
    {
        $livestock = Livestock::factory()->create();

        $route = route('livestock.show', $livestock);

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'brand_number' => $livestock->brand_number,
            'electronic_code' => $livestock->electronic_code,
        ]);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'brand_number',
                'electronic_code',
                'name',
                'entry_date',
                'birth_date',
                'general_comment',
                'tits',
                'is_enabled',
                'is_alive',
                'entry_cause_id',
                'state_id',
                'animal_category',
                'breed_id',
                'color_id',
                'classification_id',
                'owner_id',
                'technique_id',
                'father_id',
                'mother_id',
                'adoptive_mother_id',
                'receiving_mother_id',
            ]
        ]);

    }

    public function test_users_can_create_a_new_breed(): void
    {
        $payload = LivestockFactory::raw();

        $route = route('livestock.store');

        $response = $this->actingAs($this->user)
            ->postJson($route, $payload);

        $response->assertStatus(201);

        $this->assertDatabaseHas('livestock', [
            'brand_number' => $payload['brand_number'],
        ]);
    }

}
