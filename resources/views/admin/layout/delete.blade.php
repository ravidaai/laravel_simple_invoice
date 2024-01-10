<div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title m--font-danger" id="exampleModalLabel">
                    Caution!
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        &times;
                    </span>
                </button>
            </div>
            <div class="modal-body">
                <h5>
                    Are you sure that you want permanently delete the data?
                </h5>
                <p class="m--font-danger">
                    <strong>Note,</strong>
                    You can't restore it later.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Close
                </button>
                <button href="" data-dismiss="modal" aria-hidden="true" class="btn btn-danger delete">
                    Yes, ..
                </button>
                <input type="hidden" id="delete_id">
            </div>
        </div>
    </div>
</div>