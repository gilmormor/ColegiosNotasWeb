@php
  use App\Menu;
@endphp
@if ($upermisos || $rpermisos)
  @if ($item['submenu'] == [])
      @if (Menu::permiso($upermisos,$item['id']) || Menu::permiso($rpermisos,$item['id']))
        @if ($item['bloqueo'] == 0)
          <li>
            <a href="{{route($item['slug'])}}">
              <i class="{{$item['icon']}}"></i> <span>{{ $item['name'] }}</span>
            </a>
          </li>
          @else
            <li>
              <a href="{{route($item['slug'])}}" disabled>
                <i class="{{$item['icon']}}"></i> <span>{{ $item['name'] }}</span>
              </a>
            </li>
        @endif
      @endif
  @else
    @if (Menu::permiso($upermisos,$item['id']) || Menu::permiso($rpermisos,$item['id']))
      <li class="treeview">
        <a href="#">
          <i class="{{$item['icon']}}"></i>
          <span>{{ $item['name'] }}</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          @foreach ($item['submenu'] as $submenu)
              @if ($submenu['submenu'] == [])
                  @if (Menu::permiso($upermisos,$submenu['id']) || Menu::permiso($rpermisos,$submenu['id']))
                    @if ($submenu['bloqueo'] == 0)
                      <li>
                        <a href="{{route($submenu['slug'])}}">
                          <i class="fa fa-circle-o"></i> {{ $submenu['name'] }}
                        </a>
                      </li>
                    @else
                      @if(Auth::user()->pago == 1) <!--1 es que ya pago y lo va a dejar mostrar el menu -->
                      <li>
                        <a href="{{route($submenu['slug'])}}">
                          <i class="fa fa-circle-o"></i> {{ $submenu['name'] }}
                        </a>
                      </li>
                      @else <!--0 es que no pago y muestra el menu en rojo -->
                        <li>
                          <a class="text-red" href="#" title="Tiene deuda pendiente">
                            <i class="fa fa-circle-o text-red"></i> {{ $submenu['name'] }}
                          </a>
                        </li>
                      @endif
                    @endif
                  @endif
              @else
                  @include('partials.menu', [ 'item' => $submenu ])
              @endif
          @endforeach
        </ul>
      </li>
    @endif
  @endif
@endif
