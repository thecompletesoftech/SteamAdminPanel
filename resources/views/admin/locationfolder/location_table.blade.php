<html>
        <head>
               <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
               <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
        </head>
</html>

<table class="table align-middle table-row-dashed fs-6 gy-5">

  <tr>
    <th>ID No.</th>
    <th>{{ trans_choice('content.location', 1)}}</th>
    <th>{{ trans_choice('content.isImmidate', 1)}}</th>
    <th>ACTION</th>
  </tr>
  <?php $i=1 ; ?>
  @foreach($location as $user)

  <tr>

    <td>{{$i++ }}</td>
    <td>{{$user->service_name }}</td>
    <td>{{$user->immidate}}</td>
    <td>
        <a href="{{ url('/') }}/admin/locations/edit/{{$user->id}}" title="Edit" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" >
                    <span class="svg-icon svg-icon-3">
                        <i class="fa fa-pen"></i>
                    </span>
        </a>
    
        <a href="{{ url('/') }}/admin/locations/status/{{$user->id}}/{{$user->status==0?1:0}}" title="Edit" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" >
                    <span class="svg-icon svg-icon-3">
                        <i class='fa {{$user->status==0?"fa-thumbs-up":"fa-thumbs-down"}} ' style='color:{{$user->status==0?"green":"red"}}'></i>
                    </span>
        </a>
        <a  onclick="return confirm('Are you sure you want to delete ?')"  href="{{ url('/') }}/admin/locations/destroy/{{$user->id}}" title="Delete" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" >
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
