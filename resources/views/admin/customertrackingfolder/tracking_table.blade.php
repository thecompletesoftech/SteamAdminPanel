<html>
        <head>
               <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
               <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
        </head>
</html>

<table class="table align-middle table-row-dashed fs-6 gy-5">

  <tr>
    <th>ID No.</th>
    <th>Service ID</th>
    <th>Generate</th>
    <th>Pending Assignment</th>
    <th>Assign Engineer</th>
    <th>Engineer Check</th>
    <th>Service Process</th>
    <th>Solve By Engineer</th>
    <th>Service Closed</th>
    <th>ACTION</th>
  </tr>

  @foreach($customertrack as $user)

  <tr>

    <td>{{$user->track_id}}</td>
    <td>{{$user->Service_request_id}}</td>
    <td>{{$user->service_generated}}</td>
    <td>{{$user->Pending_assignment}}</td>
    <td>{{$user->assign_engineer}}</td>
    <td>{{$user->engineer_checkin}}</td>
    <td>{{$user->service_process}}</td>
    <td>{{$user->solve_by_engineer}}</td>
    <td>{{$user->service_closed}}</td>


    <td>
        <a href="{{ url('/') }}/admin/customertrackings/{{$user->track_id}}/edit" title="Edit" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" >
                    <span class="svg-icon svg-icon-3">
                        <i class="fa fa-pen"></i>
                    </span>
        </a>
        <a href="{{ url('/') }}/admin/customertrackings/destroy/{{$user->track_id}}" title="Delete" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" >
                    <span class="svg-icon svg-icon-3">
                        <i class="fa fa-trash"></i>
                    </span>
        </a>
    </td>
  </tr>
  @endforeach
</table>
