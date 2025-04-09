<html>
        <head>
               <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
               <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
        </head>
</html>

<table class="table align-middle table-row-dashed fs-6 gy-5">

  <tr>
    <th>ID No.</th>
    <th>Customer Name</th>
    <th>Flow</th>
    <th>Pressure</th>
    <th>Temprature</th>
    <th>Totalizer</th>
    {{-- <th>Last Reding Time</th> --}}
    <th>Data/Time</th>
    <th>ACTION</th>
  </tr>

  @foreach($customerdata as $user)

  <tr>

    <td>{{$user->id}}</td>
    {{-- <td>{{$user->Manager}}</td> --}}
    <td>{{$user->customer_name}}</td>
    <td>{{$user->flow}}</td>
    <td>{{$user->pressure}}</td>
    <td>{{$user->temprature}}</td>
    <td>{{$user->totalizer}}</td>
    {{-- <td>{{$user->Last_reading_time}}</td> --}}
    <td>{{$user->updated_at}}</td>


    <td>
        <a href="{{ url('/') }}/admin/customerdatas/{{$user->id}}/edit" title="Edit" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" >
                    <span class="svg-icon svg-icon-3">
                        <i class="fa fa-pen"></i>
                    </span>
        </a>
        <a href="{{ url('/') }}/admin/customerdatas/destroy/{{$user->id}}" title="Delete" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" >
                    <span class="svg-icon svg-icon-3">
                        <i class="fa fa-trash"></i>
                    </span>
        </a>
    </td>
  </tr>
  @endforeach
</table>
