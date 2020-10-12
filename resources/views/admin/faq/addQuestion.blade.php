<!-- Modal -->
<div class="modal fade" id="questionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <form action="{{ route('admin.faq.store') }}" method="post" id="faqQuesAdd">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New FAQ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    X
                    </button>
                </div>
                <div class="modal-body">
                    <p class="modal-text">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="question">Category</label>
                                    <select name="category" class="form-control">
                                        <option value="">Select a category for faq.</option>
                                        @foreach($faqCategories as $category)
                                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="question">Question</label>
                                    <textarea name="question" class="summernote" id="question" >

                                    </textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="answer">Answer</label>
                                    <textarea name="answer" class="summernote" id="answer" rows=5>

                                    </textarea>
                                </div>
                            </div>
                        </div>
                    </p>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
