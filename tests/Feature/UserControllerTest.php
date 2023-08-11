<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase; // Para resetear la base de datos antes de cada prueba

    /** @test */
    public function it_can_return_users_list()
    {
        // Autenticar un usuario para acceder a la ruta
        $user = User::factory()->create();
        $this->actingAs($user);

        // Realizar una solicitud HTTP GET a la ruta de índice de usuarios
        $response = $this->get(route('users.index'));

        // Asegurar que la respuesta sea exitosa (código 200)
        $response->assertOk();

        // Asegurar que la vista renderizada sea la correcta
        $response->assertViewIs('components.users.user');
    }

    /** @test */
    public function it_can_show_user_details()
    {
        // Crea un usuario de prueba en la base de datos
        $user = User::factory()->create();

        // Autenticar un usuario para acceder a la ruta
        $authenticatedUser = User::factory()->create();
        $this->actingAs($authenticatedUser);

        // Realizar una solicitud HTTP GET a la ruta de detalles de usuario
        $response = $this->get(route('users.show', $user->id));

        // Asegurar que la respuesta sea exitosa (código 200)
        $response->assertOk();

        // Asegurar que el JSON retornado tenga la información correcta del usuario
        $response->assertJson(['user' => $user->toArray()]);
    }

    /** @test */
    public function it_can_update_user()
    {
        // Crea un usuario de prueba en la base de datos
        $user = User::factory()->create();

        // Autenticar un usuario para acceder a la ruta
        $this->actingAs($user);

        // Nuevos datos para actualizar el usuario
        $newData = ['name' => 'Updated Name', 'email' => 'updated@example.com'];

        // Realizar una solicitud HTTP PUT para actualizar el usuario
        $response = $this->put(route('users.update', $user->id), $newData);

        // Asegurar que la respuesta sea exitosa (código 200)
        $response->assertOk();

        // Asegurar que el JSON retornado tenga el mensaje correcto
        $response->assertJson(['message' => 'Usuario actualizado correctamente']);
    }

    /** @test */
    public function it_can_delete_user()
    {
        // Crea un usuario de prueba en la base de datos
        $user = User::factory()->create();

        // Autenticar un usuario para acceder a la ruta
        $this->actingAs($user);

        // Realizar una solicitud HTTP DELETE para eliminar el usuario
        $response = $this->delete(route('users.destroy', $user->id));

        // Asegurar que la respuesta sea exitosa (código 200)
        $response->assertOk();

        // Asegurar que el JSON retornado tenga el mensaje correcto
        $response->assertJson(['message' => 'Usuario eliminado correctamente']);
    }

}
