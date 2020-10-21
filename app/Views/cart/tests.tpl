{* SMARTY *}

{extends "template/maintemplate.tpl"}

{block name="head" append}
    <link href="{$assetsPath}/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
{/block}

{block name="content" nocache}
    <main>
        <div class="main_title">
            <h1>{constant("TESTS_TITLE")}</h1>
        </div>

        <div class="box_form">
            <div class="row">
                <div class="col-md-2">
                    <h3>CATEGORY</h3>
                    <div class="form-group">
                        <select class="form-control" id="categorySelector">
                            {foreach from=$categories item=category}
                                <option name="{$category.name}" value="{$category.id}">{$category.name}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0"
                           role="grid"
                           aria-describedby="dataTable_info" style="width: 100%;">
                        <thead>
                        <tr role="row">
                            <th tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1"
                                aria-label="TEST NAME: activate to sort column ascending" style="width: 180px;">TEST
                                NAME
                            </th>
                            <th tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1"
                                aria-label="REGULAR PRICE: activate to sort column ascending" style="width: 160px;">
                                PRICE
                            </th>
                            <th tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1"
                                aria-label="REGULAR PRICE: activate to sort column ascending" style="width: 160px;">
                                CATEGORIES
                            </th>
                            <th tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1"
                                aria-label="CART: activate to sort column ascending" style="width: 50px;">
                                CART
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        {foreach from=$tests item=test}
                            <tr role="row" class="even">
                                <td>{$test.name}</td>
                                <td id="test{$test.id}" data-price="{$test.price}">{$test.price}</td>
                                <td>{$test.category}</td>
                                <td>
                                    <button id="test{$test.id}" data-name="{$test.name}" class="btn btn-info cartBtn"
                                            data-test="{$test.id}">
                                        Add To Cart
                                    </button>
                                </td>
                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                </div>
                <div class="col-md-4">
                    <div class="box_general_3 booking">
                        <form>
                            <div class="title">
                                <h3>Your booking</h3>
                            </div>
                            <ul class="treatments checkout clearfix">
                                {if count($cartData) > 0}
                                    {foreach from=$cartData item=$cartItem}
                                        {if is_object($cartItem)}
                                            <li class="checkoutItem" data-cart="{$cartItem->id}">
                                                {$cartItem->name}
                                                <a href="#"><i class="float-right removeItem icon-cancel"
                                                               data-id="{$cartItem->id}"></i></a>
                                                <strong class="float-right">{$cartItem->price}kd</strong>
                                            </li>
                                        {/if}
                                    {/foreach}
                                {/if}
                                <li class="total">
                                    Total <strong class="float-right" id="totalAmount">{$cartData.total} KD</strong>
                                </li>
                            </ul>
                            <hr>
                            <a href="#" id="btnRequestTest" class="btn_1 full-width">Request tests</a>
                        </form>
                    </div>
                    <!-- /box_general -->
                </div>
            </div>
        </div>
    </main>
{/block}

{block name="footer" append}
    <script src="{$assetsPath}/vendor/datatables/jquery.dataTables.js"></script>
    <script src="{$assetsPath}/vendor/datatables/dataTables.bootstrap4.js"></script>
    <script>
        $(document).ready(function () {
            let table = $('#dataTable').DataTable({
                "pageLength": 5,
                lengthMenu: [[5, 10], [5, 10]]
            });

            RegisterEvents();
            ClearShit();

            $('#dataTable').on('draw.dt', function () {
                RegisterEvents();
                ClearShit();
            });

            $('#categorySelector').on('change', function () {
                table.search($(this).find("option:selected").text());
                table.draw();
            });

            $('#btnRequestTest').on('click', function () {
                AjaxPost('{$siteurl}checkout', '', function (data) {
                    let responseCode = data['state'];
                    if (responseCode == 'success') {
                        window.location.href = data['message'];
                    }
                    else
                        alert(data['message']);
                });
                return false;
            });
        });

        function ClearShit() {
            $('.checkoutItem').each(function (e) {
                $('button[data-test="' + $(this).data("cart") + '"]').addClass("disabled");
            });
        }

        function RegisterEvents() {
            $('.cartBtn').off('click');
            $('.cartBtn').on('click', function (e) {
                if ($(this).hasClass("disabled")) return;
                let itemId = $(this).data('test');
                let itemName = $(this).data("name")
                let itemPrice = $('#test' + itemId).data("price");
                let element = $(this);
                {literal}
                let itemData = {itemID: itemId}
                {/literal}

                AjaxPost('{$siteurl}addtocart', itemData, function (data) {
                    let responseCode = data['state'];
                    if (responseCode != 'error') {
                        let responseMsg = data['message'];
                        let elementToAdd = "           <li class=\"checkoutItem\" data-cart=" + itemId + ">\n" +
                            "                               " + responseMsg['item']['name'] + "\n" +
                            "                            <a href=\"#\"><i class=\"float-right removeItem icon-cancel\"\n" +
                            "                        data-id=" + itemId + "></i></a>\n" +
                            "                        <strong class=\"float-right\">" + responseMsg['item']['price'] + " KD</strong>\n" +
                            "                            </li>"
                        $('.checkout > .total').before(elementToAdd);
                        // $('.checkout > .total').before("<li>" + responseMsg['item']['name'] + " " +
                        //     "<strong class='float-right'>" + responseMsg['item']['price'] + " KD</strong></li>");
                        $('#totalAmount').html(responseMsg['total'] + " KD");
                        element.addClass('disabled');
                        RegisterEvents();
                    }
                    else
                        alert("Something went wrong while trying to add an item to the cart!");
                });
            });

            $('.removeItem').off('click');
            $('.removeItem').on('click', function (e) {
                {literal}
                let itemData = {itemID: $(this).data("id")};
                {/literal}
                AjaxPost('{$siteurl}removefromcart', itemData, function (data) {
                    let responseCode = data['state'];

                    if (responseCode === 'success') {
                        let responseMsg = data['message'];
                        let element = $("#item" + responseMsg['item']);
                        let listElement = $("li[data-cart='" + responseMsg['item'] + "']");

                        element.removeClass('disabled');
                        listElement.remove();
                        $('#totalAmount').html(responseMsg['total'] + " KD");
                    }
                });
                return false;
            });
        }


    </script>
{/block}