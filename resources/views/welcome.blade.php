@extends('app')

@section('css')
    <style>
       

       .ticket-open-btn, .btn-custom-login-reg {
            padding: 5px 20px;
            margin-left: 10px;
            color: #dff0ff;
            text-decoration: none;
            background-color: #0a65b4;
            border-radius: 5px;

        }

        
        .ticket-open-btn:hover, .btn-custom-login-reg:hover {
           
            background-color: #2d96f1;
           

        }
    </style>
@endsection
@section('content')
<div class="container py-5">
    <div class="row justify-content-center text-center">
        <h1>Welcome to Support Ticket System</h1>
    </div>

    <div class="row justify-content-center mt-4 ">
        <div class="col-lg-6">
            <div class=" p-4 bg-white shadow-lg rounded">

                <h2 class="text-center text-success">About Our Service</h2>

                <p class="mt-3 text-muted text-center">
                    This service allows customers to easily open support tickets to submit their issues. Tickets
                    are visible to both customers and admins, ensuring transparent communication. Admins receive
                    email notifications when a ticket is opened. They can reply to
                    customers' concerns and close tickets once resolved, triggering an email notification to the
                    customer. If needed, customers can open new tickets to address further issues, ensuring
                    continuous support.
                </p>

            </div>
        </div>
    </div>


</div>
@endsection

</html>
