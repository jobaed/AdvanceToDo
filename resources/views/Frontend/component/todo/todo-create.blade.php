<div class="modal" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <form id="inserToDo">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Customer</h5>
                </div>
                <div class="modal-body">



                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">

                                <input type="hidden" id="update_id" value="">

                                <label class="form-label">Title *</label>
                                <input type="text" class="form-control" id="title"
                                    placeholder=":Enter Your Work , Event">

                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label">Expire Date *</label>
                                        <input type="date" class="form-control" id="exp_date">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Expire Time *</label>
                                        <input type="time" class="form-control" id="exp_time">
                                    </div>
                                </div>

                                <div class="" id="completewrapper">
                                    <label class="form-label">Complete *</label>
                                    <select name="" id="complete" class="form-control">
                                        <option value="0">Unfinished</option>
                                        <option value="1" selected>Finish</option>
                                    </select>
                                </div>
                                    
                                

                                <label class="form-label">Description</label>
                                <textarea name="" class="form-control" id="description" cols="30" rows="5"></textarea>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="CloseCreateTodo" class="btn  btn-sm btn-danger" data-bs-dismiss="modal"
                        aria-label="Close">Close</button>
                    <button type="submit" class="btn btn-sm  btn-success">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>


<script>
    $("#CloseCreateTodo").on('click', function(e) {

        e.preventDefault();
        $('#create-modal').modal('hide');
        $("#inserToDo").trigger("reset");
        document.getElementById('update_id').value = '';

    });

    $("#inserToDo").on('submit', async function(e) {

        let update_id = document.getElementById('update_id').value;
        // alert(update_id);

        e.preventDefault();

        let title = document.getElementById('title').value;
        let exp_date = document.getElementById('exp_date').value;
        let exp_time = document.getElementById('exp_time').value;
        let  complete = document.getElementById('complete').value;
        let description = document.getElementById('description').value;
        let Userdata = {};

        // alert(complete);

        if (title.length === 0) {
            errorToast("Title Required !");
        } else if (exp_date.length === 0) {
            errorToast("Expire Date Required !");
        } else if (exp_time.length === 0) {
            errorToast("Expire Time Required !");
        } else if (description.length === 0) {
            errorToast("Description Date Required !");
        } else {
            if (update_id == "") {

                if (title === '') {
                    errorToast("Title Required");
                } else if (description === '') {
                    Userdata = {
                        title: title,
                        exp_date: exp_date,
                        exp_time: exp_time
                    };
                } else {
                    Userdata = {
                        title: title,
                        exp_date: exp_date,
                        exp_time: exp_time,
                        description: description
                        
                    };
                }

                console.log(Userdata);

                showLoader();
                let res = await axios.post('/create-todo', Userdata);
                hideLoader();

                console.log(res.data);

                if (res.data.status == "success") {
                    getList();
                    $('#create-modal').modal('hide');
                    $("#inserToDo").trigger("reset");
                    successToast('Todo Added Successfull');
                } else if (res.data.status == "error") {
                    errorToast(res.data.message);
                }


            } else {

                let id = document.getElementById('update_id').value;

                if (title === '') {
                    errorToast("Title Required");
                } else if (description === '') {
                    Userdata = {
                        id: id,
                        title: title,
                        exp_date: exp_date,
                        exp_time: exp_time,
                        completed: complete
                    };
                } else {
                    Userdata = {
                        id: id,
                        title: title,
                        exp_date: exp_date,
                        exp_time: exp_time,
                        description: description,
                        completed: complete
                    };
                }

                console.log(Userdata);

                showLoader();
                let res = await axios.post('/update-todo', Userdata);
                hideLoader();

                console.log(res);

                if (res.data.status == "success") {
                    getList();
                    $('#create-modal').modal('hide');
                    $("#inserToDo").trigger("reset");
                    successToast('Todo Added Successfull');
                } else if (res.data.status == "error") {
                    errorToast(res.data.message);
                }

            }
        }




    });
</script>
