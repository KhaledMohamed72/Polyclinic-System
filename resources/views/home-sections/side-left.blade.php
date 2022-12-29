<div class="col-md-3">
    <div class="card overflow-hidden">
        <div style="background-color: rgba(85, 110, 230, 0.25) !important">
            <div class="row">
                <div class="col-7">
                    <div class="text-primary p-3">
                        <h5 class="text-primary">Welcome Back !</h5>
                        <p>Pulpo Clinic</p>
                    </div>
                </div>
                <div class="col-5 align-self-end">
                    <img src="{{asset('assets/dist/img/home-avatar.png')}}" alt="" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
    <div class="card card-white">
        <div class="card-header mb-6">
            <h3 class="card-title font-weight-bold">Monthly Earning</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <div id="month_earring_rate"></div>
                </div>
                <div class="col-sm-12">
                    <p class="text-muted">This month</p>
                    <h3>{{$current_monthly_earrings}}£</h3>
                    <p class="text-muted">
                            <span class=" text-success  mr-2">
                                {{number_format($earring_percentage, 2, '.', '')}}% <i class="fa fa-arrow-up"></i>
                            </span>From previous month
                    </p>
                </div>

            </div>
        </div>
        <!-- /.card-body -->
    </div>
</div>
