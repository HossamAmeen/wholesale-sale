<?php
namespace App\Http\Controllers\BackEnd;
use Illuminate\Http\Request;
use App\Models\{Client ,Order , Bill};
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use Maatwebsite\Excel\Facades\Excel;
use DNS1D;
use Image ,DB;
use PDF;
class ClientController extends BackEndController
{
    public function __construct(Client $model)
    {
        parent::__construct($model);
    }
  
    public function store(Request $request){
        $requestArray = $request->all();
        $total =$request->purchasing_price * $request->quantity;
        $requestArray['user_id'] = Auth::user()->id;
        $this->model->create($requestArray);
        session()->flash('action', 'تم الاضافه بنجاح');

        return redirect()->route($this->getClassNameFromModel().'.index');
    }

   
    public function update($id , Request $request){



        $row = $this->model->FindOrFail($id);
        $requestArray = $request->all();
       
      
        $requestArray['user_id'] = Auth::user()->id;
        $row->update($requestArray);


        session()->flash('action', 'تم التحديث بنجاح');
        return redirect()->route($this->getClassNameFromModel().'.index');
    }

  


    public function filter($rows)
    {

        return  $rows;
    }

   
}
