{* SMARTY *}


<table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0" role="grid"
       aria-describedby="dataTable_info" style="width: 100%;">
    <thead>
    <tr role="row">
        <th class="sorting_asc" aria-controls="dataTable"
            aria-label="#: activate to sort column descending" style="width: 80px;">#
        </th>
        <th tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1"
            aria-label="Date: activate to sort column ascending" style="width: 450px;">{constant("GENERAL_DATE")}
        </th>
        <th tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1"
            aria-label="Client Name: activate to sort column ascending" style="width: 180px;">{constant("GENERAL_CLIENTNAME")}
        </th>
        <th tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1"
            aria-label="TEST NAME: activate to sort column ascending" style="width: 160px;">{constant("GENERAL_TESTNAME")}
        </th>
        <th tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1"
            aria-label="PHONE NUMBER: activate to sort column ascending" style="width: 180px;">{constant("GENERAL_PHONENUMBER")}
        </th>
        <th tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1"
            aria-label="ACTION: activate to sort column ascending" style="width: 114px;">{constant("GENERAL_ACTION")}
        </th>
    </tr>
    </thead>
    <tbody>
    {foreach from=$ordersData item=order}
        <tr role="row" class="even">
            <td>{$order.id}</td>
            <td>{$order.order_date|date_format:"%a, %B %e, %Y %T"}</td>
            <td>{$order.clientname}</td>
            <td>{$order.testname}</td>
            <td>{$order.phone_number}</td>
            {if !$order.aborted}
                <td>
                    <button data-killname="{$order.testname}" data-killid="{$order.id}" class="btn btn-danger btnAbort">
                        ABORT
                    </button>
                </td>
            {else}
                <td><span class="text-danger">ABORTED</span></td>
            {/if}
        </tr>
    {/foreach}
    </tbody>
</table>
