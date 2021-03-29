@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="css/category.css" type="text/css"> 
<body style="background-image: url('/images/insertCategory.png');">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Insert New Category</div>

                    <div class="card-body">
                    <form class="subform"  method="post" action="{{ route('addCategory') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="ID" class="col-md-4 col-form-label text-md-right">Category ID</label>

                                <div class="col-md-6">
                                    <input id="ID" type="text" name="ID" autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" name="name">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <input type="submit" name="insert" value="Insert" class="btn btn-primary">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection