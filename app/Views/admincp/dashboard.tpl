{* SMARTY *}

{extends "admincp/template/admintemplate.tpl"}

{block name="content" nocache}
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fa fa-table"></i> ORDERS
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>DATE</th>
                                <th>CLIENT NAME</th>
                                <th>TEST NAME</th>
                                <th>PHONE NUMBER</th>
                                <th>ORDER STATE</th>
                                <th>ACTIONS</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>#</th>
                                <th>DATE</th>
                                <th>CLIENT NAME</th>
                                <th>TEST NAME</th>
                                <th>PHONE NUMBER</th>
                                <th>ORDER STATE</th>
                                <th>ACTIONS</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            {foreach from=$orders item=$order}
                                <tr>
                                    <td>{$order.id}</td>
                                    <td>{$order.order_date}</td>
                                    <td>{$order.clientname}</td>
                                    <td>{$order.testname}</td>
                                    <td>{$order.phone_number}</td>
                                    <td>{$order.order_state}</td>
                                    <td>
                                        <button class="btn btn-success btnDone" data-order="{$order.id}">DONE</button>
                                        <button class="btn btn-danger btnAbort" data-order="{$order.id}">ABORT</button>
                                    </td>
                                </tr>
                            {/foreach}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid-->
    </div>
    <!-- Update Modal-->
    <div class="modal fade" id="modalDONE" tabindex="-1" role="dialog" aria-labelledby="modalDONELabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDONELabel">Update Order</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form method="post" class="ajaxForm" data-loader="orderLoader"
                      data-url="{$siteurl}adminOrderUpdate">
                    <div class="modal-body">
                        <div id="orderLoader"></div>

                        <input type="hidden" value="0" name="orderID" id="orderID">
                        <textarea id="orderMessage" name="orderMessage"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary btnUpdateOrder" type="submit">DONE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
{/block}



{block name="footer" append}
    <script>
        $(function () {
            $('#dataTable').DataTable();
            CKEDITOR.replace('orderMessage');

            $('#dataTable').on('draw.dt', function () {
                RegisterEvents();
            });

            // $('.btnUpdateOrder').on('click', function () {
            //
            // });

            RegisterEvents();

            function RegisterEvents() {
                $('.btnDone').on('click', function () {
                    let orderID = $(this).data("order");
                    $('#orderID').val(orderID);
                    $('#modalDONE').modal();
                });
            }
        });
    </script>
{/block}