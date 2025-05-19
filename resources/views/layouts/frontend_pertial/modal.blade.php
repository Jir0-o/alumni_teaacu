<!-- notice modal start -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Create Notice</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" action="{{ route('createNotice') }}" method="POST" enctype="multipart/form-data">
                    <div class="col-md-12">
                        <label for="Title" class="form-label">Title <sup class="text-danger">*</sup></label>
                        <input required id="Title" class="form-control" placeholder="Notice Title" name="title">
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="validTill" class="form-label">Valid Till <sup
                                    class="text-danger">*</sup></label>
                            <input required id="validTill" class="form-control" type="date" placeholder="Select Date"
                                name="validTill">
                        </div>
                        <div class="col-md-8">
                            <label for="uril" class="form-label">Link/URL </label>
                            <input id="uril" class="form-control" placeholder="Reference link" name="uril">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="refdoc" class="form-label">Resource </label>
                        <input id="refdoc" class="form-control" type="file" placeholder="Resource/Document"
                            name="refdoc">
                    </div>
                    <div class="col-md-12">
                        <label for="Notice" class="form-label">Notice Body</label>
                        <textarea id="ckeditor" class="ckeditor form-control" name="noticeBody"></textarea>
                    </div>
                    <div class="text-right">
                        @csrf
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button style="float: right;" type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- notice modal end -->

<!-- event modal start -->
<div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Create Event</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" action="{{ route('createEvent') }}" method="POST" enctype="multipart/form-data">
                    <div class="col-md-12">
                        <label for="Title" class="form-label">Title <sup class="text-danger">*</sup></label>
                        <textarea required id="Title" class="form-control" placeholder="Event Title"
                            name="title"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="validTill" class="form-label">Registration Open Till <sup
                                    class="text-danger">*</sup></label>
                            <input required id="validTill" class="form-control" type="date" placeholder="Select Date"
                                name="validTill">
                        </div>
                        <div class="col-md-8">
                            <label for="regAmount" class="form-label">Registration Amount </label>
                            <input id="regAmount" type=number class="form-control" placeholder="Registration Amount"
                                name="regAmount">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="Image" class="form-label">Image <sub class="text-success">(You can choose
                                multiple image)</sub></label>
                        <input id="Image" class="form-control" type="file" name="images[]" multiple>
                    </div>
                    <div class="text-right">
                        @csrf
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button style="float: right;" type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- event modal end -->
