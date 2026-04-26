<?php

namespace Tests\Feature\LookUp;

use App\Models\ProductMovementType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductMovementTypeTest extends TestCase
{

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_users_can_get_a_list_of_product_movement_types(): void
    {

        ProductMovementType::factory(3)->create();

        $route = route('product-movement-types.index');

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

    public function test_unauthenticated_users_cannot_access_product_movement_types_endpoints(): void
    {
        $productMovementType = ProductMovementType::factory()->create();

        $routeIndex = route('product-movement-types.index');
        $responseIndex = $this->getJson($routeIndex);
        $responseIndex->assertStatus(401);

        $routeShow = route('product-movement-types.show', $productMovementType);
        $responseShow = $this->getJson($routeShow);
        $responseShow->assertStatus(401);

        $storePayload = [
            'code' => 'sh',
            'name' => 'showTest'
        ];
        $routeStore = route('product-movement-types.store');
        $responseStore = $this->postJson($routeStore, $storePayload);
        $responseStore->assertStatus(401);
        $this->assertDatabaseMissing('product_movement_types', [
            'code' => 'sh'
        ]);


        $updatePayload = [
            'name' => 'test'
        ];
        $routeUpdate = route('product-movement-types.update', $productMovementType);
        $responseUpdate = $this->putJson($routeUpdate, $updatePayload);
        $responseUpdate->assertStatus(401);

        $routeDestroy = route('product-movement-types.destroy', $productMovementType);
        $responseDestroy = $this->deleteJson($routeDestroy);
        $responseDestroy->assertStatus(401);
        $this->assertDatabaseMissing('product_movement_types', [
            'name' => 'test'
        ]);
    }

    public function test_users_can_get_a_single_productMovementType(): void
    {
        $productMovementType = ProductMovementType::factory()->create();

        $route = route('product-movement-types.show', $productMovementType);

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'code' => $productMovementType->code,
            'name' => $productMovementType->name
        ]);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'code',
                'name',
            ]
        ]);
    }

    public function test_users_can_create_a_new_productMovementType(): void
    {
        $payload = [
            'code' => 'HO',
            'name' => 'Holstein'
        ];

        $route = route('product-movement-types.store');

        $response = $this->actingAs($this->user)
             ->postJson($route,$payload);

        $response->assertStatus(201);

        $this->assertDatabaseHas('product_movement_types', [
            'code' => 'HO'
        ]);
    }

    public function test_users_cannot_create_a_new_productMovementType_with_missing_parameters(): void
    {
        $payload = [
            'name' => 'Holstein'
        ];

        $route = route('product-movement-types.store');

        $response = $this->actingAs($this->user)
             ->postJson($route,$payload);

        $response->assertStatus(422);

        $this->assertDatabaseMissing('product_movement_types', [
            'name' => 'Holstein'
        ]);
    }

    public function test_users_cannot_create_a_productMovementType_with_a_duplicated_code(): void
    {
        $productMovementType = ProductMovementType::factory()->create();

        $payload = [
            'code' => $productMovementType->code,
            'name' => 'Modificado'
        ];

        $route = route('product-movement-types.store');

        $response = $this->actingAs($this->user)
            ->postJson($route, $payload);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(['code']);
    }

    public function test_users_can_update_a_productMovementType(): void
    {
        $productMovementType = ProductMovementType::factory()->create();

        $payload = [
            'code' => 'WG',
            'name' => 'Wagyu'
        ];

        $route = route('product-movement-types.update', $productMovementType);

        $response = $this->actingAs($this->user)
            ->putJson($route, $payload);

        $response->assertStatus(200);

        $this->assertDatabaseHas('product_movement_types', [
            'code' => 'WG'
        ]);
    }

    public function test_users_cannot_update_a_productMovementType_with_missing_parameters(): void
    {
        $productMovementType = ProductMovementType::factory()->create();

        $payload = [];

        $route = route('product-movement-types.update', $productMovementType);

        $response = $this->actingAs($this->user)
            ->putJson($route, $payload);

        $response->assertStatus(422);

        $this->assertDatabaseHas($productMovementType);
    }

    public function test_users_can_delete_a_productMovementType(): void
    {
        $productMovementType = ProductMovementType::factory()->create([
            'code' => 'AN',
            'name' => 'Angus'
        ]);

        $route = route('product-movement-types.destroy', $productMovementType);

        $response = $this->actingAs($this->user)
            ->deleteJson($route);

        $response->assertStatus(204);

        $this->assertSoftDeleted($productMovementType);
    }

    public function test_users_cannot_get_a_soft_deleted_productMovementType(): void
    {
        $productMovementType = ProductMovementType::factory()->create();

        $productMovementType->delete();

        $route = route('product-movement-types.show', $productMovementType);

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(404);
    }

}
