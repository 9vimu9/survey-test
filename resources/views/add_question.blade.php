@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add Question</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="{{route("storeQuestion")}}" method="POST">
                        @csrf
                        <div>
                            <div class="row">
                                <div class="col-md-8">Question</div>
                                <div class="col-md-4">User</div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <input type="text" style="width: 100%;" name="question">
                                </div>
                                <div class="col-md-4">
                                    <select name="user_id" id="user_id" style="width: 100%;">
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="submit" class="btn-dark btn" style="float: right;">
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
