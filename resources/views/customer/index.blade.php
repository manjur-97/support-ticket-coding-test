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
        .ticket-card .dlt-btn {
            background-color: #d8291d;
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
                                        Edit Ticket
                                    </button>
                                @endif
                                <button type="button" class="btn btn-warning dlt-btn" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal-{{ $ticket->id }}">
                                    Delete
                                </button>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editModal-{{ $ticket->id }}" tabindex="-1"
                                    aria-labelledby="editModalLabel-{{ $ticket->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel-{{ $ticket->id }}">Edit Ticket
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Modal body content (e.g. a form) -->
                                                <form action="{{ route('tickets.update', $ticket->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <label for="issue_title-{{ $ticket->id }}">Issue Title</label>
                                                    <input type="text" class="form-control" name="issue_title"
                                                        id="issue_title-{{ $ticket->id }}"
                                                        value="{{ $ticket->issue_title }}">

                                                    <label for="description-{{ $ticket->id }}"
                                                        class="mt-3">Description</label>
                                                    <textarea class="form-control" name="description" id="description-{{ $ticket->id }}">{{ $ticket->description }}</textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Confirm</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="deleteModal-{{ $ticket->id }}" tabindex="-1"
                                    aria-labelledby="deleteModalLabel-{{ $ticket->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel-{{ $ticket->id }}">Edit
                                                    Ticket
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to delete this ticket?</p>
                                                <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-danger">Delete Ticket</button>
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
