@extends('template')
@section('title')
    @if(isset($odata)) Update Owner @else Add Owner @endif
@endsection
@section('css_file')
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <link rel="stylesheet" type="text/css"
          href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/base/jquery-ui.css">
    <style>
        span {
            font-weight: normal;
        }
    </style>
@endsection
@section('content')
    <?php
    $on_count = count($on_collection_data);
    $onpayrow=0;
    $legal_count = count($legal_collection_data);
    $legalpayrow=0;
    $on_amount_total = 0;
    $legal_amount_total = 0;
    $gst_total = 0;
    $gst = $odata->gst; ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                @if(isset($odata)) Update Owner @else Add Owner @endif
            </h1>
            <ol class="breadcrumb">
                <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">@if(isset($odata)) Update Owner @else Add Owner @endif</li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form role="form" action="/update_invoice" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" @if(isset($odata)) value="{{ $odata->oid }}" @else @endif>
                            <input type="hidden" name="status" value="1">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Company : <span>{{ $odata->companyname }}</span></label><br>
                                            <label>Building No : <span>{{ $odata->wingname }}</span></label><br>
                                            <label>Unit No : <span>{{ $odata->unit_no }}</span></label><br>
                                            <label> Owner Name : <span>{{ $odata->owner_name }}</span></label><br>
                                            <label>Owner Mobile 1 : <span>{{ $odata->owner_mo_1 }}</span></label><br>
                                            {{--<label>Owner Address : <span>{{ $odata->owner_address }}</span></label><br>--}}
                                            <label style="width:120px;">Visit Payment :</label>
                                            <input name="visit_pay"
                                                   @if(isset($odata->visitpay)) value="{{ $odata->visitpay }}"
                                                   @else @endif  placeholder="Enter Visit Time Payment"><br>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-md-3" style="padding-left: 0px;margin-right: -15px;">Parking
                                                    No :</label>
                                                <div class="col-md-9" style="padding-left: 0px;">
                                                    <input name="parking_no"
                                                           @if(isset($odata->parking)) value="{{ $odata->parking }}"
                                                           @else @endif  placeholder="Enter Wid">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-md-3"
                                                       style="padding-left: 0px;margin-right: -15px;">GST % :</label>
                                                <div class="col-md-9" style="padding-left: 0px;">
                                                    <input id="gst" name="gst"
                                                           @if(isset($odata->gst)) value="{{ $odata->gst }}"
                                                           @else @endif  placeholder="Enter GST %">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-md-3"
                                                       style="padding-left: 0px; margin-right: -15px;">Maintenance
                                                    :</label>
                                                <div class="col-md-9" style="padding-left: 0px;">
                                                    <input name="maintenance"
                                                           @if(isset($odata->maintenance)) value="{{ $odata->maintenance }}"
                                                           @else @endif  placeholder="Enter Maintenance Amount">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-md-3" style="padding-left: 0px; margin-right: -15px;">Broker
                                                    Name :</label>
                                                <div class="col-md-9" style="padding-left: 0px;">
                                                    {{ $odata->broker_name }}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-md-3" style="padding-left: 0px; margin-right: -15px;">Broker
                                                    Mobile :</label>
                                                <div class="col-md-9" style="padding-left: 0px;">
                                                    {{ $odata->broker_mo }}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-md-3" style="padding-left: 0px; margin-right: -15px;">Sell
                                                    Price :</label>
                                                <div class="col-md-9" style="padding-left: 0px;">
                                                    <input name="sell_price"
                                                           @if(isset($odata->sellpay)) value="{{ $odata->sellpay }}"
                                                           @else @endif  placeholder="Enter Sell Price">
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-6" style='text-align:center;background:#ffcfcf;padding-top: 10px;'>
                                    <div class="col-md-4">
                                        <div class="form-group" style='margin-bottom: 0px;text-align:center;'>
                                            <label>Date</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group" style='margin-bottom: 0px;text-align:center;'>
                                            <label>Amount</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group" style='margin-bottom: 0px;text-align:center;'>
                                            <label>Note</label>
                                        </div>
                                    </div>
                                    <div id='ondiv'>
                                        @foreach($on_collection_data as $onpaydata)
                                        <div class="col-md-1"><div class="form-group"></div></div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="hidden" name="ondata[]" value='{{ $onpayrow++ }}'>
                                                <input type="text" class="form-control datepicker_recurring_start"
                                                       name="on_date[]" value="{{$onpaydata->paydate}}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" class="form-control on_amount" name="on_amount[]" value="{{$onpaydata->payment}}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="on_note[]" value="{{$onpaydata->note}}">
                                            </div>
                                        </div>
                                            <?php $on_amount_total += $onpaydata->payment; ?>
                                        @endforeach
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <i class="fa fa-fw fa-plus addOn"
                                                   style='font-size:25px;margin-top:5px;'></i>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="hidden" name="ondata[]" value='1'>
                                                <input type="text" class="form-control datepicker_recurring_start"
                                                       name="on_date[]">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" class="form-control on_amount" name="on_amount[]" value="0">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="on_note[]">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group pull-right">
                                            <label>Total : </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="on_amount_total" name="on_amount_total" value="{{$on_amount_total}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6"
                                     style='text-align:center;background:#cfffd5;padding-top: 10px;'>
                                    <div class="col-md-1">
                                        <div class="form-group" style='margin-bottom: 0px;text-align:center;'>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group" style='margin-bottom: 0px;text-align:center;'>
                                            <label>Date</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group" style='margin-bottom: 0px;text-align:center;'>
                                            <label>Amount</label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group" style='margin-bottom: 0px;text-align:center;'>
                                            <label>Note</label>
                                        </div>
                                    </div>
                                    <div id='legaldiv'>
                                        @foreach($legal_collection_data as $legalpaydata)
                                            <div class="col-md-1"><div class="form-group"></div></div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input type="hidden" name="legaldata[]" value='{{ $legalpayrow++ }}'>
                                                    <input type="text" class="form-control datepicker_recurring_start"
                                                           name="legal_date[]" value="{{$legalpaydata->paydate}}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input type="text" class="form-control legal_amount" name="legal_amount[]" value="{{$legalpaydata->payment}}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="legal_note[]" value="{{$legalpaydata->note}}">
                                                </div>
                                            </div>
                                            <?php
                                            $legal_amount_total += $legalpaydata->payment;
                                            $gst_total += ($legalpaydata->payment * $gst)/100;
                                            ?>

                                        @endforeach
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <i class="fa fa-fw fa-plus addLegal"
                                                   style='font-size:25px;margin-top:5px;'></i>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="hidden" name="legaldata[]" value='1'>
                                                <input type="text" class="form-control datepicker_recurring_start"
                                                       name="legal_date[]">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" class="form-control legal_amount" name="legal_amount[]" value="0">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="legal_note[]">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group pull-right">
                                            <label>Total : </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                               <input type="text" class="form-control" id="legal_amount_total" name="legal_amount_total" value="{{$legal_amount_total}}">
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label>GST</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="gst_total" name="gst_total" value="{{$gst_total}}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- /.box-body -->
                            <div class="box-footer">
                                <input type="submit" class="btn btn-primary" value="Submit">
                            </div>
                        </form>
                    </div>
                    <!-- /.box -->
                    <!-- /input-group -->
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
    </div>
    </div>
    <!--/.col (left) -->
    <!-- right column -->
    </div>
    <!-- /.row -->
    </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
@section('js_file')
    <!-- Bootstrap
   WYSIHTML5
   <script src="/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script> 
   -->
@endsection
@section('script')

    <script>
        $(document).ready(function () {

            var gstper = 0;
            gstper = $('#gst').val();

            $('#gst').change(function (e) {
                gstper = $(this).val();
            });




            $('#txtPhone').blur(function (e) {
                if (validatePhone('txtPhone')) {
                    $('#spnPhoneStatus').html('Valid');
                    $('#spnPhoneStatus').css('color', 'green');
                }
                else {
                    $('#spnPhoneStatus').html('Invalid');
                    $('#spnPhoneStatus').css('color', 'red');
                }
            });


            var onc = <?= $on_count; ?>;
            $('.addOn').click(function (e) {

                var on_total_amount = 0;
                $(".on_amount").each(function() {
                    var amt = parseFloat($(this).val());
                    on_total_amount += amt;
                });
                $('#on_amount_total').val(on_total_amount);

                onc++;
                $('#ondiv').append('<div class="col-md-1"><input type="hidden" name="ondata[]" value=' + onc + '></div><div class="col-md-3"><div class="form-group"><input type="text" class="form-control datepicker_recurring_start" name="on_date[]"></div></div>	<div class="col-md-4"><div class="form-group"><input type="text" class="form-control on_amount" name="on_amount[]" value="0"></div></div>	<div class="col-md-4"><div class="form-group"><input type="text" class="form-control" name="on_note[]"></div></div>');
            });

            var legalc = <?= $legal_count; ?>;
            $('.addLegal').click(function (e) {

                var legal_total_amount = 0;
                $(".legal_amount").each(function() {
                    var amt = parseFloat($(this).val());
                    legal_total_amount += amt;
                });

                $('#legal_amount_total').val(legal_total_amount);
                $('#gst_total').val((legal_total_amount*gstper)/100);

                legalc++;
                $('#legaldiv').append('<div class="col-md-1"><input type="hidden" name="legaldata[]" value=' + legalc + '></div><div class="col-md-3"><div class="form-group"><input type="text" class="form-control datepicker_recurring_start" name="legal_date[]"></div></div><div class="col-md-4"><div class="form-group"><input type="text" class="form-control legal_amount" name="legal_amount[]" value="0"></div></div><div class="col-md-4"><div class="form-group"><input type="text" class="form-control" name="legal_note[]"></div></div>');
            });

            $('body').on('focus', ".datepicker_recurring_start", function() {
                $(this).datepicker();
            });

            $('body').on('change', ".datepicker_recurring_start", function () {
                var from = $(this).val().split("/");
                $(this).val(from[1] + '/' + from[0] + '/' + from[2]);
            });

        });

        function validatePhone(txtPhone) {
            var a = document.getElementById(txtPhone).value;
            var filter = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;
            if (filter.test(a) && a.length < 11) {
                return true;
            }
            else {
                return false;
            }
        }
    </script>
@endsection

