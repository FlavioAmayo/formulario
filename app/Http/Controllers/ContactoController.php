<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactoController extends Controller
{
    public function index()
    {
        return view('contacto');
    }

    public function enviar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|max:255',
            'mensaje' => 'required|string|max:500',
        ]);

        $datos = [
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'mensaje' => $request->mensaje,
        ];

        Mail::send('emails.contacto', $datos, function ($message) use ($datos) {
            $message->from($datos['correo'], $datos['nombre']);
            $message->to('famayo@unitru.edu.pe', 'Admin')
                    ->subject('Nuevo mensaje de contacto');
        });

        return redirect()->back()->with('success', '¡Tu mensaje ha sido enviado con éxito!');
    }
}
