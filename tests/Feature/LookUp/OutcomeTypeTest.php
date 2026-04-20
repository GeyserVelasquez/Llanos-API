<?php

namespace LookUp;

use App\Models\OutcomeType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OutcomeTypeTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_users_can_get_a_list_of_outcome_types(): void
    {

        OutcomeType::factory(3)->create();

        $route = route('outcome-types.index');

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

    public function test_unauthenticated_users_cannot_access_outcome_types_endpoints(): void
    {
        $outcomeType = OutcomeType::factory()->create();

        $routeIndex = route('outcome-types.index');
        $responseIndex = $this->getJson($routeIndex);
        $responseIndex->assertStatus(401);

        $routeShow = route('outcome-types.show', $outcomeType);
        $responseShow = $this->getJson($routeShow);
        $responseShow->assertStatus(401);

        $storePayload = [
            'code' => 'sh',
            'name' => 'showTest'
        ];
        $routeStore = route('outcome-types.store');
        $responseStore = $this->postJson($routeStore, $storePayload);
        $responseStore->assertStatus(401);
        $this->assertDatabaseMissing('outcome_types', [
            'code' => 'sh'
        ]);


        $updatePayload = [
            'name' => 'test'
        ];
        $routeUpdate = route('outcome-types.update', $outcomeType);
        $responseUpdate = $this->putJson($routeUpdate, $updatePayload);
        $responseUpdate->assertStatus(401);

        $routeDestroy = route('outcome-types.destroy', $outcomeType);
        $responseDestroy = $this->deleteJson($routeDestroy);
        $responseDestroy->assertStatus(401);
        $this->assertDatabaseMissing('outcome_types', [
            'name' => 'test'
        ]);
    }

    public function test_users_can_get_a_single_outcomeType(): void
    {
        $outcomeType = OutcomeType::factory()->create();

        $route = route('outcome-types.show', $outcomeType);

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'code' => $outcomeType->code,
            'name' => $outcomeType->name
        ]);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'code',
                'name',
            ]
        ]);
    }

    public function test_users_can_create_a_new_outcomeType(): void
    {
        $payload = [
            'code' => 'HO',
            'name' => 'Holstein'
        ];

        $route = route('outcome-types.store');

        $response = $this->actingAs($this->user)
             ->postJson($route,$payload);

        $response->assertStatus(201);

        $this->assertDatabaseHas('outcome_types', [
            'code' => 'HO'
        ]);
    }

    public function test_users_cannot_create_a_new_outcomeType_with_missing_parameters(): void
    {
        $payload = [
            'name' => 'Holstein'
        ];

        $route = route('outcome-types.store');

        $response = $this->actingAs($this->user)
             ->postJson($route,$payload);

        $response->assertStatus(422);

        $this->assertDatabaseMissing('outcome_types', [
            'name' => 'Holstein'
        ]);
    }

    public function test_users_cannot_create_a_outcomeType_with_a_duplicated_code(): void
    {
        $outcomeType = OutcomeType::factory()->create();

        $payload = [
            'code' => $outcomeType->code,
            'name' => 'Modificado'
        ];

        $route = route('outcome-types.store');

        $response = $this->actingAs($this->user)
            ->postJson($route, $payload);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(['code']);
    }

    public function test_users_can_update_a_outcomeType(): void
    {
        $outcomeType = OutcomeType::factory()->create();

        $payload = [
            'code' => 'WG',
            'name' => 'Wagyu'
        ];

        $route = route('outcome-types.update', $outcomeType);

        $response = $this->actingAs($this->user)
            ->putJson($route, $payload);

        $response->assertStatus(200);

        $this->assertDatabaseHas('outcome_types', [
            'code' => 'WG'
        ]);
    }

    public function test_users_cannot_update_a_outcomeType_with_missing_parameters(): void
    {
        $outcomeType = OutcomeType::factory()->create();

        $payload = [];

        $route = route('outcome-types.update', $outcomeType);

        $response = $this->actingAs($this->user)
            ->putJson($route, $payload);

        $response->assertStatus(422);

        $this->assertDatabaseHas($outcomeType);
    }

    public function test_users_can_delete_a_outcomeType(): void
    {
        $outcomeType = OutcomeType::factory()->create([
            'code' => 'AN',
            'name' => 'Angus'
        ]);

        $route = route('outcome-types.destroy', $outcomeType);

        $response = $this->actingAs($this->user)
            ->deleteJson($route);

        $response->assertStatus(204);

        $this->assertSoftDeleted($outcomeType);
    }

    public function test_users_cannot_get_a_soft_deleted_outcomeType(): void
    {
        $outcomeType = OutcomeType::factory()->create();

        $outcomeType->delete();

        $route = route('outcome-types.show', $outcomeType);

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(404);
    }

}
