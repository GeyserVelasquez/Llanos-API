<?php

namespace LookUp;

use App\Models\ServiceType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceTypeTest extends TestCase
{

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_users_can_get_a_list_of_service_types(): void
    {

        ServiceType::factory(3)->create();

        $route = route('service-types.index');

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

    public function test_unauthenticated_users_cannot_access_service_types_endpoints(): void
    {
        $serviceType = ServiceType::factory()->create();

        $routeIndex = route('service-types.index');
        $responseIndex = $this->getJson($routeIndex);
        $responseIndex->assertStatus(401);

        $routeShow = route('service-types.show', $serviceType);
        $responseShow = $this->getJson($routeShow);
        $responseShow->assertStatus(401);

        $storePayload = [
            'code' => 'sh',
            'name' => 'showTest'
        ];
        $routeStore = route('service-types.store');
        $responseStore = $this->postJson($routeStore, $storePayload);
        $responseStore->assertStatus(401);
        $this->assertDatabaseMissing('service_types', [
            'code' => 'sh'
        ]);


        $updatePayload = [
            'name' => 'test'
        ];
        $routeUpdate = route('service-types.update', $serviceType);
        $responseUpdate = $this->putJson($routeUpdate, $updatePayload);
        $responseUpdate->assertStatus(401);

        $routeDestroy = route('service-types.destroy', $serviceType);
        $responseDestroy = $this->deleteJson($routeDestroy);
        $responseDestroy->assertStatus(401);
        $this->assertDatabaseMissing('service_types', [
            'name' => 'test'
        ]);
    }

    public function test_users_can_get_a_single_service_type(): void
    {
        $serviceType = ServiceType::factory()->create();

        $route = route('service-types.show', $serviceType);

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'code' => $serviceType->code,
            'name' => $serviceType->name
        ]);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'code',
                'name',
            ]
        ]);
    }

    public function test_users_can_create_a_new_service_type(): void
    {
        $payload = [
            'code' => 'HO',
            'name' => 'Holstein'
        ];

        $route = route('service-types.store');

        $response = $this->actingAs($this->user)
             ->postJson($route,$payload);

        $response->assertStatus(201);

        $this->assertDatabaseHas('service_types', [
            'code' => 'HO'
        ]);
    }

    public function test_users_cannot_create_a_new_service_type_with_missing_parameters(): void
    {
        $payload = [
            'name' => 'Holstein'
        ];

        $route = route('service-types.store');

        $response = $this->actingAs($this->user)
             ->postJson($route,$payload);

        $response->assertStatus(422);

        $this->assertDatabaseMissing('service_types', [
            'name' => 'Holstein'
        ]);
    }

    public function test_users_cannot_create_a_service_type_with_a_duplicated_code(): void
    {
        $serviceType = ServiceType::factory()->create();

        $payload = [
            'code' => $serviceType->code,
            'name' => 'Modified'
        ];

        $route = route('service-types.store');

        $response = $this->actingAs($this->user)
            ->postJson($route, $payload);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(['code']);
    }

    public function test_users_can_update_a_service_type(): void
    {
        $serviceType = ServiceType::factory()->create();

        $payload = [
            'code' => 'WG',
            'name' => 'Wagyu'
        ];

        $route = route('service-types.update', $serviceType);

        $response = $this->actingAs($this->user)
            ->putJson($route, $payload);

        $response->assertStatus(200);

        $this->assertDatabaseHas('service_types', [
            'code' => 'WG'
        ]);
    }

    public function test_users_cannot_update_a_service_type_with_missing_parameters(): void
    {
        $serviceType = ServiceType::factory()->create();

        $payload = [];

        $route = route('service-types.update', $serviceType);

        $response = $this->actingAs($this->user)
            ->putJson($route, $payload);

        $response->assertStatus(422);

        $this->assertDatabaseHas('service_types', [
            'id' => $serviceType->id,
            'code' => $serviceType->code,
            'name' => $serviceType->name
        ]);
    }

    public function test_users_can_delete_a_service_type(): void
    {
        $serviceType = ServiceType::factory()->create([
            'code' => 'AN',
            'name' => 'Angus'
        ]);

        $route = route('service-types.destroy', $serviceType);

        $response = $this->actingAs($this->user)
            ->deleteJson($route);

        $response->assertStatus(204);

        $this->assertSoftDeleted($serviceType);
    }

    public function test_users_cannot_get_a_soft_deleted_service_type(): void
    {
        $serviceType = ServiceType::factory()->create();

        $serviceType->delete();

        $route = route('service-types.show', $serviceType);

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(404);
    }

}
