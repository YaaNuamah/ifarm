@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="form-group row">
                        <div class="col-md-4">
                         Welcome To iFarms.
                        </div>
                        <div class="col-md-4">
                            <a class="btn btn-primary" href='/farms/create'>
                                Create a new farm
                            </a>
                        </div>
                    @if ($farms->count()>0)
                    <div class="col-md-4">
                            <a class="btn btn-success" href='/notify'>
                                Notify
                            </a>
                        </div>
                    @endif
                    </div>

                    <div class="form-group row ">
                        <div class="col-md-12">
                        @if ($farms->count())
                                <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                    <th scope="col">Farm</th>
                                    <th scope="col">Crop</th>
                                    <th scope="col">Location</th>
                                    <th scope="col">Number of Acres</th>
                                    <th scope="col">Date Cultivated</th>
                                    <th scope="col">Expected Harvest Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($farms as $farm)
                                    <tr>
                                    <th scope="row">{{ $farm->id }}</th>
                                    <td>{{$farm->crop}}</td>
                                    <td>{{$farm->gps}}</td>
                                    <td>{{$farm->size}}</td>
                                    <td>{{ gmdate("D d, m Y", strtotime($farm->date_started)) }}</td>
                                    <td>{{ gmdate("D d, m Y", strtotime($farm->date_harvest)) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                                </table>

                        @else 
                            No farms found
                        @endif
                        </div>
                    </div>
                   
            </div>
        </div>
    </div>
</div>
@endsection
