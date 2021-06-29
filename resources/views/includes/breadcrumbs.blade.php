<!-- ======================== page title =========================== -->
<section class="page-title page-title-layout5 bg-overlay">
    <div class="bg-img">
        <img src="{{ asset('assets/images/page-titles/8.jpg') }}" alt="background" />
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="pagetitle__heading">Health Essentials</h1>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        @if(isset($category) && !empty($category))
                            <li class="breadcrumb-item active" aria-current="page">{{ ucfirst($category) }}</li>
                        @endif
                    </ol>
                </nav>
            </div>
            <!-- /.col-12 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
</section>
<!-- /.page-title -->