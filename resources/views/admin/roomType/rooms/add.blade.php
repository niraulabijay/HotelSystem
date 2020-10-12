<!-- Modal -->
<div class="modal animated fadeInUp" id="addRoomUnit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
    <form method="post" action="{{ route('admin.room.add') }}" enctype="multipart/form-data">
        @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Unit?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    x
                    </button>
                </div>
                <div class="modal-body">
                    <h5 class="modal-title">
                       New Unit for - <strong id="addRoomUnitTitle"></strong>
                    </h5>
                    <input type="hidden" name="room_type_id" id="addRoomUnitId">
                    <div class="form-group">
                        <label for="">Name of unit</label>
                        <input type="text" name="title" placeholder="Eg: 101, A20,.." class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                    <button type="submit" class="btn btn-primary">Confirm</button>
                </div>
            </div>
        </form>
    </div>
</div>
