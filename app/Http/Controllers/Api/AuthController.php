<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterClientRequest;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Models\Client;
use App\Models\ClientRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as PasswordRule;

class AuthController extends ApiController
{
    public function registerRequest(RegisterClientRequest $request)
    {
        $data = $request->validated();

        $clientRequest = ClientRequest::create([
            'full_name' => $data['full_name'],
            'company_name' => $data['company_name'],
            'cnpj' => $data['cnpj'],
            'position' => $data['position'] ?? null,
            'phone' => $data['phone'] ?? null,
            'email' => $data['email'],
            'logo_path' => null,
            'observations' => $data['observations'] ?? null,
            'status' => ClientRequest::STATUS_PENDING,
            'submitted_at' => now(),
        ]);

        return $this->success(['request' => $clientRequest], 'Cadastro encaminhado com sucesso.', 201);
    }

    public function register(RegisterUserRequest $request)
    {
        $data = $request->validated();

        $client = Client::create([
            'razao_social' => $data['company_name'],
            'nome_fantasia' => $data['company_name'],
            'cnpj' => $data['cnpj'],
            'email' => $data['email'],
            'telefone' => $data['phone'] ?? null,
            'status' => 'ativo',
            'registered_at' => now(),
        ]);

        $user = User::create([
            'name' => $data['full_name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'client_id' => $client->id,
            'phone' => $data['phone'] ?? null,
            'must_change_password' => false,
        ]);
        $user->assignRole('Cliente');

        $token = $user->createToken('api-token')->plainTextToken;

        return $this->success(['user' => $user, 'token' => $token], 'Cadastro realizado com sucesso.', 201);
    }

    public function login(LoginRequest $request)
    {
        $payload = $request->validated();
        $cnpjPrefix = preg_replace('/\D/', '', $payload['cnpj']);

        $user = User::whereHas('client', function ($query) use ($cnpjPrefix) {
            $query->whereRaw("REPLACE(REPLACE(REPLACE(REPLACE(cnpj, '.', ''), '/', ''), '-', ''), ' ', '') LIKE ?", ["{$cnpjPrefix}%"]);
        })->first();

        if (! $user || ! Hash::check($payload['password'], $user->password)) {
            return $this->error('CNPJ ou senha inválidos.', 401);
        }

        $token = $user->createToken('api-token')->plainTextToken;
        $user->update(['last_login_at' => now()]);

        return $this->success(['user' => $user, 'token' => $token]);
    }

    public function me(Request $request)
    {
        return $this->success(['user' => $request->user()]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()?->delete();

        return $this->success([], 'Logout realizado.');
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();

        if (isset($data['current_password']) && ! Hash::check($data['current_password'], $user->password)) {
            return $this->error('Senha atual incorreta.', 422);
        }

        $user->update([
            'password' => $data['password'],
            'must_change_password' => false,
        ]);

        return $this->success([], 'Senha atualizada com sucesso.');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => ['required', 'email']]);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? $this->success([], 'Link de redefinição enviado por e-mail.')
            : $this->error('Não foi possível enviar o link de redefinição.', 500);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', PasswordRule::min(8)->mixedCase()->numbers()->symbols()],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'must_change_password' => false,
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? $this->success([], 'Senha redefinida com sucesso.')
            : $this->error('Não foi possível redefinir a senha.', 500);
    }
}
