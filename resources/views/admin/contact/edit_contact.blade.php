@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Blog Category  Page </h4>
                            <br>
                            <br>

                            <form method="post" action="{{ route('update.message',$contact->id) }}">
                                @csrf

                                <input type="hidden" name="id" value="{{ $contact->id }}">
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Name : </label>
                                    <div class="col-sm-10">
                                        <input name="name" class="form-control" type="text" value="{{ $contact->name }}"  id="example-text-input">
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Email : </label>
                                    <div class="col-sm-10">
                                        <input name="email" class="form-control" type="email" value="{{ $contact->emal }}"  id="example-text-input">
                                    </div>
                                </div>
                                <!-- end row -->
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Subject : </label>
                                    <div class="col-sm-10">
                                        <input name="subject" class="form-control" type="text" value="{{ $contact->subject }}"  id="example-text-input">
                                    </div>
                                </div>
                                <!-- end row -->
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Phone : </label>
                                    <div class="col-sm-10">
                                        <input name="phone" class="form-control" type="text" value="{{ $contact->phone }}"  id="example-text-input">
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Message : </label>
                                    <div class="col-sm-10">
                                           <textarea id="elm1" required="" name="message" class="form-control" rows="5">
                                            {{ $contact->message }}
                                        </textarea>
                                    </div>
                                </div>

                                <input type="submit" class="btn btn-info waves-effect waves-light" value="Update Contact">
                            </form>



                        </div>
                    </div>
                </div> <!-- end col -->
            </div>



        </div>
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
