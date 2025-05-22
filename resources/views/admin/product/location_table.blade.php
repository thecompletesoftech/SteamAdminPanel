<html>
        <head>
               <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
               <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
        </head>
</html>

<table class="table align-middle table-row-dashed fs-6 gy-5">

  <tr>
    <th>ID No.</th>
    <th>product Uploaded By</th>
    <th>Vendor Name</th>
    <th>product category</th>
    <th>product name</th>
    <th>product_image</th>
    <th>product_price</th>
    <th>product_specification</th>
    <th>product_stock</th>
    
  
    <th>ACTION</th>
  </tr>
  <?php $i=1 ; ?>
  @foreach($location as $user)

  <tr>

    <td>{{$i++ }}</td>
    <td>{{$user->cat_name }}</td>
    <td><a href="{{$user->uploaded_by==0?'#':'##'}}">{{$user->uploaded_by==0?'Admin':'Vendor' }}</a></td>
    
    <td>{{$user->product_name }}</td>
    <td><img src="{{ url('/') }}/{{$user->product_image }}" height="100"/></td>
    <td>{{$user->product_price }}</td>
    <td>{{$user->product_specification	 }}</td>
    <td>{{$user->product_stock }}</td>
    
    <td>
        <a href="{{ url('/') }}/admin/locations/edit/{{$user->id}}" title="Edit" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" >
                    <span class="svg-icon svg-icon-3">
                        <i class="fa fa-pen"></i>
                    </span>
        </a>
    
        <a href="{{ url('/') }}/admin/locations/status/{{$user->id}}/{{$user->product_status==0?1:0}}" title="Edit" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" >
                    <span class="svg-icon svg-icon-3">
                        <i class='fa {{$user->product_status==0?"fa-thumbs-up":"fa-thumbs-down"}} ' style='color:{{$user->product_status==0?"green":"red"}}'></i>
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
