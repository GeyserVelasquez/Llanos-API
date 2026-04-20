<?php

namespace LookUp;

use App\Models\EntryCause;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EntryCauseTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_users_can_get_a_list_of_entry_causes(): void
    {

        EntryCause::factory(3)->create();

        $route = route('entry-causes.index');

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

    public function test_unauthenticated_users_cannot_access_entry_causes_endpoints(): void
    {
        $entryCause = EntryCause::factory()->create();

        $routeIndex = route('entry-causes.index');
        $responseIndex = $this->getJson($routeIndex);
        $responseIndex->assertStatus(401);

        $routeShow = route('entry-causes.show', $entryCause);
        $responseShow = $this->getJson($routeShow);
        $responseShow->assertStatus(401);

        $storePayload = [
            'code' => 'sh',
            'name' => 'showTest'
        ];
        $routeStore = route('entry-causes.store');
        $responseStore = $this->postJson($routeStore, $storePayload);
        $responseStore->assertStatus(401);
        $this->assertDatabaseMissing('entry_causes', [
            'code' => 'sh'
        ]);


        $updatePayload = [
            'name' => 'test'
        ];
        $routeUpdate = route('entry-causes.update', $entryCause);
        $responseUpdate = $this->putJson($routeUpdate, $updatePayload);
        $responseUpdate->assertStatus(401);

        $routeDestroy = route('entry-causes.destroy', $entryCause);
        $responseDestroy = $this->deleteJson($routeDestroy);
        $responseDestroy->assertStatus(401);
        $this->assertDatabaseMissing('entry_causes', [
            'name' => 'test'
        ]);
    }

    public function test_users_can_get_a_single_entryCause(): void
    {
        $entryCause = EntryCause::factory()->create();

        $route = route('entry-causes.show', $entryCause);

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'code' => $entryCause->code,
            'name' => $entryCause->name
        ]);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'code',
                'name',
            ]
        ]);
    }

    public function test_users_can_create_a_new_entryCause(): void
    {
        $payload = [
            'code' => 'HO',
            'name' => 'Holstein'
        ];

        $route = route('entry-causes.store');

        $response = $this->actingAs($this->user)
             ->postJson($route,$payload);

        $response->assertStatus(201);

        $this->assertDatabaseHas('entry_causes', [
            'code' => 'HO'
        ]);
    }

    public function test_users_cannot_create_a_new_entryCause_with_missing_parameters(): void
    {
        $payload = [
            'name' => 'Holstein'
        ];

        $route = route('entry-causes.store');

        $response = $this->actingAs($this->user)
             ->postJson($route,$payload);

        $response->assertStatus(422);

        $this->assertDatabaseMissing('entry_causes', [
            'name' => 'Holstein'
        ]);
    }

    public function test_users_cannot_create_a_entryCause_with_a_duplicated_code(): void
    {
        $entryCause = EntryCause::factory()->create();

        $payload = [
            'code' => $entryCause->code,
            'name' => 'Modificado'
        ];

        $route = route('entry-causes.store');

        $response = $this->actingAs($this->user)
            ->postJson($route, $payload);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(['code']);
    }

    public function test_users_can_update_a_entryCause(): void
    {
        $entryCause = EntryCause::factory()->create();

        $payload = [
            'code' => 'WG',
            'name' => 'Wagyu'
        ];

        $route = route('entry-causes.update', $entryCause);

        $response = $this->actingAs($this->user)
            ->putJson($route, $payload);

        $response->assertStatus(200);

        $this->assertDatabaseHas('entry_causes', [
            'code' => 'WG'
        ]);
    }

    public function test_users_cannot_update_a_entryCause_with_missing_parameters(): void
    {
        $entryCause = EntryCause::factory()->create();

        $payload = [];

        $route = route('entry-causes.update', $entryCause);

        $response = $this->actingAs($this->user)
            ->putJson($route, $payload);

        $response->assertStatus(422);

        $this->assertDatabaseHas($entryCause);
    }

    public function test_users_can_delete_a_entryCause(): void
    {
        $entryCause = EntryCause::factory()->create([
            'code' => 'AN',
            'name' => 'Angus'
        ]);

        $route = route('entry-causes.destroy', $entryCause);

        $response = $this->actingAs($this->user)
            ->deleteJson($route);

        $response->assertStatus(204);

        $this->assertSoftDeleted($entryCause);
    }

    public function test_users_cannot_get_a_soft_deleted_entryCause(): void
    {
        $entryCause = EntryCause::factory()->create();

        $entryCause->delete();

        $route = route('entry-causes.show', $entryCause);

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(404);
    }

}
