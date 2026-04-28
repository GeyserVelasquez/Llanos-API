<?php

    namespace Tests\Feature\LookUp;

use App\Models\AbortType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AbortTypeTest extends TestCase
{
    public function test_users_can_get_a_list_of_abort_types(): void
    {
        AbortType::factory(3)->create();

        $route = route('abort-types.index');

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

    public function test_unauthenticated_users_cannot_access_abort_types_endpoints(): void
    {
        $abortType = AbortType::factory()->create();

        $routeIndex = route('abort-types.index');
        $responseIndex = $this->getJson($routeIndex);
        $responseIndex->assertStatus(401);

        $routeShow = route('abort-types.show', $abortType);
        $responseShow = $this->getJson($routeShow);
        $responseShow->assertStatus(401);

        $storePayload = [
            'code' => 'sh',
            'name' => 'showTest'
        ];
        $routeStore = route('abort-types.store');
        $responseStore = $this->postJson($routeStore, $storePayload);
        $responseStore->assertStatus(401);

        $updatePayload = [
            'name' => 'test'
        ];
        $routeUpdate = route('abort-types.update', $abortType);
        $responseUpdate = $this->putJson($routeUpdate, $updatePayload);
        $responseUpdate->assertStatus(401);

        $routeDestroy = route('abort-types.destroy', $abortType);
        $responseDestroy = $this->deleteJson($routeDestroy);
        $responseDestroy->assertStatus(401);
    }

    public function test_users_can_get_a_single_abort_type(): void
    {
        $abortType = AbortType::factory()->create();

        $route = route('abort-types.show', $abortType);

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'code' => $abortType->code,
            'name' => $abortType->name
        ]);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'code',
                'name',
            ]
        ]);
    }

    public function test_users_can_create_a_new_abort_type(): void
    {
        $payload = [
            'code' => 'A1',
            'name' => 'Abort One'
        ];

        $route = route('abort-types.store');

        $response = $this->actingAs($this->user)
             ->postJson($route, $payload);

        $response->assertStatus(201);

        $this->assertDatabaseHas('abort_types', [
            'code' => 'A1'
        ]);
    }

    public function test_users_can_update_an_abort_type(): void
    {
        $abortType = AbortType::factory()->create();

        $payload = [
            'code' => 'A2',
            'name' => 'Abort Two'
        ];

        $route = route('abort-types.update', $abortType);

        $response = $this->actingAs($this->user)
            ->putJson($route, $payload);

        $response->assertStatus(200);

        $this->assertDatabaseHas('abort_types', [
            'code' => 'A2'
        ]);
    }

    public function test_users_can_delete_an_abort_type(): void
    {
        $abortType = AbortType::factory()->create();

        $route = route('abort-types.destroy', $abortType);

        $response = $this->actingAs($this->user)
            ->deleteJson($route);

        $response->assertStatus(204);

        $this->assertSoftDeleted($abortType);
    }

    public function test_users_cannot_get_a_soft_deleted_abortType(): void
    {
        $abortType = AbortType::factory()->create();

        $abortType->delete();

        $route = route('abort-types.show', $abortType);

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(404);
    }
}

