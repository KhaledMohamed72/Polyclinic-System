<div class="row">
    <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-check-circle"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Appointments</span>
                <span class="info-box-number">
                  {{$appointments_count}}
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-file"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Prescriptions</span>
                <span class="info-box-number">{{$prescriptions_count}}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <!-- fix for small devices only -->
    <div class="clearfix hidden-md-up"></div>

    <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box mb-3">
            <span class="info-box-icon material-icons bg-success">settings_accessibility</span>
            <div class="info-box-content">
                <span class="info-box-text">Sessions</span>
                <span class="info-box-number">{{$sessions_count}}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
</div>
