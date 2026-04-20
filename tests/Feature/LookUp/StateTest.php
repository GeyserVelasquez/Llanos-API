<?php

namespace LookUp;

use App\Models\State;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StateTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_users_can_get_a_list_of_states(): void
    {

        State::factory(3)->create();

        $route = route('states.index');

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

    public function test_unauthenticated_users_cannot_access_states_endpoints(): void
    {
        $state = State::factory()->create();

        $routeIndex = route('states.index');
        $responseIndex = $this->getJson($routeIndex);
        $responseIndex->assertStatus(401);

        $routeShow = route('states.show', $state);
        $responseShow = $this->getJson($routeShow);
        $responseShow->assertStatus(401);

        $storePayload = [
            'code' => 'sh',
            'name' => 'showTest'
        ];
        $routeStore = route('states.store');
        $responseStore = $this->postJson($routeStore, $storePayload);
        $responseStore->assertStatus(401);
        $this->assertDatabaseMissing('states', [
            'code' => 'sh'
        ]);


        $updatePayload = [
            'name' => 'test'
        ];
        $routeUpdate = route('states.update', $state);
        $responseUpdate = $this->putJson($routeUpdate, $updatePayload);
        $responseUpdate->assertStatus(401);

        $routeDestroy = route('states.destroy', $state);
        $responseDestroy = $this->deleteJson($routeDestroy);
        $responseDestroy->assertStatus(401);
        $this->assertDatabaseMissing('states', [
            'name' => 'test'
        ]);
    }

    public function test_users_can_get_a_single_state(): void
    {
        $state = State::factory()->create();

        $route = route('states.show', $state);

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'code' => $state->code,
            'name' => $state->name
        ]);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'code',
                'name',
            ]
        ]);
    }

    public function test_users_can_create_a_new_state(): void
    {
        $payload = [
            'code' => 'HO',
            'name' => 'Holstein'
        ];

        $route = route('states.store');

        $response = $this->actingAs($this->user)
             ->postJson($route,$payload);

        $response->assertStatus(201);

        $this->assertDatabaseHas('states', [
            'code' => 'HO'
        ]);
    }

    public function test_users_cannot_create_a_new_state_with_missing_parameters(): void
    {
        $payload = [
            'name' => 'Holstein'
        ];

        $route = route('states.store');

        $response = $this->actingAs($this->user)
             ->postJson($route,$payload);

        $response->assertStatus(422);

        $this->assertDatabaseMissing('states', [
            'name' => 'Holstein'
        ]);
    }

    public function test_users_cannot_create_a_state_with_a_duplicated_code(): void
    {
        $state = State::factory()->create();

        $payload = [
            'code' => $state->code,
            'name' => 'Modificado'
        ];

        $route = route('states.store');

        $response = $this->actingAs($this->user)
            ->postJson($route, $payload);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(['code']);
    }

    public function test_users_can_update_a_state(): void
    {
        $state = State::factory()->create();

        $payload = [
            'code' => 'WG',
            'name' => 'Wagyu'
        ];

        $route = route('states.update', $state);

        $response = $this->actingAs($this->user)
            ->putJson($route, $payload);

        $response->assertStatus(200);

        $this->assertDatabaseHas('states', [
            'code' => 'WG'
        ]);
    }

    public function test_users_cannot_update_a_state_with_missing_parameters(): void
    {
        $state = State::factory()->create();

        $payload = [];

        $route = route('states.update', $state);

        $response = $this->actingAs($this->user)
            ->putJson($route, $payload);

        $response->assertStatus(422);

        $this->assertDatabaseHas($state);
    }

    public function test_users_can_delete_a_state(): void
    {
        $state = State::factory()->create([
            'code' => 'AN',
            'name' => 'Angus'
        ]);

        $route = route('states.destroy', $state);

        $response = $this->actingAs($this->user)
            ->deleteJson($route);

        $response->assertStatus(204);

        $this->assertSoftDeleted($state);
    }

    public function test_users_cannot_get_a_soft_deleted_state(): void
    {
        $state = State::factory()->create();

        $state->delete();

        $route = route('states.show', $state);

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(404);
    }

}
