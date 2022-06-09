<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\miniform;
use App\Events\NewTrade;


class HomeController extends Controller
{
    public function savePost(Request $request){
        file_put_contents( storage_path().'/logs/carla.log', "\n". __FILE__ .":". __LINE__ ."\n".var_export($request->nombre, true)."\n", FILE_APPEND );
        $miniform  = new miniform();
        $miniform->nombre = $request->nombre;
        $miniform->cantidad = $request->cantidad;
        $miniform->save();
        $trade = $request->nombre;
        broadcast(new NewTrade($trade))->toOthers();

        return redirect('/');
    }
}
