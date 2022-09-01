@extends('back-end.layout.app')
@php $row_num = 1; $pageTitle = "عرض المصروفات" @endphp
@section('title')
{{$pageTitle}}
@endsection

@section('content')
<form action="{{route($routeName.'.store')}}" method="POST">
    @csrf
    {{-- <div class="col-md-6">
        <div class="row">
            @php $input = "note"; @endphp
            <div class="col-md-10 col-sm-2">
                <label class="">سبب الصرف</label>
                <input type="text" class="form-control" name="{{ $input }}"
                    value="{{isset($row) ? $row->{$input}:Request::old($input)}}" required>
                <label class="">القيمه</label>
                <input type="number" class="form-control ls-group-input" name="{{ $input }}"
                    value="{{isset($row) ? $row->{$input}:Request::old($input)}}" required>
            </div>
        </div>
    </div> --}}
    <div class="form-group">
        <label class="col-lg-2 control-label">سبب الصرف</label>
        <div class="col-lg-4">
            <input type="text" name="note" class="form-control" >
        </div>
        <label class="col-lg-2 control-label">القيمه </label>
        <div class="col-lg-2">
            <input type="text" name="value" class="form-control">
        </div>
    </div>
    <div class="form-group">
        <div class="col-lg-offset-4">
            <button class="btn btn-info " type="submit"> اضافة </button>
        </div>
    </div>
</form>
<a class="btn btn-info" href="{{$routeName.'?day=' . date('Y-m-d')}}">مصروفات اليوم</a>
<a class="btn btn-info" href="{{$routeName.'?month=' . date('m')}}">مصروفات الشهر</a>
<a class="btn btn-info" href="{{$routeName.'?year=' . date('Y')}}">مصروفات السنة</a>
<a class="btn btn-success" href="{{$routeName}}">مصروفات الكل</a>

<br><br>
<form action="{{$routeName}}" method="GET">
<input  class="form controll" type="date" name="dateSearch" value="{{session('dateSearch') ?? ''}}"  required>
<button type="submit"  class="btn btn-info">بحث </button>
</form>
@component('back-end.layout.header')
@slot('nav_title')
{{$pageTitle}}
@endslot
@endcomponent
@component('back-end.shared.table' )
@if (session()->get('action') )
<div class="alert alert-success">
    <strong>{{session()->get('action')}}</strong>
</div>
@endif
<table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
    <thead>
        <tr>
            <th># </th>
            <th>سبب الصرف</th>
            <th> القيمة</th>
            <th>تاريخ الاضافة</th>
            <th>المسؤول</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @php
            $total_value = 0 ;
        @endphp
        @foreach ($rows as $item)
        <tr>
            <td> {{$row_num++}}</td>
            <td>{{$item->note}}</td>
            <td>{{$item->value}}</td>
            <td>{{$item->created_at->format('Y-m-d') }}</td>
            <td>{{$item->user->user_name ?? " "}}</td>
            <td>
                    <form action="{{ route($routeName.'.destroy' , ['id' => $item]) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('delete') }}
                        <button type="submit" rel="tooltip" title=""  onclick="check()" class="btn btn-xs btn-danger"><i
                            class="fa fa-minus"></i></button>
                  
                    </form>
            </td>
            @php
               $total_value += $item->value
            @endphp
        </tr>
        @endforeach
    </tbody>

</table>
<div style="text-align: center ; margin: 5% 20%">
    <p>   اجمالي المصروفات : {{$total_value}}</p>
</div>
@endcomponent
@endsection

@push('js')

<script type="text/javascript">
    $(document).ready(function(){
            $("#{{$routeName}}").addClass('active');
        });

    function printPageWithAjax(){
        var route= $(event.target).attr("data-route");
        var mywindow = window.open(route, 'PRINT', 'height=600,width=800');
        mywindow.focus(); // necessary for IE >= 10
        mywindow.print();
    }
</script>

@endpush
