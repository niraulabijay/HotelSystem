<!-- Modal -->
<div class="modal animated fadeInUp" id="deleteContent{{$brand->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
    <form method="post" action="{{ route('admin.brands.delete') }}">
        @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Brand ?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    x
                    </button>
                </div>
                <div class="modal-body">
                    <p class="modal-text">
                        Are you sure want to delete this hotel brand?
                    </p>
                <input type="hidden" name="brand_id" value="{{ $brand->id }}">
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                    <button type="submit" class="btn btn-primary">Confirm</button>
                </div>
            </div>
        </form>
    </div>
</div>
