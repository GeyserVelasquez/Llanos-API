<?php

namespace LookUp;

use App\Models\SupplyType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SupplyTypeTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_users_can_get_a_list_of_supply_types(): void
    {

        SupplyType::factory(3)->create();

        $route = route('supply-types.index');

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

    public function test_unauthenticated_users_cannot_access_supply_types_endpoints(): void
    {
        $supplyType = SupplyType::factory()->create();

        $routeIndex = route('supply-types.index');
        $responseIndex = $this->getJson($routeIndex);
        $responseIndex->assertStatus(401);

        $routeShow = route('supply-types.show', $supplyType);
        $responseShow = $this->getJson($routeShow);
        $responseShow->assertStatus(401);

        $storePayload = [
            'code' => 'sh',
            'name' => 'showTest'
        ];
        $routeStore = route('supply-types.store');
        $responseStore = $this->postJson($routeStore, $storePayload);
        $responseStore->assertStatus(401);

        $updatePayload = [
            'name' => 'test'
        ];
        $routeUpdate = route('supply-types.update', $supplyType);
        $responseUpdate = $this->putJson($routeUpdate, $updatePayload);
        $responseUpdate->assertStatus(401);

        $routeDestroy = route('supply-types.destroy', $supplyType);
        $responseDestroy = $this->deleteJson($routeDestroy);
        $responseDestroy->assertStatus(401);
    }

    public function test_users_can_get_a_single_supply_type(): void
    {
        $supplyType = SupplyType::factory()->create();

        $route = route('supply-types.show', $supplyType);

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'code' => $supplyType->code,
            'name' => $supplyType->name
        ]);
    }

    public function test_users_can_create_a_new_supply_type(): void
    {
        $payload = [
            'code' => 'HO',
            'name' => 'Holstein'
        ];

        $route = route('supply-types.store');

        $response = $this->actingAs($this->user)
             ->postJson($route,$payload);

        $response->assertStatus(201);

        $this->assertDatabaseHas('supply_types', [
            'code' => 'HO'
        ]);
    }

    public function test_users_cannot_create_a_new_supply_type_with_missing_parameters(): void
    {
        $payload = [
            'name' => 'Holstein'
        ];

        $route = route('supply-types.store');

        $response = $this->actingAs($this->user)
             ->postJson($route,$payload);

        $response->assertStatus(422);
    }

    public function test_users_cannot_create_a_supply_type_with_a_duplicated_code(): void
    {
        $supplyType = SupplyType::factory()->create();

        $payload = [
            'code' => $supplyType->code,
            'name' => 'Modified'
        ];

        $route = route('supply-types.store');

        $response = $this->actingAs($this->user)
            ->postJson($route, $payload);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(['code']);
    }

    public function test_users_can_update_a_supply_type(): void
    {
        $supplyType = SupplyType::factory()->create();

        $payload = [
            'code' => 'WG',
            'name' => 'Wagyu'
        ];

        $route = route('supply-types.update', $supplyType);

        $response = $this->actingAs($this->user)
            ->putJson($route, $payload);

        $response->assertStatus(200);

        $this->assertDatabaseHas('supply_types', [
            'code' => 'WG'
        ]);
    }

    public function test_users_can_delete_a_supply_type(): void
    {
        $supplyType = SupplyType::factory()->create();

        $route = route('supply-types.destroy', $supplyType);

        $response = $this->actingAs($this->user)
            ->deleteJson($route);

        $response->assertStatus(204);

        $this->assertSoftDeleted($supplyType);
    }
}
