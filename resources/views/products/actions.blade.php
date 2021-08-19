<!-- Create Modal effects -->
<div class="modal" id="edit_{{ $product->id }}">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">تعديل قسم : {{ $product->product_name }}</h6><button aria-label="Close" class="close" data-dismiss="modal"
                    type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('products.update', $product->id) }}" method="post" id="edit-product">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">إسم المنتج:</label>
                        <input type="text" value="{{ $product->product_name }}" class="form-control" name="product_name" id="recipient-name">
                    </div>
                    <div class="form-group">
                        <label for="section-select" class="col-form-label">القسم:</label>
                        <select class="form-control select2" name="section_id" id="section-select">
                            <option label="اختار القسم ..."></option>
                            @foreach($sections as $section)
                            <option {{ $section->id == $product->section_id ? 'selected' : '' }} value="{{ $section->id }}">
                                {{ $section->section_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">وصف المنتج:</label>
                        <textarea class="form-control" name="description" id="message-text">{{ $product->description }}</textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-success" type="button"
                    onclick="event.preventDefault();document.getElementById('edit-product').submit();">تأكيد</button>
                <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">إغلاق</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal effects-->

<!-- Delete Modal effects -->
<div class="modal" id="delete_{{ $product->id }}">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">حذف المنتج : {{ $product->product_name }}</h6><button aria-label="Close" class="close" data-dismiss="modal"
                    type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('products.destroy', $product->id) }}" method="post" id="delete-product">
                    @csrf
                    @method('delete')
                        <label class="col-form-label">هل انت متأكد من حذف المنتج ؟</label>    
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-danger" type="button"
                    onclick="event.preventDefault();document.getElementById('delete-product').submit();">تأكيد</button>
                <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">إغلاق</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal effects-->