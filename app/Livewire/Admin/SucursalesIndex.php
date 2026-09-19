<?php

namespace App\Livewire\Admin;

use App\Models\Sucursal;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Gestión de Sucursales')]
class SucursalesIndex extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public string $search = '';

    #[Url(history: true)]
    public string $filtroEstado = '';

    public string $ordenarPor = 'nombre';

    public string $ordenDireccion = 'asc';

    public int $perPage = 10;

    // Estado del modal de creación / edición
    public bool $mostrarModal = false;

    public bool $modoEdicion = false;

    public ?int $sucursalId = null;

    // Formulario
    public string $nombre = '';

    public string $codigo = '';

    public ?string $direccion = null;

    public ?string $telefono = null;

    public ?string $ciudad = null;

    public bool $activa = true;

    // Modal de eliminación
    public bool $mostrarModalEliminar = false;

    public ?int $sucursalAEliminarId = null;

    public string $sucursalAEliminarNombre = '';

    protected function rules(): array
    {
        return [
            'nombre' => 'required|string|max:150',
            'codigo' => 'required|string|max:20|unique:sucursales,codigo,'.$this->sucursalId,
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:30',
            'ciudad' => 'nullable|string|max:100',
            'activa' => 'boolean',
        ];
    }

    protected function validationAttributes(): array
    {
        return [
            'nombre' => 'nombre de la sucursal',
            'codigo' => 'código de sucursal',
            'direccion' => 'dirección',
            'telefono' => 'teléfono',
            'ciudad' => 'ciudad',
            'activa' => 'estado',
        ];
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFiltroEstado(): void
    {
        $this->resetPage();
    }

    public function ordenar(string $campo): void
    {
        if ($this->ordenarPor === $campo) {
            $this->ordenDireccion = $this->ordenDireccion === 'asc' ? 'desc' : 'asc';
        } else {
            $this->ordenarPor = $campo;
            $this->ordenDireccion = 'asc';
        }
    }

    public function abrirModalCrear(): void
    {
        $this->resetValidation();
        $this->reset(['nombre', 'codigo', 'direccion', 'telefono', 'ciudad', 'sucursalId']);
        $this->activa = true;
        $this->modoEdicion = false;
        $this->mostrarModal = true;
    }

    public function abrirModalEditar(int $id): void
    {
        $this->resetValidation();
        $sucursal = Sucursal::findOrFail($id);

        $this->sucursalId = $sucursal->id;
        $this->nombre = $sucursal->nombre;
        $this->codigo = $sucursal->codigo;
        $this->direccion = $sucursal->direccion;
        $this->telefono = $sucursal->telefono;
        $this->ciudad = $sucursal->ciudad;
        $this->activa = (bool) $sucursal->activa;

        $this->modoEdicion = true;
        $this->mostrarModal = true;
    }

    public function guardar(): void
    {
        $validated = $this->validate();
        $userId = Auth::id();

        if ($this->modoEdicion && $this->sucursalId) {
            $sucursal = Sucursal::findOrFail($this->sucursalId);
            $sucursal->update([
                'nombre' => $validated['nombre'],
                'codigo' => strtoupper($validated['codigo']),
                'direccion' => $validated['direccion'],
                'telefono' => $validated['telefono'],
                'ciudad' => $validated['ciudad'],
                'activa' => $validated['activa'],
                'usuario_modificador_id' => $userId,
            ]);

            session()->flash('success', 'Sucursal actualizada exitosamente.');
            $this->dispatch('swal', icon: 'success', title: '¡Sucursal Actualizada!', text: "La sucursal \"{$sucursal->nombre}\" fue actualizada correctamente.");
        } else {
            $sucursal = Sucursal::create([
                'nombre' => $validated['nombre'],
                'codigo' => strtoupper($validated['codigo']),
                'direccion' => $validated['direccion'],
                'telefono' => $validated['telefono'],
                'ciudad' => $validated['ciudad'],
                'activa' => $validated['activa'],
                'usuario_creador_id' => $userId,
            ]);

            session()->flash('success', 'Sucursal registrada exitosamente.');
            $this->dispatch('swal', icon: 'success', title: '¡Sucursal Registrada!', text: "La sucursal \"{$sucursal->nombre}\" fue registrada exitosamente.");
        }

        $this->mostrarModal = false;
        $this->resetValidation();
    }

    public function toggleEstado(int $id): void
    {
        $sucursal = Sucursal::findOrFail($id);
        $sucursal->activa = ! $sucursal->activa;
        $sucursal->usuario_modificador_id = Auth::id();
        $sucursal->save();

        $estadoTexto = $sucursal->activa ? 'Activa' : 'Inactiva';
        session()->flash('success', "Estado de la sucursal \"{$sucursal->nombre}\" modificado.");
        $this->dispatch('swal', icon: 'success', title: 'Estado Actualizado', text: "La sucursal \"{$sucursal->nombre}\" ahora está {$estadoTexto}.");
    }

    public function confirmarEliminar(int $id): void
    {
        $sucursal = Sucursal::withCount(['usuarios', 'reservas'])->findOrFail($id);
        $this->sucursalAEliminarId = $sucursal->id;
        $this->sucursalAEliminarNombre = $sucursal->nombre;
        $this->mostrarModalEliminar = true;
    }

    public function eliminar(): void
    {
        if (! $this->sucursalAEliminarId) {
            return;
        }

        $sucursal = Sucursal::findOrFail($this->sucursalAEliminarId);
        $nombre = $sucursal->nombre;
        $sucursal->usuario_eliminador_id = Auth::id();
        $sucursal->save();
        $sucursal->delete();

        $this->mostrarModalEliminar = false;
        $this->reset(['sucursalAEliminarId', 'sucursalAEliminarNombre']);

        session()->flash('success', 'Sucursal eliminada del sistema.');
        $this->dispatch('swal', icon: 'success', title: 'Sucursal Eliminada', text: "La sucursal \"{$nombre}\" ha sido eliminada del sistema.");
    }

    public function render(): View
    {
        $query = Sucursal::withCount(['usuarios', 'reservas']);

        if ($this->search !== '') {
            $query->where(function ($q) {
                $q->where('nombre', 'like', '%'.$this->search.'%')
                    ->orWhere('codigo', 'like', '%'.$this->search.'%')
                    ->orWhere('ciudad', 'like', '%'.$this->search.'%')
                    ->orWhere('direccion', 'like', '%'.$this->search.'%');
            });
        }

        if ($this->filtroEstado !== '') {
            $query->where('activa', $this->filtroEstado === '1');
        }

        $sucursales = $query->orderBy($this->ordenarPor, $this->ordenDireccion)
            ->paginate($this->perPage);

        $totalSucursales = Sucursal::count();
        $totalActivas = Sucursal::where('activa', true)->count();
        $ciudadesDistintas = Sucursal::distinct('ciudad')->whereNotNull('ciudad')->count('ciudad');

        return view('livewire.admin.sucursales-index', [
            'sucursales' => $sucursales,
            'totalSucursales' => $totalSucursales,
            'totalActivas' => $totalActivas,
            'ciudadesDistintas' => $ciudadesDistintas,
        ]);
    }
}
