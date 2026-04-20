<?php

namespace LookUp;

use App\Models\AnimalCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnimalCategoryTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_users_can_get_a_list_of_animal_categories(): void
    {

        AnimalCategory::factory(3)->create();

        $route = route('animal-categories.index');

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

    public function test_unauthenticated_users_cannot_access_animal_categories_endpoints(): void
    {
        $animalCategory = AnimalCategory::factory()->create();

        $routeIndex = route('animal-categories.index');
        $responseIndex = $this->getJson($routeIndex);
        $responseIndex->assertStatus(401);

        $routeShow = route('animal-categories.show', $animalCategory);
        $responseShow = $this->getJson($routeShow);
        $responseShow->assertStatus(401);

        $storePayload = [
            'code' => 'sh',
            'name' => 'showTest'
        ];
        $routeStore = route('animal-categories.store');
        $responseStore = $this->postJson($routeStore, $storePayload);
        $responseStore->assertStatus(401);

        $updatePayload = [
            'name' => 'test'
        ];
        $routeUpdate = route('animal-categories.update', $animalCategory);
        $responseUpdate = $this->putJson($routeUpdate, $updatePayload);
        $responseUpdate->assertStatus(401);

        $routeDestroy = route('animal-categories.destroy', $animalCategory);
        $responseDestroy = $this->deleteJson($routeDestroy);
        $responseDestroy->assertStatus(401);
    }

    public function test_users_can_get_a_single_animal_category(): void
    {
        $animalCategory = AnimalCategory::factory()->create();

        $route = route('animal-categories.show', $animalCategory);

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'code' => $animalCategory->code,
            'name' => $animalCategory->name
        ]);
    }

    public function test_users_can_create_a_new_animal_category(): void
    {
        $payload = [
            'code' => 'HO',
            'name' => 'Holstein'
        ];

        $route = route('animal-categories.store');

        $response = $this->actingAs($this->user)
             ->postJson($route,$payload);

        $response->assertStatus(201);

        $this->assertDatabaseHas('animal_categories', [
            'code' => 'HO'
        ]);
    }

    public function test_users_cannot_create_a_new_animal_category_with_missing_parameters(): void
    {
        $payload = [
            'name' => 'Holstein'
        ];

        $route = route('animal-categories.store');

        $response = $this->actingAs($this->user)
             ->postJson($route,$payload);

        $response->assertStatus(422);
    }

    public function test_users_cannot_create_a_animal_category_with_a_duplicated_code(): void
    {
        $animalCategory = AnimalCategory::factory()->create();

        $payload = [
            'code' => $animalCategory->code,
            'name' => 'Modified'
        ];

        $route = route('animal-categories.store');

        $response = $this->actingAs($this->user)
            ->postJson($route, $payload);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(['code']);
    }

    public function test_users_can_update_a_animal_category(): void
    {
        $animalCategory = AnimalCategory::factory()->create();

        $payload = [
            'code' => 'WG',
            'name' => 'Wagyu'
        ];

        $route = route('animal-categories.update', $animalCategory);

        $response = $this->actingAs($this->user)
            ->putJson($route, $payload);

        $response->assertStatus(200);

        $this->assertDatabaseHas('animal_categories', [
            'code' => 'WG'
        ]);
    }

    public function test_users_can_delete_a_animal_category(): void
    {
        $animalCategory = AnimalCategory::factory()->create();

        $route = route('animal-categories.destroy', $animalCategory);

        $response = $this->actingAs($this->user)
            ->deleteJson($route);

        $response->assertStatus(204);

        $this->assertSoftDeleted($animalCategory);
    }
}
