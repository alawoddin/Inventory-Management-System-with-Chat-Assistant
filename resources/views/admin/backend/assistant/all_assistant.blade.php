@extends('admin.admin_master')
@section('admin')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid my-0">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">All assistant</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <a href="{{ route('add.assistants') }}" class="btn btn-secondary">Add assistant</a>
                    </ol>
                </div>
            </div>

            <!-- Datatables  -->
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Assistants</h5>
            </div><!-- end card header -->

            <div class="card-body">
                <div class="row g-3">
                    @foreach ($assistant as $item)  
                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="card h-100 text-center border-0 shadow-sm">
                                <div class="card-body">
                                    <a href="{{ route('chat-assistants.chat',$item->id) }}" class="text-decoration-none text-dark">
                                        <div class="mb-3">
                                            <img src="{{ (!empty($item->avatar)) ? url('upload/avatar/'.$item->avatar) : url('upload/no_image.jpg') }}"
                                                 class="rounded-circle img-fluid border"
                                                 style="width: 100px; height: 100px; object-fit: cover;">
                                        </div> 
                                        <h5 class="fw-semibold">{{ $item->name }}</h5>
                                        <p class="small text-muted mb-0">{{ $item->role_description }}</p>
                                    </a>
                                </div>
                            </div>
                        </div><!-- .col -->
                    @endforeach
                </div><!-- .row -->
            </div><!-- .card-body -->

        </div><!-- .card -->
    </div><!-- .col-12 -->
</div><!-- .row -->




        </div> <!-- container-fluid -->

    </div> <!-- content -->
@endsection
