<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use App\Slide;
use App\Promotion;
use App\Produit;
use App\Categorie;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function home()
    {
        $slides=Slide::orderby('id','desc')->paginate(1);
        $promotions=Promotion::orderby('id','desc')->paginate(1);
        $new_products=Produit::orderby('id','desc')->paginate(8);
        $categories=Categorie::orderby('id','desc')->paginate(7);
        $produits = DB::table('produits')
        ->Join('souscategories', 'produits.souscategories_id', '=', 'souscategories.id')
        ->Join('categories', 'souscategories.categories_id', '=', 'categories.id')
        ->select('produits.*','souscategories.name as namsc')
        ->distinct()->where('categories.id',1)
        ->orderBy('produits.created_at','desc')
        ->paginate(4);
       
    	return view('welcome',compact('slides','promotions','produits','new_products','categories'));
    }

    public function getbycate($id){
    //dd($id);
    //echo $id;
   $produits = DB::table('produits')
   ->Join('souscategories', 'produits.souscategories_id', '=', 'souscategories.id')
   ->Join('categories', 'souscategories.categories_id', '=', 'categories.id')
   ->select('produits.*','souscategories.name as namsc')
   ->distinct()->where('categories.id',$id)
   ->orderBy('produits.created_at','desc')
   ->paginate(4);
  

   
  return $produits;

    }
}
