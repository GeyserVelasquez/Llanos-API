<?php

namespace LookUp;

use App\Models\MilkingType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MilkingTypeTest extends TestCase
{

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_users_can_get_a_list_of_milking_types(): void
    {

        MilkingType::factory(3)->create();

        $route = route('milking-types.index');

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

    public function test_unauthenticated_users_cannot_access_milking_types_endpoints(): void
    {
        $milkingType = MilkingType::factory()->create();

        $routeIndex = route('milking-types.index');
        $responseIndex = $this->getJson($routeIndex);
        $responseIndex->assertStatus(401);

        $routeShow = route('milking-types.show', $milkingType);
        $responseShow = $this->getJson($routeShow);
        $responseShow->assertStatus(401);

        $storePayload = [
            'code' => 'sh',
            'name' => 'showTest'
        ];
        $routeStore = route('milking-types.store');
        $responseStore = $this->postJson($routeStore, $storePayload);
        $responseStore->assertStatus(401);
        $this->assertDatabaseMissing('milking_types', [
            'code' => 'sh'
        ]);


        $updatePayload = [
            'name' => 'test'
        ];
        $routeUpdate = route('milking-types.update', $milkingType);
        $responseUpdate = $this->putJson($routeUpdate, $updatePayload);
        $responseUpdate->assertStatus(401);

        $routeDestroy = route('milking-types.destroy', $milkingType);
        $responseDestroy = $this->deleteJson($routeDestroy);
        $responseDestroy->assertStatus(401);
        $this->assertDatabaseMissing('milking_types', [
            'name' => 'test'
        ]);
    }

    public function test_users_can_get_a_single_milkingType(): void
    {
        $milkingType = MilkingType::factory()->create();

        $route = route('milking-types.show', $milkingType);

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'code' => $milkingType->code,
            'name' => $milkingType->name
        ]);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'code',
                'name',
            ]
        ]);
    }

    public function test_users_can_create_a_new_milkingType(): void
    {
        $payload = [
            'code' => 'HO',
            'name' => 'Holstein'
        ];

        $route = route('milking-types.store');

        $response = $this->actingAs($this->user)
             ->postJson($route,$payload);

        $response->assertStatus(201);

        $this->assertDatabaseHas('milking_types', [
            'code' => 'HO'
        ]);
    }

    public function test_users_cannot_create_a_new_milkingType_with_missing_parameters(): void
    {
        $payload = [
            'name' => 'Holstein'
        ];

        $route = route('milking-types.store');

        $response = $this->actingAs($this->user)
             ->postJson($route,$payload);

        $response->assertStatus(422);

        $this->assertDatabaseMissing('milking_types', [
            'name' => 'Holstein'
        ]);
    }

    public function test_users_cannot_create_a_milkingType_with_a_duplicated_code(): void
    {
        $milkingType = MilkingType::factory()->create();

        $payload = [
            'code' => $milkingType->code,
            'name' => 'Modificado'
        ];

        $route = route('milking-types.store');

        $response = $this->actingAs($this->user)
            ->postJson($route, $payload);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(['code']);
    }

    public function test_users_can_update_a_milkingType(): void
    {
        $milkingType = MilkingType::factory()->create();

        $payload = [
            'code' => 'WG',
            'name' => 'Wagyu'
        ];

        $route = route('milking-types.update', $milkingType);

        $response = $this->actingAs($this->user)
            ->putJson($route, $payload);

        $response->assertStatus(200);

        $this->assertDatabaseHas('milking_types', [
            'code' => 'WG'
        ]);
    }

    public function test_users_cannot_update_a_milkingType_with_missing_parameters(): void
    {
        $milkingType = MilkingType::factory()->create();

        $payload = [];

        $route = route('milking-types.update', $milkingType);

        $response = $this->actingAs($this->user)
            ->putJson($route, $payload);

        $response->assertStatus(422);

        $this->assertDatabaseHas($milkingType);
    }

    public function test_users_can_delete_a_milkingType(): void
    {
        $milkingType = MilkingType::factory()->create([
            'code' => 'AN',
            'name' => 'Angus'
        ]);

        $route = route('milking-types.destroy', $milkingType);

        $response = $this->actingAs($this->user)
            ->deleteJson($route);

        $response->assertStatus(204);

        $this->assertSoftDeleted($milkingType);
    }

    public function test_users_cannot_get_a_soft_deleted_milkingType(): void
    {
        $milkingType = MilkingType::factory()->create();

        $milkingType->delete();

        $route = route('milking-types.show', $milkingType);

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(404);
    }

}
