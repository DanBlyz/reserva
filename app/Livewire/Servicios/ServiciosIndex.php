<?php

namespace App\Livewire\Servicios;

use App\Models\Servicio;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Servicios de Fisioterapia')]
class ServiciosIndex extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public string $search = '';

    #[Url(history: true)]
    public string $filtroActivo = '';

    public string $ordenarPor = 'nombre';

    public string $ordenDireccion = 'asc';

    public int $perPage = 10;

    // Estado del modal de creación / edición
    public bool $mostrarModal = false;

    public bool $modoEdicion = false;

    public ?int $servicioId = null;

    // Campos del formulario
    public string $nombre = '';

    public ?string $descripcion = null;

    public string $precio_base = '';

    public int $duracion_minutos = 30;

    public string $color = '#4f46e5';

    public bool $activo = true;

    // Estado del modal de confirmación de eliminación
    public bool $mostrarModalEliminar = false;

    public ?int $servicioAEliminarId = null;

    public string $servicioAEliminarNombre = '';

    /**
     * Paleta de colores predeterminados para fisioterapia
     */
    public array $coloresSugeridos = [
        '#4f46e5', // Índigo / Consulta
        '#059669', // Esmeralda / Rehabilitación
        '#0284c7', // Azul cielo / Hidroterapia
        '#d97706', // Ámbar / Electroterapia
        '#dc2626', // Rojo / Urgencias
        '#7c3aed', // Violeta / Terapia Manual
        '#db2777', // Rosa / Estética & Drenaje
        '#0d9488', // Verde Azulado / Masaje
        '#475569', // Pizarra / Control general
    ];

    /**
     * Opciones de duración rápida en minutos
     */
    public array $duracionesSugeridas = [15, 20, 30, 40, 45, 60, 75, 90, 120];

    protected function rules(): array
    {
        return [
            'nombre' => 'required|string|max:150|unique:servicios,nombre,'.$this->servicioId,
            'descripcion' => 'nullable|string|max:1000',
            'precio_base' => 'required|numeric|min:0|max:999999.99',
            'duracion_minutos' => 'required|integer|min:5|max:480',
            'color' => ['required', 'regex:/^#([A-Fa-f0-9]{6})$/'],
            'activo' => 'boolean',
        ];
    }

    protected function validationAttributes(): array
    {
        return [
            'nombre' => 'nombre del servicio',
            'descripcion' => 'descripción',
            'precio_base' => 'precio base',
            'duracion_minutos' => 'duración en minutos',
            'color' => 'color identificador',
            'activo' => 'estado',
        ];
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFiltroActivo(): void
    {
        $this->resetPage();
    }

    public function ordenarPor(string $campo): void
    {
        if ($this->ordenarPor === $campo) {
            $this->ordenDireccion = $this->ordenDireccion === 'asc' ? 'desc' : 'asc';
        } else {
            $this->ordenarPor = $campo;
            $this->ordenDireccion = 'asc';
        }
    }

    public function limpiarFiltros(): void
    {
        $this->reset(['search', 'filtroActivo']);
        $this->resetPage();
    }

    public function abrirModalCrear(): void
    {
        $this->resetValidation();
        $this->reset([
            'nombre', 'descripcion', 'precio_base', 'duracion_minutos', 'color', 'servicioId',
        ]);
        $this->duracion_minutos = 30;
        $this->color = '#4f46e5';
        $this->activo = true;
        $this->modoEdicion = false;
        $this->mostrarModal = true;
    }

    public function abrirModalEditar(int $id): void
    {
        $this->resetValidation();
        $servicio = Servicio::findOrFail($id);

        $this->servicioId = $servicio->id;
        $this->nombre = $servicio->nombre;
        $this->descripcion = $servicio->descripcion;
        $this->precio_base = (string) $servicio->precio_base;
        $this->duracion_minutos = (int) $servicio->duracion_minutos;
        $this->color = $servicio->color;
        $this->activo = (bool) $servicio->activo;

        $this->modoEdicion = true;
        $this->mostrarModal = true;
    }

    public function cerrarModal(): void
    {
        $this->mostrarModal = false;
        $this->resetValidation();
    }

    public function guardar(): void
    {
        $validated = $this->validate();
        $userId = Auth::id();

        if ($this->modoEdicion && $this->servicioId) {
            $servicio = Servicio::findOrFail($this->servicioId);
            $servicio->update([
                'nombre' => $validated['nombre'],
                'descripcion' => $validated['descripcion'],
                'precio_base' => $validated['precio_base'],
                'duracion_minutos' => $validated['duracion_minutos'],
                'color' => $validated['color'],
                'activo' => $validated['activo'],
                'usuario_modificador_id' => $userId,
            ]);

            session()->flash('success', 'Servicio actualizado exitosamente.');
            $this->dispatch('swal', icon: 'success', title: '¡Servicio Actualizado!', text: "El servicio \"{$servicio->nombre}\" fue actualizado correctamente.");
        } else {
            $nuevoServicio = Servicio::create([
                'nombre' => $validated['nombre'],
                'descripcion' => $validated['descripcion'],
                'precio_base' => $validated['precio_base'],
                'duracion_minutos' => $validated['duracion_minutos'],
                'color' => $validated['color'],
                'activo' => $validated['activo'],
                'usuario_creador_id' => $userId,
            ]);

            session()->flash('success', 'Servicio creado exitosamente.');
            $this->dispatch('swal', icon: 'success', title: '¡Servicio Registrado!', text: "El servicio \"{$nuevoServicio->nombre}\" fue registrado exitosamente.");
        }

        $this->mostrarModal = false;
        $this->resetValidation();
    }

    public function toggleEstado(int $id): void
    {
        $servicio = Servicio::findOrFail($id);
        $servicio->activo = ! $servicio->activo;
        $servicio->usuario_modificador_id = Auth::id();
        $servicio->save();

        $estadoTexto = $servicio->activo ? 'Activo' : 'Inactivo';
        session()->flash('success', "Estado del servicio \"{$servicio->nombre}\" actualizado.");
        $this->dispatch('swal', icon: 'success', title: 'Estado Actualizado', text: "El servicio \"{$servicio->nombre}\" ahora está {$estadoTexto}.");
    }

    public function confirmarEliminar(int $id): void
    {
        $servicio = Servicio::findOrFail($id);
        $this->servicioAEliminarId = $servicio->id;
        $this->servicioAEliminarNombre = $servicio->nombre;
        $this->mostrarModalEliminar = true;
    }

    public function cancelarEliminar(): void
    {
        $this->mostrarModalEliminar = false;
        $this->reset(['servicioAEliminarId', 'servicioAEliminarNombre']);
    }

    public function eliminar(): void
    {
        if (! $this->servicioAEliminarId) {
            return;
        }

        $servicio = Servicio::findOrFail($this->servicioAEliminarId);
        $nombre = $servicio->nombre;
        $servicio->usuario_eliminador_id = Auth::id();
        $servicio->save();
        $servicio->delete();

        $this->mostrarModalEliminar = false;
        $this->reset(['servicioAEliminarId', 'servicioAEliminarNombre']);

        session()->flash('success', 'Servicio eliminado correctamente.');
        $this->dispatch('swal', icon: 'success', title: 'Servicio Eliminado', text: "El servicio \"{$nombre}\" fue eliminado correctamente.");
    }

    public function seleccionarColor(string $hex): void
    {
        $this->color = $hex;
    }

    public function seleccionarDuracion(int $minutos): void
    {
        $this->duracion_minutos = $minutos;
    }

    public function render(): View
    {
        $query = Servicio::query();

        if ($this->search !== '') {
            $query->where(function ($q) {
                $q->where('nombre', 'like', '%'.$this->search.'%')
                    ->orWhere('descripcion', 'like', '%'.$this->search.'%');
            });
        }

        if ($this->filtroActivo !== '') {
            $query->where('activo', $this->filtroActivo === '1');
        }

        $servicios = $query->orderBy($this->ordenarPor, $this->ordenDireccion)
            ->paginate($this->perPage);

        // Métricas calculadas
        $totalServicios = Servicio::count();
        $totalActivos = Servicio::where('activo', true)->count();
        $duracionPromedio = (int) round(Servicio::avg('duracion_minutos') ?? 0);
        $precioPromedio = round(Servicio::avg('precio_base') ?? 0, 2);

        return view('livewire.servicios.servicios-index', [
            'servicios' => $servicios,
            'totalServicios' => $totalServicios,
            'totalActivos' => $totalActivos,
            'duracionPromedio' => $duracionPromedio,
            'precioPromedio' => $precioPromedio,
        ]);
    }
}
