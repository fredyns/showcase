<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Entry;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EntryControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    protected function castToJson($json)
    {
        if (is_array($json)) {
            $json = addslashes(json_encode($json));
        } elseif (is_null($json) || is_null(json_decode($json))) {
            throw new \Exception(
                'A valid JSON string was not provided for casting.'
            );
        }

        return \DB::raw("CAST('{$json}' AS JSON)");
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_entries()
    {
        $entries = Entry::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('entries.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.entries.index')
            ->assertViewHas('entries');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_entry()
    {
        $response = $this->get(route('entries.create'));

        $response->assertOk()->assertViewIs('app.entries.create');
    }

    /**
     * @test
     */
    public function it_stores_the_entry()
    {
        $data = Entry::factory()
            ->make()
            ->toArray();

        $data['json'] = json_encode($data['json']);

        $response = $this->post(route('entries.store'), $data);

        $data['json'] = $this->castToJson($data['json']);

        $this->assertDatabaseHas('entries', $data);

        $entry = Entry::latest('id')->first();

        $response->assertRedirect(route('entries.edit', $entry));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_entry()
    {
        $entry = Entry::factory()->create();

        $response = $this->get(route('entries.show', $entry));

        $response
            ->assertOk()
            ->assertViewIs('app.entries.show')
            ->assertViewHas('entry');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_entry()
    {
        $entry = Entry::factory()->create();

        $response = $this->get(route('entries.edit', $entry));

        $response
            ->assertOk()
            ->assertViewIs('app.entries.edit')
            ->assertViewHas('entry');
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

        $data['json'] = json_encode($data['json']);

        $response = $this->put(route('entries.update', $entry), $data);

        $data['id'] = $entry->id;

        $data['json'] = $this->castToJson($data['json']);

        $this->assertDatabaseHas('entries', $data);

        $response->assertRedirect(route('entries.edit', $entry));
    }

    /**
     * @test
     */
    public function it_deletes_the_entry()
    {
        $entry = Entry::factory()->create();

        $response = $this->delete(route('entries.destroy', $entry));

        $response->assertRedirect(route('entries.index'));

        $this->assertModelMissing($entry);
    }
}
