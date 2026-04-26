<?php

namespace Tests\Feature\LookUp;

use App\Models\Classification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClassificationTest extends TestCase
{

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_users_can_get_a_list_of_classifications(): void
    {

        Classification::factory(3)->create();

        $route = route('classifications.index');

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

    public function test_unauthenticated_users_cannot_access_classifications_endpoints(): void
    {
        $classification = Classification::factory()->create();

        $routeIndex = route('classifications.index');
        $responseIndex = $this->getJson($routeIndex);
        $responseIndex->assertStatus(401);

        $routeShow = route('classifications.show', $classification);
        $responseShow = $this->getJson($routeShow);
        $responseShow->assertStatus(401);

        $storePayload = [
            'code' => 'sh',
            'name' => 'showTest'
        ];
        $routeStore = route('classifications.store');
        $responseStore = $this->postJson($routeStore, $storePayload);
        $responseStore->assertStatus(401);
        $this->assertDatabaseMissing('classifications', [
            'code' => 'sh'
        ]);


        $updatePayload = [
            'name' => 'test'
        ];
        $routeUpdate = route('classifications.update', $classification);
        $responseUpdate = $this->putJson($routeUpdate, $updatePayload);
        $responseUpdate->assertStatus(401);

        $routeDestroy = route('classifications.destroy', $classification);
        $responseDestroy = $this->deleteJson($routeDestroy);
        $responseDestroy->assertStatus(401);
        $this->assertDatabaseMissing('classifications', [
            'name' => 'test'
        ]);
    }

    public function test_users_can_get_a_single_classification(): void
    {
        $classification = Classification::factory()->create();

        $route = route('classifications.show', $classification);

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'code' => $classification->code,
            'name' => $classification->name
        ]);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'code',
                'name',
            ]
        ]);
    }

    public function test_users_can_create_a_new_classification(): void
    {
        $payload = [
            'code' => 'HO',
            'name' => 'Holstein'
        ];

        $route = route('classifications.store');

        $response = $this->actingAs($this->user)
             ->postJson($route,$payload);

        $response->assertStatus(201);

        $this->assertDatabaseHas('classifications', [
            'code' => 'HO'
        ]);
    }

    public function test_users_cannot_create_a_new_classification_with_missing_parameters(): void
    {
        $payload = [
            'name' => 'Holstein'
        ];

        $route = route('classifications.store');

        $response = $this->actingAs($this->user)
             ->postJson($route,$payload);

        $response->assertStatus(422);

        $this->assertDatabaseMissing('classifications', [
            'name' => 'Holstein'
        ]);
    }

    public function test_users_cannot_create_a_classification_with_a_duplicated_code(): void
    {
        $classification = Classification::factory()->create();

        $payload = [
            'code' => $classification->code,
            'name' => 'Modificado'
        ];

        $route = route('classifications.store');

        $response = $this->actingAs($this->user)
            ->postJson($route, $payload);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(['code']);
    }

    public function test_users_can_update_a_classification(): void
    {
        $classification = Classification::factory()->create();

        $payload = [
            'code' => 'WG',
            'name' => 'Wagyu'
        ];

        $route = route('classifications.update', $classification);

        $response = $this->actingAs($this->user)
            ->putJson($route, $payload);

        $response->assertStatus(200);

        $this->assertDatabaseHas('classifications', [
            'code' => 'WG'
        ]);
    }

    public function test_users_cannot_update_a_classification_with_missing_parameters(): void
    {
        $classification = Classification::factory()->create();

        $payload = [];

        $route = route('classifications.update', $classification);

        $response = $this->actingAs($this->user)
            ->putJson($route, $payload);

        $response->assertStatus(422);

        $this->assertDatabaseHas($classification);
    }

    public function test_users_can_delete_a_classification(): void
    {
        $classification = Classification::factory()->create([
            'code' => 'AN',
            'name' => 'Angus'
        ]);

        $route = route('classifications.destroy', $classification);

        $response = $this->actingAs($this->user)
            ->deleteJson($route);

        $response->assertStatus(204);

        $this->assertSoftDeleted($classification);
    }

    public function test_users_cannot_get_a_soft_deleted_classification(): void
    {
        $classification = Classification::factory()->create();

        $classification->delete();

        $route = route('classifications.show', $classification);

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(404);
    }

}
