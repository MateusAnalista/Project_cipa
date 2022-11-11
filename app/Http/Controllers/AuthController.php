<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * @return string
     */
    protected $user;    // Variavel ou atributo da classe

    /**
     *  Construtor da classe AuthController
     * 
     *  @param \App\Models\User $user
     */
    public function __construct(User $user) {
        $this->user = $user;
    }

    public function login(Request $request)
    {
        try {
            // Realiza validação dos dados enviados pelo navegador
            $validated = $request->validate([
                "email" => ["required", "string"],
                "password" => ["required", "string"],
            ]);

            $user = $this->user->where("email", $validated["email"])->first();

            // Se validação não passar, imprime erro
            if(!$user) {    // Espera retornar false
                throw new Exception("Usuário não encontrado!", 404);
            }

            // Se validação não passar, imprime erro
            if(!Hash::check($validated["password"], $user->password)) {
                throw new Exception("Senhas não batem!", 400);
            }

            $token = $user->createToken("appToken")->plainTextToken;

            $user->remember_token = $token;
            $user->save();

            $response = [
                "user"  => $user,
                "token" => $token
            ];

            return response($response, 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response("Usuário deslogado!", 201);
    }
}
