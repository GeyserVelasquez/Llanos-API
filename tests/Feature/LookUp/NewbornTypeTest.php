<?php

namespace LookUp;

use App\Models\NewbornType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewbornTypeTest extends TestCase
{

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_users_can_get_a_list_of_newborn_types(): void
    {

        NewbornType::factory(3)->create();

        $route = route('newborn-types.index');

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

    public function test_unauthenticated_users_cannot_access_newborn_types_endpoints(): void
    {
        $newbornType = NewbornType::factory()->create();

        $routeIndex = route('newborn-types.index');
        $responseIndex = $this->getJson($routeIndex);
        $responseIndex->assertStatus(401);

        $routeShow = route('newborn-types.show', $newbornType);
        $responseShow = $this->getJson($routeShow);
        $responseShow->assertStatus(401);

        $storePayload = [
            'code' => 'sh',
            'name' => 'showTest'
        ];
        $routeStore = route('newborn-types.store');
        $responseStore = $this->postJson($routeStore, $storePayload);
        $responseStore->assertStatus(401);
        $this->assertDatabaseMissing('newborn_types', [
            'code' => 'sh'
        ]);


        $updatePayload = [
            'name' => 'test'
        ];
        $routeUpdate = route('newborn-types.update', $newbornType);
        $responseUpdate = $this->putJson($routeUpdate, $updatePayload);
        $responseUpdate->assertStatus(401);

        $routeDestroy = route('newborn-types.destroy', $newbornType);
        $responseDestroy = $this->deleteJson($routeDestroy);
        $responseDestroy->assertStatus(401);
        $this->assertDatabaseMissing('newborn_types', [
            'name' => 'test'
        ]);
    }

    public function test_users_can_get_a_single_newbornType(): void
    {
        $newbornType = NewbornType::factory()->create();

        $route = route('newborn-types.show', $newbornType);

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'code' => $newbornType->code,
            'name' => $newbornType->name
        ]);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'code',
                'name',
            ]
        ]);
    }

    public function test_users_can_create_a_new_newbornType(): void
    {
        $payload = [
            'code' => 'HO',
            'name' => 'Holstein'
        ];

        $route = route('newborn-types.store');

        $response = $this->actingAs($this->user)
             ->postJson($route,$payload);

        $response->assertStatus(201);

        $this->assertDatabaseHas('newborn_types', [
            'code' => 'HO'
        ]);
    }

    public function test_users_cannot_create_a_new_newbornType_with_missing_parameters(): void
    {
        $payload = [
            'name' => 'Holstein'
        ];

        $route = route('newborn-types.store');

        $response = $this->actingAs($this->user)
             ->postJson($route,$payload);

        $response->assertStatus(422);

        $this->assertDatabaseMissing('newborn_types', [
            'name' => 'Holstein'
        ]);
    }

    public function test_users_cannot_create_a_newbornType_with_a_duplicated_code(): void
    {
        $newbornType = NewbornType::factory()->create();

        $payload = [
            'code' => $newbornType->code,
            'name' => 'Modificado'
        ];

        $route = route('newborn-types.store');

        $response = $this->actingAs($this->user)
            ->postJson($route, $payload);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(['code']);
    }

    public function test_users_can_update_a_newbornType(): void
    {
        $newbornType = NewbornType::factory()->create();

        $payload = [
            'code' => 'WG',
            'name' => 'Wagyu'
        ];

        $route = route('newborn-types.update', $newbornType);

        $response = $this->actingAs($this->user)
            ->putJson($route, $payload);

        $response->assertStatus(200);

        $this->assertDatabaseHas('newborn_types', [
            'code' => 'WG'
        ]);
    }

    public function test_users_cannot_update_a_newbornType_with_missing_parameters(): void
    {
        $newbornType = NewbornType::factory()->create();

        $payload = [];

        $route = route('newborn-types.update', $newbornType);

        $response = $this->actingAs($this->user)
            ->putJson($route, $payload);

        $response->assertStatus(422);

        $this->assertDatabaseHas($newbornType);
    }

    public function test_users_can_delete_a_newbornType(): void
    {
        $newbornType = NewbornType::factory()->create([
            'code' => 'AN',
            'name' => 'Angus'
        ]);

        $route = route('newborn-types.destroy', $newbornType);

        $response = $this->actingAs($this->user)
            ->deleteJson($route);

        $response->assertStatus(204);

        $this->assertSoftDeleted($newbornType);
    }

    public function test_users_cannot_get_a_soft_deleted_newbornType(): void
    {
        $newbornType = NewbornType::factory()->create();

        $newbornType->delete();

        $route = route('newborn-types.show', $newbornType);

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(404);
    }

}
