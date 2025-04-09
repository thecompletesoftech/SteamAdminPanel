<html>
        <head>
               <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
               <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
        </head>
</html>


<form method="GET" action="{{ route('admin.managerregistrations.index') }}">
                                    <div class="py-2 flex">
                                        <div class="overflow-hidden flex pl-4">
                                            <input type="search" name="search" value="{{ request()->input('search') }}" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Search" style="height:3rem;">
                                            {{-- <button type='submit' '>
                                                {{ __('Search') }}
                                            </button> --}}

                                            <button type="submit" class="btn btn-primary"><i class="fa fa-search fa-sm"></i></button>


                                        </div>
                                    </div>
                                  </form>



<table class="table align-middle table-row-dashed fs-6 gy-5">

  <tr>
    <th>ID No.</th>
    <th>Location</th>
    <th>Image</th>
    <th>Name</th>
    <th>Phone</th>
    <th>Email</th>
    <th>About</th>
    <th>ACTION</th>
  </tr>

  @foreach($user as $data)

  <tr>

    <td>{{$data->id }}</td>
    <td>{{$data->location}}</td>
    <td>
        @if(!empty($data->image))
        <img src="{{ url('/') }}/uploads/{{$data->image}}" style="width:50px; height:50px;border-radius: 25px;" />
        @else
        <img src="{{ asset('blank_user.PNG') }}" style="width:50px; height:50px;border-radius: 25px;" />
        @endif
    </td>
    <td>{{$data->name}}</td>
    <td>{{$data->phone}}</td>
    <td>{{$data->email}}</td>



    <td>{{$data->about}}</td>

    <td>
        <a href="{{ url('/') }}/admin/managerregistrations/{{$data->id}}/edit" title="Edit" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" >
                    <span class="svg-icon svg-icon-3">
                        <i class="fa fa-pen"></i>
                    </span>
        </a>
        <a onclick="return confirm('Are you sure you want to delete Manager Data ?')"  href="{{ url('/') }}/admin/managerregistrations/destroy/{{$data->id}}" title="Delete" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" >
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
        {{ $user->links() }}
    </div>
</div>
