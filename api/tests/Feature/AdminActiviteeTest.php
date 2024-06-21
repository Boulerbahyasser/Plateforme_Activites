<?php

namespace Tests\Feature;

use App\Models\Activite;
use Carbon\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

use function PHPUnit\Framework\assertTrue;

class AdminActiviteeTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function testcreateActivity(): void
    {
        $formData = [
            'titre' => 'Programmation avec C++',
            'description' => 'Programmation orientee objet avec C++',
            'lien_youtube' => 'https://www.youtube.com/',
            'objectifs' => 'Comprendre les notions necessaires',
            'domaine' => 'Informatique',
            'IMAGE_PUB' => UploadedFile::fake()->image('test_image.jpg')
        ];

        $response = $this->postJson( 'api/create/activity', $formData);
        
        $response->assertStatus(201)
                 ->assertJson(['message' => 'the insertion was successful']);

        $this->assertDatabaseHas('activites', ['titre' => 'Programmation avec C++']);

        $this->assertTrue(
            Storage::disk('public')->exists('IMAGE_PUBs/'.$formData['IMAGE_PUB']->hashName())
        );
    }
    public function test_require(){
        $formData = [
            'lien_youtube' => 'https://www.youtube.com/',
            'objectifs' => 'Comprendre les notions necessaires',
        ];

        $response=$this->postJson('/api/create/activity/',$formData);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors('titre')
                 ->assertJsonValidationErrors('description')
                 ->assertJsonValidationErrors('domaine');

    }
    public function test_unique_titre(){
        Activite::create([
            'titre' => 'Programmation avec C++',
            'description' => 'Programmation procedurale avec C++',
            'lien_youtube' => 'https://www.youtube.com/',
            'objectifs' => 'Comprendre les notions necessaires',
            'domaine' => 'Informatique',
        ]);

        $formData = [
            'titre' => 'Programmation avec C++',
            'description' => 'Programmation orientee objet avec C++',
            'lien_youtube' => 'https://www.youtube2.com/',
            'objectifs' => 'Comprendre les notions necessaires de P.P',
            'domaine' => 'Embeded systems',
            ];
        $response=$this->postJson('/api/create/activity',$formData);
        $response->assertStatus(422)->assertJsonValidationErrors('titre');
    }

    public function testUpdateActivity(){
        $activity=Activite::create([
            'titre' => 'Programmation avec C++',
            'description' => 'P.O.O avec C++',
            'lien_youtube' => 'https://www.youtube.com/',
            'objectifs' => 'Comprendre les notions necessaires',
            'domaine' => 'Informatique',
        ]);
        $formData = [
            'titre' => 'Programmation avec Java',
            'description' => 'P.O.O avec Java',
            'lien_youtube' => 'https://www.youtube.com/',
            'objectifs' => 'Comprendre les notions necessaires',
            'domaine' => 'Informatique',
        ];

        $response = $this->putJson("api/update/activity/{$activity->id}", $formData);

        $response->assertStatus(200)
                 ->assertJson(['message'=>'the update was successful']);
        
        $this->assertDatabaseHas('activites',[
            'id'=>$activity->id,
            'titre' => 'Programmation avec Java']);
    }

    public function testDestroyActivity(): void
{

    $activity = Activite::create([
        'titre' => 'Programmation avec C++',
        'description' => 'P.O.O avec C++',
        'lien_youtube' => 'https://www.youtube.com/',
        'objectifs' => 'Comprendre les notions necessaires',
        'domaine' => 'Informatique',
    ]);

    // Envoyer une requete de suppression
    $response = $this->deleteJson("api/delete/activity/{$activity->id}");

    // Vérifier la réponse et la base de données
    $response->assertStatus(200)
             ->assertJson(['message' => 'the delete was successful']);
            
    // vérifier l'absence de l'objet supprimé
    $this->assertDatabaseMissing('activites', ['id' => $activity->id]);
}
}
 