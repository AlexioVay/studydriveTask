@extends('app')

@section('main')
    @parent
    <div class="container">
        @if ($project)
            <i class="material-icons amaranth">favorite</i> <h2>{{ __('home.most_liked_img') }}</h2>
        @else
            <i class="material-icons">face</i> <h2>{{ __('home.most_user_likes') }}</h2>
        @endif


        <div id="content">

            <div id="app">
              <paginate
                :page-count="5"
                :container-class="pagination"
                :prev-text="prev"
                :next-text="next"
                :click-handler="paginateCallback">
              </paginate>
            </div>

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

        </div>
    </div>
@endsection

@section('title', 'Home Title')
