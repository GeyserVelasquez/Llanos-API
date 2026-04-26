<?php

namespace Tests\Feature;

use App\Models\Batch;
use App\Models\BatchMovement;
use App\Models\Livestock;
use App\Models\User;
use Tests\TestCase;

class BatchMovementTest extends TestCase
{
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_users_can_get_a_list_of_batch_movements(): void
    {
        BatchMovement::factory(3)->create();

        $route = route('batch-movements.index');

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(200);

        $response->assertJsonCount(3, 'data');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'batch_id',
                    'livestock_id',
                    'made_at',
                    'attributes'
                ]
            ]
        ]);
    }

    public function test_users_can_get_a_single_batch_movement(): void
    {
        $batchMovement = BatchMovement::factory()->create();

        $route = route('batch-movements.show', $batchMovement);

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'batch_id' => $batchMovement->batch_id,
            'livestock_id' => $batchMovement->livestock_id,
            'made_at' => $batchMovement->made_at->format('Y-m-d'),
        ]);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'batch_id',
                'livestock_id',
                'made_at',
                'attributes'
            ]
        ]);
    }

    public function test_users_can_create_a_new_batch_movement(): void
    {
        $batch = Batch::factory()->create();
        $livestock = Livestock::factory()->create();

        $payload = [
            'batch_id' => $batch->id,
            'livestock_id' => $livestock->id,
            'made_at' => now()->format('Y-m-d'),
            'attributes' => ['reason' => 'test']
        ];

        $route = route('batch-movements.store');

        $response = $this->actingAs($this->user)
            ->postJson($route, $payload);

        $response->assertStatus(201);

        $this->assertDatabaseHas('batch_movements', [
            'batch_id' => $payload['batch_id'],
            'livestock_id' => $payload['livestock_id'],
        ]);
    }

    public function test_users_cannot_create_a_new_batch_movement_with_missing_parameters(): void
    {
        $payload = ['made_at' => now()->format('Y-m-d')];

        $route = route('batch-movements.store');

        $response = $this->actingAs($this->user)
            ->postJson($route, $payload);

        $response->assertStatus(422);
    }

    public function test_users_can_update_a_batch_movement(): void
    {
        $batchMovement = BatchMovement::factory()->create();
        $newBatch = Batch::factory()->create();

        $payload = [
            'batch_id' => $newBatch->id,
        ];

        $route = route('batch-movements.update', $batchMovement);

        $response = $this->actingAs($this->user)
            ->putJson($route, $payload);

        $response->assertStatus(200);

        $this->assertDatabaseHas('batch_movements', [
            'id' => $batchMovement->id,
            'batch_id' => $newBatch->id
        ]);
    }

    public function test_users_can_delete_a_batch_movement(): void
    {
        $batchMovement = BatchMovement::factory()->create();

        $route = route('batch-movements.destroy', $batchMovement);

        $response = $this->actingAs($this->user)
            ->deleteJson($route);

        $response->assertStatus(204);

        $this->assertSoftDeleted($batchMovement);
    }

    public function test_users_cannot_get_a_soft_deleted_batch_movement(): void
    {
        $batchMovement = BatchMovement::factory()->create();

        $batchMovement->delete();

        $route = route('batch-movements.show', $batchMovement);

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(404);
    }
}
