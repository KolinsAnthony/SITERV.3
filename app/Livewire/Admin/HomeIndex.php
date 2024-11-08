<?php 
 
namespace App\Livewire\Admin; 
 
use App\Models\Estudiante; 
use App\Models\Programa; 
use App\Models\Rubro; 
use App\Models\User; 
use App\Models\Comprobante; 
use Illuminate\Support\Facades\DB; 
use Livewire\Component; 
 
class HomeIndex extends Component
{




    public $rubroData = [];
    public $boletasData = [];

    

    public function mount()
    {

        // Obtener la cantidad de pedidos por mes
        $this->boletasData = Comprobante::select(DB::raw('MONTH(fecha) as month'), DB::raw('count(*) as total'))
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Asegúrate de que todos los meses estén representados
        for ($i = 1; $i <= 12; $i++) {
            if (!isset($this->boletasData[$i])) {
                $this->boletasData[$i] = 0;
            }
        }
        ksort($this->boletasData);






        // Obtener la cantidad de Comprobantes por estudiantes
        $this->rubroData = Comprobante::with('rubro')
            ->get()
            ->groupBy('rubro.id')
            ->mapWithKeys(function ($items, $key) {
                return [$items->first()->rubro->nombre_rubro => $items->count()];
                })
            ->toArray();

        // Calcular los porcentajes para el gráfico de dona
        $total = array_sum($this->rubroData);
        $this->rubroData = array_map(function ($value) use ($total) {
            return $total > 0 ? round(($value / $total) * 100, 2) : 0;
            }, $this->rubroData);
    }


    public function render()
    {
        $users = User::count();
        $estudiantes = Estudiante::count();
        $programas = Programa::count();
        $rubros = Rubro::count();

        return view('livewire.admin.home-index',[
           'users'=> $users,
           'estudiantes'=>$estudiantes ,
           'programas'=> $programas ,
           'rubros'=>$rubros,
           'rubroData' => $this->rubroData,
           'boletasData' => $this->boletasData,
        ]);
    }
}