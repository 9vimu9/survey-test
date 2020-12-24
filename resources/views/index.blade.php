@extends('layouts.app')


@section('style')
    <style>
        table {
            width:100%;
        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }

    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Index</div>

                    <div class="card-body">

                        <table>
                            <tr>
                                <th>Answered By</th>
                                <th>Question</th>
                                <th>Answer</th>
                                <th>Answered At</th>
                            </tr>
                            @foreach($questions as $question)
                                <tr>
                                    <td>{{$question->user}}</td>
                                    <td>{{$question->question}}</td>
                                    <td>{{$question->answer}}</td>
                                    <td>{{$question->answered_at}}</td>
                                </tr>
                            @endforeach


                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
