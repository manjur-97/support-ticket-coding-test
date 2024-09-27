@extends('app')

@section('content')
    @if (Auth::user()->role == 'customer')
        <section class="mt-5">
            <div class="mask d-flex align-items-center ">
                <div class="container">

                    <div class="row d-flex justify-content-center align-items-center ">
                        <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <div class="card" style="border-radius: 15px;">
                                <div class="card-body p-5">
                                    <h2 class="text-uppercase text-center mb-5">Create a ticket</h2>

                                    <form action="{{ route('tickets.store') }}" method="POST">
                                        @csrf

                                        <div class="form-group m-2">
                                            <label for="issue_title">Issue Title</label>
                                            <input type="text" name="issue_title" id="issue_title" class="form-control"
                                                value="{{ old('issue_title') }}">
                                            @if ($errors->has('issue_title'))
                                                <span style="color: red;">{{ $errors->first('issue_title') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group m-2">
                                            <label for="description">Description</label>
                                            <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                                            @if ($errors->has('description'))
                                                <span style="color: red;">{{ $errors->first('description') }}</span>
                                            @endif
                                        </div>

                                        <button type="submit" class="btn btn-primary m-2">Open Ticket</button>
                                        <a href="{{url('/customer')}}"  class="btn btn-warning m-2">Cancle</a>
                                        
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @else
        <section class="container mt-5">
            <h4 class="text-center">Admin Can't Open Ticket</h4>
            <a href="{{url('/admin')}}"><p class="text-center ">View Tickets</p></a>
            
        </section>
    @endif
@endsection
