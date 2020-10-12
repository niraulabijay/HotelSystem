<form action="{{ route('admin.room.update') }}" method="post" id="faqQuesAdd">
    @csrf
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Unit?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            x
            </button>
        </div>
        <div class="modal-body">
            <h5 class="modal-title">
               Unit for - <strong id="editRoomUnitTitle">{{$editRoom->roomType->title}}</strong>
            </h5>
            <input type="hidden" name="room_id" id="editRoomUnitId" value="{{$editRoom->id}}">
            <div class="form-group">
                <label for="">Name of unit</label>
                <input type="text" name="title" value="{{ $editRoom->title }}" placeholder="Eg: 101, A20,.." class="form-control" required>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
            <button type="submit" class="btn btn-primary">Confirm</button>
        </div>
    </div>
</form>
