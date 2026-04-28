<?php

namespace Tests\Feature\LookUp;

use App\Models\Breed;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BreedTest extends TestCase
{

    public function test_users_can_get_a_list_of_breeds(): void
    {

        $breeds = Breed::factory(3)->create();

        $route = route('breeds.index');

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(200);

        $response->assertJsonCount(3, 'data');

        $response->assertJsonFragment([
            'code' => $breeds->first()->code,
            'name' => $breeds->first()->name,
        ]);

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

    public function test_unauthenticated_users_cannot_access_breeds_endpoints(): void
    {
        $breed = Breed::factory()->create();

        $routeIndex = route('breeds.index');
        $responseIndex = $this->getJson($routeIndex);
        $responseIndex->assertStatus(401);

        $routeShow = route('breeds.show', $breed);
        $responseShow = $this->getJson($routeShow);
        $responseShow->assertStatus(401);

        $storePayload = [
            'code' => 'sh',
            'name' => 'showTest'
        ];
        $routeStore = route('breeds.store');
        $responseStore = $this->postJson($routeStore, $storePayload);
        $responseStore->assertStatus(401);
        $this->assertDatabaseMissing('breeds', [
            'code' => 'sh'
        ]);


        $updatePayload = [
            'name' => 'test'
        ];
        $routeUpdate = route('breeds.update', $breed);
        $responseUpdate = $this->putJson($routeUpdate, $updatePayload);
        $responseUpdate->assertStatus(401);

        $routeDestroy = route('breeds.destroy', $breed);
        $responseDestroy = $this->deleteJson($routeDestroy);
        $responseDestroy->assertStatus(401);
        $this->assertDatabaseMissing('breeds', [
            'name' => 'test'
        ]);
    }

    public function test_users_can_get_a_single_breed(): void
    {
        $breed = Breed::factory()->create();

        $route = route('breeds.show', $breed);

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'code' => $breed->code,
            'name' => $breed->name
        ]);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'code',
                'name',
            ]
        ]);
    }

    public function test_users_can_create_a_new_breed(): void
    {
        $payload = [
            'code' => 'HO',
            'name' => 'Holstein'
        ];

        $route = route('breeds.store');

        $response = $this->actingAs($this->user)
             ->postJson($route,$payload);

        $response->assertStatus(201);

        $this->assertDatabaseHas('breeds', [
            'code' => $payload['code']
        ]);
    }

    public function test_users_cannot_create_a_new_breed_with_missing_parameters(): void
    {
        $payload = [
            'name' => 'Holstein'
        ];

        $route = route('breeds.store');

        $response = $this->actingAs($this->user)
             ->postJson($route,$payload);

        $response->assertStatus(422);

        $this->assertDatabaseMissing('breeds', [
            'name' => 'Holstein'
        ]);
    }

    public function test_users_cannot_create_a_breed_with_a_duplicated_code(): void
    {
        $breed = Breed::factory()->create();

        $payload = [
            'code' => $breed->code,
            'name' => 'Brahman Modificado'
        ];

        $route = route('breeds.store');

        $response = $this->actingAs($this->user)
            ->postJson($route, $payload);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(['code']);
    }

    public function test_users_can_update_a_breed(): void
    {
        $breed = Breed::factory()->create();

        $payload = [
            'code' => 'WG',
            'name' => 'Wagyu'
        ];

        $route = route('breeds.update', $breed);

        $response = $this->actingAs($this->user)
            ->putJson($route, $payload);

        $response->assertStatus(200);

        $this->assertDatabaseHas('breeds', [
            'code' => 'WG'
        ]);
    }

    public function test_users_cannot_update_a_breed_with_missing_parameters(): void
    {
        $breed = Breed::factory()->create();

        $payload = [];

        $route = route('breeds.update', $breed);

        $response = $this->actingAs($this->user)
            ->putJson($route, $payload);

        $response->assertStatus(422);

        $this->assertDatabaseHas($breed);
    }

    public function test_users_can_delete_a_breed(): void
    {
        $breed = Breed::factory()->create([
            'code' => 'AN',
            'name' => 'Angus'
        ]);

        $route = route('breeds.destroy', $breed);

        $response = $this->actingAs($this->user)
            ->deleteJson($route);

        $response->assertStatus(204);

        $this->assertSoftDeleted($breed);
    }

    public function test_users_cannot_get_a_soft_deleted_breed(): void
    {
        $breed = Breed::factory()->create();

        $breed->delete();

        $route = route('breeds.show', $breed);

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(404);
    }

}
