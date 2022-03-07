<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Entry;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EntryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_entries_list()
    {
        $entries = Entry::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.entries.index'));

        $response->assertOk()->assertSee($entries[0]->label);
    }

    /**
     * @test
     */
    public function it_stores_the_entry()
    {
        $data = Entry::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.entries.store'), $data);

        $this->assertDatabaseHas('entries', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_entry()
    {
        $entry = Entry::factory()->create();

        $data = [
            'label' => $this->faker->word,
            'date' => $this->faker->date,
            'text' => $this->faker->text,
            'uuid' => $this->faker->uuid,
            'file' => $this->faker->text(255),
            'datetime' => $this->faker->dateTime,
            'bool' => $this->faker->boolean,
            'number' => $this->faker->randomNumber(2),
            'json' => [],
        ];

        $response = $this->putJson(route('api.entries.update', $entry), $data);

        $data['id'] = $entry->id;

        $this->assertDatabaseHas('entries', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_entry()
    {
        $entry = Entry::factory()->create();

        $response = $this->deleteJson(route('api.entries.destroy', $entry));

        $this->assertModelMissing($entry);

        $response->assertNoContent();
    }
}
