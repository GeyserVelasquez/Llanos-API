<?php

namespace Tests\Feature\LookUp;

use App\Models\BirthType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BirthTypeTest extends TestCase
{

    public function test_users_can_get_a_list_of_birth_types(): void
    {

        BirthType::factory(3)->create();

        $route = route('birth-types.index');

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

    public function test_unauthenticated_users_cannot_access_birth_types_endpoints(): void
    {
        $birthType = BirthType::factory()->create();

        $routeIndex = route('birth-types.index');
        $responseIndex = $this->getJson($routeIndex);
        $responseIndex->assertStatus(401);

        $routeShow = route('birth-types.show', $birthType);
        $responseShow = $this->getJson($routeShow);
        $responseShow->assertStatus(401);

        $storePayload = [
            'code' => 'sh',
            'name' => 'showTest'
        ];
        $routeStore = route('birth-types.store');
        $responseStore = $this->postJson($routeStore, $storePayload);
        $responseStore->assertStatus(401);
        $this->assertDatabaseMissing('birth_types', [
            'code' => 'sh'
        ]);


        $updatePayload = [
            'name' => 'test'
        ];
        $routeUpdate = route('birth-types.update', $birthType);
        $responseUpdate = $this->putJson($routeUpdate, $updatePayload);
        $responseUpdate->assertStatus(401);

        $routeDestroy = route('birth-types.destroy', $birthType);
        $responseDestroy = $this->deleteJson($routeDestroy);
        $responseDestroy->assertStatus(401);
        $this->assertDatabaseMissing('birth_types', [
            'name' => 'test'
        ]);
    }

    public function test_users_can_get_a_single_birthType(): void
    {
        $birthType = BirthType::factory()->create();

        $route = route('birth-types.show', $birthType);

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'code' => $birthType->code,
            'name' => $birthType->name
        ]);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'code',
                'name',
            ]
        ]);
    }

    public function test_users_can_create_a_new_birthType(): void
    {
        $payload = [
            'code' => 'HO',
            'name' => 'Holstein'
        ];

        $route = route('birth-types.store');

        $response = $this->actingAs($this->user)
             ->postJson($route,$payload);

        $response->assertStatus(201);

        $this->assertDatabaseHas('birth_types', [
            'code' => 'HO'
        ]);
    }

    public function test_users_cannot_create_a_new_birthType_with_missing_parameters(): void
    {
        $payload = [
            'name' => 'Holstein'
        ];

        $route = route('birth-types.store');

        $response = $this->actingAs($this->user)
             ->postJson($route,$payload);

        $response->assertStatus(422);

        $this->assertDatabaseMissing('birth_types', [
            'name' => 'Holstein'
        ]);
    }

    public function test_users_cannot_create_a_birthType_with_a_duplicated_code(): void
    {
        $birthType = BirthType::factory()->create();

        $payload = [
            'code' => $birthType->code,
            'name' => 'Modificado'
        ];

        $route = route('birth-types.store');

        $response = $this->actingAs($this->user)
            ->postJson($route, $payload);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(['code']);
    }

    public function test_users_can_update_a_birthType(): void
    {
        $birthType = BirthType::factory()->create();

        $payload = [
            'code' => 'WG',
            'name' => 'Wagyu'
        ];

        $route = route('birth-types.update', $birthType);

        $response = $this->actingAs($this->user)
            ->putJson($route, $payload);

        $response->assertStatus(200);

        $this->assertDatabaseHas('birth_types', [
            'code' => 'WG'
        ]);
    }

    public function test_users_cannot_update_a_birthType_with_missing_parameters(): void
    {
        $birthType = BirthType::factory()->create();

        $payload = [];

        $route = route('birth-types.update', $birthType);

        $response = $this->actingAs($this->user)
            ->putJson($route, $payload);

        $response->assertStatus(422);

        $this->assertDatabaseHas($birthType);
    }

    public function test_users_can_delete_a_birthType(): void
    {
        $birthType = BirthType::factory()->create([
            'code' => 'AN',
            'name' => 'Angus'
        ]);

        $route = route('birth-types.destroy', $birthType);

        $response = $this->actingAs($this->user)
            ->deleteJson($route);

        $response->assertStatus(204);

        $this->assertSoftDeleted($birthType);
    }

    public function test_users_cannot_get_a_soft_deleted_birthType(): void
    {
        $birthType = BirthType::factory()->create();

        $birthType->delete();

        $route = route('birth-types.show', $birthType);

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(404);
    }

}
