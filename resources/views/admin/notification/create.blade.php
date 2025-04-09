@extends('admin.layouts.base')
@section('content')
    @include('admin.layouts.components.header', [
        'title' => __('messages.create', ['name' => trans_choice('content.notification', 1)]),
        'breadcrumbs' => Breadcrumbs::render('admin.notifications.create'),
    ])

    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        
        <div id="kt_content_container" class="container">
            
            <div class="card">
              
                <div class="card-body">
                  
                    <div class="d-flex flex-column flex-lg-row">
                       
                        <div class="flex-lg-row-fluid me-0 me-lg-20">

                          
                            {!! Form::open(['route' => 'admin.notifications.store', 'method' => 'POST', 'class' => 'form', 'enctype' => 'multipart/form-data']) !!}

                            @include('admin.notification.form')
                            
                            <div class="card-footer d-flex justify-content-end py-6 px-9">
                                <a href="{{ route('admin.notifications.index') }}"
                                    class="btn btn-light btn-active-light-primary me-2 text-black">{{ __('content.back_title') }}</a>
                                <button type="submit" class="btn btn-primary">{{ __('content.create_title') }}</button>
                            </div>
                           

                            {!! Form::close() !!}
                            
                        </div>
                        
                    </div>
                   
                </div>
           
            </div>
            
        </div>
    
    </div>
   
@endsection
