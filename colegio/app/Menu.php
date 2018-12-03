<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\permiso;
use App\Menu;
class Menu extends Model
{
  protected $table="menus";
  protected $fillable =['id','name','slug','parent','order','enabled'];

  public static function menu($id,$tipo)
  {
      $collection = collect();
      $permisos = new permiso();
      if ($tipo == 1) {
        $p = $permisos->user($id);
      }
      else {
        $p = $permisos->rol($id);
      }
      $m = Menu::all();
      $tam = sizeof($m);
      for ($i = 0; $i < $tam; $i++) {
        $borrar = true;
          for ($j=0; $j < sizeof($p) ; $j++) {
            if ($p[$j]->menu_id == $m[$i]->id) {
              $collection->push($m[$i]);
            }
          }
      }
      return $collection;
  }

  public static function permiso($permisos,$id)
  {

    for ($i=0; $i <sizeof($permisos) ; $i++) {
      if ($permisos[$i]->menu_id == $id) {
        return true;
      }
    }
    return false;
  }

  public function getChildren($data, $line)
   {
       $children = [];
       foreach ($data as $line1) {
           if ($line['id'] == $line1['parent']) {
               $children = array_merge($children, [ array_merge($line1, ['submenu' => $this->getChildren($data, $line1) ]) ]);
           }
       }
       return $children;
   }
   public static function padre($data, $line)
    {
        $children = "";
        foreach ($data as $line1) {
            if ($line['parent'] == $line1['id']) {
                $children =$line1['name'];
            }
        }
        return $children;
    }

   public static function countChildren($data, $line)
    {
        $children = 0;
        foreach ($data as $line1) {
            if ($line['id'] == $line1['parent']) {
                $children ++;
            }
        }
        return $children;
    }

   public function optionsMenu()
   {
       return $this->where('enabled', 1)
           ->orderby('parent')
           ->orderby('order')
           ->orderby('name')
           ->get()
           ->toArray();
   }
   public static function menus()
   {
       $menus = new Menu();
       $data = $menus->optionsMenu();
       $menuAll = [];
       foreach ($data as $line) {
           $item = [ array_merge($line, ['submenu' => $menus->getChildren($data, $line) ]) ];
           $menuAll = array_merge($menuAll, $item);
       }
       return $menus->menuAll = $menuAll;
   }
}
