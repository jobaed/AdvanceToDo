<div class="modal" id="completeUpdate-modal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="width: 450px;">

            <div class="modal-body text-center">
                <h3 class=" mt-3 text-warning">Are You Sure To Complete "<span class="catName"></span>" Todo?</h3>
                <p class="mb-3">Once Update, you can get it back From Finished Todo Page.</p>
                <div class="catID d-none">

                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer justify-content-end">
                <div>
                    <button type="button" id="closeBtn" class="btn shadow-sm btn-secondary"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="confirmComplete" class="btn shadow-sm btn-danger">Finish</button>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    $("#closeBtn").on('click', function(e) {
        e.preventDefault();
        $('#delete-modal').modal('hide');

    })
    $("#confirmComplete").on("click", async function() {
        let id = $(".catID").html();
        // alert(id);

        showLoader();
        let res = await axios.post("/uncomplete-todo", {
            id: id
        });
        hideLoader();
        $("#completeUpdate-modal").modal('hide');

        // console.log(res.data);

        if (res.data.status == "success") {
            getList();
            $('#create-modal').modal('hide');
            $("#inserToDo").trigger("reset");
            successToast(res.data.message);
        } else if (res.data.status == "error") {
            errorToast(res.data.message);
        }
    })
</script>
