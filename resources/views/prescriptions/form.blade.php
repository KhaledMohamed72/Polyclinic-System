@csrf

<div class="card-body">
    <div class="row">
            <div class="col-md-6 form-group">
                <label class="control-label">Patient <span
                        class="text-danger">*</span></label>
                <select
                    class="form-control select2 sel_patient "
                    name="patient_id" id="patient">
                    <option disabled selected>Select Patient</option>

                </select>
            </div>
            <div class="col-md-6 form-group">
                <label class="control-label">Appointment <span
                        class="text-danger">*</span></label>
                <select
                    class="form-control select2 sel_appointment "
                    name="appointment_id" id="appointment">
                    <option disabled selected>Select Appointment</option>
                </select>
            </div>
        </div>
        <blockquote>Medication &amp; Test Reports Details</blockquote>
        <div class="row">
            <div class="col-md-6">
                <div class='repeater mb-4'>
                    <div data-repeater-list="medicines" class="form-group">
                        <label>Medicines <span class="text-danger">*</span></label>
                        <div data-repeater-item class="mb-3 row">
                            <div class="col-md-5 col-6">
                                <input type="text" name="medicine" class="form-control"
                                       placeholder="Medicine Name" />
                            </div>
                            <div class="col-md-5 col-6">
                                                    <textarea type="text" name="notes" class="form-control"
                                                              placeholder="Notes..."></textarea>
                            </div>
                            <div class="col-md-2 col-4">
                                <input data-repeater-delete type="button"
                                       class="fcbtn btn btn-outline btn-danger btn-1d btn-sm inner"
                                       value="X" />
                            </div>
                        </div>
                    </div>
                    <input data-repeater-create type="button" class="btn btn-primary"
                           value="Add Medicine" />
                </div>
            </div>
            <div class="col-md-6">
                <div class='repeater mb-4'>
                    <div data-repeater-list="test_reports" class="form-group">
                        <label>Test Reports </label>
                        <div data-repeater-item class="mb-3 row">
                            <div class="col-md-5 col-6">
                                <input type="text" name="test_report" class="form-control"
                                       placeholder="Test Report Name" />
                            </div>
                            <div class="col-md-5 col-6">
                                                    <textarea type="text" name="notes" class="form-control"
                                                              placeholder="Notes..."></textarea>
                            </div>
                            <div class="col-md-2 col-4">
                                <input data-repeater-delete type="button"
                                       class="fcbtn btn btn-outline btn-danger btn-1d btn-sm inner"
                                       value="X" />
                            </div>
                        </div>
                    </div>
                    <input data-repeater-create type="button" class="btn btn-primary"
                           value="Add Test Report" />
                </div>
            </div>
        </div>
    <!-- /.card-body -->
</div>

