<?php

namespace LookUp;

use App\Models\EmbrionExtractionType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmbrionExtractionTypeTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_users_can_get_a_list_of_embrion_extraction_types(): void
    {

        EmbrionExtractionType::factory(3)->create();

        $route = route('embrion-extraction-types.index');

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(200);

        $response->assertJsonCount(3, 'data');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'code',
                    'name',
                ]
            ]
        ]);
    }

    public function test_unauthenticated_users_cannot_access_embrion_extraction_types_endpoints(): void
    {
        $embrionExtractionType = EmbrionExtractionType::factory()->create();

        $routeIndex = route('embrion-extraction-types.index');
        $responseIndex = $this->getJson($routeIndex);
        $responseIndex->assertStatus(401);

        $routeShow = route('embrion-extraction-types.show', $embrionExtractionType);
        $responseShow = $this->getJson($routeShow);
        $responseShow->assertStatus(401);

        $storePayload = [
            'code' => 'sh',
            'name' => 'showTest'
        ];
        $routeStore = route('embrion-extraction-types.store');
        $responseStore = $this->postJson($routeStore, $storePayload);
        $responseStore->assertStatus(401);

        $updatePayload = [
            'name' => 'test'
        ];
        $routeUpdate = route('embrion-extraction-types.update', $embrionExtractionType);
        $responseUpdate = $this->putJson($routeUpdate, $updatePayload);
        $responseUpdate->assertStatus(401);

        $routeDestroy = route('embrion-extraction-types.destroy', $embrionExtractionType);
        $responseDestroy = $this->deleteJson($routeDestroy);
        $responseDestroy->assertStatus(401);
    }

    public function test_users_can_get_a_single_embrion_extraction_type(): void
    {
        $embrionExtractionType = EmbrionExtractionType::factory()->create();

        $route = route('embrion-extraction-types.show', $embrionExtractionType);

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'code' => $embrionExtractionType->code,
            'name' => $embrionExtractionType->name
        ]);
    }

    public function test_users_can_create_a_new_embrion_extraction_type(): void
    {
        $payload = [
            'code' => 'HO',
            'name' => 'Holstein'
        ];

        $route = route('embrion-extraction-types.store');

        $response = $this->actingAs($this->user)
             ->postJson($route,$payload);

        $response->assertStatus(201);

        $this->assertDatabaseHas('embrion_extraction_types', [
            'code' => 'HO'
        ]);
    }

    public function test_users_cannot_create_a_new_embrion_extraction_type_with_missing_parameters(): void
    {
        $payload = [
            'name' => 'Holstein'
        ];

        $route = route('embrion-extraction-types.store');

        $response = $this->actingAs($this->user)
             ->postJson($route,$payload);

        $response->assertStatus(422);
    }

    public function test_users_cannot_create_a_embrion_extraction_type_with_a_duplicated_code(): void
    {
        $embrionExtractionType = EmbrionExtractionType::factory()->create();

        $payload = [
            'code' => $embrionExtractionType->code,
            'name' => 'Modified'
        ];

        $route = route('embrion-extraction-types.store');

        $response = $this->actingAs($this->user)
            ->postJson($route, $payload);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(['code']);
    }

    public function test_users_can_update_a_embrion_extraction_type(): void
    {
        $embrionExtractionType = EmbrionExtractionType::factory()->create();

        $payload = [
            'code' => 'WG',
            'name' => 'Wagyu'
        ];

        $route = route('embrion-extraction-types.update', $embrionExtractionType);

        $response = $this->actingAs($this->user)
            ->putJson($route, $payload);

        $response->assertStatus(200);

        $this->assertDatabaseHas('embrion_extraction_types', [
            'code' => 'WG'
        ]);
    }

    public function test_users_can_delete_a_embrion_extraction_type(): void
    {
        $embrionExtractionType = EmbrionExtractionType::factory()->create();

        $route = route('embrion-extraction-types.destroy', $embrionExtractionType);

        $response = $this->actingAs($this->user)
            ->deleteJson($route);

        $response->assertStatus(204);

        $this->assertSoftDeleted($embrionExtractionType);
    }
}
