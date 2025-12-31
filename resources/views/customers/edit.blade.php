@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Edit Customer</span>
                    <a href="{{ route('customers.index') }}" class="btn btn-sm btn-secondary">Back</a>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label for="name">Name *</label>
                            <input type="text" name="name" class="form-control" value="{{ $customer->name }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="address">Address</label>
                            <input type="text" name="address" class="form-control" value="{{ $customer->address }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label>Customer Registration type *</label>
                            <select name="registration_type" class="form-control" required>
                                <option value="Registered" {{ $customer->registration_type == 'Registered' ? 'selected' : '' }}>Registered</option>
                                <option value="Unregistered" {{ $customer->registration_type == 'Unregistered' ? 'selected' : '' }}>Unregistered</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="phone">Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ $customer->phone }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="ntn_cnic">NTN / CNIC</label>
                            <input type="text" name="ntn_cnic" class="form-control" value="{{ $customer->ntn_cnic }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="province">Destination Provice</label>
                            <input type="text" name="province" class="form-control" value="{{ $customer->province }}" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Customer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
