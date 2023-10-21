@extends('admin.admin_dashboard')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <div class="page-content">

        <div class="row profile-body">
            <div class="col-md-8 col-xl-8 middle-wrapper">
                <div class="row">
                    <div class="card">
                        <div class="card-body">

                            <h6 class="card-title">Edit Amenities </h6>

                            <form method="post" action="{{ route('update.amenities') }}" class="forms-sample">
                                @csrf

                                <input type="hidden" name="id" value="{{ $amenities->id }}">
                                <div class="mb-3">
                                    <label for="amenities_name" class="form-label">Amenities Name</label>
                                    <input type="text" name="amenities_name" class="form-control" value="{{ $amenities->amenities_name }}">
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
