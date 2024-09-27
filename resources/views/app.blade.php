<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ticket System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

   <style>
       .navbar-custom {
      background: linear-gradient(90deg, #023B6D, #6610f2);
      box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px;
    }

    .navbar-custom .navbar-brand {
      color: #fff;
      font-weight: bold;
      font-size: 1.5rem;
    }



    .navbar-toggler-icon {
      background-color: #1f9139a1;
      border-radius: 2px;
      color: #ffff
    }

    .btn-custom {
      background-color: #28a745;
      color: #fff;
      border-radius: 25px;
      padding: 7px 20px;
    }

    .btn-custom:hover {
      background-color: #11c738;
    }
   </style>
    @yield('css')
        
    
</head>

<body>

    @include('partials.header')

    <section>
        <div>
            @yield('content')
        </div>

    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>
