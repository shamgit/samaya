<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class IssuedMaterialController extends Controller
{
    
    public function issue_material(Request $request)
    {


        return view('IssuedMaterial.issue_material');
    }

     public function issue_material_add(Request $request)
    {


        return view('IssuedMaterial.issue_material_add');
    }

     public function issue_material_edit(Request $request)
    {


        return view('IssuedMaterial.issue_material_edit');
    }

     public function issue_material_view(Request $request)
    {


        return view('IssuedMaterial.issue_material_view');
    }

}