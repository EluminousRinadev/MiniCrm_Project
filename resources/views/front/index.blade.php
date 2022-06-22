@extends('front.layout.master')
@section('main_content')

<!-- Categories Start -->

<div class="container-fluid pt-5">

    <div class="row px-xl-5 pb-3">
        @foreach($company as $data)

        <div class="col-lg-4 col-md-6 pb-1">
            <div class="cat-item d-flex flex-column border mb-4" style="padding: 30px;">
                <p class="text-right">{{$data['name']}}</p>
                @php
                $companyDetails = url('/companyDetails').'/'.base64_encode($data['id'] ?? '');
                @endphp
                <a href="{{$companyDetails}}" class="cat-img position-relative overflow-hidden mb-3">
                    @if(isset($data['logo']) && !empty($data['logo']))
                    <img class="img-fluid" src="{{$logoPublicPath.$data['logo']}}" alt="">
                    @else
                    No Image
                    @endif

                </a>
                <h5 class="font-weight-semi-bold m-0"><a href="{{$data['website']}}" target="_blank">
                        website</a></h5>
            </div>
        </div>
        @endforeach
    </div>

</div>

<!-- Categories End -->
@endsection