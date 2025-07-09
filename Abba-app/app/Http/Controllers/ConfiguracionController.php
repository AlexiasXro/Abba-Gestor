<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
    public function actualizarAspecto(Request $request)
    {
        $request->validate([
            'aspecto' => 'required|in:' . implode(',', array_keys(config('aspectos')))
        ]);

        $user = auth()->user();
        $user->aspecto = $request->aspecto;
        $user->save();

        return back()->with('success', 'Aspecto actualizado correctamente.');
    }
}

