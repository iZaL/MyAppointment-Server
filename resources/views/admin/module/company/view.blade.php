@extends('admin.layouts.two-col')

@section('breadcrumb')
    <div class="banner">
        <h2>
            <a href="/admin">Home</a>
            <i class="fa fa-angle-right"></i>
            <a href="{{action('Admin\CompanyController@index')}}">Companies</a>
            <i class="fa fa-angle-right"></i>
            <span>{{ $company->name }}</span>
        </h2>
    </div>
@endsection

@section('js')
    @parent
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
    <script src="/adminpanel/js/address.picker.js"></script>
    <script>
        $(function () {
            var latitude = '{{ $company->latitude ? : '29.357' }}';
            var longitude = '{{ $company->longitude ? : '47.951' }}';

            get_map(latitude, longitude);

            var addresspickerMap = $("#addresspicker_map").addresspicker({
                updateCallback: showCallback,
                elements: {
                    map: "#map",
                    lat: "#latitude",
                    lng: "#longitude"
                }
            });

            var gmarker = addresspickerMap.addresspicker("marker");
            gmarker.setVisible(true);
            addresspickerMap.addresspicker("updatePosition");

            $('#reverseGeocode').change(function () {
                $("#addresspicker_map").addresspicker("option", "reverseGeocode", ($(this).val() === 'true'));
            });

            function showCallback(geocodeResult, parsedGeocodeResult) {
                $('#callback_result').text(JSON.stringify(parsedGeocodeResult, null, 4));
            }
        });
    </script>
@endsection

@section('left')
    @include('admin.module.company.sidebar',['active' =>'info', 'record'=>$company])
    <hr>
    <div class="panel-heading">
        <h1>
            Edit : {{ $company->name }}
        </h1>
    </div>
    @include('admin.module.company.edit-form',['active' =>'info', 'company'=>$company,'cities'=>$cities,'timings'=>$timings])
@endsection

@section('right')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1>
                {{ $company->name }}
            </h1>
        </div>
    </div>
    <div class="panel-body">
        <table class="table table-user-information">
            <tbody>
            <tr>
                <img src="{{ $company->image }}" class="img img-responsive img-circle img-thumbnail center-block" style="width: 150px; height: 150px"/>

                <th>Description</th>
                <td>{{ $company->description }}</td>
            </tr>
            <tr>
                <th>City</th>
                <td>{{ $company->city }}</td>
            </tr>
            <tr>
                <th>Address</th>
                <td>{{ $company->address }}</td>
            </tr>
            <tr>
                <th>Open/Close Time</th>
                <td>{{ $company->opens_at }} - {{ $company->closes_at }}</td>
            </tr>
            <tr>
                <th>Week Holiday</th>
                <td>{{ $company->holidays }}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="panel-footer ">
        <a data-toggle="tooltip" href="{{ action('Admin\CompanyController@edit',$company->id) }}" data-original-title="Edit Company" type="button" class="btn btn-sm btn-warning"><i class="fa fa-2x fa-edit"></i></a>
        <a href="#" data-link="{{ action('Admin\CompanyController@destroy',$company->id) }}" data-target="#deleteModalBox" data-original-title="Delete Company" data-toggle="modal" type="button" class="btn btn-sm btn-danger"><i class="fa fa-2x fa-remove"></i></a>
    </div>
    @include('admin.partials.delete-modal',['info' => 'This will delete company and related records (employees,services) etc .'])

@endsection
