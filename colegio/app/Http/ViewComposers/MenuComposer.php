<?php
    namespace App\Http\ViewComposers;

    use Illuminate\View\View;
    use App\Repositories\UserRepository;
    use App\Menu;
    use App\permiso;
    use App\Colegio;
    use Illuminate\Support\Facades\Auth;

    class MenuComposer
    {
      public function compose(View $view)
      {
        $user = Auth::user();
        $menus = Menu::menus();
        $permisos = new permiso();
        $rpermisos = $permisos->rol($user->tipo_id);
        $upermisos = $permisos->user($user->id);
        $colegio = Colegio::all();
        $view->with('menus',$menus)
             ->with('upermisos',$upermisos)
             ->with('rpermisos',$rpermisos)
             ->with('nombrec', $colegio);
      }
    }
