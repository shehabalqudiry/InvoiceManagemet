@can('section-edit')
<!-- Edit Modal effects -->
<div class="modal" id="edit_{{ $section->id }}">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">تعديل قسم : {{ $section->section_name }}</h6><button aria-label="Close" class="close" data-dismiss="modal"
                    type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('sections.update', $section->id) }}" method="post" id="edit-section">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">إسم القسم:</label>
                        <input type="text" value="{{ $section->section_name }}" class="form-control" name="section_name" id="recipient-name">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">وصف القسم:</label>
                        <textarea class="form-control" name="description" id="message-text">{{ $section->description }}</textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-success" type="button"
                    onclick="event.preventDefault();document.getElementById('edit-section').submit();">تأكيد</button>
                <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">إغلاق</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal effects-->
@endcan
@can('section-delete')
<!-- Delete Modal effects -->
<div class="modal" id="delete_{{ $section->id }}">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">حذف قسم : {{ $section->section_name }}</h6><button aria-label="Close" class="close" data-dismiss="modal"
                    type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('sections.destroy', $section->id) }}" method="post" id="delete-section">
                    @csrf
                    @method('delete')
                        <label class="col-form-label">هل انت متأكد من حذف القسم ؟</label>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-danger" type="button"
                    onclick="event.preventDefault();document.getElementById('delete-section').submit();">تأكيد</button>
                <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">إغلاق</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal effects-->
@endcan
