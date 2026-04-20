<?php

namespace LookUp;

use App\Models\Herd;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HerdTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_users_can_get_a_list_of_herds(): void
    {
        Herd::factory(3)->create();

        $route = route('herds.index');

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

    public function test_unauthenticated_users_cannot_access_herds_endpoints(): void
    {
        $herd = Herd::factory()->create();

        $routeIndex = route('herds.index');
        $responseIndex = $this->getJson($routeIndex);
        $responseIndex->assertStatus(401);

        $routeShow = route('herds.show', $herd);
        $responseShow = $this->getJson($routeShow);
        $responseShow->assertStatus(401);

        $storePayload = [
            'code' => 'sh',
            'name' => 'showTest'
        ];
        $routeStore = route('herds.store');
        $responseStore = $this->postJson($routeStore, $storePayload);
        $responseStore->assertStatus(401);

        $updatePayload = [
            'name' => 'test'
        ];
        $routeUpdate = route('herds.update', $herd);
        $responseUpdate = $this->putJson($routeUpdate, $updatePayload);
        $responseUpdate->assertStatus(401);

        $routeDestroy = route('herds.destroy', $herd);
        $responseDestroy = $this->deleteJson($routeDestroy);
        $responseDestroy->assertStatus(401);
    }

    public function test_users_can_get_a_single_herd(): void
    {
        $herd = Herd::factory()->create();

        $route = route('herds.show', $herd);

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'code' => $herd->code,
            'name' => $herd->name
        ]);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'code',
                'name',
            ]
        ]);
    }

    public function test_users_can_create_a_new_herd(): void
    {
        $payload = [
            'code' => 'H1',
            'name' => 'Herd One'
        ];

        $route = route('herds.store');

        $response = $this->actingAs($this->user)
             ->postJson($route, $payload);

        $response->assertStatus(201);

        $this->assertDatabaseHas('herds', [
            'code' => 'H1'
        ]);
    }

    public function test_users_cannot_create_a_new_herd_with_missing_parameters(): void
    {
        // For herds, code and name are required in the migration but sometimes in StoreHerdRequest.
        // Actually StoreBreedRequest says 'sometimes', 'required'.
        // If I send empty payload, it should fail if they are required.
        $payload = [];

        $route = route('herds.store');

        $response = $this->actingAs($this->user)
             ->postJson($route, $payload);

        // Based on BreedController:
        // $data = $request->validate([
        //     'code' => ['required', Rule::unique('breeds')],
        //     $data = $request->validated();
        // ]);
        // Wait, BreedController.php store method uses manual validation instead of the request for 'code' and 'name'?
        // Let me check BreedController again.

        $response->assertStatus(422);
    }

    public function test_users_can_update_a_herd(): void
    {
        $herd = Herd::factory()->create();

        $payload = [
            'code' => 'H2',
            'name' => 'Herd Two'
        ];

        $route = route('herds.update', $herd);

        $response = $this->actingAs($this->user)
            ->putJson($route, $payload);

        $response->assertStatus(200);

        $this->assertDatabaseHas('herds', [
            'code' => 'H2'
        ]);
    }

    public function test_users_can_delete_a_herd(): void
    {
        $herd = Herd::factory()->create();

        $route = route('herds.destroy', $herd);

        $response = $this->actingAs($this->user)
            ->deleteJson($route);

        $response->assertStatus(204);

        $this->assertSoftDeleted($herd);
    }

    public function test_users_cannot_get_a_soft_deleted_herd(): void
    {
        $herd = Herd::factory()->create();

        $herd->delete();

        $route = route('herds.show', $herd);

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(404);
    }
}