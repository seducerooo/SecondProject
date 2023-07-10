@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Multi  Image  All</h4>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Multi  Image  All</h4>
                            <br>

                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>About Multi Image</th>
                                    <th>Action</th>
                                </tr>
                                </thead>


                                <tbody>
                                @foreach($allMultiImage as $item)

                                <tr>
                                  <td>{{ $item->id }}</td>
                                  <td><img id="showImage" width="60px" height="60px" src="{{ asset($item->multi_image) }}"></td>
                                  <td>{{ $item->created_at }}</td>
                                    <td>
                                        <a href="{{ route('edit.multi.image',$item->id) }}" class="btn btn-info sm" title="Edit Data"><i class="fas fa-ad"></i> </a>

                                         <form class="btn btn-danger sm"  action="{{ route('delete.multi.image',$item->id) }}" method="post">
                                             @csrf
                                             @method('DELETE')
                                             <i class="fas fa-trash-alt">
                                             <input type="submit" class="btn btn-danger sm" value="">
                                             </i>
                                         </form>
{{--                                        <a  href="{{ route('delete.multi.image',$item->id) }}" class="btn btn-danger sm" title="Delete Data"><i class="fas fa-trash-alt"></i> </a>--}}
                                    </td>
                                </tr>

                                @endforeach

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->



            </div> <!-- container-fluid -->
    </div>


    <script type="text/javascript">

        $(document).ready(function(){
            $('#image').change(function(e){
                var reader = new FileReader();
                reader.onload = function(e){
                    $('#showImage').attr('src',e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });

    </script>

@endsection
