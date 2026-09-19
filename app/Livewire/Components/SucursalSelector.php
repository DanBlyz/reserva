<?php

namespace App\Livewire\Components;

use App\Models\Sucursal;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SucursalSelector extends Component
{
    public ?int $sucursalSeleccionadaId = null;

    public function mount(): void
    {
        $user = Auth::user();
        if ($user) {
            $sucursal = $user->sucursalActiva();
            $this->sucursalSeleccionadaId = $sucursal?->id;
            if ($this->sucursalSeleccionadaId && ! session()->has('sucursal_activa_id')) {
                session(['sucursal_activa_id' => $this->sucursalSeleccionadaId]);
            }
        }
    }

    public function cambiarSucursal(int $sucursalId): void
    {
        $user = Auth::user();
        if (! $user || ! $user->esAdmin()) {
            return;
        }

        $sucursal = Sucursal::where('id', $sucursalId)->where('activa', true)->first();
        if ($sucursal) {
            $this->sucursalSeleccionadaId = $sucursal->id;
            session(['sucursal_activa_id' => $sucursal->id]);
            session()->flash('success', "Sucursal activa cambiada a: {$sucursal->nombre}");
            $this->dispatch('sucursal-cambiada', sucursalId: $sucursal->id);
            $this->js('window.location.reload()');
        }
    }

    public function render(): View
    {
        $user = Auth::user();
        $sucursales = $user && $user->esAdmin()
            ? Sucursal::where('activa', true)->orderBy('nombre')->get()
            : collect();

        $sucursalActual = $user ? $user->sucursalActiva() : null;

        return view('livewire.components.sucursal-selector', [
            'esAdmin' => $user ? $user->esAdmin() : false,
            'sucursales' => $sucursales,
            'sucursalActual' => $sucursalActual,
        ]);
    }
}
