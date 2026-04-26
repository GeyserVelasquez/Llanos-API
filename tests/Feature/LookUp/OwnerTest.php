<?php

namespace Tests\Feature\LookUp;

use App\Models\Owner;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OwnerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_users_can_get_a_list_of_owners(): void
    {
        Owner::factory(3)->create();

        $route = route('owners.index');

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
                    'telephone',
                ]
            ]
        ]);
    }

    public function test_unauthenticated_users_cannot_access_owners_endpoints(): void
    {
        $owner = Owner::factory()->create();

        $routeIndex = route('owners.index');
        $responseIndex = $this->getJson($routeIndex);
        $responseIndex->assertStatus(401);

        $routeShow = route('owners.show', $owner);
        $responseShow = $this->getJson($routeShow);
        $responseShow->assertStatus(401);

        $storePayload = [
            'code' => 'sh',
            'name' => 'showTest'
        ];
        $routeStore = route('owners.store');
        $responseStore = $this->postJson($routeStore, $storePayload);
        $responseStore->assertStatus(401);
        $this->assertDatabaseMissing('owners', [
            'code' => 'sh'
        ]);

        $updatePayload = [
            'name' => 'test'
        ];
        $routeUpdate = route('owners.update', $owner);
        $responseUpdate = $this->putJson($routeUpdate, $updatePayload);
        $responseUpdate->assertStatus(401);

        $routeDestroy = route('owners.destroy', $owner);
        $responseDestroy = $this->deleteJson($routeDestroy);
        $responseDestroy->assertStatus(401);
        $this->assertDatabaseMissing('owners', [
            'name' => 'test'
        ]);
    }

    public function test_users_can_get_a_single_owner(): void
    {
        $owner = Owner::factory()->create();

        $route = route('owners.show', $owner);

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'code' => $owner->code,
            'name' => $owner->name,
            'telephone' => $owner->telephone,
        ]);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'code',
                'name',
                'telephone',
            ]
        ]);
    }

    public function test_users_can_create_a_new_owner(): void
    {
        $payload = [
            'code' => 'O1',
            'name' => 'Owner One',
            'telephone' => '123456789'
        ];

        $route = route('owners.store');

        $response = $this->actingAs($this->user)
             ->postJson($route, $payload);

        $response->assertStatus(201);

        $this->assertDatabaseHas('owners', [
            'code' => 'O1'
        ]);
    }

    public function test_users_cannot_create_a_new_owner_with_missing_parameters(): void
    {
        $payload = [
            'name' => 'Owner One'
        ];

        $route = route('owners.store');

        $response = $this->actingAs($this->user)
             ->postJson($route, $payload);

        $response->assertStatus(422);

        $this->assertDatabaseMissing('owners', [
            'name' => 'Owner One'
        ]);
    }

    public function test_users_cannot_create_an_owner_with_a_duplicated_code(): void
    {
        $owner = Owner::factory()->create();

        $payload = [
            'code' => $owner->code,
            'name' => 'Owner Duplicated'
        ];

        $route = route('owners.store');

        $response = $this->actingAs($this->user)
            ->postJson($route, $payload);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(['code']);
    }

    public function test_users_can_update_an_owner(): void
    {
        $owner = Owner::factory()->create();

        $payload = [
            'code' => 'O2',
            'name' => 'Owner Two Updated',
            'telephone' => '987654321'
        ];

        $route = route('owners.update', $owner);

        $response = $this->actingAs($this->user)
            ->putJson($route, $payload);

        $response->assertStatus(200);

        $this->assertDatabaseHas('owners', [
            'code' => 'O2'
        ]);
    }

    public function test_users_cannot_update_an_owner_with_missing_parameters(): void
    {
        $owner = Owner::factory()->create();

        $payload = [];

        $route = route('owners.update', $owner);

        $response = $this->actingAs($this->user)
            ->putJson($route, $payload);

        $response->assertStatus(422);
    }

    public function test_users_can_delete_an_owner(): void
    {
        $owner = Owner::factory()->create([
            'code' => 'AN',
            'name' => 'Angus'
        ]);

        $route = route('owners.destroy', $owner);

        $response = $this->actingAs($this->user)
            ->deleteJson($route);

        $response->assertStatus(204);

        $this->assertSoftDeleted($owner);
    }

    public function test_users_cannot_get_a_soft_deleted_owner(): void
    {
        $owner = Owner::factory()->create();

        $owner->delete();

        $route = route('owners.show', $owner);

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(404);
    }
}
