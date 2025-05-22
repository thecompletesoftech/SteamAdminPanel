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
    <th>Sub-Sevices</th>
    <th>Choices</th>
    <th>Link With Product</th>
    <th>Product Category</th>
    <th>ACTION</th>
  </tr>
  <?php $i = 1; ?>
  {{$location}}
  @foreach($location as $user)

  <tr>

    <td>{{$i++ }}</td>
    <td>{{$user->service_name }}</td>
    <td>{{$user->sub_service_name }}</td>
    <td>{{ str_replace('"sub_service_data":',"", $user->sub_services_data )}}</td>
    <?php $searchVal = array('link_with_product":"0"', '"link_with_product":"1"');

    // Array containing replace string from  search string
    $replaceVal = array("Yes", "No"); ?>
    <td>{{ str_replace($searchVal,$replaceVal, $user->link_with_product) }}</td>

    <td>{{ str_replace('"cat_name":',"", $user->link_with_category )}}</td>
    <td>
      <a href="{{ url('/') }}/admin/subservices/edit/{{$user->sub_id}}" title="Edit" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
        <span class="svg-icon svg-icon-3">
          <i class="fa fa-pen"></i>
        </span>
      </a>
      <a onclick="return confirm('Are you sure you want to delete ?')" href="{{ url('/') }}/admin/subservices/destroy/{{$user->sub_id}}" title="Delete" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
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