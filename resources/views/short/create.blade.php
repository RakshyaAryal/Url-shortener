@extends('templates.default')
@section('content')
    <form id="logout-form" action="{{ route('logout') }}" method="POST" >
        {{ csrf_field() }}
        <input type="submit" value="Logout" />
    </form>
    <div class="row">
        <div class="col-md-5">

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif


            <br/>
            <form action="{{ route('short.store') }}" method="post">
                {{ csrf_field() }}
                <div class="form-group has-error">
                <input type="text" name="long_url" class="form-control">
                    <span class="help-block"></span>
                <input type="submit" name="Shorten" class="btn btn-success">
                </div>

            </form>
        </div>
    </div>
@endsection