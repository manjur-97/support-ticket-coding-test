@extends('app')
@section('css')
    <style>
        /* General Card Styling */
        .ticket-card {
            background: linear-gradient(90deg, #7eacd448, #6710f24f);
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            position: relative;
            padding: 15px;
            box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;
        }


        .ticket-status {
            position: absolute;
            top: 20px;
            left: 25px;


        }

        .ticket-card .badge {
            background-color: #17a2b8;
            font-size: 14px;
            padding: 8px 12px;
            border-radius: 20px;
            color: white;


        }

        .ticket-card .ticket-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #343a40;
            margin-top: 30px;
        }

        .ticket-card .ticket-description {
            font-size: 1rem;
            color: #6c757d;
            margin-bottom: 20px;
        }

        .ticket-card .text-muted {
            font-size: 0.9rem;
            color: #adb5bd;
            margin-bottom: 10px;
        }

        .ticket-card .edit-btn {
            background-color: #11C738;
            color: #ffffff;
            border: none;
            font-weight: 600;
            padding: 8px 15px;
            border-radius: 10px;
            box-shadow: rgba(240, 46, 170, 0.2) 5px 5px, rgba(240, 46, 170, 0.1) 10px 10px;
        }

        .ticket-card .edit-btn:hover {
            background-color: #dfab0f;
        }
    </style>
@endsection

@section('content')
    <div class="container  mt-5">
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

        @if ($tickets->count() > 0)
            <div class="row">
                @foreach ($tickets as $ticket)
                    <div class="col-12 col-md-6 col-lg-4">

                        <div class="ticket-card card mb-4">
                            <div class="ticket-status">
                                <span class="badge {{ $ticket->status == 'closed' ? 'bg-success' : 'bg-info' }}">
                                    {{ $ticket->status }}
                                </span>
                            </div>
                            <div class="card-body">
                                <h5 class="ticket-title">{{ $ticket->issue_title }}</h5>
                                <p class="ticket-description">{{ $ticket->description }}</p>

                                <p class="text-muted">Submitted by:
                                    <strong>{{ $ticket->customer->name ?? 'Unknown Customer' }}</strong>
                                </p>
                                @if ($ticket->feedback)
                                    <p class="text-muted"><em>Feedback:</em> {{ $ticket->feedback }}</p>
                                @endif

                                @if ($ticket->status == 'open')
                                    <button type="button" class="btn btn-warning edit-btn" data-bs-toggle="modal"
                                        data-bs-target="#editModal-{{ $ticket->id }}">
                                        Close Ticket
                                    </button>
                                @endif

                                <div class="modal fade" id="editModal-{{ $ticket->id }}" tabindex="-1"
                                    aria-labelledby="modalLabel-{{ $ticket->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalLabel-{{ $ticket->id }}">Feedback</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('tickets.close') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

                                                    <label for="feedback-{{ $ticket->id }}">Feedback</label>
                                                    <textarea class="form-control" name="feedback" id="feedback-{{ $ticket->id }}" required></textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancle</button>
                                                <button type="submit" class="btn btn-primary">Confirm</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>


                    </div>
                @endforeach
            </div>
        @else
            <h4 class="text-center">No Tickets Available</h4>
        @endif

    </div>
@endsection

{{-- @section('content')
    <div class="container">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="row mt-5">

            @if ($tickets->count() > 0)
                @foreach ($tickets as $ticket)
                    <div class="col-4">
                        <div class="card mb-4">

                            <span class="badge {{ $ticket->status == 'closed' ? 'bg-success' : 'bg-info' }} ">
                                <h5 class="card-header"> {{ $ticket->status }}</h5>
                            </span>
                            <div class="card-body">
                                <h5>{{ $ticket->issue_title }}</h5>
                                <p class="card-text">{{ $ticket->description }}</p>

                                <p class="text-muted">
                                    Submitted by: {{ $ticket->customer->name ?? 'Unknown Customer' }}
                                </p>
                                @if ($ticket->feedback)
                                    <p class="text-muted">
                                        Feedback: {{ $ticket->feedback }}
                                    </p>
                                @endif

                                @if ($ticket->status == 'open')
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#closeModal-{{ $ticket->id }}">
                                        Close Ticket
                                    </button>
                                @else
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Modal for closing ticket -->
                    <div class="modal fade" id="closeModal-{{ $ticket->id }}" tabindex="-1"
                        aria-labelledby="modalLabel-{{ $ticket->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalLabel-{{ $ticket->id }}">Feedback</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('tickets.close') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

                                        <label for="feedback-{{ $ticket->id }}">Feedback</label>
                                        <textarea class="form-control" name="feedback" id="feedback-{{ $ticket->id }}" required></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancle</button>
                                    <button type="submit" class="btn btn-primary">Confirm</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <h4 class="text-center">No Tickets Available</h4>
            @endif

        </div>
    </div>
@endsection --}}
