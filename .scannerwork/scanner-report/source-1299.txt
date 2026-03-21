@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid my-0">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Add Assistant</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">

                        <li class="breadcrumb-item active">Add Assistant</li>
                    </ol>
                </div>
            </div>

            <!-- Form Validation -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Add Brand</h5>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <form action="{{ route('store.assistants') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="row g-3 gx-gs">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlInputText1" class="form-label">Select Chat
                                                Assistants Avater </label>
                                            <div class="form-control-wrap">
                                                <input type="file" name="avatar" class="form-control">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlInputText1" class="form-label">Active Chat
                                                Assistant </label>
                                            <div class="form-control-wrap">
                                                <input type="checkbox" name="is_active" value="1">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlInputText1" class="form-label">Chat Assistant Name
                                            </label>
                                            <div class="form-control-wrap">
                                                <input type="text" name="name" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlInputText1" class="form-label">Chat Assistant Role
                                                Description </label>
                                            <div class="form-control-wrap">
                                                <input type="text" name="role_description" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlInputText1" class="form-label">Chat Assistant
                                                Welcome Message </label>
                                            <div class="form-control-wrap">
                                                <input type="text" name="welcome_message" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="category" class="form-label">Chat Assistant Group </label>
                                            <div class="form-control-wrap">
                                                <select name="category" class="form-select" id="category"
                                                    aria-label="Default select example">
                                                    <option selected="">Open this select menu</option>
                                                    <option value="Business">Business</option>
                                                    <option value="Education">Education</option>
                                                    <option value="Health">Health</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleFormControlInputText1" class="form-label">Chat Instructions
                                            </label>
                                            <div class="form-control-wrap">
                                                <textarea name="instructions" placeholder="Explain in details what AI Chat Assistant Needs to do.." class="form-control"
                                                    rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-lg-12 col-xl-12">
                                        <button type="submit" class="btn btn-secondary">Save Changes</button>
                                    </div>


                                </div>
                            </form>
                        </div> <!-- end card-body -->
                    </div> <!-- end card-->
                </div> <!-- end col -->


            </div>



        </div> <!-- container-fluid -->

    </div>



    <script type="text/javascript">
        $(document).ready(function() {
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            })
        })
    </script>
@endsection
