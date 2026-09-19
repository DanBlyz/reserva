<?php

namespace App\Livewire\Admin;

use App\Models\Permiso;
use App\Models\Rol;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Roles y Permisos del Sistema')]
class RolesIndex extends Component
{
    public string $search = '';

    // Modal Crear / Editar Rol
    public bool $mostrarModal = false;

    public bool $modoEdicion = false;

    public ?int $rolId = null;

    public string $nombre = '';

    public string $slug = '';

    public ?string $descripcion = null;

    public bool $activo = true;

    // Modal Eliminar
    public bool $mostrarModalEliminar = false;

    public ?int $rolAEliminarId = null;

    public string $rolAEliminarNombre = '';

    // Lista de roles protegidos del sistema
    public array $rolesProtegidos = ['admin', 'personal_atencion', 'cajero', 'recepcionista'];

    protected function rules(): array
    {
        return [
            'nombre' => 'required|string|max:100',
            'slug' => 'required|string|max:100|unique:roles,slug,'.$this->rolId,
            'descripcion' => 'nullable|string|max:255',
            'activo' => 'boolean',
        ];
    }

    protected function validationAttributes(): array
    {
        return [
            'nombre' => 'nombre del rol',
            'slug' => 'identificador slug',
            'descripcion' => 'descripción',
            'activo' => 'estado',
        ];
    }

    public function updatingSearch(): void
    {
        // Reset state si es necesario
    }

    public function abrirModalCrear(): void
    {
        $this->resetValidation();
        $this->reset(['nombre', 'slug', 'descripcion', 'rolId']);
        $this->activo = true;
        $this->modoEdicion = false;
        $this->mostrarModal = true;
    }

    public function abrirModalEditar(int $id): void
    {
        $this->resetValidation();
        $rol = Rol::findOrFail($id);

        $this->rolId = $rol->id;
        $this->nombre = $rol->nombre;
        $this->slug = $rol->slug;
        $this->descripcion = $rol->descripcion;
        $this->activo = (bool) $rol->activo;

        $this->modoEdicion = true;
        $this->mostrarModal = true;
    }

    public function guardar(): void
    {
        $validated = $this->validate();
        $userId = Auth::id();

        if ($this->modoEdicion && $this->rolId) {
            $rol = Rol::findOrFail($this->rolId);
            $rol->update([
                'nombre' => $validated['nombre'],
                'slug' => Str::slug($validated['slug'], '_'),
                'descripcion' => $validated['descripcion'],
                'activo' => $validated['activo'],
                'usuario_modificador_id' => $userId,
            ]);

            session()->flash('success', 'Rol actualizado con éxito.');
            $this->dispatch('swal', icon: 'success', title: '¡Rol Actualizado!', text: "El rol \"{$rol->nombre}\" ha sido actualizado con éxito.");
        } else {
            $nuevoRol = Rol::create([
                'nombre' => $validated['nombre'],
                'slug' => Str::slug($validated['slug'], '_'),
                'descripcion' => $validated['descripcion'],
                'activo' => $validated['activo'],
                'usuario_creador_id' => $userId,
            ]);

            session()->flash('success', 'Rol creado exitosamente.');
            $this->dispatch('swal', icon: 'success', title: '¡Rol Creado!', text: "El rol \"{$nuevoRol->nombre}\" ha sido creado exitosamente.");
        }

        $this->mostrarModal = false;
        $this->resetValidation();
    }

    public function confirmarEliminar(int $id): void
    {
        $rol = Rol::withCount('usuarios')->findOrFail($id);

        if (in_array($rol->slug, $this->rolesProtegidos, true)) {
            session()->flash('error', 'No puedes eliminar los roles predeterminados del sistema.');
            $this->dispatch('swal', icon: 'error', title: 'Acción Denegada', text: 'No puedes eliminar los roles predeterminados del sistema.');

            return;
        }

        if ($rol->usuarios_count > 0) {
            session()->flash('error', "No puedes eliminar el rol porque tiene {$rol->usuarios_count} usuarios asignados.");
            $this->dispatch('swal', icon: 'error', title: 'Acción Denegada', text: "No puedes eliminar el rol porque tiene {$rol->usuarios_count} usuarios asignados.");

            return;
        }

        $this->rolAEliminarId = $rol->id;
        $this->rolAEliminarNombre = $rol->nombre;
        $this->mostrarModalEliminar = true;
    }

    public function eliminar(): void
    {
        if (! $this->rolAEliminarId) {
            return;
        }

        $rol = Rol::findOrFail($this->rolAEliminarId);
        $nombre = $rol->nombre;
        $rol->usuario_eliminador_id = Auth::id();
        $rol->save();
        $rol->delete();

        $this->mostrarModalEliminar = false;
        $this->reset(['rolAEliminarId', 'rolAEliminarNombre']);

        session()->flash('success', 'Rol eliminado correctamente.');
        $this->dispatch('swal', icon: 'success', title: 'Rol Eliminado', text: "El rol \"{$nombre}\" ha sido eliminado correctamente.");
    }

    public function toggleEstado(int $id): void
    {
        $rol = Rol::findOrFail($id);

        if ($rol->slug === 'admin') {
            session()->flash('error', 'El rol de Administrador no puede ser desactivado.');
            $this->dispatch('swal', icon: 'error', title: 'Acción Denegada', text: 'El rol de Administrador no puede ser desactivado.');

            return;
        }

        $rol->activo = ! $rol->activo;
        $rol->usuario_modificador_id = Auth::id();
        $rol->save();

        $estadoTexto = $rol->activo ? 'Activo' : 'Inactivo';
        session()->flash('success', "Estado del rol \"{$rol->nombre}\" actualizado.");
        $this->dispatch('swal', icon: 'success', title: 'Estado Actualizado', text: "El rol \"{$rol->nombre}\" ahora está {$estadoTexto}.");
    }

    public function render(): View
    {
        $roles = Rol::withCount('usuarios')
            ->when($this->search, function ($q) {
                $q->where('nombre', 'like', '%'.$this->search.'%')
                    ->orWhere('slug', 'like', '%'.$this->search.'%')
                    ->orWhere('descripcion', 'like', '%'.$this->search.'%');
            })
            ->orderBy('id')
            ->get();

        // Permisos del sistema agrupados por módulo
        $permisosPorModulo = Permiso::all()->groupBy('modulo');

        return view('livewire.admin.roles-index', [
            'roles' => $roles,
            'permisosPorModulo' => $permisosPorModulo,
        ]);
    }
}
