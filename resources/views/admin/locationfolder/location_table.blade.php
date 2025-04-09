<html>
        <head>
               <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
               <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
        </head>
</html>

<table class="table align-middle table-row-dashed fs-6 gy-5">

  <tr>
    <th>ID No.</th>
    <th>Location</th>
    <th>ACTION</th>
  </tr>

  @foreach($location as $user)

  <tr>

    <td>{{$user->location_id }}</td>
    <td>{{$user->location}}</td>
    <td>
        <a href="{{ url('/') }}/admin/locations/{{$user->location_id}}/edit" title="Edit" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" >
                    <span class="svg-icon svg-icon-3">
                        <i class="fa fa-pen"></i>
                    </span>
        </a>
        <a  onclick="return confirm('Are you sure you want to delete ?')"  href="{{ url('/') }}/admin/locations/destroy/{{$user->location_id}}" title="Delete" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" >
                    <span class="svg-icon svg-icon-3">
                        <i class="fa fa-trash"></i>
                    </span>
        </a>
    </td>
  </tr>
  @endforeach
</table>

<div class="row">
    <div class="col-lg-12">
        {{ $location->links() }}
    </div>
</div>
