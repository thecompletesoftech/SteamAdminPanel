<table class="table align-middle table-row-dashed fs-6 gy-5">
  <tr>
    <th>Sr No.</th>
    <th>Date</th>

    <th>Start Time</th>
    <th colspan="3" class="text-center">End Time</th>
    <th colspan="2" class="text-center">ACTION</th>
  </tr>
  @foreach($set_availablitys as $availablity)

  <tr>
    <td>{{$availablity->id}}</td>
    <td>
    {{$availablity->date}}
  </td>

    <td>{{$availablity->start_time}}</td>
    <td>
    {{$availablity->end_time}}
    </td>
    
    
  <td>
  <a href="{{ url('/') }}/admin/users/destroy/{{$user->id}}" title="Delete" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" >
                <span class="svg-icon svg-icon-3" >
                    <i class="fa fa-trash"></i>
                </span>
            </a>
  </td>
   
  </tr>
  @endforeach
</table>
<div class="row">
<div class="col-lg-12">
  {{ $set_availablitys->links() }}
         </div>
</div>