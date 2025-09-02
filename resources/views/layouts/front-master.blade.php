<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forever MedSpa - Book an Appointment</title>
    <link rel="stylesheet" href="{{url('/medspatemplate/css')}}/styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
     @stack('csslink')
     
         @stack('css')
         <link rel="shortcut icon" href="{{url('/medspa.png')}}" type="image/x-icon" />
    <link rel="apple-touch-icon" href="{{url('/medspa.png')}}" />
     
</head>

<body>
    <!-- Page Header -->
<//x-front_header/>

    <div class="background-pattern"></div>
    @yield('body')
    
    <!-- Website Footer -->
<//x-footer/>

  <script src="{{url('/medspatemplate/js')}}/script.js"></script>
    @stack('footerscript')

</body>

</html>
