<?php

namespace App\Livewire\Admin;

use App\Models\Permiso;
use App\Models\Rol;
use App\Models\Sucursal;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Personal y Usuarios del Sistema')]
class UsuariosIndex extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public string $search = '';

    #[Url(history: true)]
    public string $filtroRol = '';

    #[Url(history: true)]
    public string $filtroSucursal = '';

    #[Url(history: true)]
    public string $filtroEstado = '';

    public string $ordenarPor = 'name';

    public string $ordenDireccion = 'asc';

    public int $perPage = 10;

    // Modal Crear / Editar Usuario
    public bool $mostrarModal = false;

    public bool $modoEdicion = false;

    public ?int $usuarioId = null;

    // Campos formulario usuario
    public string $name = '';

    public ?string $nombres = null;

    public ?string $ap_paterno = null;

    public ?string $ap_materno = null;

    public ?string $cedula = null;

    public ?string $celular = null;

    public ?string $direccion = null;

    public string $email = '';

    public string $password = '';

    public ?int $rol_id = null;

    public ?int $sucursal_id = null;

    public bool $activo = true;

    // Modal de Permisos Granulares
    public bool $mostrarModalPermisos = false;

    public ?int $usuarioPermisosId = null;

    public string $usuarioPermisosNombre = '';

    public array $permisosSeleccionados = [];

    // Modal Modificar Contraseña
    public bool $mostrarModalPassword = false;

    public ?int $usuarioPasswordId = null;

    public string $usuarioPasswordNombre = '';

    public string $nuevaPassword = '';

    // Modal Eliminar
    public bool $mostrarModalEliminar = false;

    public ?int $usuarioAEliminarId = null;

    public string $usuarioAEliminarNombre = '';

    protected function rules(): array
    {
        $passwordRule = $this->modoEdicion ? 'nullable|string|min:8' : 'required|string|min:8';

        return [
            'name' => 'required|string|max:150',
            'nombres' => 'nullable|string|max:100',
            'ap_paterno' => 'nullable|string|max:100',
            'ap_materno' => 'nullable|string|max:100',
            'cedula' => 'nullable|string|max:30',
            'celular' => 'nullable|string|max:30',
            'direccion' => 'nullable|string|max:255',
            'email' => 'required|email|max:150|unique:users,email,'.$this->usuarioId,
            'password' => $passwordRule,
            'rol_id' => 'required|exists:roles,id',
            'sucursal_id' => 'nullable|exists:sucursales,id',
            'activo' => 'boolean',
        ];
    }

    protected function validationAttributes(): array
    {
        return [
            'name' => 'nombre completo / de usuario',
            'email' => 'correo electrónico',
            'password' => 'contraseña',
            'rol_id' => 'rol asignado',
            'sucursal_id' => 'sucursal base',
        ];
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFiltroRol(): void
    {
        $this->resetPage();
    }

    public function updatingFiltroSucursal(): void
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
        $this->reset([
            'name', 'nombres', 'ap_paterno', 'ap_materno',
            'cedula', 'celular', 'direccion', 'email',
            'password', 'rol_id', 'sucursal_id', 'usuarioId',
        ]);
        $this->activo = true;
        $this->modoEdicion = false;

        // Por defecto asignar la sucursal activa en sesión si existe
        $this->sucursal_id = session('sucursal_activa_id') ?? Sucursal::where('activa', true)->first()?->id;
        $this->rol_id = Rol::where('activo', true)->first()?->id;

        $this->mostrarModal = true;
    }

    public function abrirModalEditar(int $id): void
    {
        $this->resetValidation();
        $user = User::findOrFail($id);

        $this->usuarioId = $user->id;
        $this->name = $user->name;
        $this->nombres = $user->nombres;
        $this->ap_paterno = $user->ap_paterno;
        $this->ap_materno = $user->ap_materno;
        $this->cedula = $user->cedula;
        $this->celular = $user->celular;
        $this->direccion = $user->direccion;
        $this->email = $user->email;
        $this->password = '';
        $this->rol_id = $user->rol_id;
        $this->sucursal_id = $user->sucursal_id;
        $this->activo = (bool) $user->activo;

        $this->modoEdicion = true;
        $this->mostrarModal = true;
    }

    public function guardar(): void
    {
        $validated = $this->validate();
        $adminId = Auth::id();

        // Autogenerar name si se ingresaron nombres y apellidos
        $nombreCompleto = trim("{$validated['nombres']} {$validated['ap_paterno']} {$validated['ap_materno']}");
        $nameFinal = ! empty($nombreCompleto) ? $nombreCompleto : $validated['name'];

        $datos = [
            'name' => $nameFinal,
            'nombres' => $validated['nombres'],
            'ap_paterno' => $validated['ap_paterno'],
            'ap_materno' => $validated['ap_materno'],
            'cedula' => $validated['cedula'],
            'celular' => $validated['celular'],
            'direccion' => $validated['direccion'],
            'email' => $validated['email'],
            'rol_id' => $validated['rol_id'],
            'sucursal_id' => $validated['sucursal_id'],
            'activo' => $validated['activo'],
        ];

        if (! empty($validated['password'])) {
            $datos['password'] = Hash::make($validated['password']);
        }

        if ($this->modoEdicion && $this->usuarioId) {
            $user = User::findOrFail($this->usuarioId);
            $datos['usuario_modificador_id'] = $adminId;
            $user->update($datos);

            session()->flash('success', 'Usuario actualizado correctamente.');
            $this->dispatch('swal', icon: 'success', title: '¡Usuario Actualizado!', text: "El usuario \"{$user->name}\" fue actualizado correctamente.");
        } else {
            $datos['usuario_creador_id'] = $adminId;
            $nuevoUser = User::create($datos);

            session()->flash('success', 'Usuario registrado con éxito.');
            $this->dispatch('swal', icon: 'success', title: '¡Usuario Registrado!', text: "El usuario \"{$nuevoUser->name}\" fue registrado con éxito.");
        }

        $this->mostrarModal = false;
        $this->resetValidation();
    }

    public function toggleEstado(int $id): void
    {
        if ($id === Auth::id()) {
            session()->flash('error', 'No puedes desactivar tu propia cuenta activa.');
            $this->dispatch('swal', icon: 'error', title: 'Acción Denegada', text: 'No puedes desactivar tu propia cuenta activa.');

            return;
        }

        $user = User::findOrFail($id);
        $user->activo = ! $user->activo;
        $user->usuario_modificador_id = Auth::id();
        $user->save();

        $estadoTexto = $user->activo ? 'Activo' : 'Inactivo';
        session()->flash('success', "Estado del usuario \"{$user->name}\" actualizado.");
        $this->dispatch('swal', icon: 'success', title: 'Estado Actualizado', text: "El usuario \"{$user->name}\" ahora está {$estadoTexto}.");
    }

    public function abrirModalPermisos(int $id): void
    {
        $user = User::with('permisos')->findOrFail($id);
        $this->usuarioPermisosId = $user->id;
        $this->usuarioPermisosNombre = $user->name;
        $this->permisosSeleccionados = $user->permisos->pluck('id')->map(fn ($id) => (string) $id)->toArray();
        $this->mostrarModalPermisos = true;
    }

    public function guardarPermisos(): void
    {
        if (! $this->usuarioPermisosId) {
            return;
        }

        $user = User::findOrFail($this->usuarioPermisosId);
        $user->permisos()->sync($this->permisosSeleccionados);

        $this->mostrarModalPermisos = false;
        $this->reset(['usuarioPermisosId', 'usuarioPermisosNombre', 'permisosSeleccionados']);

        session()->flash('success', "Permisos actualizados correctamente para {$user->name}.");
        $this->dispatch('swal', icon: 'success', title: '¡Permisos Actualizados!', text: "Los permisos directos de \"{$user->name}\" han sido sincronizados.");
    }

    public function abrirModalPassword(int $id): void
    {
        $this->resetValidation();
        $user = User::findOrFail($id);
        $this->usuarioPasswordId = $user->id;
        $this->usuarioPasswordNombre = $user->name;
        $this->nuevaPassword = '';
        $this->mostrarModalPassword = true;
    }

    public function generarPassword(): void
    {
        $this->nuevaPassword = Str::password(10, letters: true, numbers: true, symbols: false);
    }

    public function cambiarPassword(): void
    {
        $this->validate([
            'nuevaPassword' => 'required|string|min:8',
        ], [
            'nuevaPassword.required' => 'La nueva contraseña es obligatoria.',
            'nuevaPassword.min' => 'La contraseña debe tener al menos 8 caracteres.',
        ]);

        if (! $this->usuarioPasswordId) {
            return;
        }

        $user = User::findOrFail($this->usuarioPasswordId);
        $user->password = Hash::make($this->nuevaPassword);
        $user->usuario_modificador_id = Auth::id();
        $user->save();

        $nombre = $this->usuarioPasswordNombre;
        $this->mostrarModalPassword = false;
        $this->reset(['usuarioPasswordId', 'usuarioPasswordNombre', 'nuevaPassword']);

        session()->flash('success', "Contraseña de \"{$nombre}\" actualizada correctamente.");
        $this->dispatch('swal', icon: 'success', title: '¡Contraseña Modificada!', text: "La contraseña de \"{$nombre}\" fue actualizada correctamente.");
    }

    public function cerrarModalPassword(): void
    {
        $this->mostrarModalPassword = false;
        $this->resetValidation();
        $this->reset(['usuarioPasswordId', 'usuarioPasswordNombre', 'nuevaPassword']);
    }

    public function confirmarEliminar(int $id): void
    {
        if ($id === Auth::id()) {
            session()->flash('error', 'No puedes eliminar tu propia cuenta.');
            $this->dispatch('swal', icon: 'error', title: 'Acción Denegada', text: 'No puedes eliminar tu propia cuenta.');

            return;
        }

        $user = User::findOrFail($id);
        $this->usuarioAEliminarId = $user->id;
        $this->usuarioAEliminarNombre = $user->name;
        $this->mostrarModalEliminar = true;
    }

    public function eliminar(): void
    {
        if (! $this->usuarioAEliminarId || $this->usuarioAEliminarId === Auth::id()) {
            return;
        }

        $user = User::findOrFail($this->usuarioAEliminarId);
        $nombre = $user->name;
        $user->usuario_eliminador_id = Auth::id();
        $user->save();
        $user->delete();

        $this->mostrarModalEliminar = false;
        $this->reset(['usuarioAEliminarId', 'usuarioAEliminarNombre']);

        session()->flash('success', 'Usuario dado de baja del sistema.');
        $this->dispatch('swal', icon: 'success', title: 'Usuario Eliminado', text: "El usuario \"{$nombre}\" ha sido dado de baja del sistema.");
    }

    public function render(): View
    {
        $query = User::with(['rol', 'sucursal', 'permisos']);

        if ($this->search !== '') {
            $query->where(function ($q) {
                $q->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('email', 'like', '%'.$this->search.'%')
                    ->orWhere('cedula', 'like', '%'.$this->search.'%')
                    ->orWhere('celular', 'like', '%'.$this->search.'%');
            });
        }

        if ($this->filtroRol !== '') {
            $query->where('rol_id', $this->filtroRol);
        }

        if ($this->filtroSucursal !== '') {
            $query->where('sucursal_id', $this->filtroSucursal);
        }

        if ($this->filtroEstado !== '') {
            $query->where('activo', $this->filtroEstado === '1');
        }

        $usuarios = $query->orderBy($this->ordenarPor, $this->ordenDireccion)
            ->paginate($this->perPage);

        $roles = Rol::where('activo', true)->orderBy('nombre')->get();
        $sucursales = Sucursal::where('activa', true)->orderBy('nombre')->get();
        $permisosPorModulo = Permiso::all()->groupBy('modulo');

        $totalUsuarios = User::count();
        $totalActivos = User::where('activo', true)->count();

        return view('livewire.admin.usuarios-index', [
            'usuarios' => $usuarios,
            'roles' => $roles,
            'sucursales' => $sucursales,
            'permisosPorModulo' => $permisosPorModulo,
            'totalUsuarios' => $totalUsuarios,
            'totalActivos' => $totalActivos,
        ]);
    }
}
