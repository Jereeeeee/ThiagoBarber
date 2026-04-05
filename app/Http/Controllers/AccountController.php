<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class AccountController extends Controller
{
    public function __invoke()
    {
        $user = Auth::user();
        $cursosComprados = Collection::make();

        if ($user instanceof User && Schema::hasTable('cursos') && Schema::hasTable('cursos_usuario')) {
            $cursosComprados = $user->cursos()
                ->latest('cursos_usuario.created_at')
                ->get();
        }

        return view('account', [
            'user' => $user,
            'cursosComprados' => $cursosComprados,
        ]);
    }
}
