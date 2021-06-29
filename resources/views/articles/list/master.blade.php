@extends('layouts.app')

@section('content')
    {{-- {{ dump($category) }} --}}
    @include('includes.breadcrumbs')
    
    <!-- ====================== Blog Grid ========================= -->
    <section class="blog-grid @if(!isset($home)) lg:hidden @endif">
        <div class="container">
            <div class="row"  data-page="{{ ($page ? $page + 1 : 2) . (request()->get('q') ? '&q=' . request()->get('q') : '') }}">
                
                @include('articles.list.' . $view)

                @if($articles->count() === 19)
                    @include('includes.load-more')
                @endif
    
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-12 text-center">
                    <nav class="pagination-area">
                        <ul class="pagination justify-content-center">
                            <li><a class="current" href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li>
                                <a href="#"><i class="icon-arrow-right"></i></a>
                            </li>
                        </ul>
                    </nav>
                    <!-- .pagination-area -->
                </div>
                <!-- /.col-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </section>
    <!-- /.blog Grid -->
@stop

@section('schema')
    @include('includes.microdata.items')
@stop
