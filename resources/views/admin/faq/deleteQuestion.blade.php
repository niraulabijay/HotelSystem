<!-- Modal -->
<div class="modal fade" id="deleteFaqModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <form action="{{ route('admin.faq.delete') }}" method="post" id="faqQuesAdd">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Are you sure want to delete this question?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    X
                    </button>
                </div>
                <div class="modal-body">
                    <p class="modal-text">
                        <div class="row">
                            <div class="col-12">
                                <input type="hidden" id="deleteFaqId" name="id">
                                <p>Changes cannot be reverted.</p>
                            </div>
                        </div>
                    </p>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                    <button type="submit" id="saveQuestion" class="btn btn-primary">Confirm</button>
                </div>
            </div>
        </form>
    </div>
</div>
