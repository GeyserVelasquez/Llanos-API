<?php

namespace Tests\Feature\LookUp;

use App\Models\ExtractionType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExtractionTypeTest extends TestCase
{

    public function test_users_can_get_a_list_of_extraction_types(): void
    {

        ExtractionType::factory(3)->create();

        $route = route('extraction-types.index');

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

    public function test_unauthenticated_users_cannot_access_extraction_types_endpoints(): void
    {
        $extractionType = ExtractionType::factory()->create();

        $routeIndex = route('extraction-types.index');
        $responseIndex = $this->getJson($routeIndex);
        $responseIndex->assertStatus(401);

        $routeShow = route('extraction-types.show', $extractionType);
        $responseShow = $this->getJson($routeShow);
        $responseShow->assertStatus(401);

        $storePayload = [
            'code' => 'sh',
            'name' => 'showTest'
        ];
        $routeStore = route('extraction-types.store');
        $responseStore = $this->postJson($routeStore, $storePayload);
        $responseStore->assertStatus(401);
        $this->assertDatabaseMissing('extraction_types', [
            'code' => 'sh'
        ]);


        $updatePayload = [
            'name' => 'test'
        ];
        $routeUpdate = route('extraction-types.update', $extractionType);
        $responseUpdate = $this->putJson($routeUpdate, $updatePayload);
        $responseUpdate->assertStatus(401);

        $routeDestroy = route('extraction-types.destroy', $extractionType);
        $responseDestroy = $this->deleteJson($routeDestroy);
        $responseDestroy->assertStatus(401);
        $this->assertDatabaseMissing('extraction_types', [
            'name' => 'test'
        ]);
    }

    public function test_users_can_get_a_single_extractionType(): void
    {
        $extractionType = ExtractionType::factory()->create();

        $route = route('extraction-types.show', $extractionType);

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'code' => $extractionType->code,
            'name' => $extractionType->name
        ]);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'code',
                'name',
            ]
        ]);
    }

    public function test_users_can_create_a_new_extractionType(): void
    {
        $payload = [
            'code' => 'HO',
            'name' => 'Holstein'
        ];

        $route = route('extraction-types.store');

        $response = $this->actingAs($this->user)
             ->postJson($route,$payload);

        $response->assertStatus(201);

        $this->assertDatabaseHas('extraction_types', [
            'code' => 'HO'
        ]);
    }

    public function test_users_cannot_create_a_new_extractionType_with_missing_parameters(): void
    {
        $payload = [
            'name' => 'Holstein'
        ];

        $route = route('extraction-types.store');

        $response = $this->actingAs($this->user)
             ->postJson($route,$payload);

        $response->assertStatus(422);

        $this->assertDatabaseMissing('extraction_types', [
            'name' => 'Holstein'
        ]);
    }

    public function test_users_cannot_create_a_extractionType_with_a_duplicated_code(): void
    {
        $extractionType = ExtractionType::factory()->create();

        $payload = [
            'code' => $extractionType->code,
            'name' => 'Modificado'
        ];

        $route = route('extraction-types.store');

        $response = $this->actingAs($this->user)
            ->postJson($route, $payload);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(['code']);
    }

    public function test_users_can_update_a_extractionType(): void
    {
        $extractionType = ExtractionType::factory()->create();

        $payload = [
            'code' => 'WG',
            'name' => 'Wagyu'
        ];

        $route = route('extraction-types.update', $extractionType);

        $response = $this->actingAs($this->user)
            ->putJson($route, $payload);

        $response->assertStatus(200);

        $this->assertDatabaseHas('extraction_types', [
            'code' => 'WG'
        ]);
    }

    public function test_users_cannot_update_a_extractionType_with_missing_parameters(): void
    {
        $extractionType = ExtractionType::factory()->create();

        $payload = [];

        $route = route('extraction-types.update', $extractionType);

        $response = $this->actingAs($this->user)
            ->putJson($route, $payload);

        $response->assertStatus(422);

        $this->assertDatabaseHas($extractionType);
    }

    public function test_users_can_delete_a_extractionType(): void
    {
        $extractionType = ExtractionType::factory()->create([
            'code' => 'AN',
            'name' => 'Angus'
        ]);

        $route = route('extraction-types.destroy', $extractionType);

        $response = $this->actingAs($this->user)
            ->deleteJson($route);

        $response->assertStatus(204);

        $this->assertSoftDeleted($extractionType);
    }

    public function test_users_cannot_get_a_soft_deleted_extractionType(): void
    {
        $extractionType = ExtractionType::factory()->create();

        $extractionType->delete();

        $route = route('extraction-types.show', $extractionType);

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(404);
    }

}
