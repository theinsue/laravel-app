@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3>{{ $news->title}} </h3>
                    </div>

                    <div class="panel-body">
                        {!! $news->description !!}
                    </div>

                    <div class="panel-body">
                        <div class="text-right">
                            <p>by {{ $news->creator  }}</p>

                            <p>{{ Carbon\Carbon::parse($news->pubDate)->format('d-m-Y')  }}</p>
                        </div>

                        <p><i><b>Source </b>-
                            <a href="{{ $news->link }}">{{ $news->link }}</a></i>
                        </p>
                        <hr/>
                        <p>
                            <a href="{{ URL::previous()  }}"><< previous</a>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection


