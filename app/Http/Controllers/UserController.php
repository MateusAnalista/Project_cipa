<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Exception;

class UserController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    // Index - Listar
    public function index()
    {
        try {
            $response = $this->user->all();

            // Log::debug(print_r($response, true)); AQUI FICA MELHOR PARA DEBUGAR MEU CÓDIGO
            return $response;
        } catch (\Throwable $th) {
            return new Exception("Erro ao listar os dados!", 500);
        }
    }

    // Create - Criar
    public function store(UserStoreRequest $request)
    {
        try {
            $validated = $request->validated();
            
            return $this->user->create($validated);
        } catch (\Throwable $th) {
            return new Exception("Erro ao criar os dados!", 500);
        }
    }

    // Read - Ler
    public function show(int $id)
    {
        try {
            return $this->user->find($id);
        } catch (\Throwable $th) {
            return new Exception("Erro ao mostrar os dados!", 500);
        }
    }
    
    // Update - Atualizar
    public function update(UserUpdateRequest $request, int $id)
    {
        try {
            $validated = $request->validated();
            return $this->user->where("id", $id)->update($validated);
        } catch (\Throwable $th) {
            return new Exception("Erro ao atualizar os dados!", 500);
        }
    }

    // Delete - Deletar 
    public function destroy(int $id)
    {
        try {
            return $this->user->delete($id);
        } catch (\Throwable $th) {
            return new Exception("Erro ao deletar os dados!", 500);
        }
    }
}
