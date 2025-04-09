<html>
        <head>
               <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
               <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
        </head>
</html>

<table class="table align-middle table-row-dashed fs-6 gy-5">

  <tr>
    <th>ID No.</th>
    <th>Manager</th>
    <th>Employee Name</th>
    {{-- <th>Image</th> --}}
    <th>Expert</th>
    <th>Phone</th>
    <th>ACTION</th>
  </tr>

  @foreach($employee as $user)
  <tr>
    <td>{{$user->emp_id}}</td>
    <td>{{$user->name}}</td>
    <td>{{$user->emo_name}}</td>
    {{-- <td><img src="{{ url('/') }}/employees/image/{{$user->emp_img}}" style="width:50px; height:50px;" /></td> --}}
    <td>{{$user->emo_expert}}</td>
    <td>{{$user->emo_contact}}</td>
    <td>
        <a href="{{ url('/') }}/admin/employees/{{$user->emp_id}}/edit" title="Edit" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" >
                    <span class="svg-icon svg-icon-3">
                        <i class="fa fa-pen"></i>
                    </span>
        </a>
        <a href="{{ url('/') }}/admin/employees/destroy/{{$user->emp_id}}" title="Delete" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" >
                    <span class="svg-icon svg-icon-3">
                        <i class="fa fa-trash"></i>
                    </span>
        </a>
    </td>
  </tr>
  @endforeach
</table>
