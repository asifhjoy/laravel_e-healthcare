<?php

namespace App\Http\Controllers;

use App\Departments;
use Illuminate\Http\Request;

class DepartmentsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->middleware('verified');
    }

    protected function index()
    {
        $departments = Departments::paginate(5);
        $count = Departments::all()->count();


        return view('departments',compact('departments','count'));
    }

    protected function add(Request $r)
    {

         $dpt = new Departments;

         $dpt->dptcode = $r->dptcode;
         $dpt->dptname = $r->dptname;
         $dpt->total_doc = $r->count;
         $dpt->save();

         return redirect()->back()->with('success','New Department Added');
    }

    protected function dptdel($id)
    {
        Departments::find($id)->delete();

        return redirect()->back()->with('success','Department Successfully Deleted');
    }

}
