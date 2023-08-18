<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between ">
                    <div class="align-items-center col">
                        <h4>Pending To Do</h4>
                    </div>
                    <div class="align-items-center col">
                        <button data-bs-toggle="modal" data-bs-target="#create-modal"
                            class="float-end btn m-0 btn-sm bg-gradient-primary" id="createTodo">Create</button>
                    </div>
                </div>
                <hr class="bg-dark " />
                <table class="table" id="tableData">
                    <thead>
                        <tr class="bg-light">
                            <th>No</th>
                            <th>Title</th>
                            <th>Expire Time</th>
                            <th>Description</th>
                            <th>Pending</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="tableList">
                        {{-- Table Data --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    getList();

    async function getList() {

        showLoader();
        let res = await axios.get("/list-todo");
        hideLoader();


        // console.log(res.data);
        let tableData = $('#tableData');
        let tableList = $('#tableList');

        tableData.DataTable().destroy();
        tableList.empty();


        res.data['data'].forEach(function(item, index) {
            let row = `<tr>
                        <td>${index + 1}</td>
                        <td>${item['title']}</td>
                        <td><span class="bg-primary rounded-2 px-3 py-2 text-light" >${item['exp_time']} || ${item['exp_date']} </span></td>
                        <td>${item['description']}</td>
                        <td style="text-align: center; "><div class="isCompliteWrapper"><i onclick="isComplete(${item['id']}, '${item['title']}')"  data-id="${item['id']}" data-name="${item['title']}" id="completeBtn" class="bi bi-patch-check-fill"></i></div></td>
                        <td>
                            <button data-id="${item['id']}" 
                                    data-title="${item['title']}" 
                                    data-description="${item.description}"
                                    data-exp_date="${item.exp_date}"
                                    data-exp_time="${item.exp_time}"                                   
                                    " class="btn edit btn-success px-3 py-2" id="proEditBtn"><i style="font-size: 18px;" class="bi bi-pencil-fill"></i></button>
                            <button data-id="${item['id']}" data-name="${item.title}" class="btn delete btn-danger px-3 py-2"><i style="font-size: 18px;" class="bi bi-trash-fill"></i></button>
                        </td>
                    </tr>`;
            tableList.append(row);
        });


        $('.edit').on('click', function() {

            $("#completewrapper").removeClass('d-none');

            let id = $(this).data('id');
            let title = $(this).data('title');
            let exp_date = $(this).data('exp_date');
            let exp_time = $(this).data('exp_time');
            let description = $(this).data('description');

            // alert(description);


            $("#title").val(title);
            $("#exp_date").val(exp_date);
            $("#exp_time").val(exp_time);
            $("#description").val(description);


            $("#create-modal").modal('show');
            $("#update_id").val(id);
        });

        $('.delete').on('click', function() {
            let id = $(this).data('id');
            let Name = $(this).data('name');
            // console.log(Name);
            $(".catName").text(Name);
            $("#delete-modal").modal('show');
            $(".catID").html(id);
        });

        tableData.DataTable({
            order: [
                [0, 'desc']
            ],
            lengthMenu: [5, 10, 15, 20, 25, 30, 35, 40, 45, 50],
            language: {
                paginate: {
                    next: '&#8594;', // or '→'
                    previous: '&#8592;' // or '←'
                }
            }
        });
    }


    async function isComplete(id, name) {

        $("#completeUpdate-modal").modal('show');
        
        $(".catName").text(name);
        $(".catID").text(id);
    }

    $('#createTodo').on('click', function() {
        // alert();
        $("#completewrapper").addClass('d-none');
    })
</script>
