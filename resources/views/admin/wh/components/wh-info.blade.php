<div>
    <h5 class="mb-1">Warehouse General Information</h5>
    <p class="text-muted mb-4">Please fill all information below</p>
</div>
<div>
    <div class="row g-4">

                <div class="col-lg-6">
                <label for="job-title-Input" class="form-label">Warehouse Title <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="job-title-Input" placeholder="Enter warehouse title" required name="wh_title" value="{{(isset($data['wh']))? $data['wh']->title:''}}">
                 </div>

                <div class="col-lg-6">
                <label for="job-position-Input" class="form-label">Warehouse Email</label>
                <input type="email" class="form-control" id="job-position-Input" placeholder="info@warehouse.com" required name="wh_email" value="{{(isset($data['wh']))? $data['wh']->email:''}}">
                </div>

                <div class="col-lg-6">
                <label for="job-category-Input" class="form-label">Warehouse Phone</label>
                <input type="text" class="form-control" id="job-position-Input" placeholder="(0) 123456789" required name="wh_phone" value="{{(isset($data['wh']))? $data['wh']->phone:''}}">
                </div>

                <div class="col-lg-6">
                <label for="job-type-Input" class="form-label">Status <span class="text-danger">*</span></label>
                    <select  class="form-select" id="status_field" required name="wh_status" >
                        <option value="">Choose One</option>
                        <option value="1" {{(isset($data['wh']) AND $data['wh']->status==1)? "selected":''}}>Active</option>
                        <option value="2" {{(isset($data['wh']) AND $data['wh']->status==2)? "selected":''}}>In-Active</option>

                    </select>
                    </div>

                 <div class="col-lg-6">
                <label for="description-field" class="form-label">Address <span class="text-danger">*</span></label>
                <textarea class="form-control" id="description-field" rows="3" placeholder="Enter address" required="" name="wh_address">{{(isset($data['wh']))? $data['wh']->address:''}}</textarea>
                 </div>
        <div class="col-lg-6">
                <label for="description-field" class="form-label">Additional Note </label>
                <textarea class="form-control" id="description-field" rows="3" placeholder="Warehouse Additional Instructions"  name="wh_note">{{(isset($data['wh']))? $data['wh']->note:''}}</textarea>

        </div>
        <div class="col-lg-12">
            <div class="hstack justify-content-end gap-2">
                <button type="button" class="btn btn-ghost-danger"><i class="ri-close-line align-bottom"></i> Cancel</button>

                <button type="button" class="btn btn-primary btn-label right ms-auto nexttab" data-nexttab="pills-bill-hours-tab"><i class="ri-bank-card-line label-icon align-middle fs-16 ms-2"></i>Setup Working Hours</button>
            </div>
        </div>
    </div>
</div>
