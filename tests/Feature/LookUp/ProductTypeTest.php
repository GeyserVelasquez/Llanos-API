<?php

namespace LookUp;

use App\Models\ProductType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTypeTest extends TestCase
{

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_users_can_get_a_list_of_product_types(): void
    {

        ProductType::factory(3)->create();

        $route = route('product-types.index');

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

    public function test_unauthenticated_users_cannot_access_product_types_endpoints(): void
    {
        $productType = ProductType::factory()->create();

        $routeIndex = route('product-types.index');
        $responseIndex = $this->getJson($routeIndex);
        $responseIndex->assertStatus(401);

        $routeShow = route('product-types.show', $productType);
        $responseShow = $this->getJson($routeShow);
        $responseShow->assertStatus(401);

        $storePayload = [
            'code' => 'sh',
            'name' => 'showTest'
        ];
        $routeStore = route('product-types.store');
        $responseStore = $this->postJson($routeStore, $storePayload);
        $responseStore->assertStatus(401);

        $updatePayload = [
            'name' => 'test'
        ];
        $routeUpdate = route('product-types.update', $productType);
        $responseUpdate = $this->putJson($routeUpdate, $updatePayload);
        $responseUpdate->assertStatus(401);

        $routeDestroy = route('product-types.destroy', $productType);
        $responseDestroy = $this->deleteJson($routeDestroy);
        $responseDestroy->assertStatus(401);
    }

    public function test_users_can_get_a_single_product_type(): void
    {
        $productType = ProductType::factory()->create();

        $route = route('product-types.show', $productType);

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'code' => $productType->code,
            'name' => $productType->name
        ]);
    }

    public function test_users_can_create_a_new_product_type(): void
    {
        $payload = [
            'code' => 'HO',
            'name' => 'Holstein'
        ];

        $route = route('product-types.store');

        $response = $this->actingAs($this->user)
             ->postJson($route,$payload);

        $response->assertStatus(201);

        $this->assertDatabaseHas('product_types', [
            'code' => 'HO'
        ]);
    }

    public function test_users_cannot_create_a_new_product_type_with_missing_parameters(): void
    {
        $payload = [
            'name' => 'Holstein'
        ];

        $route = route('product-types.store');

        $response = $this->actingAs($this->user)
             ->postJson($route,$payload);

        $response->assertStatus(422);
    }

    public function test_users_cannot_create_a_product_type_with_a_duplicated_code(): void
    {
        $productType = ProductType::factory()->create();

        $payload = [
            'code' => $productType->code,
            'name' => 'Modified'
        ];

        $route = route('product-types.store');

        $response = $this->actingAs($this->user)
            ->postJson($route, $payload);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(['code']);
    }

    public function test_users_can_update_a_product_type(): void
    {
        $productType = ProductType::factory()->create();

        $payload = [
            'code' => 'WG',
            'name' => 'Wagyu'
        ];

        $route = route('product-types.update', $productType);

        $response = $this->actingAs($this->user)
            ->putJson($route, $payload);

        $response->assertStatus(200);

        $this->assertDatabaseHas('product_types', [
            'code' => 'WG'
        ]);
    }

    public function test_users_can_delete_a_product_type(): void
    {
        $productType = ProductType::factory()->create();

        $route = route('product-types.destroy', $productType);

        $response = $this->actingAs($this->user)
            ->deleteJson($route);

        $response->assertStatus(204);

        $this->assertSoftDeleted($productType);
    }

    public function test_users_cannot_get_a_soft_deleted_productType(): void
    {
        $productType = ProductType::factory()->create();

        $productType->delete();

        $route = route('product-types.show', $productType);

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(404);
    }
}
