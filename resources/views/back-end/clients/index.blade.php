@extends('back-end.layout.app')
@php $row_num = 1; $pageTitle = "عرض التجار" @endphp
@section('title')
{{$pageTitle}}
@endsection

@section('content')


@component('back-end.layout.header')
@slot('nav_title')
{{$pageTitle}}
<a href="{{ route($routeName.'.create') }}">
    <button class="alert-success"> <i class="fa fa-plus"></i> </button>
</a>
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
            <th>#</th>
            <th>الاسم </th>
            <th>الهاتف </th>
           
            <th>المسؤول</th>
            <th>وقت الاضافه</th>


            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($rows as $item)
        <tr>
                <td> {{$row_num++}}</td>
                <td>{{$item->name}}</td>
                <td>{{$item->phone}}</td>
               
                <td>{{$item->user->user_name ?? " "}}</td>
                <td>{{$item->updated_at}}</td>
                <td>
                    <form action="{{ route($routeName.'.destroy' , ['id' => $item]) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('delete') }}
                        <a href="{{ route($routeName.'.edit' , ['id' => $item]) }}" rel="tooltip" title=""
                            class="btn btn-xs btn-info">
                            <i class="fa fa-pencil-square-o"></i>
                        </a>
                        <a href="{{url('admin/bills?client='. $item->id.'&limit=500')}}" rel="tooltip" title=""
                            class="btn btn-xs btn-info">
                            <i class="fas fa-envelope-open-text"></i>
                        </a>
                        <a href="{{url('admin/bills/create?client='. $item->id.'&limit=500')}}" rel="tooltip" title=""
                            class="btn btn-xs btn-info">
                            <i class="fa fa-plus"></i>
                        </a>
                        
                            
                            <button type="submit" rel="tooltip" title="" onclick="check()"
                                class="btn btn-xs btn-danger"><i class="fa fa-minus"></i></button>
                            @yield('moreButton')
                    </form>





                </td>
        </tr>
        @endforeach
    </tbody>
</table>
<br><br>

@endcomponent
@endsection

@push('js')

<script type="text/javascript">
    $(document).ready(function(){
            $("#{{$routeName}}").addClass('active');
        });
</script>
<script>
    $.ajaxSetup({
            headers:{ 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });
    
</script>
@endpush