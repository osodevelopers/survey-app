@extends('layouts.application')

@section('content')
{{-- <div class="container"> --}}
    <app></app>
    {{-- <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    You are logged in!
                    <example-component></example-component>
                    <el-button type="primary" style="width:100%;">登录</el-button>
                </div>
            </div>
        </div>
    </div> --}}
{{-- </div> --}}
@endsection
