<script src="<?php echo base_url(); ?>/assets/js/highcharts/highcharts.js"></script>
<script src="<?php echo base_url(); ?>/assets/js/highcharts/no-data-to-display.js"></script>


<section class="content-header">
    <h1>
        Dashboard
    </h1>
    <ol class="breadcrumb">
        <li class="active">Dashboard</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-body">
                    <div class="col-xs-12">
                        <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>  

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Last 5 Customers</h3>

                    <div class="box-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">

                            <div class="input-group-btn">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tbody><tr>
                                <th>Username</th>
                                <th>Full Name</th>
                                <th>Status</th>
                                <th>Payment</th>
                                <th>Added</th>
                            </tr>
                            <?php
                            if (!empty($data_arr['last_five_customer'])) {
                                foreach ($data_arr['last_five_customer'] as $customer) {
                                    $status = getStatusLabel($customer->status);
                                    $payment = getPaymentStatus($customer->is_paid);
                                    ?>
                                    <tr>
                                        <td><?php echo $customer->username; ?></td>
                                        <td><?php echo $customer->first_name . " " . $customer->last_name; ?></td>
                                        <td><span class="label <?php echo $status['class']; ?>"><?php echo $status['label']; ?></span></td>
                                        <td><span class="label <?php echo $payment['class']; ?>"><?php echo $payment['label']; ?></span></td>
                                        <td><?php echo $customer->date_entered; ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <tr> 
                                    <td colspan="5"> <a href="<?php echo base_url(); ?>/admin/frontusers">View All</a></td>
                                </tr>   

                                <?php
                            }
                            ?>
                        </tbody></table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Last 5 Transactions</h3>

                    <div class="box-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">

                            <div class="input-group-btn">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tbody><tr>
                                <th>Invoice</th>
                                <th>Username</th>
                                <th>Amount</th>
                                <th>Payment Method</th>
                                <th>Payment Status</th>
                                <th>Added</th>
                            </tr>
                            <?php
                          
                            if (!empty($data_arr['last_five_trans'])) {
                                foreach ($data_arr['last_five_trans'] as $tran) {
                                    $status = getPaymentStatusLabel($tran->payment_status);
                                    ?>
                                    <tr>
                                        <td><?php echo $tran->invoice; ?></td>
                                        <td><?php echo (!empty($tran->user_detail->username))?$tran->user_detail->username:''; ?></td>
                                        <td><?php echo $tran->amount; ?></td>
                                        <td><?php echo $tran->payment_method; ?></td>
                                        <td><span class="label <?php echo $status['class']; ?>"><?php echo $status['label']; ?></span></td>
                                        <td><?php echo $tran->date_entered; ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <tr> 
                                    <td colspan="5"> <a href="<?php echo base_url(); ?>/admin/transactions">View All</a></td>
                                </tr>   

                                <?php
                            } else {
                                ?>
                                <tr>
                                    <td colspan="6">No Record</td>
                                </tr>   
    <?php
}
?>
                        </tbody></table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>

</section>
<script>
    $(function() {
        $('#container').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Users Report'
            },
            xAxis: {
                categories: [
                    'Active',
                    'Not Active',
                    'Paid',
                    'Not Paid'
                ],
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: ''
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                    name: 'Users',
                    data: <?php echo json_encode($data_arr['user_data']); ?>

                }]
        });
    });
</script>