<?php

namespace App\Http\Controllers\BackEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{Expense};
use Auth;
class ExpenseController extends BackEndController
{
    public function __construct(Expense $model)
    {
        parent::__construct($model);
    }
    public function store(Request $request){

        $requestArray = $request->all();
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
        $rows = $rows->whereDate('created_at' ,'>=', '2022-01-01');
 
        if(request('day') != null)
        {
            // $rows = $rows->whereYear('deleted_at' , date('Y'))->whereMonth('deleted_at' , date('m'))->whereDate('deleted_at' , date('d'));
            $rows = $rows->whereYear('created_at' , date('Y'))->whereMonth('created_at' , date('m'))->whereDate('created_at' , request('day'));
        }
      
        if(request('month') != null)
        $rows = $rows->whereYear('created_at' , date('Y'))->whereMonth('created_at' ,  request('month'));
        if(request('year') != null)
        $rows = $rows->whereYear('created_at' , request('year'));

        if(request('dateSearch') != null)
        {
            // session('dateSearch' ,request('dateSearch') );
            session(['dateSearch' => request('dateSearch')]);
            $rows = $rows->whereDate('created_at' ,'>=', request('dateSearch'));
        }
        
        return $rows;
    }
}
