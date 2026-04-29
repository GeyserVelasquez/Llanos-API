<?php

namespace Tests\Feature;

use App\Models\Image;
use Tests\TestCase;

class ImageTest extends TestCase
{
    public function test_users_can_get_a_list_of_images(): void
    {
        Image::factory(3)->create();

        $route = route('images.index');

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(200);

        $response->assertJsonCount(3, 'data');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'path',
                    'description',
                    'livestock_id',
                ]
            ]
        ]);
    }

    public function test_users_can_get_a_single_image(): void
    {
        $image = Image::factory()->create();

        $route = route('images.show', $image);

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'name' => $image->name,
            'path' => $image->path,
            'description' => $image->description,
            'livestock_id' => $image->livestock_id,
        ]);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'path',
                'description',
                'livestock_id',
            ]
        ]);
    }

    public function test_users_can_create_a_new_image(): void
    {
        $payload = Image::factory()->raw();

        $route = route('images.store');

        $response = $this->actingAs($this->user)
            ->postJson($route, $payload);

        $response->assertStatus(201);

        $this->assertDatabaseHas('images', [
            'name' => $payload['name'],
            'path' => $payload['path'],
            'livestock_id' => $payload['livestock_id'],
        ]);
    }

    public function test_users_cannot_create_a_new_image_with_missing_parameters(): void
    {
        $payload = ['name' => 'Test Image'];

        $route = route('images.store');

        $response = $this->actingAs($this->user)
            ->postJson($route, $payload);

        $response->assertStatus(422);
    }

    public function test_users_can_update_an_image(): void
    {
        $image = Image::factory()->create();

        $payload = ['name' => 'Updated Name'];

        $route = route('images.update', $image);

        $response = $this->actingAs($this->user)
            ->putJson($route, $payload);

        $response->assertStatus(200);

        $this->assertDatabaseHas('images', [
            'id' => $image->id,
            'name' => 'Updated Name'
        ]);
    }

    public function test_users_can_delete_an_image(): void
    {
        $image = Image::factory()->create();

        $route = route('images.destroy', $image);

        $response = $this->actingAs($this->user)
            ->deleteJson($route);

        $response->assertStatus(204);

        $this->assertSoftDeleted($image);
    }

    public function test_users_cannot_get_a_soft_deleted_image(): void
    {
        $image = Image::factory()->create();

        $image->delete();

        $route = route('images.show', $image);

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(404);
    }
}
