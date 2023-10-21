@extends('admin.admin_dashboard')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <div class="page-content">

        <div class="row profile-body">
            <div class="col-md-8 col-xl-8 middle-wrapper">
                <div class="row">
                    <div class="card">
                        <div class="card-body">

                            <h6 class="card-title">Add Property Type </h6>

                            <form method="post" action="{{ route('store.type') }}" class="forms-sample">
                                @csrf

                                <div class="mb-3">
                                    <label for="type_name" class="form-label">Type Name</label>
                                    <input type="text" name="type_name" class="form-control @error('type_name') is-invalid @enderror">
                                    @error('type_name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="type_icon" class="form-label">Type Icon</label>
                                    <input type="text" name="type_icon" class="form-control @error('type_icon') is-invalid @enderror">
                                    @error('type_icon')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary me-2">Save Changes </button>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

@endsection
