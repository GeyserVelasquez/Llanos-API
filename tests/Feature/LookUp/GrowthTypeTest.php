<?php

namespace LookUp;

use App\Models\GrowthType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GrowthTypeTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_users_can_get_a_list_of_growth_types(): void
    {

        GrowthType::factory(3)->create();

        $route = route('growth-types.index');

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

    public function test_unauthenticated_users_cannot_access_growth_types_endpoints(): void
    {
        $growthType = GrowthType::factory()->create();

        $routeIndex = route('growth-types.index');
        $responseIndex = $this->getJson($routeIndex);
        $responseIndex->assertStatus(401);

        $routeShow = route('growth-types.show', $growthType);
        $responseShow = $this->getJson($routeShow);
        $responseShow->assertStatus(401);

        $storePayload = [
            'code' => 'sh',
            'name' => 'showTest'
        ];
        $routeStore = route('growth-types.store');
        $responseStore = $this->postJson($routeStore, $storePayload);
        $responseStore->assertStatus(401);

        $updatePayload = [
            'name' => 'test'
        ];
        $routeUpdate = route('growth-types.update', $growthType);
        $responseUpdate = $this->putJson($routeUpdate, $updatePayload);
        $responseUpdate->assertStatus(401);

        $routeDestroy = route('growth-types.destroy', $growthType);
        $responseDestroy = $this->deleteJson($routeDestroy);
        $responseDestroy->assertStatus(401);
    }

    public function test_users_can_get_a_single_growth_type(): void
    {
        $growthType = GrowthType::factory()->create();

        $route = route('growth-types.show', $growthType);

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'code' => $growthType->code,
            'name' => $growthType->name
        ]);
    }

    public function test_users_can_create_a_new_growth_type(): void
    {
        $payload = [
            'code' => 'HO',
            'name' => 'Holstein'
        ];

        $route = route('growth-types.store');

        $response = $this->actingAs($this->user)
             ->postJson($route,$payload);

        $response->assertStatus(201);

        $this->assertDatabaseHas('growth_types', [
            'code' => 'HO'
        ]);
    }

    public function test_users_cannot_create_a_new_growth_type_with_missing_parameters(): void
    {
        $payload = [
            'name' => 'Holstein'
        ];

        $route = route('growth-types.store');

        $response = $this->actingAs($this->user)
             ->postJson($route,$payload);

        $response->assertStatus(422);
    }

    public function test_users_cannot_create_a_growth_type_with_a_duplicated_code(): void
    {
        $growthType = GrowthType::factory()->create();

        $payload = [
            'code' => $growthType->code,
            'name' => 'Modified'
        ];

        $route = route('growth-types.store');

        $response = $this->actingAs($this->user)
            ->postJson($route, $payload);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(['code']);
    }

    public function test_users_can_update_a_growth_type(): void
    {
        $growthType = GrowthType::factory()->create();

        $payload = [
            'code' => 'WG',
            'name' => 'Wagyu'
        ];

        $route = route('growth-types.update', $growthType);

        $response = $this->actingAs($this->user)
            ->putJson($route, $payload);

        $response->assertStatus(200);

        $this->assertDatabaseHas('growth_types', [
            'code' => 'WG'
        ]);
    }

    public function test_users_can_delete_a_growth_type(): void
    {
        $growthType = GrowthType::factory()->create();

        $route = route('growth-types.destroy', $growthType);

        $response = $this->actingAs($this->user)
            ->deleteJson($route);

        $response->assertStatus(204);

        $this->assertSoftDeleted($growthType);
    }
}
